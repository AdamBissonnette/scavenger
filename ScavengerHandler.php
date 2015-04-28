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
                //Check if they sent a correct Answer
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
                        $response_body = "You've completed the adventure";
                    }
                }
                else
                {
                    $global_result = $this->_checkGlobals($body, true, true);

                    //Check for global commands
                    if ($global_result != "")
                    {
                        $response_body = $global_result;
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
                $response_body = $this->_checkGlobals($body, true);
            }
        }
        else
        {
            //Do global commands for unregistered users
            $response_body = $this->_checkGlobals($body);
        }

        return $response_body;
    }

    function _checkGlobals($body, $isAuthenticated=false, $hasStarted=false)
    {
        $responseToGlobal = "";

        if ($isAuthenticated)
        {
            foreach ($this->globals["authGlobals"] as $command) {
                if (preg_match($command["regex"], $body))
                {
                    if ($hasStarted)
                    {
                        if (isset($command["startedresponse"]))
                        {
                            return $command["startedresponse"];                            
                        }
                    }

                    return $command["smsresponse"];
                }
            }
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
