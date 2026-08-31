<?php

//here only admin can access to users and see them and edit them 

namespace src\Controllers;

use src\Models\Task;
use src\Core\Database;
use src\Models\User;
use src\Models\Task_User;

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


}