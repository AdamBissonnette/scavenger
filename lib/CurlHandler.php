<?php

class CurlHandler
{
    var $url = null;

    function __construct($url)
    {
        $this->url = $url;
    }

    function DoCurl($data)
    {
        $json = json_encode($data);

        $ch = curl_init($this->url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($json))                                                                       
        );                                                                                                                   
                                                                                                                             
        return curl_exec($ch);
    }
}

?>