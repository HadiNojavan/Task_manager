<?php

session_start();
require_once "../../../vendor/autoload.php";
use GuzzleHttp\Client;

if (!isset($_SESSION['token'])) {
    header("Location: ../login.html");
    exit;
}

$client = new Client(['base_uri' => 'http://localhost:8082']);

$response = $client->post('/api/tasks', [  'headers' => [ 'Authorization' => 'Bearer ' . $_SESSION['token']], 'json' => [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'due_date' => $_POST['due_date'],
        'priority' => $_POST['priority'],
        'status' => $_POST['status']
    ]
]);

$task = json_decode($response->getBody(), true);

echo "<h1>Task created successfully</h1>";
echo "<h2>" . htmlspecialchars($task['title']) . "</h2>";
echo "<p>" . htmlspecialchars($task['description']) . "</p>";
echo "<a href='tasks.php'>Back to tasks</a>";