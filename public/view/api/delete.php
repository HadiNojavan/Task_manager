<?php

session_start();
require_once "../../../vendor/autoload.php";
use GuzzleHttp\Client;

if (!isset($_SESSION['token'])) {
    header("Location: ../login.html");
    exit;
}

$id = $_GET['id'];

$client = new Client(['base_uri' => 'http://localhost:8082']);

$response = $client->delete("/api/tasks/$id", [
    'headers' => [
        'Authorization' => 'Bearer ' . $_SESSION['token']
    ]
]);

$data = json_decode($response->getBody(), true);

header("Location: tasks.php");
exit;