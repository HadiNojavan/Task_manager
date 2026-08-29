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
            abort(404,$message="no matching tasks found in database");
        
        header('Content-Type: application/json');

        echo json_encode($tasks);

    }

    public function show($id)//this method will get one task 
    {
        $task = $this->task->get($id);

        if (!$task)
            abort(404,"no matching task found in database");

        header('Content-Type: application/json');

        echo json_encode($task);

    }

    public function store(){
        $data=file_get_contents('php://input');//here we have to featch body of post man 
        $data=json_decode($data,true);//but postman body type is json we have to convert it to arrey php from =>
        $task = $this->task->create($data);
        header('Content-Type: application/json');
        echo json_encode($task);

    }

    public function update($id){//here we update one task by id
        $upt=file_get_contents('php://input');//here we fetch data from postman that we want to update 
        $upt=json_decode($upt,true);
        $task = $this->task->update($id,$upt);
        header('Content-Type: application/json');
        echo json_encode($task);
    }
}