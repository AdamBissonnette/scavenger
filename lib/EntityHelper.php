<?php

function getEntities($data, $entityManager)
{
    $entityName = $data->entityName;

    $repository = $entityManager->getRepository($entityName);
    $entities = $repository->findBy(array("state" => 1));

    $json = array();

    foreach ($entities as $entity) {
        $json[json_encode($entity->getId())] = $entity->jsonSerialize();
    }

    if (count($json) == 0)
    {
        $json = "";
    }

    return json_encode($json);
}

function getEntity($data, $entityManager)
{
    $id = $data->id;
    $entityName = $data->entityName;

    $entity = $entityManager->find($entityName, $id);

    return $entity->jsonSerialize();
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

    $story->setFirstClue($clue);

    $entityManager->flush();

    return json_encode($story->jsonSerialize());
}

function addEditParty($data, $entityManager)
{
    $id = $data->id;
    $name = $data->name;

    $party = $entityManager->find("Party", $id);
    if (!$party) {
        $party = new Party();  
    }

    $party->setName($name);
    $entityManager->persist($party);
    $entityManager->flush();

    return json_encode($party->jsonSerialize());
}

function addEditHunt($data, $entityManager)
{
    $id = $data->id;

    $start = null;
    if ($data->start != "")
    {
        $start = $data->start;
    }

    $end = null;
    if ($data->end != "")
    {
        $end = $data->end;
    }

    $hintsUsed = $data->hintsUsed;

    $clue = $data->clue;
    $party = $data->party;
    $story = $data->story;

    $hunt = $entityManager->find("Hunt", $id);
    if (!$hunt) {
        $hunt = new Hunt();  
    }

    $hunt->setStart($start);
    $hunt->setEnd($end);
    $hunt->setHintsUsed($hintsUsed);

    if ($clue != null)
    {
        $clue = $entityManager->find("Clue", $clue);
        $hunt->setCurrentClue($clue);
    }

    if ($party != null)
    {
        $party = $entityManager->find("Party", $party);
        $hunt->setParty($party);
    }

    if ($story != null)
    {
        $story = $entityManager->find("Story", $story);
        $hunt->setStory($story);
    }

    $entityManager->persist($hunt);
    $entityManager->flush();

    return json_encode($hunt->jsonSerialize());
}

function addEditUser($data, $entityManager)
{
    $id = $data->id;
    $name = $data->name;
    $email = $data->email;
    $phone = $data->phone;
    $party = $data->party;

    if (isset($data->party))
    {
        $party = $entityManager->find("Party", $party);
    }
    else
    {
        $party = null;
    }
    

    $user = $entityManager->find("User", $id);
    if (!$user) {
        $user = new User();  
        $user->setRegistrationDate(new DateTime());
    }

    $user->setName($name);
    $user->setEmail($email);
    $user->setPhone($phone);
    $user->setParty($party);
    
    $entityManager->persist($user);
    $entityManager->flush();

    return json_encode($user->jsonSerialize());
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


?>