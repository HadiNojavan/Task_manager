<?php
namespace src\Core;


/* 

*/
use src\Middleware\TokenAuth;
use src\Controllers\Authorization;

class Router {

    protected $routes=[];
    protected Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    protected function add($method,$uri,$controller){
        $this->routes[]=[
            'uri'        => $uri,
            'controller' => $controller,
            'method'     => $method ,
            'middleware'=>null,
            
        ];
        return $this;
    }

    public function get($uri, $controller)
    {
        return $this->add("GET",$uri, $controller);
        
    }

    public function post($uri, $controller) {
        return $this->add('POST', $uri, $controller);
        
    }

    public function patch($uri, $controller) {
        return $this->add('PATCH', $uri, $controller);  
    }

    public function delete($uri, $controller) {
        return $this->add('DELETE', $uri, $controller);
    }

    public function only($key){
        $this->routes[array_key_last($this->routes)]['middleware']=$key;
        return $this;
    }


    public function route($uri, $method)
{
    foreach ($this->routes as $route) {

        //first out http method should equeal
        if ($route['method'] !== strtoupper($method)) {
            continue;
        }

        // we divide /api/tasks/5 to  [ "", "api", "tasks", "5" ]
        //or for route /api/tasks/{id}  [ "", "api", "tasks", "{id}" ]
        $routeParts = explode('/', $route['uri']);
        $uriParts   = explode('/', $uri);

        if (count($routeParts) !== count($uriParts)) {
            continue;
        }

        $params = [];

        // check evrey part of uri and route are same 
        foreach ($routeParts as $key => $routePart) {

            if ($routePart === '{id}') {
                $params['id'] = $uriParts[$key];
                continue;
            }

            if ($routePart !== $uriParts[$key]) {
                continue 2;//this means it will countine our main foreach ($this->routes as $route) too
            }
        }

        // Middleware 
        $authUser = null;
        if ($route['middleware']) {
            //always check that user is logined and has token 
            $tokenAuth=new TokenAuth($this->db);
            $authUser = $tokenAuth->handle();

            //then we check that our middle ware is admin or not
            if ($route['middleware']==='admin'){
                $role= new Authorization($this->db);
                $role_admin=$role->check_role($authUser);
                if (!$role_admin){
                    abort(403,'access denied: only for admin');
                }
            }
        }

        //Controller + Action
        [$controller, $action] = $route['controller'];

        $controller = new $controller($this->db);

        // if we have params id in uri 
        if ($params) {

        if ($authUser !== null) {
            return $controller->$action($params['id'], $authUser);
        }

        return $controller->$action($params['id']);
    }

    if ($authUser !== null) {
        return $controller->$action($authUser);
    }

    return $controller->$action();
    }
    
    $this->abort(404,$message="no matching router uri found ");
}

    


    
   public function abort($code =404,$massage=null){
    http_response_code($code);
    header('Content-Type: application/json');
    if ($massage){
        echo json_encode([ 'error' => $code ,'massage'=>$massage]);
        die();
    }
    echo json_encode([ 'error' => $code ]);
    die();
}


}