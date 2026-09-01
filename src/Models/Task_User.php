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

    

    public function assign($taskId, $userId)
{
        try {

            return $this->db->query( 'INSERT INTO task_user (task_id, user_id) VALUES (?, ?) RETURNING *',
                    [$taskId, $userId] )->fetch();

        } catch (\PDOException $e) {

            if ($e->getCode() === '23505') {//اگر ردیف تکراری در جدول ثبت شود خطا میدهد 
                abort(409, 'This task is already assigned to this user');
            }

            throw $e;
        }
}

    public function tasks_userid($userid){
        
        return $this->db->query('SELECT tasks.* FROM tasks JOIN task_user on tasks.id=task_user.task_id WHERE task_user.user_id = ?', [$userid]) ->fetchAll();
    }

    public function userHasTask($userId,$taskId){
        return $this->db->query("SELECT tasks.* FROM tasks JOIN task_user on tasks.id = task_user.task_id WHERE
         task_user.user_id = ? AND task_user.task_id = ?",[$userId,$taskId])->fetch();
    }


}
