<?php

session_start();
require_once "../../../vendor/autoload.php";
use GuzzleHttp\Client;

$client = new Client(['base_uri' => 'http://localhost:8082']);

$response = $client->post('/api/register', ['json' => ['username' => $_POST['username'], 'password' => $_POST['password']]]);
$data = json_decode($response->getBody(), true);

if (isset($data['id'])) {
    $response = $client->post('/api/login', ['json' => ['username' => $_POST['username'], 'password' => $_POST['password']]]);
    $loginData = json_decode($response->getBody(), true);

    if (isset($loginData['token'])) {
        $_SESSION['token'] = $loginData['token'];
        $_SESSION['username'] = $loginData['username'];
        $_SESSION['role'] = $loginData['role'];
        header("Location: http://localhost:8080/api/tasks.php");
        exit;
    }
}

echo "Register failed";
echo "<br>";
echo $response->getBody();