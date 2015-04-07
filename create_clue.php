<?php
require_once "bootstrap.php";
$newClue = $argv[1];
$clue = new Clue();
$clue->setClue($newClue);
$entityManager->persist($clue);
$entityManager->flush();
echo "Created Clue with ID " . $clue->getId() . "\n";