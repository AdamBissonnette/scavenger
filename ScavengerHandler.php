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
                            array("regex" => "/(start)/i", "smsresponse" => "Your adventure is now starting!", "mmsresponse" => null),
                            array("regex" => "/(time)/i", "smsresponse" => "The time is at hand!")
                            ),
                        'noAuthGlobals' => array(
                            array('regex' => ".*", "/(start)/i" => "You don't appear the be registered.")
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
            $curClue = $this->_findCurrentClueByUser($user);

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
                        $response_body = $nextClue->getValue();
                    }
                    else
                    {
                        $response_body = "You've completed the adventure";
                    }
                }
                else
                {
                    if (preg_match("/(start)/i", $body))
                    {
                        //send the first clue
                        $response_body = format_TwiML("Your adventure is now starting!");
                    }
                    elseif (preg_match("/(taco)/i", $body)) {
                        $response_body = format_TwiML("", "http://dev.mediamanifesto.com/twilio/scavenger/tacotaco.m4a");
                    }
                    elseif (preg_match("/(picture)/i", $body)) {
                        $response_body = format_TwiML("pretty pic", "http://dev.mediamanifesto.com/twilio/scavenger/webpage.png");
                    }
                    elseif (isset($_GET["MediaUrl0"]))
                    {
                        $response_body = format_TwiML($_GET["MediaUrl0"]);
                    }
                    else
                    {
                        //They got the answer wrong - send them a hint
                        //Do global commands for registered users
                        //If we don't have hints then suggest that they skip the question and message Adam / Berkley that shits going down
                        $response_body = "You got the answer wrong, oh no!";
                    }
                }
            }
            else
            {
                //Do global commands for registered users
                if (preg_match("/(start)/i", $body))
                {
                    //send the first clue
                    $response_body = format_TwiML("first clue value");
                }
                elseif (preg_match("/(taco)/i", $body)) {
                    $response_body = format_TwiML("", "http://dev.mediamanifesto.com/twilio/scavenger/tacotaco.m4a");
                }
                elseif (preg_match("/(picture)/i", $body)) {
                    $response_body = format_TwiML("pretty pic", "http://dev.mediamanifesto.com/twilio/scavenger/webpage.png");
                }
                elseif (isset($_GET["MediaUrl0"]))
                {
                    $response_body = format_TwiML($_GET["MediaUrl0"]);
                }
            }
        }
        else
        {
            //Do global commands for unregistered users
        }

        return $response_body;
    }

    function _checkGlobals($isAuthenticated)
    {
        $responseToGlobal = "";

        if (preg_match("/(start)/i", $body["Body"]))
        {
            $response_body = format_TwiML("Your adventure is now starting!");
        }

        return $response_body;
    }

    // function _checkNoAuthGlobals()

    function _findUserByFrom($from)
    {
        $repository = $this->entityManager->getRepository("User");

        $user = $repository->findOneBy(array('phone' => $from));
        if (!$user) {
            $user = new User();  
        }

        return $user;
    }

    function _findCurrentClueByUser($user)
    {
        $repository = $this->entityManager->getRepository("Dummy");

        $clue = $repository->findOneBy(array('user' => $user->getId()));
        if (!$clue) {
            $clue = new Clue();  
        }

        return $clue;
    }

    function _findAnswerForClueByValue($clue, $sms_value=null, $mms_value=null)
    {
        $answer = null;

        if (preg_match("/(taco)/i", $sms_value)) {
            $answer = $this->entityManager->find("Answer", 1);
            if (!$answer) {
                $answer = new Answer();  
            }
        }

        return $answer;
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
