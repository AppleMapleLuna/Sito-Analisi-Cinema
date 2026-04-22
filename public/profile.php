<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../src/database/php.conndatabase.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Il mio profilo</title>

    <!-- CSS PROFILO -->
    <link rel="stylesheet" href="../src/template/style_gestione_profilo.css">

    <!-- NAVBAR CSS -->
    <link rel="stylesheet" href="assets/components/navbar_style.css">
</head>
<body>

    <!-- NAVBAR -->
    <?php include __DIR__ . '/assets/components/navbar.php'; ?>

    <div class="container">
        <div class="profile-card">
            <h1>Il mio profilo</h1>

            <div class="avatar-section">
                <img src="" alt="Avatar" id="avatar-preview" class="avatar">
                <label for="avatar-upload" class="btn-upload">Cambia foto</label>
                <input type="file" id="avatar-upload" accept="image/*" style="display:none;">
            </div>

            <div class="info-row">
                <span class="info-label">Username:</span>
                <span class="info-value"><?= htmlspecialchars($_SESSION['user']['Username']) ?></span>
            </div>

            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value"><?= htmlspecialchars($_SESSION['user']['Email']) ?></span>
            </div>

            <div class="info-row">
                <span class="info-label">Password:</span>
                <span class="info-value">••••••••</span>
                <a href="../src/auth/cambia_password.php" class="btn-edit">Cambia password</a>
            </div>

            <div class="logout-section">
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php include __DIR__ . '/assets/components/componente_footer.php'; ?>

    <script src="../src/scripts/script_profilo.js"></script>
</body>
</html>
