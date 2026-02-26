<?php
// config.php
$host = 'mysql-analisicinema.alwaysdata.net';
$user = 'analisicinema';
$password = 'CHDCciao1234';
$dbname = 'analisicinema_database';

// Creazione connessione
$conn = new mysqli($host, $user, $password, $dbname);

// Controllo connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Imposta charset per gestire correttamente i caratteri
$conn->set_charset("utf8mb4");
?>