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

    public function update($id,$upt){//first we have to get columns of our table 
        $task=$this->get($id);
        $allowedKeys=$this->get_key_columns();//we get columns that are exit in table 

        foreach ($upt as $key => $value){
            if (in_array($key, $allowedKeys))//so client can not add another columns
                $this->database->query("UPDATE tasks SET $key = ? WHERE id=?", [$value,$id]);
        }
        return $this->get($id);
    }


     public function destroy($id){
        $this->database->query("DELETE FROM tasks WHERE id =?", [$id]);
     }
     
    public function get_key_columns(){
        $res=[];
        $data=$this->database
            ->query("SELECT column_name FROM information_schema.columns WHERE table_name ='tasks'")
            ->fetchAll();
        
        foreach ($data as $row) {
           $res[] = $row['column_name'];
            }
        return $res;
    }

}

    