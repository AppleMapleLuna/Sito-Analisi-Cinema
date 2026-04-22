<?php
require_once '../src/database/php.conndatabase.php';
if (!isset($_SESSION['ID_Utente'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Il mio profilo</title>
    <link rel="stylesheet" href="../src/template/style_gestione_profilo.css">
    <link rel="stylesheet" href="../src/template/components/navbar_style.css">
</head>
<body>
    <?php include __DIR__ . '../src/template/components/navbar.php'; ?>
    <div class="container">
        <div class="profile-card">
            <h1>Il mio profilo</h1>

            <div class="avatar-section">
                <img src="" alt="Avatar" id="avatar-preview" class="avatar">
                <label for="avatar-upload" class="btn-upload">Cambia foto</label>
                <input type="file" id="avatar-upload" accept="image/*" style="display: none;">
            </div>

            <div class="info-row" id="username-row">
                <span class="info-label">Username:</span>
                <span class="info-value" id="username-display"></span>
                <button class="btn-edit" id="edit-username">Modifica</button>
                <div class="edit-form" id="edit-username-form" style="display: none;">
                    <input type="text" id="username-input" maxlength="30">
                    <button class="btn-save-small" id="save-username">Salva</button>
                    <button class="btn-cancel-small" id="cancel-username">Annulla</button>
                </div>
            </div>

            <div class="info-row" id="email-row">
                <span class="info-label">Email:</span>
                <span class="info-value" id="email-display"></span>
                <button class="btn-edit" id="edit-email">Modifica</button>
                <div class="edit-form" id="edit-email-form" style="display: none;">
                    <input type="email" id="email-input" maxlength="50">
                    <button class="btn-save-small" id="save-email">Salva</button>
                    <button class="btn-cancel-small" id="cancel-email">Annulla</button>
                </div>
            </div>

            <div class="info-row">
                <span class="info-label">Password:</span>
                <span class="info-value">••••••••</span>
                <a href="../src/auth/cambia_password.php" class="btn-edit">Cambia password</a>
            </div>

            <div class="info-row">
                <span class="info-label">Lingua:</span>
                <select id="lingua-select">
                    <option value="it">Italiano</option>
                    <option value="en">English</option>
                </select>
            </div>

            <div class="logout-section">
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>

            <div id="message" class="message"></div>
        </div>
    </div>
    <?php include __DIR__ . '/../src/template/components/componente_footer.php'; ?>
    <script src="../src/scripts/script_profilo.js"></script>
</body>
</html>