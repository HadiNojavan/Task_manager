<?php

//here only admin can access to users and see them and edit them 

namespace src\Controllers;

use src\Models\Task;
use src\Core\Database;
use src\Models\User;
use src\Models\Task_User;
use src\Validation\Validator; 

class Users
{
    protected Task $task;
    protected User $user;
    protected $taskUser;

    public function __construct(Database $database)
    {
        $this->task = new Task($database);
        $this->user = new User($database); 
        $this->taskUser = new Task_User($database);
    }

    public function all(){
        $users=$this->user->getuserinfo();
        if (!$users) 
            abort(404, 'No users found');

        header('Content-Type: application/json');

        echo json_encode($users);
    
    }

    public function add_admin(){
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
        $admin=true;
        $new_user=$this->user->create($username, $password,$admin);

        unset($new_user['password']); //we dont want to return password of user to api 
        echo json_encode($new_user);
    }


}