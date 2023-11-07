<?php

function dd($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die();
}

function bindParams($statement, $params)
{
    foreach ($params as $column => $param) {
        $statement->bindParam($param, $column, PDO::PARAM_STR);
        return $statement;  
    }
} 


function headerParams()
{
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
}
?>