<?php

class ServiceProvided
{

    private $connection;
    private $table_name = "service_provided";
    public function __construct($database)
    {
        $this->connection = $database;
    }

    public function create($data)
    {
        $query     = "INSERT INTO {$this->table_name} (selling_date, quantity, service_type_id) VALUES (:selling_date, :quantity, :service_type_id)";
        $statement = $this->connection->prepare($query);

        //! ID servizio va prelevato da ServiceType??
        $data['selling_date']    = htmlspecialchars(strip_tags($data['selling_date']));
        $data['quantity']        = htmlspecialchars(strip_tags($data['quantity']));
        $data['service_type_id'] = htmlspecialchars(strip_tags($data['service_type_id']));

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
        $query     = "SELECT sp.id, service_type_id, name, time_saved, selling_date, quantity  FROM {$this->table_name} AS sp INNER JOIN service_type AS st ON st.id = sp.service_type_id WHERE sp.id = :id";
        $statement = $this->connection->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetch(PDO::FETCH_ASSOC);
        return $results;
    }

    public function readAll()
    {
        //! TEMPO TOTALE QUA DENTRO?!

        $query = "SELECT sp.id, service_type_id, st.name, time_saved, selling_date, quantity FROM {$this->table_name} AS sp INNER JOIN service_type AS st ON st.id = service_type_id";

        $fromDate = $_GET['from'] ?? null;
        $toDate   = $_GET['to'] ?? null;
        $service  = $_GET['name'] ?? null;
        $params   = [];

        if ($fromDate) {
            $query .= " WHERE selling_date >= :from";
            $params[':from'] = $fromDate;
        }
        if ($toDate) {
            $query .= ($fromDate ? ' AND' : ' WHERE') . " selling_date <= :to";
            $params[':to'] = $toDate;
        }
        if ($service) {
            $query .= ($toDate || $fromDate ? ' AND' : ' WHERE') . ' name = :service';
            $params[':service'] = $service;
        }

        $query .= " ORDER BY service_type_id";

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
        $query     = "UPDATE {$this->table_name} SET selling_date = :selling_date, quantity = :quantity WHERE id = :id";
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
        $query     = "DELETE FROM {$this->table_name} WHERE id = :id";
        $statement = $this->connection->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $statement->bindParam(":id", $id, PDO::PARAM_INT);

        return $statement->execute() && $statement->rowCount() > 0;
    }

    public function sum()
    {
        //$totalTime = $_GET['total_time'] ?? null;
        //if ($totalTime && $totalTime == true) {
        $query = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(time_saved))) as time_saved, name FROM {$this->table_name} INNER JOIN service_type AS st ON st.id = service_type_id";

        $fromDate = $_GET['from'] ?? null;
        $toDate   = $_GET['to'] ?? null;
        $service  = $_GET['name'] ?? null;
        $params   = [];

        if ($fromDate) {
            $query .= " WHERE selling_date >= :from";
            $params[':from'] = $fromDate;
        }
        if ($toDate) {
            $query .= ($fromDate ? ' AND' : ' WHERE') . " selling_date <= :to";
            $params[':to'] = $toDate;
        }
        if ($service) {
            $query .= ($toDate || $fromDate ? ' AND' : ' WHERE') . ' name = :service';
            $params[':service'] = $service;
        }

        $query .= " GROUP BY name";

        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        $sum = $statement->fetchAll();
        return $sum;
    }
    //  return;
    // }
}
?>