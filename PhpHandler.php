<?php
require('lib/ScavengerHandler.php');
require('lib/TwiMlHelper.php');

// header("content-type: text/xml");

$message = $_GET;
$format = $message["format"];

$Scavenger = new ScavengerHandler($message, $entityManager);
$response_body = $Scavenger->CreateResponse($message);

$output = "";

if ($format == "xml")
{
    $xml = format_TwiML($response_body);
    $xmlDoc = new DOMDocument();
    $xmlDoc->loadXML($xml);
    $xmlDoc->formatOutput=true;

    $output = "<pre style='white-space: pre-wrap'>" . htmlentities($xmlDoc->saveXML()) . "</pre>";
}
else
{
    $output = $response_body["body"];
}

echo $output;


?>