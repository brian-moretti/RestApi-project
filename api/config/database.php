<?php

class Database
{
    // private $host = 'localhost';
    // private $port = 3306;
    // private $dbname = 'services';
    // private $charset = 'utfmb4';
    private $user = 'root';
    private $password = '';

    private $config = [
        'database' => [
            'host'    => 'localhost',
            'port'    => 3306,
            'dbname'  => 'services',
            'charset' => 'utf8mb4'
        ]
    ]; //rimosso user e password 

    public $connection;
    public $statement;

    public function __construct()
    {
        $dsn = 'mysql:' . http_build_query($this->config['database'], '', ';');

        //$dsn = "mysql:host=localhost;port=3306;dbname=services;user=root;charset=utf8mb4";
        $this->connection = new PDO(
            $dsn,
            $this->user,
            $this->password,
            [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
    }

    public function connect()
    {
        try {
            $this->connection;
        } catch (\PDOException $e) {
            echo 'Errore di connessione' . $e->getMessage();
        }
        return $this->connection;
    }
    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);
        return $this->statement;
    }
}

?>