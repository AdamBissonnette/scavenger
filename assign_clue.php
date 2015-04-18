<?php
require_once "bootstrap.php";

$clueID = $argv[1];
$answerID = $argv[2];

$clue = $entityManager->find("Clue", $clueID);
$answer = $entityManager->find("Answer", $answerID);

$clue->addTrailing($answer);
$answer->setClue($clue);

$entityManager->flush();

echo "\n\nClue:\n\n";

var_dump(json_encode($clue));

echo "\n\nAnswer:\n\n";

var_dump(json_encode($answer));
