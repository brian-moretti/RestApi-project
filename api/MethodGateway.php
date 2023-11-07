<?php

class MethodGateway
{
    private $serviceClass;
    private $data;

    public function __construct($serviceClass)
    {
        $this->serviceClass = $serviceClass;
        $this->data         = json_decode(file_get_contents('php://input'), true);
    }
    public function create($data)
    {
        if (!empty($data)) {
            switch ($this->serviceClass::class) {
                case 'ServiceType':
                    $result = $this->serviceClass->create($data);
                    http_response_code(201);
                    echo json_encode([
                        'message'       => "New element with ID: {$result} is created",
                        "ID: {$result}" => $data
                    ]);
                    break;
                case 'ServiceProvided':
                    $result = $this->serviceClass->create($data);
                    http_response_code(201);
                    echo json_encode([
                        'message'       => "New element with ID: {$result} is created",
                        "ID: {$result}" => $data
                    ]);
                    break;
                default:
                    echo 'Error - Class not founded';
                    break;
            }
        } else {
            http_response_code(400);
            echo 'Super Error';
        }
    }

    public function getAll()
    {
        $statement = $this->serviceClass->readAll();
        if (count($statement) <= 0) {
            echo "No element available";
            return;
        }
        http_response_code(200);
        echo json_encode($statement);
    }

    public function update($statement, $data)
    {
        //se sono uguali


        if (!empty($data)) {
            switch ($this->serviceClass::class) {
                case 'ServiceType':
                    $this->serviceClass->update($statement, $data);
                    http_response_code(200);
                    echo json_encode([
                        'message'                => "Element updated",
                        "ID: {$statement['id']}" => $data
                    ]);

                    break;
                case 'ServiceProvided':
                    $this->serviceClass->update($statement, $data);
                    http_response_code(200);
                    echo json_encode([
                        'message' => "Element updated",
                        "ID: {$statement['id']}" => $data
                    ]);

                    break;
                default:
                    echo 'Error - Class not founded';
                    break;
            }
        } else {
            http_response_code(400);
            echo 'Super Error';
        }

    }

    public function delete($id)
    {
        $this->serviceClass->delete($id);
        http_response_code(200);
        echo json_encode([
            'Message' => "Element deleted",
            "Element" => "ID: $id"
        ]);
    }
    public function processRequest($method, $uri)
    {
        $id      = basename($uri);
        $pattern = '#^/api/([A-Za-z-]+)(?:/(\d+))?$#';
        //! OCCHIO CAMBIO URL
        preg_match($pattern, $uri, $matches);
        $test = $matches[2] ?? null;
        if ($test === $id) {
            $this->processResourceRequest($method, $id);
        } else {
            $this->processCollectionRequest($method);
        }
    }
    public function processResourceRequest($method, $id)
    {
        $statement = $this->serviceClass->read($id);
        if (!$statement) {
            http_response_code(404);
            echo json_encode(['Error' => 'Element not founded']);
            return;
        }

        switch ($method) {
            case 'GET':
                http_response_code(200);
                echo json_encode($statement);
                break;
            case 'PATCH':
                $this->update($statement, $this->data);
                break;
            case 'DELETE':
                $this->delete($id);
                break;
            default:
                http_response_code(405);
                break;
        }
    }

    public function processCollectionRequest($method)
    {
        switch ($method) {
            case 'GET':
                $this->getAll();
                break;
            case 'POST':
                $this->create($this->data);
                break;
            default:
                http_response_code(405);
                break;
        }
    }
}


?>