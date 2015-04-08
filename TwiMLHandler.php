<?php header("content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8"?>';
require('bootstrap.php');

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

$sms_response = "";
$response_body = "<Response/>";

function send_message($client, $from_number, $to_number, $message_body)
{
    $message = $client->account->messages->sendMessage(
      $from_number, // From a Twilio number in your account
      $to_number, // Text any number
      $message_body
    );
}

function delete_message($client, $sid)
{
    $client->account->messages->delete($sid);
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

$body = $_GET["Body"];

if (preg_match("/(start)/i", $body))
{
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

echo $response_body;
?>