<?php
session_start();

$users = [
  "neo@matrix.io" => [
    "hash" => '$2y$10$REPLACE_HASH',
    "name" => "Neo"
  ]
];

$email = $_POST['email'] ?? '';
$pass  = $_POST['password'] ?? '';

if(!isset($users[$email]) || !password_verify($pass,$users[$email]['hash'])){
  header("Location: login.php?e=1");
  exit;
}

$_SESSION['user']=$users[$email];
header("Location: dashboard.php");
