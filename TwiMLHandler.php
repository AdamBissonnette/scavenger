<?php
require('lib/ScavengerHandler.php');
require('lib/TwiMlHelper.php');

header("content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8"?>';

$message = $_GET;
$Scavenger = new ScavengerHandler($message, $entityManager);
$response_body = $Scavenger->CreateResponse($message);

echo format_twiML($response_body);
?>