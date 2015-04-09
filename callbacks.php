<?php
header('Content-type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (isset($data))
{
    require('bootstrap.php');

    $json = "";

    switch ($data->fn) {
        case 'aeclue':
            $json = addEditClue($data, $entityManager);
            break;
        case 'gclues':
            $json = getClues($data, $entityManager);
            break;
        case 'delclue':
            $json = deleteClue($data, $entityManager);
            break;
        default:
            break;
    }

    echo $json;
}

function addEditClue($data, $entityManager)
{
    $id = $data->id;
    $name = $data->name;
    $value = $data->value;

    $clue = $entityManager->find("Clue", $id);
    if (!$clue) {
        $clue = new Clue();  
    }

    $clue->setName($name);
    $clue->setValue($value);

    $entityManager->persist($clue);
    $entityManager->flush();

    return json_encode($clue->jsonSerialize());
}

function getClues($data, $entityManager)
{
    $repository = $entityManager->getRepository('Clue');
    $clues = $repository->findAll();

    $json = array();

    foreach ($clues as $clue) {
        $json[$clue->getId()] = $clue->jsonSerialize();
    }

    return json_encode($json);
}

function deleteClue($data, $entityManager)
{
    $id = $data->id;

    $clue = $entityManager->find("Clue", $id);
    if ($clue) {
        $entityManager->remove($clue);
        $entityManager->flush();
    }
}