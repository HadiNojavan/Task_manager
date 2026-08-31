<?php

namespace src\Models;

use src\Core\Database;


class User{
    protected $db;
    
    public function __construct(Database $db) {
        $this->db=$db;
    }

    public function create($username, $password){//create new user in db

    return $this->db->query( "INSERT INTO users (username, password)VALUES (?, ?) RETURNING *",
            [$username, $password])
        ->fetch();
}

    public function findByUsername($username){//to check that our new username exits in db or not 

        return $this->db
            ->query('SELECT username FROM users WHERE username=?',[$username])
            ->fetch();
    }

    public function findpassword($username){//to check that our new username exits in db or not 

        return $this->db
            ->query('SELECT password FROM users WHERE username=?',[$username])
            ->fetch();
    }

    public function savetoken($username,$token){
        return $this->db->query("UPDATE users SET api_token = ? WHERE username = ?", [$token, $username])
        ->fetch();
    }

    public function findtoken($token){
        return $this->db->query('SELECT id,username,role FROM users WHERE api_token=?',[$token])
            ->fetch();
    }

   public function tasks($userId){
        $taskUser = new Task_User($this->db);
        return $taskUser->tasks_userid($userId);

    }


    public function getuserinfo(){
        return $this->db->query('SELECT id,username,role FROM users',[])
            ->fetchAll();
    }
    public function findByuserid($id){
        return $this->db->query('SELECT id FROM users WHERE id=?',[$id])
            ->fetch();
    }
    

    }
    
