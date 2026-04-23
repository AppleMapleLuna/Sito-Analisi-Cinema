<?php
// Avevo problemi di sessione quindi metto questo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: ../../public/login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profilo · Dashboard</title>
  <!-- Google Fonts per un aspetto più curato -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <!-- Font per icone pulite -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="profile-card">
  
  <!-- Intestazione con avatar e nome -->
  <div class="user-header">
    <div class="avatar-wrapper">
      <i class="fas fa-user-astronaut"></i> <!-- icona divertente / moderna -->
    </div>
    <div class="welcome-text">
      <h1>
        Ciao, <span class="username-highlight"><?= htmlspecialchars($_SESSION['user']['Username'] ?? 'Utente') ?></span>
      </h1>
      <span class="badge-role">
        <i class="fas fa-shield-alt" style="margin-right: 6px;"></i>Account attivo
      </span>
    </div>
  </div>

  <!-- Pannello informativo del profilo (esempio, si può espandere) -->
  <div class="info-panel">
    <div class="info-row">
      <div class="info-icon"><i class="fas fa-id-badge"></i></div>
      <div class="info-label">Username</div>
      <div class="info-value"><?= htmlspecialchars($_SESSION['user']['Username'] ?? '—') ?></div>
    </div>
    <div class="info-row">
      <div class="info-icon"><i class="fas fa-envelope"></i></div>
      <div class="info-label">Email</div>
      <div class="info-value"><?= htmlspecialchars($_SESSION['user']['Email'] ?? 'utente@esempio.it') ?></div>
    </div>
    <div class="info-row">
      <div class="info-icon"><i class="fas fa-calendar-alt"></i></div>
      <div class="info-label">Membro dal</div>
      <div class="info-value"><?= htmlspecialchars($_SESSION['user']['Iscrizione'] ?? '2025') ?></div>
    </div>
  </div>

  <!-- Sezione navigazione principale -->
  <div class="divider">
    <span><i class="far fa-compass" style="margin-right: 6px;"></i> navigazione</span>
  </div>

  <div class="nav-actions">
    <a href="../public/index.php" class="nav-link">
      <i class="fas fa-home"></i> Homepage
    </a>
    <a href="../public/profilo.php" class="nav-link">
      <i class="fas fa-user-circle"></i> Profilo
    </a>
    <a href="../public/logout.php" class="nav-link logout-link">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </div>

  <!-- Messaggio di benvenuto aggiuntivo / piccolo spazio -->
  <div class="footer-note">
    <i class="far fa-smile-wink"></i> Bentornatə · Gestisci il tuo account in sicurezza
  </div>
</div>

</body>
</html>
