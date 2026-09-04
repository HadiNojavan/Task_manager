<?php

session_start();
require_once "../../../vendor/autoload.php";
use GuzzleHttp\Client;

if (!isset($_SESSION['token'])) {
    header("Location: http://localhost:8080/");
    exit;
}

$client = new Client(['base_uri' => 'http://localhost:8082']);
$response = $client->post('/api/logout', ['headers' => ['Authorization' => 'Bearer ' . $_SESSION['token']]]);
$data = json_decode($response->getBody(), true);

session_unset();
session_destroy();
header("Location: http://localhost:8080/");
exit;

header("Location: http://localhost:8080/");
exit;