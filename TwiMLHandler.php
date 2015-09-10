<?php
require_once('lib/ScavengerHandler.php');
require_once('lib/TwiMLHelper.php');

include_once('lib/AuthenticationHandler.php');
do_authenticate();

header("content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8"?>';

$message = $_GET;
$Scavenger = new ScavengerHandler($message, $entityManager);

$response_body = $Scavenger->CreateResponse($message);

if (!empty($response_body["body"]))
{
    echo format_twiML($response_body);
}
?>