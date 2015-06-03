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

        switch ($data->fn) {
            case 'get':
                $json = getEntity($data, $entityManager);
            break;
            case 'put':
            case 'post':
                 switch($data->entityName) {
                    case 'Party':
                        $json = addEditParty($data, $entityManager);
                    break;
                    case 'User':
                        $json = addEditUser($data, $entityManager);
                    break;
                    case 'Hunt':
                        $json = addEditUser($data, $entityManager);
                    break;
                    default:
                        exit(0);
                    break;
                }
            break;
            case 'delete':
                $json = deleteEntity($data, $entityManager);
            break;
            default:
                exit(0);
            break;
        }

        echo $json;
    }
}

?>