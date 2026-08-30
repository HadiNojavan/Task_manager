<?php
/*
when we write asks::class php automaatcilly send our autoloader to Router file so there is no
need to rewrite use src\Controllers\Tasks in Router file 
*/

use src\Controllers\Tasks;
use src\Controllers\Register;
use src\Controllers\Login;

$router->get('/api/tasks', [Tasks::class, 'index']); // here we get all tasks from database that method in controllers is index to get all info 
$router->get('/api/tasks/{id}', [Tasks::class, 'show']);//here we get only one task by id 
$router->post('/api/tasks', [Tasks::class, 'store']);//here i create new task 
$router->patch('/api/tasks/{id}', [Tasks::class, 'update']);//this update out task by id
$router->delete('/api/tasks/{id}', [Tasks::class, 'destroy']);//here we can delete one task by id 

$router->post('/api/register', [Register::class, 'register_new_user']);//to register new user

$router->post('/api/login', [Login::class, 'login']);