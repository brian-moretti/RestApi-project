<?php

class ServiceType
{

    private $connection;
    private $table_name = "service_type";
    public function __construct($database)
    {
        $this->connection = $database;
    }

    public function create($data)
    {
        $query = "INSERT INTO {$this->table_name} (name, time_saved) VALUES (:name, :time_saved)";
        //$query2    = "INSERT INTO {$this->table_name} SET (name = :name, time_saved = :time_saved)";

        $statement = $this->connection->prepare($query);

        $statement->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $statement->bindValue(':time_saved', $data['time_saved'], PDO::PARAM_STR);
        //bindParams($statement, [':name' => $this->name, ':time_saved' => $this->time_saved]);

        $statement->execute();
        if ($statement->rowCount() > 0) {
            $result = $this->connection->lastInsertId();
            return $result;
        }
        return false;

    }

    public function read($id)
    {
        $query     = "SELECT * FROM {$this->table_name} WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $id        = htmlspecialchars(strip_tags($id));
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetch(PDO::FETCH_ASSOC);
        return $results;
    }
    public function readAll()
    {
        $query     = "SELECT * FROM {$this->table_name}";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $results['type'] = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            array_push($results['type'], $row);
        }
        return $results;
    }
    public function update($currentData, $newData)
    {
        $query     = "UPDATE {$this->table_name} SET name = :name, time_saved = :time_saved WHERE id = :id";
        $statement = $this->connection->prepare($query);

        $newData['name']       = htmlspecialchars(strip_tags($newData['name'] ?? ''));
        $newData['time_saved'] = htmlspecialchars(strip_tags($newData['time_saved'] ?? ''));

        $statement->bindParam(":id", $currentData['id'], PDO::PARAM_INT);
        $statement->bindValue(":name", $newData['name'] ?? $currentData['name'], PDO::PARAM_STR);
        $statement->bindValue(":time_saved", $newData['time_saved'] ?? $currentData['time_saved'], PDO::PARAM_STR);

        return $statement->execute() && $statement->rowCount() > 0;
    }
    public function delete($id)
    {
        $query     = "DELETE FROM {$this->table_name} WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $id        = htmlspecialchars(strip_tags($id));
        $statement->bindParam(":id", $id, PDO::PARAM_INT);

        return $statement->execute() && $statement->rowCount() > 0;
    }

    public function sum()
    {
        //$totalTime = $_GET['total_time'] ?? null;
        //if ($totalTime && $totalTime == true) {
        $query     = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(time_saved))) FROM {$this->table_name}";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $sum = $statement->fetchColumn();
        return $sum;
        // }
        //return;
    }
}

?>