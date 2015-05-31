<?php
require('lib/ScavengerHandler.php');
require('lib/TwiMlHelper.php');

// header("content-type: text/xml");

$message = $_GET;
$Scavenger = new ScavengerHandler($message, $entityManager);
$response_body = $Scavenger->CreateResponse($message);

$xml = format_TwiML($response_body);
$xmlDoc = new DOMDocument();
$xmlDoc->loadXML($xml);
$xmlDoc->formatOutput=true;

echo "<pre style='white-space: pre-wrap'>" . htmlentities($xmlDoc->saveXML()) . "</pre>";
?>