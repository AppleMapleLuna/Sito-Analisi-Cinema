<?php
session_start();

if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <?php if ($_SESSION['user']['admin'] === 1): ?>
        <link rel="stylesheet" href="../src/template/admin_style.css">
        <script src="../src/scripts/admin_script.js" defer></script>
    <?php else: ?>
        <link rel="stylesheet" href="../src/template/user_style.css">
        <script src="../src/scripts/script_profilo.js" defer></script>
    <?php endif; ?>
</head>
<body>

<?php
if ($_SESSION['user']['admin'] === 1) {
    include __DIR__ . '/../src/admin/dashboard_admin.php';
} else {
    include __DIR__ . '/../src/user/dashboard_utente.php';
}
?>

</body>
</html>
