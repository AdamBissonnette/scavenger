<?php //header("content-type: text/xml");
include_once('ScavengerHandler.php');
echo '<?xml version="1.0" encoding="UTF-8"?>';

$message = $_GET;
$Scavenger = new ScavengerHandler($message);
$response_body = $Scavenger->CreateResponse($message);

echo $response_body;
?>