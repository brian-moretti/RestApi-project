<?php

namespace App\models;

use Core\App;
use Core\Response;
use PDO;

class ServiceProvided
{
    private static $table_name = "service_provided";

    public static function readAll()
    {
        $query = "SELECT sp.id, st.name, service_type_id, time_saved, selling_date, quantity FROM " . self::$table_name . " AS sp INNER JOIN service_type AS st ON st.id = service_type_id";

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

        $query .= " ORDER BY sp.id";

        $statement = App::resolver('database')::query($query, $params);

        $results = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            array_push($results, $row);
        }
        return $results;
    }

    public static function read($id)
    {
        $statement = App::resolver('database')::query(
            "SELECT sp.id, service_type_id, name, time_saved, selling_date, quantity FROM " . self::$table_name . " AS sp INNER JOIN service_type AS st ON st.id = sp.service_type_id WHERE sp.id = :id",
            ['id' => $id]
        );
        $results   = $statement->fetch(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function create($data)
    {
        try {
            $statement = App::resolver('database')::query(
                "INSERT INTO " . self::$table_name . "(selling_date, quantity, service_type_id) VALUES (:selling_date, :quantity, :service_type_id)",
                [
                    'selling_date'    => $data['selling_date'],
                    'quantity'        => $data['quantity'],
                    'service_type_id' => $data['service_type_id']
                ]
            );
        } catch (\Exception $e) {
            Response::get(500, $e->getMessage());
        }

        if ($statement->rowCount() > 0) {
            return App::resolver('database')::$connection->lastInsertId();
        }
        return false;
    }

    public static function update($currentData, $newData)
    {
        try {
            $statement = App::resolver('database')::query(
                "UPDATE " . self::$table_name . " SET selling_date = :selling_date, quantity = :quantity WHERE id = :id",
                [
                    'selling_date' => $newData['selling_date'] ?? $currentData['selling_date'],
                    'quantity'     => $newData['quantity'] ?? $currentData['quantity'],
                    'id'           => $currentData['id']
                ]
            );
        } catch (\Exception $e) {
            Response::get(500, $e->getMessage());
        }
        return $statement && $statement->rowCount() > 0;

    }

    public static function delete($id)
    {
        try {
            $statement = App::resolver('database')::query(
                "DELETE FROM " . self::$table_name . " WHERE id = :id",
                ['id' => $id]
            );
        } catch (\Exception $e) {
            Response::get(500, $e->getMessage());
        }
        return $statement && $statement->rowCount() > 0;
    }
}
?>