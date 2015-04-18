<?php
header('Content-type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (isset($data))
{
    require('bootstrap.php');

    $json = "{}";

    //var_dump($data);

    switch ($data->fn) {
        case 'aeclue':
            $json = addEditClue($data, $entityManager);
            break;
        case 'gclues':
            $json = getEntities($data, $entityManager, "Clue");
            break;
        case 'delclue':
            $json = deleteEntity($data, $entityManager, "Clue");
            break;
        case 'aeanswer':
            $json = addEditAnswer($data, $entityManager);
            break;
        case 'ganswers':
            $json = getEntities($data, $entityManager, "Answer");
            break;
        case 'delanswer':
            $json = deleteEntity($data, $entityManager, "Answer");
            break;
        case 'aehint':
            $json = addEditHint($data, $entityManager);
            break;
        case 'ghints':
            $json = getEntities($data, $entityManager, "Hint");
            break;
        case 'delhint':
            $json = deleteEntity($data, $entityManager, "Hint");
            break;
        case 'assignAnswer':
            assignAnswer($data, $entityManager);
            break;
        case 'assignNextClue':
            assignNextClue($data, $entityManager);
            break;
        case 'assignClueHint':
            assignClueHint($data, $entityManager);
            break;
        default:
            break;
    }

    echo $json;
}

function getEntities($data, $entityManager, $entityName)
{
    $repository = $entityManager->getRepository($entityName);
    $entities = $repository->findAll();

    $json = array();

    foreach ($entities as $entity) {
        $json[$entity->getId()] = $entity->jsonSerialize();
    }

    if (count($json) == 0)
    {
        $json = "";
    }

    return json_encode($json);
}

function deleteEntity($data, $entityManager, $entityName)
{
    $id = $data->id;

    $entity = $entityManager->find($entityName, $id);
    if ($entity) {
        $entityManager->remove($entity);
        $entityManager->flush();
    }
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

function addEditAnswer($data, $entityManager)
{
    $id = $data->id;
    $value = $data->value;

    $answer = $entityManager->find("Answer", $id);
    if (!$answer) {
        $answer = new Answer();  
    }

    $answer->setValue($value);

    $entityManager->persist($answer);
    $entityManager->flush();

    return json_encode($answer->jsonSerialize());
}

function addEditHint($data, $entityManager)
{
    $id = $data->id;
    $value = $data->value;

    $hint = $entityManager->find("Hint", $id);
    if (!$hint) {
        $hint = new Hint();  
    }

    $hint->setValue($value);

    $entityManager->persist($hint);
    $entityManager->flush();

    return json_encode($hint->jsonSerialize());
}

function getAnswersByClue($data, $entityManager)
{
    $clue = $entityManager->find("Clue", $data->clueid);

    $repository = $entityManager->getRepository("Answer");
    $answers = $repository->findAll();

    $json = array();

    foreach ($answers as $answer)
    {
        $curJSON = $answer->jsonSerialize();

        $curJSON["checked"] = in_array($answer, $clue->getAnswers()->toArray());
        
        $json[$answer->getId()] = $curJSON;
    }

    return $json;
}

function assignAnswer($data, $entityManager)
{
    $clue = $entityManager->find("Clue", $data->clueid);
    $answer = $entityManager->find("Answer", $data->answerid);

    if ($data->checked == 0)
    {
        $clue->removeAnswer($answer);
    }
    else
    {
        $clue->addAnswer($answer);
    }

    $entityManager->flush();
}

function assignNextClue($data, $entityManager)
{
    $clue = $entityManager->find("Clue", $data->clueid);
    $answer = $entityManager->find("Answer", $data->answerid);

    if ($data->checked == 0)
    {
        $clue->removeTrailing($answer);
    }
    else
    {
        $clue->addTrailing($answer);
    }

    $entityManager->flush();
}

function assignClueHint($data, $entityManager)
{
    $clue = $entityManager->find("Clue", $data->clueid);
    $hint = $entityManager->find("Hint", $data->hintid);

    if ($data->checked == 0)
    {
        $clue->removeHint($hint);
    }
    else
    {
        $clue->addHint($hint);
    }

    $entityManager->flush();
}
