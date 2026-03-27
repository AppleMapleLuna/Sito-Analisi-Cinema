<?php
session_start();

if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($isAdmin = !empty($_SESSION['user']['admin'])) {
    include __DIR__ . '/../src/admin/dashboard_admin.php';
} else {
    include __DIR__ . '/../src/user/dashboard_user.php';
}