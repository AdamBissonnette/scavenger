<?php
require_once "bootstrap.php";

$value = $argv[1];

$hint = new Hint();
$hint->setValue($value);
// $hint->setPriority(1);
// $hint->setUsesLifeline(1);

$qb = $entityManager->createQueryBuilder();

$entityManager->persist($hint);
$entityManager->flush();

echo "Created Hint " . $hint->toString() . "\n";