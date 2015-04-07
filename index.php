<?php

require_once "bootstrap.php";

$clueRepo = $entityManager->getRepository('Answer');
$clues = $clueRepo->findAll();

foreach ($clues as $clue) {
    echo $clue->toString() . "\n" ;
}