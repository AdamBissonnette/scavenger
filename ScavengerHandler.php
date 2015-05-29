<?php
require('bootstrap.php');

class ScavengerHandler
{
    /* Request Params
    ToCountry
    MediaContentType0
    ToState
    SmsMessageSid
    NumMedia
    ToCity
    FromZip
    SmsSid
    FromState
    SmsStatus
    FromCity
    Body
    FromCountry
    To
    ToZip
    MessageSid
    AccountSid
    From
    MediaUrl0
    ApiVersion
    */

    const DIRECTION_UNKNOWN = 1;
    const DIRECTION_INCOMING = 2;
    const DIRECTION_OUTGOING = 3;

    const TYPE_UNKNOWN = 1;
    const TYPE_CLUE = 2;
    const TYPE_ANSWER = 3;
    const TYPE_HINT = 4;
    const TYPE_GLOBAL = 5;
    const TYPE_START = 6;
    const TYPE_END = 7;
    var $entityManager = null;
    var $message = null;
    var $globals = array('authGlobals' => array(
                            array("regex" => "/(start)/i", "smsresponse" => "Your adventure is now starting!", "startedresponse" => "You have already started your adventure!", "mmsresponse" => null),
                            array("regex" => "/(time)/i", "smsresponse" => "The time is at hand!")
                            ),
                        'noAuthGlobals' => array(
                            array('regex' => "/.*/", "smsresponse" => "You don't appear the be registered.")
                            )
                     );

    function __construct($incomingMessage, $em)
    {
        $this->message = $incomingMessage;
        $this->entityManager = $em;
    }

    public function CreateResponse()
    {
        $incoming_message_type = self::TYPE_UNKNOWN;
        $outgoing_message_type = self::TYPE_UNKNOWN;

        $response_body = "<Response/>";
        $body = $this->message["Body"];
        $fromPhone = $this->message["From"];

        $user = $this->_findUserByFrom($fromPhone);

        //check to make sure that they are a valid sender
        if (isset($user))
        {
            //Get the clue that that user is on
            $dummy = $this->_findCurrentClueByUser($user);

            $curClue = null;
            if (isset($dummy))
            {
                $curClue = $dummy->getClue();
            }

            if (isset($curClue))
            {
                //Check for global commands then the correct answer

                //Check if they sent a correct Answer
                // $global_result = $this->_checkGlobals($body, true, true, $curClue);
                $responseFound = false;

                if (preg_match("/^clue/i", trim($body)))
                {
                    $responseFound = true;
                    $response_body = $curClue->getValue();
                }
                elseif (preg_match("/^restart/i", trim($body))) {
                    $responseFound = true;
                    $clue = $this->_getFirstClue();
                    $response_body = $clue->getValue();
                    $dummy->setClue($clue);
                    $this->entityManager->flush();
                }

                if (!$responseFound)
                {
                    $answer = $this->_findAnswerForClueByValue($curClue, $body, null); //clue, sms, mms
                    $incoming_message_type = self::TYPE_ANSWER;

                    if (isset($answer))
                    {
                        //Get the next clue from the answer and format that as a 
                        $nextClue = $answer->getClue();

                        if (isset($nextClue))
                        {
                            //Send the next clue
                            //Update the currentClue
                            $response_body = $nextClue->getValue();
                            $dummy->setClue($nextClue);
                            $this->entityManager->flush();
                            $outgoing_message_type = self::TYPE_CLUE;
                        }
                        else
                        {
                            $response_body = "You've completed the shareware version of our adventure.  Tell Adam and Berkley your feedback!";
                            $dummy->setClue(null);
                            $this->entityManager->flush();
                            $outgoing_message_type = self::TYPE_END;
                        }
                    }
                    else
                    {
                        //They got the answer wrong - send them a hint
                        //If we don't have hints then suggest that they skip the question and message Adam / Berkley that shits going down

                        $hintFound = false;

                        $outgoing_message_type = self::TYPE_HINT;
                        $hint = $this->_findHintsForClue($curClue);

                        if ($hint != null)
                        {
                            $response_body = $hint->getValue();
                        }
                        else
                        {
                            $response_body = "Oops - I think we're off track and I don't have any hints for you on this one.";
                        }
                    }
                }
                else
                {
                    $incoming_message_type = self::TYPE_GLOBAL;
                    $outgoing_message_type = self::TYPE_GLOBAL;
                }
            }
            else
            {
                $incoming_message_type = self::TYPE_GLOBAL;
                $outgoing_message_type = self::TYPE_GLOBAL;
                $responseFound = false;

                switch ($body) {
                    case preg_match("/start/i", $body)?true:false:
                        //Send first clue
                        $responseFound = true;
                        $clue = $this->_getFirstClue();
                        $response_body = $clue->getValue();
                        $dummy->setClue($clue);
                        $this->entityManager->flush();
                        $incoming_message_type = self::TYPE_START;
                        $outgoing_message_type = self::TYPE_START;
                    break;
                }

                if (!$responseFound)
                {
                    $response_body = $this->_checkGlobals($body, true);
                }
            }
        }
        else
        {
            $incoming_message_type = self::TYPE_GLOBAL;
            $outgoing_message_type = self::TYPE_GLOBAL;
            //Do global commands for unregistered users
            $response_body = $this->_checkGlobals($body);
        }

        //Log Incoming Message
        $data = array('from' => $this->message["From"], 'to' => $this->message["To"], 'value' => $this->message["Body"], 'data' => json_encode($this->message), 'direction' => self::DIRECTION_INCOMING, 'type' => $incoming_message_type);
        LogMessage($data, $this->entityManager, $user);

        //Log Outgoing Message
        $data = array('from' => $this->message["To"], 'to' => $this->message["From"], 'value' => $response_body, 'data' => format_TwiML($response_body), 'direction' => self::DIRECTION_OUTGOING, 'type' => $outgoing_message_type);
        LogMessage($data, $this->entityManager, $user);

        return $response_body;
    }

    function _checkGlobals($body, $isAuthenticated=false, $hasStarted=false, $curClue=null)
    {
        $responseToGlobal = "";

        if ($isAuthenticated)
        {
            //Derp
        }
        else
        {
            foreach ($this->globals["noAuthGlobals"] as $command) {
                if (preg_match($command["regex"], $body))
                {
                    return $command["smsresponse"];
                }
            }
        }

        return $responseToGlobal;
    }

    function _findUserByFrom($from)
    {
        $repository = $this->entityManager->getRepository("User");

        $user = $repository->findOneBy(array('phone' => $from, 'state' => 1));

        return $user;
    }

    function _findCurrentClueByUser($user)
    {
        $repository = $this->entityManager->getRepository("Dummy");

        $dummy = $repository->findOneBy(array('user' => $user->getId()));
        if (isset($dummy))
        {
            $clue = $dummy->getClue();
        }


        return $dummy;
    }

    function _findAnswerForClueByValue($clue, $sms_value=null, $mms_value=null)
    {
        $curAnswer = null;
        $acceptableAnswers = $clue->getAnswers();

        foreach ($acceptableAnswers as $answer) {
            if ($answer->getValue() == "/media/")
            {
                if ($this->message["NumMedia"] >= 1)
                {
                    $curAnswer = $answer;
                    break;
                }
            }
            else if (preg_match($answer->getValue(), $sms_value)) {
                $curAnswer = $answer;
                break;
            }

        }

        return $curAnswer;
    }

    function _getFirstClue($storyID=1)
    {
        $story = $this->entityManager->find("Story", $storyID);

        return $story->getFirstClue();
    }

    function _findHintsForClue($curClue)
    {
        $curHint = null;
        $hints = $curClue->getHints();

        foreach ($hints as $hint) {
            $curHint = $hint;
            break;
        }

        return $curHint;
    }
}

function format_TwiML($message)
{
    $response_template = "<Response>%s</Response>";

    $response = "";
    $messages = explode("^", $message);

    if (count($messages) > 1)
    {
        array_shift($messages);
        foreach ($messages as $cur_message) {
            $response .= format_Message_Service($cur_message);
        }
    }
    else
    {
        $response = format_Message_Service($message);
    }

    return sprintf($response_template, $response);
}

function format_Message_Service($message_in)
{
    $mms_code = "Ø";
    $message_template = "<Message>%s</Message>";
    $sms_template = "<Body>%s</Body>";
    $mms_template = "<Media>%s</Media>";

    $mms = explode("Ø", $message_in);

    $message_out = "";
    if (count($mms) > 1)
    {
        $message_out = sprintf($mms_template, str_replace($mms_code, "", trim($message_in)));
    }
    else
    {
        $message_out = sprintf($sms_template, trim($message_in));
    }

    return sprintf($message_template, trim($message_out));

}
