<?php


require '../config/database.php';
require '../functions.php';
require '../models/ServiceProvided.php';
require '../controllers/MethodGateway.php';
headerParams();

$db              = new Database();
$connection      = $db->connect();
$serviceProvided = new ServiceProvided($connection);
$methodGateway   = new MethodGateway($serviceProvided);

$uri    = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$methodGateway->processRequest($method, $uri);
?>