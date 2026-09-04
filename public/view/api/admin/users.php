<?php

session_start();

if (!isset($_SESSION['token']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.html");
    exit;
}


require_once "../../../../vendor/autoload.php";
use GuzzleHttp\Client;

$client = new Client(['base_uri' => 'http://localhost:8082']);

$response = $client->get('/api/users', ['headers' => [ 'Authorization' => 'Bearer ' . $_SESSION['token'] ]]);

$users = json_decode($response->getBody(), true);

?>
<a href="../../admin.php">back to admin dashboard</a>
<ul>

<?php foreach ($users as $user) { ?>

    <li>
        ID: <?= $user['id'] ?>
        <br>
        Username: <?= htmlspecialchars($user['username']) ?>
        <br>    
        Role: <?= htmlspecialchars($user['role']) ?>
    </li>

<?php } ?>

</ul>