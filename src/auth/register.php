<?php
require_once '../database/php.conndatabase.php';

function registerUser($email, $username, $password) {
    global $conn;

    // Hash della password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Token di verifica email
    $token = bin2hex(random_bytes(16));

    $sql = "INSERT INTO utenti (Email, Username, Password, TokenVerifica, Verificato)
            VALUES (?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $email, $username, $hashed, $token);

    if ($stmt->execute()) {

        // Link di verifica
        $link = "https://TUO-SITO/render/public/verify.php?token=$token";

        // Invio email (versione semplice)
        $subject = "Conferma la tua registrazione";
        $message = "Clicca sul link per confermare il tuo account:\n$link";
        $headers = "From: no-reply@tuosito.it";

        require_once 'send_mail.php';
        sendVerificationEmail($email, $token);


        return true;
    }

    return false;
}
