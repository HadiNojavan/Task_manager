<?php

session_start();
require_once "../../../../vendor/autoload.php";
use GuzzleHttp\Client;

if (!isset($_SESSION['token']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $client = new Client(['base_uri' => 'http://localhost:8082']);

    $response = $client->post('/api/add_admin', [
        'headers' => [
            'Authorization' => 'Bearer ' . $_SESSION['token']
        ],
        'json' => [
            'username' => $_POST['username'],
            'password' => $_POST['password']
        ]
    ]);

    $data = json_decode($response->getBody(), true);

    if (isset($data['id'])) {
        echo "<h1>Admin created successfully</h1>";
        echo "<a href='../../admin.php'>Back to admin page</a>";
        exit;
    }

    echo $response->getBody();
    exit;
}

?>

<h1>Add New Admin</h1>

<form action="create.php" method="post">

    <input type="text" name="username" placeholder="Username" required>

    <br><br>

    <input type="password" name="password" placeholder="Password" required>

    <br><br>

    <button type="submit">Add Admin</button>

</form>