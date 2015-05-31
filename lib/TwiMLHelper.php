<?php

function format_TwiML($message)
{
    $response_template = "<Response>%s</Response>";

    $response = "";
    $messages = explode("^", $message);

    if (count($messages) > 1)
    {
        if ($messages[0] == "")
        {
            array_shift($messages);
        }
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

    $message = split($mms_code, $message_in);

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