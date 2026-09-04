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
    <title>Update Task</title>
</head>

<body>

<h1>Update Task</h1>

<form action="api/update.php?id=<?= $task['id'] ?>" method="post">

    <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>

    <br><br>

    <textarea name="description"><?= htmlspecialchars($task['description']) ?></textarea>

    <br><br>

    <input type="date" name="due_date" value="<?= htmlspecialchars($task['due_date']) ?>" required>

    <br><br>

    <select name="priority" required>
        <option value="low" <?= $task['priority'] === 'low' ? 'selected' : '' ?>>Low</option>
        <option value="medium" <?= $task['priority'] === 'medium' ? 'selected' : '' ?>>Medium</option>
        <option value="high" <?= $task['priority'] === 'high' ? 'selected' : '' ?>>High</option>
    </select>

    <br><br>

    <select name="status" required>
        <option value="pending" <?= $task['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="in_progress" <?= $task['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
        <option value="completed" <?= $task['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
    </select>

    <br><br>

    <button type="submit">Update Task</button>

</form>

</body>
</html>