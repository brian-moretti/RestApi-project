<?php


header("Content-Type: application/json; charset=UTF-8");

require "../config/database.php";
require "../models/ServiceProvided.php";
require "../models/ServiceType.php";

$db              = new Database();
$connection      = $db->connect();
$serviceProvided = new ServiceProvided($connection);
$serviceType     = new ServiceType($connection);


$totalTimeSaved    = $serviceType->sum();
$servicesTimeSaved = $serviceProvided->sum();

echo json_encode([
    'Total Time Saved with our services' => $totalTimeSaved,
    "Time Saved per service"             => $servicesTimeSaved
]);

?>