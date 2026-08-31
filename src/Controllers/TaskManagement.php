<?php

namespace src\Controllers;

use src\Models\Task_User;
use src\Core\Database;
use src\Models\Task;
use src\Models\User;   


class TaskManagement{
    protected $taskUser;
    protected Task $task;
    protected User $user;

    public function __construct(Database $database)
    {
        $this->taskUser = new Task_User($database);
        $this->task = new Task($database);
        $this->user = new User($database); 
        
    }

    public function assign($taskId, $authUser ){//we assgin on task for many user
        $data = json_decode(file_get_contents('php://input'), true);//we get userid like [1,2,3]
        $userIds = $data['user_ids'];

        //check if task with this id exits?
        $task=$this->task->task_id($taskId);
        if (!$task) 
            abort(404, 'Task not found');

        //now we have to check these users with this given id exits or not 
        foreach ($userIds as $userId){
            $user=$this->user->findByuserid($userId);
            if (!$user)
                abort(404,"user with id={$userId} not found");

        }

        foreach ($userIds as $userId) {
            $this->taskUser->assign($taskId, $userId);
}

        header('Content-Type: application/json');
        echo json_encode(["message"=>"Successfully assigned one task to many users"]);
}


}