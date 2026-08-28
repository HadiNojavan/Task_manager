<?php
namespace src\Core;

/* 

*/
class Router {

    protected $routes=[];
    protected Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
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

        // we dive /api/tasks/5 to  [ "", "api", "tasks", "5" ]
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

        // 5. Middleware
        if ($route['middleware']) {
            Middleware::resolve($route['middleware']);
        }

        // 6. Controller + Action
        [$controller, $action] = $route['controller'];

        $controller = new $controller($this->database);

        // if we have params id in uri 
        if ($params) {
            return $controller->$action($params['id']);
        }

        return $controller->$action();
    }
    
    $this->abort();
}

    public function routeee($uri, $method){
        foreach ($this->routes as $route) {
       
            $routeParts = explode('/', $route['uri']);
            $uriParts   = explode('/', $uri);

            $params = [];

            foreach ($routeParts as $key => $routePart) {

                if ($routePart === '{id}') {
                    $params['id'] = $uriParts[$key];
                    continue;
                }

                if ($routePart !== $uriParts[$key]) {
                    continue 2;
                }
}
            
        }
        if ($route["method"] === strtoupper($method)) {
            if ($route["middleware"]) {
               // $middleware = Middleware::MAP[$route["middleware"]];
                //(new $middleware)->handle();
                Middleware::resolve($route["middleware"]);
            }

             [$controller, $action] = $route['controller'];

            $controller = new $controller($this->database);
            if ($params)
                return $controller->$action($params['id']);

            return $controller->$action();
        }
   
}


    
   public function abort($code = 404){
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode([ 'error' => $code ]);
    die();
}


}