<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require '../functions.php';
require '../config/database.php';
require '../ServiceType.php';
require '../MethodGateway.php';

$db            = new Database();
$connection    = $db->connect();
$serviceType   = new ServiceType($connection);
$methodGateway = new MethodGateway($serviceType);


$uri    = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$methodGateway->processRequest($method, $uri);
?>