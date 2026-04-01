<?php
session_start();

if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['user']['admin'] === 1) {
    include __DIR__ . '/../src/admin/dashboard_admin.php';
} else {
    include __DIR__ . '/../src/user/dashboard_utente.php';
}