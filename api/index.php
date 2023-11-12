<?php


echo "Change the URL to one of the following to get access to the information about API" . json_encode([
    "/service-type"          => [
        "Description"    => "Get access to our services",
        "Method Allowed" => "GET | POST (body required)"
    ],
    "/service-type/{id}"     => [
        "Description"    => "Get access to, modify or delete a specific ID service",
        "Method Allowed" => "GET | PATCH | DELETE"
    ],
    "/service-provided"      => [
        "Description"    => "Get access to the services provided",
        "Method Allowed" => "GET | POST (body required)",
        "Additional"     => "Possibility to filter date throught these params: 'from' | 'to' | 'name'"
    ],
    "/service-provided/{id}" => [
        "Description"    => "Get access to, modify or delete a specific ID service",
        "Method Allowed" => "GET | PATCH | DELETE"
    ],
    "/total-time-saved"      => [
        "Description" => "Get access to both the total time saved with all the existing services and with all the services provided ordered by name",
    ]
]);

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

//header('location: http://localhost:8888/api');

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
?>