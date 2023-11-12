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
                        'message'     => "New element with ID: $result added to service type with ID: {$data['service_type_id']}",
                        "ID: $result" => $data
                    ]);
                    break;
                default:
                    echo json_encode(["Error Message" => "Models or class not founded"]);
                    break;
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "The body request is not correct, please try again"]);
        }
    }

    public function getAll()
    {
        $statement = $this->serviceClass->readAll();
        if (count($statement) <= 0) {
            echo json_encode(["message" => "Sorry, no element available"]);
            return;
        }
        http_response_code(200);
        echo json_encode($statement);
    }

    public function update($statement, $data)
    {

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
                        'message'                                     => "Element with ID: {$statement['id']} updated",
                        "Service ID: {$statement['service_type_id']}" => $data
                    ]);

                    break;
                default:
                    echo json_encode(["Error Message" => "Models or class not founded"]);
                    break;
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "The body request is not correct, please try again"]);
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

    public function totalTimeSaved()
    {
        $sum = $this->serviceClass->sum();
        if ($sum) {
            echo "Time saved using our services: " . json_encode($sum);
        }
    }
    public function processRequest($method, $uri)
    {
        $id      = basename($uri);
        $pattern = '#^/api/([A-Za-z-]+)(?:/(\d+))?$#';
        //! OCCHIO CAMBIO URL
        preg_match($pattern, $uri, $matches);
        $findID = $matches[2] ?? null;
        if ($findID === $id) {
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
            echo json_encode(['Error' => "Element with ID: $id not founded"]);
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
            case ('GET' && ($_GET['total_time'] ?? null)):
                $this->totalTimeSaved();
                break;
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