<?php
require_once '../database/php.conndatabase.php';
require_once 'send_mail.php';

$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($username) || empty($password)) {
    header("Location: ../../public/register.php?e=1");
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$token = bin2hex(random_bytes(16));

$sql = "INSERT INTO utenti (Email, Username, Password, TokenVerifica, Verificato)
        VALUES (?, ?, ?, ?, 0)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $email, $username, $hashed, $token);

if ($stmt->execute()) {
    sendVerificationEmail($email, $token);
    header("Location: ../../public/register.php?ok=1");
    exit;
}

header("Location: ../../public/register.php?e=1");
exit;
