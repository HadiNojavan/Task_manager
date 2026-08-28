<?php


//$router->get('/api/tasks', 'src/Controllers/Tasks.php');//we get all the of tasks 

use src\Controllers\Tasks;

$router->get('/api/tasks', [Tasks::class, 'index']); // here we get all tasks from database that method in controllers is index to get all info 
$router->get('/api/tasks/{id}', [Tasks::class, 'show']);//here we get only one task by id 
$router->post('/api/tasks', [Tasks::class, 'store']);