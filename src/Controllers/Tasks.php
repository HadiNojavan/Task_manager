<?php

namespace src\Controllers;

use src\Models\Task;
use src\Core\Database;

class Tasks
{
    protected Task $task;

    public function __construct(Database $database)
    {
        $this->task = new Task($database);
    }

    public function index()//this method will get all of tasks from Models/Task class and done 
    {
        $tasks = $this->task->all();
        
        if (!$tasks)
            abort();

        header('Content-Type: application/json');

        echo json_encode($tasks);

    }

    public function show($id)//this method will get one task 
    {
        $task = $this->task->get($id);

        if (!$task)
            abort();

        header('Content-Type: application/json');

        echo json_encode($task);

    }
}