<?php

class ServiceProvided
{

    private $connection;
    private $table_name = "service_provided";
    private $service_type_id;
    public function __construct($database)
    {
        $this->connection = $database;
    }

    public function create($data)
    {
        $query     = "INSERT INTO {$this->table_name} (selling_date, quantity, service_type_id) VALUES (:selling_date, :quantity, :service_type_id)";
        $statement = $this->connection->prepare($query);

        //! ID servizio va prelevato da ServiceType??
        $data['selling_date'] = htmlspecialchars(strip_tags($data['selling_date']));
        $data['quantity']     = htmlspecialchars(strip_tags($data['quantity']));
        $data['id']           = htmlspecialchars(strip_tags($data['id']));

        $statement->bindValue(":selling_date", $data['selling_date']);
        $statement->bindValue(":quantity", $data['quantity'], PDO::PARAM_INT);
        $statement->bindValue(":service_type_id", $data['id'], PDO::PARAM_INT);

        $statement->execute();
        if ($statement->rowCount() > 0) {
            $result = $this->connection->lastInsertId();
            return $result;
        }
        return false;
    }
    public function read($id)
    {
        $query     = "SELECT id, name, time_saved, selling_date, quantity  FROM service_type INNER JOIN {$this->table_name} ON id = service_type_id WHERE service_type_id = :id";
        $statement = $this->connection->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetch(PDO::FETCH_ASSOC);
        return $results;
    }

    public function readAll()
    {
        $query = "SELECT id, name, time_saved, selling_date, quantity FROM {$this->table_name} INNER JOIN service_type ON id = service_type_id";

        $fromDate = $_GET['from'] ?? null;
        $toDate   = $_GET['to'] ?? null;
        $service  = $_GET['name'] ?? null;
        $params   = [];

        if ($fromDate) {
            $query .= " WHERE selling_date >= :from";
            $params['from'] = $fromDate;
        }
        if ($toDate) {
            $query .= ($fromDate ? ' AND' : ' WHERE') . " selling_date <= :to";
            $params[':to'] = $toDate;
        }


        if ($service) {
            $query .= ($toDate || $fromDate ? ' AND' : ' WHERE') . ' name = :service';
            $params[':service'] = $service;
        }
        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        $results['provided'] = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            array_push($results['provided'], $row);
        }
        return $results;

    }
    public function update($currentData, $newData)
    {
        $query     = "UPDATE {$this->table_name} SET selling_date = :selling_date, quantity = :quantity WHERE service_type_id = :id";
        $statement = $this->connection->prepare($query);

        $newData['selling_date'] = htmlspecialchars(strip_tags($newData['selling_date'] ?? ''));
        $newData['quantity']     = htmlspecialchars(strip_tags($newData['quantity'] ?? ''));

        $statement->bindParam(":id", $currentData['id'], PDO::PARAM_INT);
        $statement->bindValue(':selling_date', $newData['selling_date'] ?? $currentData['selling_date']);
        $statement->bindValue(':quantity', $newData['quantity'] ?? $currentData['quantity'], PDO::PARAM_INT);

        return $statement->execute() && $statement->rowCount() > 0;

    }
    public function delete($id)
    //! DELETE CASCADE SU TYPE
    {
        $query     = "DELETE FROM {$this->table_name} WHERE service_type_id = :id";
        $statement = $this->connection->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $statement->bindParam(":id", $id, PDO::PARAM_INT);

        return $statement->execute() && $statement->rowCount() > 0;
    }

    public function filter()
    {
        $query = "SELECT name, quantity, selling_date FROM {$this->table_name} INNER JOIN service_type ON id = service_type_id";

        $fromDate = $_GET['from'] ?? null;
        $toDate   = $_GET['to'] ?? null;
        $service  = $_GET['name'] ?? null;
        $params   = [];

        if ($fromDate) {
            $query .= " WHERE selling_date >= :from";
            $params['from'] = $fromDate;
        }
        if ($toDate) {
            $query .= ($fromDate ? ' AND' : ' WHERE') . " selling_date <= :to";
            $params[':to'] = $toDate;
        }

        if ($service) {
            $query .= ($toDate ? ' AND' : ' WHERE') . ' name = :service';
            $params[':service'] = $service;
        }

        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        $date = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $date;
    }
}
?>