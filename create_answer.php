<?php
require_once "bootstrap.php";

$clueID = $argv[1];
$answerValue = $argv[2];

$clue = $entityManager->find("Clue", $clueID);
if (!$clueID) {
    echo "No clue ID.\n";
    exit(1);
}

$answer = new Answer();
$answer->setValue($answerValue);
$answer->setNextClue($clue);

$entityManager->persist($answer);
$entityManager->flush();

echo "Your new Answer Id: ".$answer->getId()."\n";