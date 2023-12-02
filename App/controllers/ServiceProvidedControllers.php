<?php

namespace App\Controllers;

use App\models\ServiceProvided;
use Core\Response;

class ServiceProvidedControllers
{

    private $data;

    public function __construct()
    {
        $this->data = json_decode(file_get_contents('php://input'), true);
    }

    public function readAll()
    {
        $statement = ServiceProvided::readAll();
        Response::get(200, $statement);
    }

    public function read()
    {
        $id        = $_GET['id'];
        $statement = ServiceProvided::read($id);
        if (!$statement) {
            Response::get(404, "No service provided has been founded with the ID: $id");
        }
        Response::get(200, $statement);
    }

    public function create()
    {
        $newServiceProvided = $this->data;
        if (!empty($newServiceProvided)) {
            $statement = ServiceProvided::create($newServiceProvided);
            Response::get(201, ["New service provided with ID: {$statement}" => $newServiceProvided]);
        } else {
            Response::get(400, "The body request is not correct, please try again");
        }
    }

    public function update()
    {
        $id                     = $_GET['id'];
        $newServiceProvided     = $this->data;
        $currentServiceProvided = ServiceProvided::read($id);

        if (!empty($newServiceProvided)) {
            ServiceProvided::update($currentServiceProvided, $newServiceProvided);
            Response::get(200, ["The service provided with ID: $id, has been updated" => $newServiceProvided]);
        } else {
            Response::get(400, "The body request is not correct, please try again");
        }
    }

    public function delete()
    {
        $id        = $_GET['id'];
        $statement = ServiceProvided::delete($id);
        if (!$statement) {
            Response::get(404, "This ID has not been found in the database");
        }
        Response::get(200, "The service provided with ID: $id has been successfully cancelled");
    }
}

?>