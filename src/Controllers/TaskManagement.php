<?php

namespace src\Controllers;

use src\Models\Task_User;
use src\Core\Database;

class TaskManagement{
    protected $taskUser;

    public function __construct(Database $database)
    {
        $this->taskUser = new Task_User($database);
    }

    public function assign($taskId, $authUser = null){
        $data = json_decode(file_get_contents('php://input'), true);
        $userId = $data['user_id'];

        $result = $this->taskUser->assign($taskId, $userId);

        header('Content-Type: application/json');
        echo json_encode($result);
}


}