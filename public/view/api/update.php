<?php

session_start();
require_once "../../../vendor/autoload.php";
use GuzzleHttp\Client;

if (!isset($_SESSION['token'])) {
    header("Location: ../index.html");
    exit;
}

$id = $_GET['id'];

$client = new Client(['base_uri' => 'http://localhost:8082']);

$response = $client->patch("/api/tasks/$id", ['headers' => [   'Authorization' => 'Bearer ' . $_SESSION['token']],'json' => [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'due_date' => $_POST['due_date'],
        'priority' => $_POST['priority'],
        'status' => $_POST['status']
    ]
]);

$task = json_decode($response->getBody(), true);

header("Location: ../show.php?id=$id");
exit;