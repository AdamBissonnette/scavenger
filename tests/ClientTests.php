<?php

    $data = array("fn" => "post", "entityName" => "Party", "id" => -1,"name" => "steve");
    $json = json_encode($data);

    $ch = curl_init('http://sandbox:1234/scavenger/webhooks.php');                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($json))                                                                       
    );                                                                                                                   
                                                                                                                         
    $result = curl_exec($ch);

    var_dump($result);

?>