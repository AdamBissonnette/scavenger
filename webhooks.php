<?php

header('Content-type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (isset($data))
{
    if (isset($data->fn) && isset($data->entityName))
    {
        require('bootstrap.php');
        require('lib/EntityHelper.php');

        $json = "{}";
        $entity = "";
        $message = "";

        switch ($data->fn) {
            case 'GET':
                try { $entity = getEntity($data, $entityManager); } catch(Exception $e) {$message = $e->getMessage();};
                $logdata = array('from' => "curl", 'to' => "webhook", 'value' => $message, 'data' => $entity, 'direction' => LogTypes::DIRECTION_INCOMING, 'type' => LogTypes::TYPE_GET_PARTY);
            break;
            case 'POST':
                 switch($data->entityName) {
                    case 'Party':
                        try { $entity = addEditParty($data, $entityManager); } catch(Exception $e) {$message = $e->getMessage();};
                        $logdata = array('from' => "curl", 'to' => "webhook", 'value' => $message, 'data' => $entity, 'direction' => LogTypes::DIRECTION_INCOMING, 'type' => LogTypes::TYPE_POST_PARTY);    
                    break;
                    case 'User':
                        try { $entity = addEditUser($data, $entityManager); } catch(Exception $e) {$message = $e->getMessage();};
                        $logdata = array('from' => "curl", 'to' => "webhook", 'value' => $message, 'data' => $entity, 'direction' => LogTypes::DIRECTION_INCOMING, 'type' => LogTypes::TYPE_POST_USER);    
                    break;
                    case 'Hunt':
                        try { $entity = addEditHunt($data, $entityManager); } catch(Exception $e) {$message = $e->getMessage();};
                        $logdata = array('from' => "curl", 'to' => "webhook", 'value' => $message, 'data' => $entity, 'direction' => LogTypes::DIRECTION_INCOMING, 'type' => LogTypes::TYPE_POST_HUNT);
                    break;
                    default:
                        exit(0);
                    break;
                }
            break;
            case 'DELETE':
                try { $entity = deleteEntity($data, $entityManager); } catch(Exception $e) {$message = $e->getMessage();};
                $logdata = array('from' => "curl", 'to' => "webhook", 'value' => $message, 'data' => $entity, 'direction' => LogTypes::DIRECTION_INCOMING, 'type' => LogTypes::TYPE_DELETE_USER);
            break;
            default:
                exit(0);
            break;
        }

        $json = json_encode(LogMessage($logdata, $entityManager, null, null)->jsonSerialize());

        echo $json;
    }
}

?>