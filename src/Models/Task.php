<?php

namespace src\Models;

use src\Core\Database;

class Task
{
    public function __construct(
        protected Database $database
    ) {
    }

    public function all()//this method will featch all data from database
    {
        return $this->database
            ->query('SELECT * FROM tasks')
            ->fetchAll();
    }

    public function get($id)//we will get one task by id 
    {
        return $this->database
            ->query('SELECT * FROM tasks WHERE id=?',[$id])
            ->fetch();
    }

    public function create($data) {//here we create new task in database and then fetch it to see in result that we create new task 
        return $this->database->query('INSERT  INTO tasks (title, description, due_date, priority, status, created_by)
                VALUES (?, ?, ?, ?, ?, ?) RETURNING *' , [$data['title'],$data['description'],$data['due_date'],$data['priority'],
                    $data['status'],$data['created_by']]
            )->fetch();
    }
}

    