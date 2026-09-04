<?php

namespace src\Controllers;

use src\Models\Task;
use src\Core\Database;
use src\Models\User;   
use src\Models\Task_User;

class Tasks
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



    public function index($authUser)//this method will get all of tasks from Models/Task class and done
    {
        if ($authUser['role']==="admin"){
            $tasks = $this->task->all();
        if (!$tasks)
            abort(404,$message="no matching tasks found in database");

        header('Content-Type: application/json');

        echo json_encode($tasks);
        return;
        }
        $user_id=$authUser['id'];
        $tasks = $this->user->tasks($user_id);
        header('Content-Type: application/json');
        echo json_encode($tasks ?: []);

    }

   public function show($id_task, $authUser){//

        $user_id = $authUser['id'];

        // Admin can see every task
        if ($authUser['role'] === "admin") {

            $task = $this->task->get($id_task);

            if (!$task) {
                abort(404, "No matching task found in database");
            }

            header('Content-Type: application/json');
            echo json_encode($task);
            return;
        }

        // Normal user can only see tasks assigned to himself
        $task = $this->taskUser->userHasTask( $user_id,$id_task);

        if (!$task) {
            abort(403, "You are not allowed to see this task");
        }

        header('Content-Type: application/json');
        echo json_encode($task);
}

    public function store($authUser = null){//here we create new task
        $data=file_get_contents('php://input');//here we have to featch body of post man 
         header('Content-Type: application/json');

        $data=json_decode($data,true);//but postman body type is json we have to convert it to arrey php from =>
        $data['created_by'] = $authUser['id'];
        $task = $this->task->create($data);
        $this->taskUser-> assign($task['id'], $task['created_by']);       

        echo json_encode($task);

    }

    public function update($id_task,$authUser){//here we update one task by id
        $upt=file_get_contents('php://input');//here we fetch id from postman that we want to update
        header('Content-Type: application/json'); 

        $upt=json_decode($upt,true);

        if ($authUser['role'] === "admin") {

        $task = $this->task->update($id_task,$upt);

        echo json_encode($task);
        return ;
    }

        $user_id=$authUser['id'];
        $task = $this->taskUser->userHasTask( $user_id,$id_task);

        if (!$task) 
            abort(403, "You are not allowed to update this task ");
        
        $task = $this->task->update($id_task,$upt);

        echo json_encode($task);
    }


    public function destroy($id_task,$authUser){
    $task = $this->task->get($id_task);

    header('Content-Type: application/json');

    if (!$task) 
        abort(404, 'No matching task found in database to delete');

    if ($authUser['role'] === "admin") {

        $this->task->destroy($id_task);
        echo json_encode(['message'=>"task whith id={$id_task} has been deleted"]);
        return ;
        }
    
    
    $user_id=$authUser['id'];
    $task = $this->taskUser->userHasTask( $user_id,$id_task);

    if (!$task) 
        abort(403, "You are not allowed to delete this task ");

    $this->task->destroy($id_task);
    echo json_encode(['message'=>"task whith id={$id_task} has been deleted"]);
    
}



      public function myTasks($authUser = null)      
    {
        if (!$authUser) 
            abort(401, 'Authentication required');
        

        $tasks = $this->user->tasks($authUser['id']);

        header('Content-Type: application/json');
        echo json_encode($tasks ?: []);
    }

    public function restore($id_task,$authUser){
        //check if this task exits 
        $task = $this->task->find_task($id_task);

        if (!$task) 
                abort(404, "No matching task found in database");

        //check if this task is deleted 
        $isdeleted=$task["deleted_at"];

        if(!$isdeleted)
            abort(400,"this task is not deleted yet");

        //if we reach here we can restore it 
        $this->task->restore($id_task);
         $task = $this->task->get($id_task);

        header('Content-Type: application/json');
        echo json_encode($task);
    }

    public function deleted($authUser=null){
        $tasks = $this->task->deleted();

        header('Content-Type: application/json');
        echo json_encode($tasks);
}

}