<?php

namespace src\Models;

use src\Core\Database;


class User{
    protected $database;
    
    public function __construct(Database $database) {
        $this->database=$database;
    }

    public function create($username, $password){//create new user in database

    return $this->database->query( "INSERT INTO users (username, password)VALUES (?, ?) RETURNING *",
            [$username, $password])
        ->fetch();
}

    public function findByUsername($username){//to check that our new username exits in database or not 

        return $this->database
            ->query('SELECT username FROM users WHERE username=?',[$username])
            ->fetch();
        
    }
    }
    
