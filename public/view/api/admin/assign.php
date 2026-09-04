<?php

session_start();
require_once "../../../../vendor/autoload.php";
use GuzzleHttp\Client;

if (!isset($_SESSION['token']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.html");
    exit;
}

$id = $_GET['id'];

$client = new Client(['base_uri' => 'http://localhost:8082']);

$response = $client->get('/api/users', ['headers' => ['Authorization' => 'Bearer ' . $_SESSION['token']]]);
$users = json_decode($response->getBody(), true);

?>

<h1>assign task</h1>

<form action="assign-submit.php?id=<?= $id ?>" method="post">

<?php foreach ($users as $user) { ?>

    <label>
        <input type="checkbox" name="users[]" value="<?= $user['id'] ?>">
        <?= htmlspecialchars($user['username']) ?>
    </label>

    <br>

<?php } ?>

<br>

<button type="submit">Assign</button>

</form>