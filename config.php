<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

return [
    'database' => [
        'host'     => $_ENV['CONNECTION'],
        'port'     => $_ENV['PORT'],
        'dbname'   => $_ENV['DB_NAME'],
        'user'     => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS'],
        'charset'  => $_ENV['CHARSET'],
        'option'   => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    ]
]

    ?>