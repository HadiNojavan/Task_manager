<?php



function base_path($path)
{
    return BASE_PATH . $path;
}


function abort($code =404,$message=null){

    http_response_code($code);

    header('Content-Type: application/json');

    if ($message){
        echo json_encode([ 'error' => $code ,'message'=>$message]);
        die();
    }
    
    echo json_encode([ 'error' => $code ]);
    die();
}