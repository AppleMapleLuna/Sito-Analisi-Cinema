<?php
// config.php

$dotenv = parse_ini_file(__DIR__ . '/.env');

$host = $dotenv['DB_HOST'];
$user = $dotenv['DB_USER'];
$password = $dotenv['DB_PASS'];
$dbname = $dotenv['DB_NAME'];

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");