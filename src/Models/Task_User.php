<?php

namespace src\Models;

use src\Core\Database;

class Task_User
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function tasks_userid($userid)
    {
        return $this->db
            ->query('SELECT * FROM   task_management WHERE user_id = ?', [$userid])
            ->fetchAll();
    }

    public function assign($taskId, $userId)
    {
        return $this->db
            ->query('INSERT INTO  task_management (task_id, user_id) VALUES (?, ?) RETURNING *', [$taskId, $userId])
            ->fetch();
    }


}
