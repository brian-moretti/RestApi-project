<?php

namespace App\models;

use Core\App;
use Core\Response;
use PDO;

class ServiceType
{
    private static $table_name = "service_type";

    public static function readAll()
    {
        $statement = App::resolver('database')::query("SELECT * FROM " . self::$table_name);
        $results   = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            array_push($results, $row);
        }
        return $results;
    }

    public static function read($id)
    {
        $statement = App::resolver('database')::query("SELECT * FROM " . self::$table_name . " WHERE id = :id", ['id' => $id]);
        $results   = $statement->fetch(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function create($data)
    {
        try {
            $statement = App::resolver('database')
                ::query(
                    "INSERT INTO " . self::$table_name . "(name, time_saved) VALUES (:name, :time_saved)",
                    ["name" => $data['name'], 'time_saved' => $data['time_saved']]
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
            $statement = App::resolver('database')::query("UPDATE " . self::$table_name . " SET name = :name, time_saved = :time_saved WHERE id = :id", [
                'name'       => $newData['name'] ?? $currentData['name'],
                'time_saved' => $newData['time_saved'] ?? $currentData['time_saved'],
                'id'         => $currentData['id']
            ]);
        } catch (\Exception $e) {
            Response::get(500, $e->getMessage());
        }

        return $statement && $statement->rowCount() > 0;
    }

    public static function delete($id)
    {
        try {
            $statement = App::resolver('database')::query("DELETE FROM " . self::$table_name . " WHERE id = :id", ["id" => $id]);
        } catch (\Exception $e) {
            Response::get(500, $e->getMessage());
        }
        return $statement && $statement->rowCount() > 0;
    }

    public static function sum()
    {
        try {
            $statement = App::resolver('database')::query(
                "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(time_saved))) FROM " . self::$table_name
            );
        } catch (\Exception $e) {
            Response::get(500, $e->getMessage());
        }
        return $statement->fetchColumn();
    }
}

?>