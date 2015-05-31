<?php

function format_TwiML($response)
{
    $message = "";
    $recipients = "";
    
    if (isset($response["body"]))
    {
        $message = $response["body"];
    }

    if (isset($response["recipients"]))
    {
        $recipients = $response["recipients"];
    }

    $response_template = "<Response>%s</Response>";

    $response_body = "";
    $messages = explode("^", $message);

    if (count($messages) > 1)
    {
        if ($messages[0] == "")
        {
            array_shift($messages);
        }
        foreach ($messages as $cur_message) {
            $response_body .= format_Message_Service($cur_message);
        }
    }
    else
    {
        $response_body = format_Message_Service($message);
    }

    $to_template = 'to="%s"';
    $response = "";

    if ($recipients != "")
    {
        foreach ($recipients as $recipient) {
            $response .= str_replace("@to", sprintf($to_template, $recipient), $response_body);
        }
    }
    else
    {
        $response .= str_replace("@to", "", $response_body);
    }   

    return sprintf($response_template, $response);
}

function format_Message_Service($message_in)
{
    $mms_code = "Ø";
    $message_template = "<Message @to>%s</Message>";
    $sms_template = "<Body>%s</Body>";
    $mms_template = "<Media>%s</Media>";

    $message = explode($mms_code, $message_in);

    $message_out = "";
    if (count($message) > 1)
    {
        if ($message[0] != "")
        {
            $message_out = sprintf($sms_template, trim($message[0]));
        }

        for ($i = 1; $i < (count($message)); $i++)
        {
            $message_out .= sprintf($mms_template, trim($message[$i]));
        }
    }
    else
    {
        $message_out = sprintf($sms_template, trim($message_in));
    }

    return sprintf($message_template, trim($message_out));

}

?>