<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


require '../config/database.php';
require '../functions.php';
require '../ServiceProvided.php';
require '../MethodGateway.php';

$db              = new Database();
$connection      = $db->connect();
$serviceProvided = new ServiceProvided($connection);
$methodGateway   = new MethodGateway($serviceProvided);

$uri    = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$methodGateway->processRequest($method, $uri);
?>