<?php

namespace App\models;

use Core\App;
use Core\Response;
use PDO;

class TotalTimeSaved
{

    public static function serviceTypeSum()
    {
        try {
            $statement = App::resolver('database')::query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(time_saved))) FROM service_type");
        } catch (\Exception $e) {
            Response::get(500, $e->getMessage());
        }
        return $statement->fetchColumn();
    }

    public static function serviceProvidedSum()
    {
        $query = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(time_saved))) as time_saved, name FROM service_provided INNER JOIN service_type AS st ON st.id = service_type_id";

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

        try {
            $statement = App::resolver('database')::query($query, $params);
        } catch (\Exception $e) {
            Response::get(500, $e->getMessage());
        }
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>