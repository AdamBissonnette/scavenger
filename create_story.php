<?php
require_once "bootstrap.php";

$storyName = $argv[1];
$storyDescription = $argv[2];

$story = new Story();
$story->setName($storyName);
$story->setDescription($storyDescription);

$entityManager->persist($story);
$entityManager->flush();

echo "Created Story " . $story->toString() . "\n";