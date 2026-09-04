<?php

namespace src\Models;

use src\Core\Database;

class Task{

    protected $database;
    
    public function __construct(Database $database) {
        $this->database=$database;
    }

    public function all($authUser=null)//this method will featch all data from database
    {   
        
        $allowedFilters = ['status','priority',  'search'];
        $querys=$_GET;
        $keys = [];
        $values = [];

        foreach($querys as $key=>$value){
            if (in_array($key,$allowedFilters)){
                $keys []=$key;
                $values[] = $value;
            }
        }

        if (!$keys)//it means we dont have any query or given query is invalid
            return $this->database ->query('SELECT * FROM tasks WHERE deleted_at IS null') ->fetchAll();

       $cond = " WHERE deleted_at IS null AND ";
        $parameter = [];

        foreach($keys as $index => $key) {
            if ($key==="search"){
                $cond .= "title ILIKE ? AND ";
                $parameter[] = "%{$values[$index]}%";
                continue;
            }
            $cond .= "{$key}=? AND ";
            $parameter[] = $values[$index];
        }

        $cond = rtrim($cond, " AND ");
        
        return $this->database ->query("SELECT * FROM tasks".$cond,$parameter) ->fetchAll();
        
    }

    public function get($id)//we will get one task by id that is not deleted 
    {
        return $this->database->query('SELECT * FROM tasks WHERE id=? AND deleted_at IS null',[$id])->fetch();
    }

    public function find_task($id){//even the task that is deleted
        return $this->database->query('SELECT * FROM tasks WHERE id=?',[$id])->fetch();
    }


    public function create($data) {//here we create new task in database and then fetch it to see in result that we create new task 
        try{
            return $this->database->query('INSERT  INTO tasks (title, description, due_date, priority, status, created_by)
                VALUES (?, ?, ?, ?, ?, ?) RETURNING *' , [$data['title'],$data['description'],$data['due_date'],$data['priority'],
                    $data['status'],$data['created_by']]
            )->fetch();
    }

        catch (\PDOException $e){
                $bug = [ "message" => $e->getMessage(), "PDO CODE" => $e->getCode()];
                 echo json_encode($bug);
                 die();
            }
        }
        
        

    public function update($id,$upt){//first we have to get columns of our table to update table 
        try{
            $task=$this->get($id);

            $allowedKeys=$this->get_key_columns();//we get columns that are exit in table 

            foreach ($upt as $key => $value){

                if (in_array($key, $allowedKeys))//so client can not add another columns like id 
                    $this->database->query("UPDATE tasks SET $key = ? WHERE id=?", [$value,$id]);
            }

            return $this->get($id);

        }

        catch (\PDOException $e) {
            $bug = ["message" => $e->getMessage(),"PDO CODE" => $e->getCode() ];
            echo json_encode($bug);
            die();
        }

        
    }


     public function destroy($id){

        try{
            $this->database->query("UPDATE tasks SET deleted_at = CURRENT_TIMESTAMP WHERE id=?", [$id]);
        }

        catch (\PDOException $e) {
            
        $bug = ["message" => $e->getMessage(),"PDO CODE" => $e->getCode()];

        echo json_encode($bug);
        die();
    }

        
     }
     
    public function get_key_columns(){
        
    $not_editable_columns = [ 'id', 'created_by', 'created_at',"deleted_at"];//here we can not allow client to update or create id columns

    $res = [];

    $data = $this->database->query("SELECT column_name FROM information_schema.columns WHERE table_name = 'tasks'")->fetchAll();

    foreach ($data as $row) {
        if (in_array($row['column_name'], $not_editable_columns)) 
            continue;
        
        $res[] = $row['column_name'];
    }

    return $res;
}

    public function task_id($taskid){
        return $this->database->query("SELECT * FROM tasks WHERE id=? AND deleted_at IS NULL",[$taskid])->fetch();
    }

    public function restore($id_task){
           try{
            $this->database->query("UPDATE tasks SET deleted_at = null WHERE id=?", [$id_task]);
        }

        catch (\PDOException $e) {
            
        $bug = ["message" => $e->getMessage(),"PDO CODE" => $e->getCode()];

        echo json_encode($bug);
        die();
    }
    }

    public function deleted($authUser=null){
    return $this->database->query('SELECT * FROM tasks WHERE deleted_at IS NOT NULL')->fetchAll();
}

}

    