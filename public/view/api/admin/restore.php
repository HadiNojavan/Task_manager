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

$response = $client->patch("/api/tasks/$id/restore", ['headers' => ['Authorization' => 'Bearer ' . $_SESSION['token']]]);

header("Location: http://localhost:8080/api/admin/deleted_task.php");
exit;
