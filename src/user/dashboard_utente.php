<?php
// Avevo problemi di sessione quindi metto questo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: /login.php");
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
  <style>
    /* Reset moderno e variabili */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Inter", system-ui, -apple-system, sans-serif;
      background: linear-gradient(145deg, #f6f9fc 0%, #e9f1f8 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      margin: 0;
      color: #1e293b;
    }

    /* Contenitore principale — effetto “glassmorphism” soffice */
    .profile-card {
      max-width: 780px;
      width: 100%;
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      background: rgba(255, 255, 255, 0.9);
      border-radius: 2.5rem;
      box-shadow: 
        0 20px 35px -8px rgba(0, 20, 45, 0.15),
        0 5px 12px -4px rgba(0, 0, 0, 0.05),
        inset 0 1px 0 rgba(255, 255, 255, 0.6);
      padding: 2.5rem 2.8rem;
      border: 1px solid rgba(255, 255, 255, 0.5);
      transition: transform 0.2s ease;
    }

    @media (max-width: 520px) {
      body {
        padding: 1rem;
      }
      .profile-card {
        padding: 1.8rem 1.5rem;
        border-radius: 2rem;
      }
    }

    /* Intestazione utente con avatar e benvenuto */
    .user-header {
      display: flex;
      align-items: center;
      gap: 1.2rem;
      margin-bottom: 2.5rem;
      flex-wrap: wrap;
    }

    .avatar-wrapper {
      background: linear-gradient(135deg, #2b5f8a, #1e3e5f);
      width: 72px;
      height: 72px;
      border-radius: 28px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 12px 18px -8px rgba(27, 55, 96, 0.2);
      border: 2px solid white;
      transition: all 0.2s;
    }

    .avatar-wrapper i {
      font-size: 2.8rem;
      color: white;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }

    .welcome-text {
      flex: 1;
    }

    .welcome-text h1 {
      font-weight: 700;
      font-size: 2.2rem;
      letter-spacing: -0.02em;
      color: #0b2a41;
      line-height: 1.2;
      margin-bottom: 0.2rem;
      word-break: break-word;
    }

    .welcome-text .username-highlight {
      background: linear-gradient(145deg, #1e4b6e, #0f3550);
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
      font-weight: 800;
    }

    .badge-role {
      display: inline-block;
      background: #d4e2f0;
      color: #1e3a5f;
      font-size: 0.8rem;
      font-weight: 600;
      padding: 0.25rem 1rem;
      border-radius: 40px;
      margin-top: 6px;
      letter-spacing: 0.3px;
      border: 1px solid rgba(255,255,255,0.7);
    }

    /* Sezione info profilo (card interna) */
    .info-panel {
      background: rgba(255, 255, 255, 0.5);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      border-radius: 1.8rem;
      padding: 1.8rem 2rem;
      margin: 2rem 0 2.2rem;
      border: 1px solid rgba(255,255,255,0.8);
      box-shadow: inset 0 1px 4px rgba(255,255,255,0.9), 0 6px 12px -6px rgba(0,20,40,0.08);
    }

    .info-row {
      display: flex;
      align-items: center;
      padding: 0.7rem 0;
      border-bottom: 1px solid rgba(55, 85, 115, 0.08);
    }

    .info-row:last-child {
      border-bottom: none;
    }

    .info-icon {
      width: 38px;
      color: #2b5f8a;
      font-size: 1.3rem;
    }

    .info-label {
      font-weight: 500;
      color: #3a5b7a;
      width: 100px;
      font-size: 0.95rem;
      text-transform: uppercase;
      letter-spacing: 0.3px;
    }

    .info-value {
      font-weight: 600;
      color: #0e2e44;
      font-size: 1.2rem;
      word-break: break-word;
    }

    /* Navigazione (link principali) */
    .nav-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      justify-content: center;
      margin-top: 0.5rem;
    }

    .nav-link {
      background: white;
      padding: 0.9rem 2rem;
      border-radius: 60px;
      font-weight: 600;
      font-size: 1.05rem;
      text-decoration: none;
      color: #1e4b6e;
      box-shadow: 0 6px 12px -6px rgba(0, 35, 70, 0.08);
      border: 1px solid rgba(200, 218, 238, 0.8);
      backdrop-filter: blur(5px);
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      flex: 0 1 auto;
    }

    .nav-link i {
      font-size: 1.1rem;
      color: #2b5f8a;
      transition: transform 0.2s;
    }

    .nav-link:hover {
      background: #ffffff;
      border-color: #9bb7d4;
      box-shadow: 0 16px 24px -10px rgba(28, 78, 120, 0.2);
      transform: translateY(-2px);
      color: #0b2a41;
    }

    .nav-link:hover i {
      transform: translateX(3px);
    }

    .logout-link {
      background: #fef6f0;
      color: #a13e2f;
      border-color: #fad9cf;
    }

    .logout-link i {
      color: #b85c4b;
    }

    .logout-link:hover {
      background: #fff3ed;
      border-color: #e6b9aa;
      color: #8b2e20;
    }

    /* Separatore elegante */
    .divider {
      display: flex;
      align-items: center;
      margin: 1.8rem 0 1rem;
      color: #6d8eaa;
      font-size: 0.8rem;
      font-weight: 500;
      letter-spacing: 1px;
    }

    .divider::before,
    .divider::after {
      content: "";
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, transparent, #b6cfE6, transparent);
    }

    .divider span {
      margin: 0 16px;
      text-transform: uppercase;
    }

    /* Footer / piccola nota */
    .footer-note {
      margin-top: 2.2rem;
      text-align: center;
      color: #587b9c;
      font-size: 0.85rem;
      font-weight: 400;
      opacity: 0.8;
    }

    /* Accessibilità e focus */
    a:focus-visible {
      outline: 3px solid #2b5f8a;
      outline-offset: 2px;
    }
  </style>
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
    <a href="index.php" class="nav-link">
      <i class="fas fa-home"></i> Homepage
    </a>
    <a href="profilo.php" class="nav-link">
      <i class="fas fa-user-circle"></i> Profilo
    </a>
    <a href="logout.php" class="nav-link logout-link">
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
