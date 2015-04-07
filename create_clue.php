<?php
require_once "bootstrap.php";

$storyID = $argv[1];
$clueValue = $argv[2];

$story = $entityManager->find("Story", $storyID);
if (!$story) {
    echo "No story.\n";
    exit(1);
}

$clue = new Clue();
$clue->setValue($clueValue);
$story->addClue($clue);

$entityManager->persist($clue);
$entityManager->flush();

echo "Created Clue " . $clue->toString() . "\n";