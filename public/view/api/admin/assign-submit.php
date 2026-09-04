<?php

session_start();
require_once "../../../../vendor/autoload.php";
use GuzzleHttp\Client;

if (!isset($_SESSION['token']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.html");
    exit;
}

$id = $_GET['id'];
$userIds = $_POST['users'];

$client = new Client(['base_uri' => 'http://localhost:8082']);

$response = $client->post("/api/tasks/$id/assign", ['headers' => ['Authorization' => 'Bearer ' . $_SESSION['token']],'json' => [
      'user_ids' => $userIds]]);

header("Location: all_tasks.php");
exit;