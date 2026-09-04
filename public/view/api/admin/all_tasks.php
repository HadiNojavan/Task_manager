<?php

session_start();
require_once "../../../../vendor/autoload.php";
use GuzzleHttp\Client;

if (!isset($_SESSION['token']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.html");
    exit;
}

$client = new Client(['base_uri' => 'http://localhost:8082']);

$response = $client->get('/api/tasks', ['headers' => ['Authorization' => 'Bearer ' . $_SESSION['token']]]);
$tasks = json_decode($response->getBody(), true);

?>

<h1>All Tasks</h1>
<a href="../../admin.php">back to admin dashboard</a>

<ul>

<?php foreach ($tasks as $task) { ?>

    <li>

        <h3>
            Title:
            <a href="../../show.php?id=<?= $task['id'] ?>">
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
        <br>
    <a href="assign.php?id=<?= $task['id'] ?>">Assign Users</a>

    </li>

<?php } ?>

</ul>