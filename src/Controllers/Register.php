<?php

namespace src\Controllers;
use src\Models\User;
use src\Core\Database;
use src\Validation\Validator; 

class Register{

    protected  $user;

    public function __construct(Database $database)
    {
        $this->user= new User($database);
    }

    public function register_new_user(){

        $data = file_get_contents('php://input');//we get username and password from postman body
        $data = json_decode($data, true);
        header('Content-Type: application/json');

        $username = $data['username'];
        $password = $data['password'];

        $validator = new Validator();

        //first we check the format of username and password is correct or not
        $errors = $validator->validate($username, $password);

        if ($errors){
            echo json_encode($errors);
            return;
        }

        //if acount with this username already exits we rasie error 
        $existing_user = $this->user->findByUsername($username);
        
        if ($existing_user) {
            echo json_encode(['error'=>"account with username {$username} alreay exits"]);
            die();
        }
        
        //finaly if evrey thing is correct we create new user
        $password = password_hash($password, PASSWORD_DEFAULT);
        $new_user=$this->user->create($username, $password);

        unset($new_user['password']); //we dont want to return password of user to api 
        echo json_encode($new_user);

    }

}