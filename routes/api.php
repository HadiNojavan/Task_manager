<?php
/*
when we write asks::class php automaatcilly send our autoloader to Router file so there is no
need to rewrite use src\Controllers\Tasks in Router file 
*/

use src\Controllers\Tasks;
use src\Controllers\Register;
use src\Controllers\Login;

use src\Controllers\TaskManagement;
use src\Controllers\Users;

//$router->get('/api/tasks', [Tasks::class, 'index']); // here we get all tasks from database that method in controllers is index to get all info 
//$router->get('/api/tasks/{id}', [Tasks::class, 'show']);//here we get only one task by id 
//$router->post('/api/tasks', [Tasks::class, 'store'])->only('auth');//here i create new task 
//$router->patch('/api/tasks/{id}', [Tasks::class, 'update'])->only('auth');//this update out task by id
//$router->delete('/api/tasks/{id}', [Tasks::class, 'destroy'])->only('auth');//here we can delete one task by id 




$router->get('/api/my-tasks', [Tasks::class, 'myTasks'])->only('auth');



$router->post('/api/register', [Register::class, 'register_new_user'])->only('guest');//to register new user
$router->post('/api/login', [Login::class, 'login'])->only('guest');

//here admin get all user info 
$router->get('/api/users', [Users::class, 'all'])->only('admin');

//here admin assing one task to many users 
$router->post('/api/tasks/{id}/assign', [TaskManagement::class, 'assign'])->only('admin');

//GET /api/my-tasks
$router->get('/api/tasks', [Tasks::class, 'index'])->only('auth');// here we get all tasks from database
$router->get('/api/tasks/{id}', [Tasks::class, 'show'])->only('auth');//here we get only one task by id 
$router->patch('/api/tasks/{id}', [Tasks::class, 'update'])->only('auth');//this update out task by id
$router->delete('/api/tasks/{id}', [Tasks::class, 'destroy'])->only('auth');//here we can delete one task by id
$router->post('/api/tasks', [Tasks::class, 'store'])->only('auth');////here i create new task 
