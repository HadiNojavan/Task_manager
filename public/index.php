<?php
//this is our autoload rather then write it manual that i did it in last project
require_once __DIR__ . '/../vendor/autoload.php';

//this is our helper function that i will use it when i need it 
const BASE_PATH=__DIR__."/../";
require_once __DIR__ . '/../src/Core/function.php';

use src\Core\Router;

use src\Core\Database;

$config=require_once __DIR__ . "/../config/config.php";
$db = new Database($config["database"]);



$router = new Router($db); 

//i will add all of my routes path here 
require_once __DIR__ . '/../routes/api.php';


$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = strtoupper($_POST["_method"] ?? $_SERVER["REQUEST_METHOD"]);

$router->route($uri,$method);