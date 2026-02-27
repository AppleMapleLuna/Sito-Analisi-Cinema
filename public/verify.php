<?php
require_once '../src/database/php.conndatabase.php';

$token = $_GET['token'] ?? '';

if (!$token) {
    die("Token mancante.");
}

$sql = "UPDATE utenti SET Verificato = 1 WHERE TokenVerifica = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Email verificata! Ora puoi effettuare il login.";
} else {
    echo "Token non valido.";
}
