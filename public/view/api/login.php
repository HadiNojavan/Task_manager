<?php

session_start();
require_once "../../../vendor/autoload.php";
use GuzzleHttp\Client;

$client = new Client(['base_uri' => 'http://localhost:8082']);

$response = $client->post('/api/login', ['json' => ['username' => $_POST['username'], 'password' => $_POST['password']]]);
$data = json_decode($response->getBody(), true);

if (isset($data['token'])) {
    $_SESSION['token'] = $data['token'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];

    if ($_SESSION['role'] === 'admin') {
        header("Location: http://localhost:8080/admin.php");
        exit;
    }

    header("Location: http://localhost:8080/api/tasks.php");
    exit;
}

echo "Login failed";
echo "<br>";
echo $response->getBody();