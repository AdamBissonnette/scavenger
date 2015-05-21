<?php
header('Content-type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (isset($data))
{
    require('bootstrap.php');

    $json = "{}";

    //var_dump($data);

    switch ($data->fn) {
        case 'getEntities':
            $json = getEntities($data, $entityManager);
        break;
        case 'deleteEntity':
            $json = deleteEntity($data, $entityManager);
        break;
        case 'aeclue':
            $json = addEditClue($data, $entityManager);
            break;
        case 'aeanswer':
            $json = addEditAnswer($data, $entityManager);
            break;
        case 'aehint':
            $json = addEditHint($data, $entityManager);
            break;
        case 'aestory':
            $json = addEditStory($data, $entityManager);
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

function getEntities($data, $entityManager)
{
    $entityName = $data->entityName;

    $repository = $entityManager->getRepository($entityName);
    $entities = $repository->findBy(array("state" => 1));

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

function deleteEntity($data, $entityManager)
{
    $id = $data->id;
    $entityName = $data->entityName;

    $entity = $entityManager->find($entityName, $id);
    if ($entity) {
        //$entityManager->remove($entity);
        $entity->setState(0);
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
    $name = $data->name;
    $value = $data->value;

    $answer = $entityManager->find("Answer", $id);
    if (!$answer) {
        $answer = new Answer();  
    }

    $answer->setName($name);
    $answer->setValue($value);
    $clue = $entityManager->find("Clue", $data->clueid);
    $data->checked = ($clue != null)?1:0;

    $entityManager->persist($answer);

    if ($clue != null)
    {
        assignNextClue($data, $entityManager, $clue, $answer);
    }

    $entityManager->flush();

    return json_encode($answer->jsonSerialize());
}

function addEditHint($data, $entityManager)
{
    $id = $data->id;
    $name = $data->name;
    $value = $data->value;

    $hint = $entityManager->find("Hint", $id);
    if (!$hint) {
        $hint = new Hint();  
    }

    $hint->setName($name);
    $hint->setValue($value);
    $clue = $entityManager->find("Clue", $data->clue);
    $data->checked = ($clue != null)?1:0;

    $entityManager->persist($hint);

    if ($clue != null)
    {
        assignClueHint($data, $entityManager, $clue, $hint);
    }

    $entityManager->flush();

    return json_encode($hint->jsonSerialize());
}

function addEditStory($data, $entityManager)
{
    $id = $data->id;
    $name = $data->name;
    $description = $data->description;
    $clueid = $data->clueid;

    $story = $entityManager->find("Story", $id);
    if (!$story) {
        $story = new Story();  
    }

    $story->setName($name);
    $story->setDescription($description);

    $entityManager->persist($story);

    $clue = $entityManager->find("Clue", $data->clueid);
    $data->checked = ($clue != null)?1:0;
    // assignNextClue($data, $entityManager, $clue, $answer);

    $story->setFirstClue($clue);

    $entityManager->flush();

    return json_encode($story->jsonSerialize());
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

function assignNextClue($data, $entityManager, $clue = null, $answer = null)
{
    if ($clue == null)
    {
        $clue = $entityManager->find("Clue", $data->clueid);
    }

    if ($answer == null)
    {
        $answer = $entityManager->find("Answer", $data->answerid);
    }

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

function assignClueHint($data, $entityManager, $clue=null, $hint=null)
{
    if ($clue == null)
    {
        $clue = $entityManager->find("Clue", $data->clue);
    }

    if ($hint == null)
    {
        $hint = $entityManager->find("Hint", $data->hintid);
    }    

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
