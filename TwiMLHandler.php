<?php header("content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8"?>';
require('bootstrap.php');
import_once('ScavengerHandler.php');

$message = $_GET;
$Scavenger = new ScavengerHandler($message);
$response_body = $Scavenger->CreateResponse($message);

echo $response_body;
?>