<?php

$method = $_SERVER['REQUEST_METHOD'];
$request = split("/", substr(@$_SERVER['PATH_INFO'], 1));

switch ($method) {
  case 'PUT':
    var_dump($request);
    break;
  case 'POST':
    var_dump($request);
    break;
  case 'GET':
    var_dump($request);
    break;
  case 'DELETE':
    var_dump($request);
    break;
}

?>