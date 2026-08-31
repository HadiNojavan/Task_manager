<?php

namespace src\Middleware;

use src\Core\Database;
use src\Models\User;

class TokenAuth {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function handle(){
        $headers = getallheaders();// "Bearer dkfjf3xff......"
        $authHeader = $headers['Authorization'] ?? '';

        if (!str_starts_with($authHeader, 'Bearer ')) {
            // there is no token in header 
            abort(401, 'Authorization token required');
        }

        //we must remove Bearer part 
        $token = substr($authHeader, 7);
        
        $user= new User($this->db);
        $search_for_token=$user->findtoken($token);
        
        //if return false means we can not find given token in table
        if(!$search_for_token){
            abort(401, 'Invalid token');
        }

        //if we reach here we find the token and we can safely go to controller
        //we send id,username,role to the router then sent to the controller
        return $search_for_token;
        
    }







}