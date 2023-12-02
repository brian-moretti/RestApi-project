<?php

namespace App\Controllers;

use Core\Response;

class RestControllers
{

    public static function home()
    {
        Response::get(200, [
            "Route defined" => [
                "/api/service-type",
                "/api/service-type/{id}",
                "/api/service-provided",
                "/api/service-provided/{id}",
                "/api/total-time-saved"
            ]
        ]);
    }
}

?>