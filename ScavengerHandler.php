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
        $response_body = "<Response/>";
        $body = $this->message["Body"];
        $fromPhone = $this->message["From"];

        $user = $this->_findUserByFrom($fromPhone);

        //check to make sure that they are a valid sender
        if (isset($user))
        {
            //Get the clue that that user is on
            $dummy = $this->_findCurrentClueByUser($user);

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
                switch ($body) {
                    case preg_match("/clue/i", $body)?true:false:
                        $responseFound = true;
                        return $curClue->getValue();
                    break;
                    case preg_match("/restart/i", $body)?true:false:
                        $responseFound = true;
                        $clue = $this->_getFirstClue();
                        $response_body = $clue->getValue();
                        $dummy->setClue($clue);
                        $this->entityManager->flush();
                    break;
                }

                if (!$responseFound)
                {
                    $answer = $this->_findAnswerForClueByValue($curClue, $body, null); //clue, sms, mms

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
                        }
                        else
                        {
                            $response_body = "You've completed the adventure. Text 'start' to being again.";
                            $dummy->setClue(null);
                            $this->entityManager->flush();
                        }
                    }
                    else
                    {
                        //They got the answer wrong - send them a hint
                        //If we don't have hints then suggest that they skip the question and message Adam / Berkley that shits going down
                        $response_body = "You got the answer wrong, oh no!";
                    }
                }
            }
            else
            {
                $responseFound = false;
                switch ($body) {
                    case preg_match("/start/i", $body)?true:false:
                        //Send first clue
                        $response_body = true;
                        $clue = $this->_getFirstClue();
                        $response_body = $clue->getValue();
                        $dummy->setClue($clue);
                        $this->entityManager->flush();
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
            //Do global commands for unregistered users
            $response_body = $this->_checkGlobals($body);
        }

        return $response_body;
    }

    function _checkGlobals($body, $isAuthenticated=false, $hasStarted=false, $curClue=null)
    {
        $responseToGlobal = "";

        if ($isAuthenticated)
        {
            $responseFound = false;
                // switch ($body) {
                //     case preg_match("/clue/i", $body)?true:false:
                //         return $curClue->getValue();
                //     break;
                //     case preg_match("/restart/i", $body)?true:false:
                //         return $curClue->getValue();
                //     break;
                // }
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

        $user = $repository->findOneBy(array('phone' => $from));

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
            if (preg_match($answer->getValue(), $sms_value)) {
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
}

function format_TwiML($sms_body="", $mms_uri="")
{
    $response_template = "<Response><Message>%s%s</Message></Response>";
    $sms_template = "<Body>$sms_body</Body>";
    $mms_template = "<Media>$mms_uri</Media>";

    if ($sms_body == "")
    {
        $sms_template = "";
    }

    if ($mms_uri == "")
    {
        $mms_template = "";
    } 

    return sprintf($response_template, $sms_template, $mms_template);
}
