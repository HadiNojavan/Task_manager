<?php

namespace src\Controllers;

use src\Models\User;
use src\Core\Database;

class Logout
{
    protected User $user;
    protected Database $db;

    public function __construct(Database $database)
    {
        $this->db = $database;
        $this->user = new User($database);
    }

    public function logout()
    {
        $headers = getallheaders(); // "Bearer dkfjf3xff......"
        $authHeader = $headers['Authorization'] ?? '';

        if (!str_starts_with($authHeader, 'Bearer ')) {
            abort(400, "you are not login to logout");
        }

        $token = substr($authHeader, 7);

        $search_for_token=$this->user->findtoken($token);
        
        //check if token exits in table
        if(!$search_for_token)
            abort(401,"you dont have token to logout it means you are not logined");
        
        //now we can safely logout user by deleting token of user 
        $userid=$search_for_token['id'];
        $this->user->deletetoken($userid);
        
         header('Content-Type: application/json');
        echo json_encode(['message' => 'Logout successful']);



        
    }


}