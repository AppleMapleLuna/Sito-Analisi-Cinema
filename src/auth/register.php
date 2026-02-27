// src/auth/register.php
<?php
require_once '../database/php.conndata.php';

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
        // Invia email di conferma
        $link = "https://tuosito.it/public/verify.php?token=$token";
        mail($email, "Conferma la tua registrazione", "Clicca qui per confermare: $link");

        return true;
    }

    return false;
}
