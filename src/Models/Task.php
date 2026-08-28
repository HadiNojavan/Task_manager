<?php

namespace src\Models;

use src\Core\Database;

class Task
{
    public function __construct(
        protected Database $database
    ) {
    }

    public function all()
    {
        return $this->database
            ->query('SELECT * FROM tasks')
            ->fetchAll();
    }

    public function get($id)
    {
        return $this->database
            ->query('SELECT * FROM tasks WHERE id=?',[$id])
            ->fetch();
    }

    
}