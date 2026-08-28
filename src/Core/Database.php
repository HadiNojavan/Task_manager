<?php

namespace src\Core;


use PDO;

class Database
{
    public $connection;
    public $statement;

    public function __construct($config)
    {
        $params = [
    'host'   => $config['host'],
    'port'   => $config['port'],
    'dbname' => $config['dbname'],
                ];
        //pgsql:host=localhost;port=;dbname=;user=;password=
        //this will add ; after evrey index of our arrey
        $dsn = 'pgsql:' . http_build_query($params, '', ';');

        

        $this->connection = new PDO($dsn,$config['user'],$config['password'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    }

    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        return $this;
    }

    public function fetchAll()
    {
        return $this->statement->fetchAll();
    }

    public function fetch()
    {
        return $this->statement->fetch();
    }
}