<?php

session_start();
require_once "../../vendor/autoload.php";
use GuzzleHttp\Client;

if (!isset($_SESSION['token'])) {
    header("Location: login.html");
    exit;
}

$id = $_GET['id'];

$client = new Client(['base_uri' => 'http://localhost:8082']);

$response = $client->get("/api/tasks/$id", ['headers' => ['Authorization' => 'Bearer ' . $_SESSION['token']]]);

$task = json_decode($response->getBody(), true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Task</title>
</head>

<body>

<h1>Task Details</h1>

<h2>
    Title: <?= htmlspecialchars($task['title']) ?>
</h2>

<p>
    Description: <?= htmlspecialchars($task['description']) ?>
</p>

<p>
    Status: <?= htmlspecialchars($task['status']) ?>
</p>

<p>
    Priority: <?= htmlspecialchars($task['priority']) ?>
</p>

<p>
    Due date: <?= htmlspecialchars($task['due_date']) ?>
</p>

<a class="text-red" href="api/delete.php?id=<?= $task['id'] ?>">Delete this task </a>
<br>
<a href="update.php?id=<?= $task['id'] ?>">Update this task</a>
<br>
<?php if ($_SESSION['role'] === "user"): ?>
<a href="api/tasks.php">Back to tasks</a>
<?php else: ?>
<a href="api/admin/all_tasks.php">Back to all tasks</a>
<br>
<a href="admin.php">back to admin dashboard</a>
<?php endif; ?>
</body>
</html>