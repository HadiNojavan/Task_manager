<?php

namespace src\Controllers;
use src\Models\User;
use src\Core\Database;
use src\Validation\Validator; 

class Login{

    protected  $user;

    public function __construct(Database $database){
        $this->user= new User($database);
    }

    public function login(){

        $data = file_get_contents('php://input');//we get username and password from postman body
        $data = json_decode($data, true);
        header('Content-Type: application/json');

        $username = $data['username'];
        $password = $data['password'];

        //we check that username exits in database 
        $user=$this->user->findByUsername($username);
        //if user not exits in database it means we dont have account
        if (!$user){
            echo json_encode(['error'=>"account with username:{$username} not exits"]);
            die();
        }

        //if we reach here we must verify password given from clinet and password from database 
        $userPassword = $this->user->findPassword($username)['password'];
      // dd($userPassword);
        if (password_verify($password, $userPassword)) {
            // password is correct
            echo json_encode(['message'=>"you have logined"]);
            return ;
        }

        echo json_encode(['error'=>"your password for account {$username} is not correct. your given password: {$password}"]);
    }


}