<?php
session_start();

if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['user']['admin'] === 1) {
    include __DIR__ . '/admin/dashboard_admin.php';
} else {
    include __DIR__ . '/user/dashboard_user.php';
}