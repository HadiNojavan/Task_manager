<?php

session_start();
require_once "../../../vendor/autoload.php";
use GuzzleHttp\Client;

if (!isset($_SESSION['token'])) {
    header("Location: http://localhost:8080/login.html");
    exit;
}

$client = new Client(['base_uri' => 'http://localhost:8082']);

$response = $client->get('/api/tasks', ['headers' => ['Authorization' => 'Bearer ' . $_SESSION['token']]]);
$tasks = json_decode($response->getBody(), true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Tasks</title>
</head>

<body>

<h1>hello <?php $_SESSION["username"] ?? "" ?></h1>
<h2>My Tasks</h2>
<a href="../create-task.html">Create Task</a>
<p style="color: red;">to delete or edit task click on title</p>    

 <form action="logout.php" method="post" style="position: absolute; top: 20px; right: 20px;">
    <button type="submit">Logout</button>
</form>


<ul>

<?php foreach ($tasks as $task) { ?>

    <li>

        <h3>
            Title:
            <a href="../show.php?id=<?= $task['id'] ?>">
                <?= htmlspecialchars($task['title']) ?>
            </a>
        </h3>

        <p>
            <?= htmlspecialchars($task['description']) ?>
        </p>

        <p>
            Status: <?= htmlspecialchars($task['status']) ?>
        </p>

        <p>
            Priority: <?= htmlspecialchars($task['priority']) ?>
        </p>

    </li>

<?php } ?>

</ul>

</body>
</html>