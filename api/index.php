<?php


echo "Change the URL to one of the following to get access to the information about API" . json_encode([
    "/api/service-type"          => [
        "Description"    => "Get access to our services",
        "Method Allowed" => "GET | POST (body required)"
    ],
    "/api/service-type/{id}"     => [
        "Description"    => "Get access to, modify or delete a specific ID service",
        "Method Allowed" => "GET | PATCH | DELETE"
    ],
    "/api/service-provided"      => [
        "Description"    => "Get access to the services provided",
        "Method Allowed" => "GET | POST (body required)",
        "Additional"     => "Possibility to filter date throught these params: 'from' | 'to' | 'name'"
    ],
    "/api/service-provided/{id}" => [
        "Description"    => "Get access to, modify or delete a specific ID service",
        "Method Allowed" => "GET | PATCH | DELETE"
    ],
    "/api/total-time-saved"      => [
        "Description" => "Get access to both the total time saved with all the existing services and with all the services provided ordered by name",
    ]
]);

header("Content-Type: application/json; charset=UTF-8");

?>