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
    var $message = null;
    var $globals = array('authGlobals' => array(
                            array("regex" => "/(start)/i", "smsresponse" => "Your adventure is now starting!", "mmsresponse" => null),
                            array("regex" => "/(time)/i", "smsresponse" => "The time is at hand!")
                            ),
                        'noAuthGlobals' => array(
                            array('regex' => ".*", "/(start)/i" => "You don't appear the be registered.")
                            )
                     );

    function __construct($incomingMessage)
    {
        $this->message = $incomingMessage;
    }

    public function CreateResponse()
    {
        $response_body = "<Response/>";
        $body = $this->message["Body"];
        $fromPhone = $this->message["From"];

        //check to make sure that they are a valid sender
        if ($fromPhone == "(306) 370-4254")
        {
            //Get the clue that that user is on
            $curClue = null;

            if ($curClue != null)
            {
                
            }
            else
            {
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
