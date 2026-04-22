<?php
require_once __DIR__ . '/../src/database/php.conndatabase.php';

$token = $_GET['token'] ?? '';

if (!$token) {
    die("Token mancante.");
}

// Un solo UPDATE: verifica e invalida il token
$sql = "UPDATE utenti 
        SET Verificato = 1, TokenVerifica = NULL 
        WHERE TokenVerifica = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Token valido → utente verificato
    header("Location: login.php?verified=1");
    exit;
} else {
    // Token non trovato → link vecchio / sbagliato
    echo "Token non valido o già usato.";
}
