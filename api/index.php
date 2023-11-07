<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");




require 'config/database.php';
require 'ServiceType.php';
require 'ServiceProvided.php';
require 'MethodGateway.php';
require 'functions.php';


//dd($_SERVER);

$db              = new Database();
$connection      = $db->connect();
$serviceType     = new ServiceType($connection);
$serviceProvided = new ServiceProvided($connection);
$methodGateway   = new MethodGateway($serviceType);


$uri    = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
//$methodGateway->processRequest($method, $uri);


$sum = $serviceType->sum();
echo "Time saved using our services: " . json_encode($sum);

$date = $serviceProvided->filter();
echo json_encode($date);
?>