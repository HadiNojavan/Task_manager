<?php

namespace src\Controllers;

use src\Models\Task;
use src\Core\Database;
use src\Models\User;   

class  Authorization{

    protected Task $task;
    protected User $user;

    public function __construct(Database $database)
    {
        $this->task = new Task($database);
        $this->user = new User($database); 
    }

    public function check_role($auth_user){
        $role=$auth_user['role'];
        return $role==='admin';
    }
}