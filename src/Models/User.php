<?php

class User{
    protected $database;
    
    public function __construct(Database $database) {
        $this->database=$database;
    }
    
}