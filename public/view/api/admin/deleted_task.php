<?php

session_start();
require_once "../../../../vendor/autoload.php";
use GuzzleHttp\Client;

if (!isset($_SESSION['token']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.html");
    exit;
}

$client = new Client(['base_uri' => 'http://localhost:8082']);

$response = $client->get('/api/tasks/deleted', ['headers' => ['Authorization' => 'Bearer ' . $_SESSION['token']]]);

$tasks = json_decode($response->getBody(), true);

?>

<h1>Deleted Tasks</h1>

<ul>

<a href="../../admin.php">back to admin dashboard</a>
<?php foreach ($tasks as $task) { ?>

    <li>

        <h3>
            <?= htmlspecialchars($task['title']) ?>
        </h3>

        <p>
            <?= htmlspecialchars($task['description']) ?>
        </p>

        <p>
            Status: <?= htmlspecialchars($task['status']) ?>
        </p>

        <a href="restore.php?id=<?= $task['id'] ?>">Restore</a>

    </li>

<?php } ?>

</ul>