<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/db.sqlite',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

function LogMessage($data, $em)
{
    // var_dump($data);
    $log = new Log();

    $log->setFrom($data["from"]);
    $log->setTo($data["to"]);
    $log->setValue($data["value"]);
    $log->setDate(new DateTime());

    $em->persist($log);
    $em->flush();
}

function MakePrettyException(Exception $e) {
$trace = $e->getTrace();

$result = 'Exception: "';
$result .= $e->getMessage();
$result .= '" @ ';
if($trace[0]['class'] != '') {
  $result .= $trace[0]['class'];
  $result .= '->';
}
$result .= $trace[0]['function'];
$result .= '();<br />';

return $result;
}