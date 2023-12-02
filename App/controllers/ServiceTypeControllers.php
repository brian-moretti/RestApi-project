<?php

namespace App\Controllers;

use Core\Response;
use App\models\ServiceType;

class ServiceTypeControllers
{

    private $data;
    public function __construct()
    {
        $this->data = json_decode(file_get_contents('php://input'), true);
        /*$_GET['id'] ?
                 $this->processResourceRequest(Request::method(), $_GET['id']) :
                 $this->processCollectionRequest(Request::method()); */
    }
    public function readAll()
    {
        $statement = ServiceType::readAll();
        Response::get(200, $statement);
    }

    public function read()
    {
        $id        = $_GET['id'];
        $statement = ServiceType::read($id);
        if (!$statement) {
            Response::get(404, "Service with ID: $id not founded");
        }
        Response::get(200, $statement);
    }

    public function create()
    {
        $newService = $this->data;

        if (!empty($newService)) {
            $statement = ServiceType::create($newService);
            Response::get(201, ["New element with ID: {$statement} is created as follow:" => $newService]);
        } else {
            Response::get(400, "The body request is not correct, please try again");
        }
    }

    public function update()
    {
        $id             = $_GET['id'];
        $currentService = ServiceType::read($id);
        $newService     = $this->data;

        if (!empty($newService)) {
            ServiceType::update($currentService, $newService);
            Response::get(200, ["Service with ID: $id has been updated as follow:" => $newService]);
        } else {
            Response::get(400, "The body request is not correct, please try again");
        }
        ;

    }

    public function delete()
    {
        $id        = $_GET['id'];
        $statement = ServiceType::delete($id);
        if (!$statement) {
            Response::get(404, "This ID has not been found in the database");
        }
        Response::get(200, "Service with ID: $id has been successfully cancelled");
    }

    public function sum()
    {
        $statement = ServiceType::sum();
        Response::get(200, $statement);
    }
}

?>