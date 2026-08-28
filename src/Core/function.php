<?php



function base_path($path)
{
    return BASE_PATH . $path;
}

function abort($code = 404){
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode([ 'error' => $code ]);
    die();
}