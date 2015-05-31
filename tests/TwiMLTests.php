<?php

require('../lib/TwiMLHelper.php');

$mediaCode = "Ø";

$response = array('body' => "This is a message^Another message" . $mediaCode . "url.jpg", "recipients" => array("+13063704254", "+1306tsttest"));

print format_TwiML($response);

?>