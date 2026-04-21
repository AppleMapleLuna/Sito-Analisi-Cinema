<?php
session_start();
require_once __DIR__ . '/../database/php.conndatabase.php';

$id_film = $_GET['id'] ?? 0;
if (!$id_film) {
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare("
    SELECT f.ID_Film, f.Titolo, f.Anno, f.Durata, f.Trama, 
           r.Nome AS RegistaNome, r.Cognome AS RegistaCognome,
           (SELECT URL FROM immagini WHERE ID_Film = f.ID_Film LIMIT 1) AS poster,
           (SELECT AVG(Voto) FROM valutazioni WHERE ID_Film = f.ID_Film) AS voto_medio,
           (SELECT COUNT(*) FROM valutazioni WHERE ID_Film = f.ID_Film) AS num_voti
    FROM film f
    LEFT JOIN registi r ON f.ID_Regista = r.ID_Regista
    WHERE f.ID_Film = ?
");
$stmt->bind_param("i", $id_film);
$stmt->execute();
$film = $stmt->get_result()->fetch_assoc();
if (!$film) {
    header('Location: index.php');
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    $voto = (int)($_POST['voto'] ?? 0);
    $testo = trim($_POST['testo'] ?? '');
    
    if ($voto < 1 || $voto > 10) {
        $message = 'Il voto deve essere tra 1 e 10.';
    } elseif (empty($testo)) {
        $message = 'Il commento non può essere vuoto.';
    } else {
        $check = $conn->prepare("SELECT ID_Recensione FROM recensioni WHERE ID_Utente = ? AND ID_Film = ?");
        $check->bind_param("ii", $_SESSION['user']['ID_Utente'], $id_film);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            $message = 'Hai già recensito questo film.';
        } else {
            $conn->begin_transaction();
            try {
                $stmt_rec = $conn->prepare("INSERT INTO recensioni (Testo, Data, ID_Utente, ID_Film) VALUES (?, CURDATE(), ?, ?)");
                $stmt_rec->bind_param("sii", $testo, $_SESSION['user']['ID_Utente'], $id_film);
                $stmt_rec->execute();
                
                $stmt_voto = $conn->prepare("INSERT INTO valutazioni (Voto, ID_Utente, ID_Film) VALUES (?, ?, ?)");
                $stmt_voto->bind_param("iii", $voto, $_SESSION['user']['ID_Utente'], $id_film);
                $stmt_voto->execute();
                
                $conn->commit();
                $message = 'Recensione pubblicata con successo!';
                header("Location: scheda_film.php?id=$id_film");
                exit;
            } catch (Exception $e) {
                $conn->rollback();
                $message = 'Errore durante il salvataggio.';
            }
        }
    }
}

$recensioni = [];
$stmt_rec = $conn->prepare("
    SELECT r.ID_Recensione, r.Testo, r.Data, r.ID_Utente, u.Username,
           (SELECT Voto FROM valutazioni WHERE ID_Utente = r.ID_Utente AND ID_Film = r.ID_Film) AS Voto
    FROM recensioni r
    JOIN utenti u ON r.ID_Utente = u.ID_Utente
    WHERE r.ID_Film = ?
    ORDER BY r.Data DESC
");
$stmt_rec->bind_param("i", $id_film);
$stmt_rec->execute();
$recensioni = $stmt_rec->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($film['Titolo']) ?> - Analisi Cinema</title>
    <link rel="stylesheet" href="../src/template/pages/homepagestyle.css">
    <style>
        .film-detail-container { max-width: 1000px; margin: 30px auto; padding: 20px; }
        .film-header-detail { display: flex; gap: 30px; margin-bottom: 30px; flex-wrap: wrap; }
        .film-poster-large { width: 250px; border-radius: 12px; }
        .film-info-detail h1 { color: #facc15; }
        .rating-box { background: #1e293b; padding: 15px; border-radius: 10px; margin: 15px 0; }
        .review-form { background: #1e293b; padding: 25px; border-radius: 16px; margin: 30px 0; }
        .review-form textarea { width: 100%; padding: 12px; background: #0f172a; border: 1px solid #facc15; border-radius: 8px; color: white; }
        .stars-input { display: flex; gap: 10px; margin: 15px 0; }
        .star-label { font-size: 24px; cursor: pointer; color: #475569; }
        .star-label.selected { color: #facc15; }
        .review-card { background: #1e293b; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
        .review-header { display: flex; justify-content: space-between; color: #facc15; margin-bottom: 10px; }
        .btn-delete-review { background: #dc2626; color: white; border: none; padding: 5px 12px; border-radius: 6px; cursor: pointer; }
        .message { background: #facc15; color: black; padding: 10px; border-radius: 6px; margin: 15px 0; }
        .btn-stat { display: inline-block; background: #facc15; color: black; padding: 8px 16px; border-radius: 6px; text-decoration: none; margin-top: 10px; }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../src/template/componenti/navbar.php'; ?>
    
    <div class="film-detail-container">
        <div class="film-header-detail">
            <img src="<?= htmlspecialchars($film['poster'] ?? 'https://via.placeholder.com/250x375?text=No+Poster') ?>" alt="<?= htmlspecialchars($film['Titolo']) ?>" class="film-poster-large">
            <div class="film-info-detail">
                <h1><?= htmlspecialchars($film['Titolo']) ?> (<?= $film['Anno'] ?>)</h1>
                <p><strong>Regia:</strong> <?= htmlspecialchars($film['RegistaNome'] . ' ' . $film['RegistaCognome']) ?></p>
                <p><strong>Durata:</strong> <?= $film['Durata'] ? substr($film['Durata'], 0, 5) : 'N/D' ?></p>
                <p><?= nl2br(htmlspecialchars($film['Trama'] ?? '')) ?></p>
                
                <div class="rating-box">
                    <span style="font-size: 2rem; font-weight: bold; color: #facc15;"><?= $film['voto_medio'] ? number_format($film['voto_medio'], 1) : '—' ?></span><span>/10</span>
                    <p><?= $film['num_voti'] ?> voti</p>
                    <a href="statistiche_film.php?id=<?= $id_film ?>" class="btn-stat">📊 Vedi statistiche complete</a>
                </div>
            </div>
        </div>
        
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['user'])): ?>
            <div class="review-form">
                <h2 style="color: #facc15; margin-bottom: 20px;">Lascia una recensione</h2>
                <form method="POST">
                    <div class="stars-input" id="star-rating">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <span class="star-label" data-value="<?= $i ?>">★</span>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="voto" id="voto-input" required>
                    <textarea name="testo" rows="4" placeholder="Scrivi il tuo commento..." required></textarea>
                    <button type="submit" style="background: #facc15; color: black; border: none; padding: 12px 24px; border-radius: 6px; font-weight: bold; margin-top: 15px; cursor: pointer;">Pubblica recensione</button>
                </form>
            </div>
        <?php else: ?>
            <p><a href="login.php">Accedi</a> per lasciare una recensione.</p>
        <?php endif; ?>
        
        <h2 style="color: #facc15; margin: 30px 0 20px;">Recensioni (<?= count($recensioni) ?>)</h2>
        
        <?php foreach ($recensioni as $rec): ?>
            <div class="review-card">
                <div class="review-header">
                    <span><strong><?= htmlspecialchars($rec['Username']) ?></strong> - voto: <?= $rec['Voto'] ?>/10</span>
                    <span><?= date('d/m/Y', strtotime($rec['Data'])) ?></span>
                </div>
                <p><?= nl2br(htmlspecialchars($rec['Testo'])) ?></p>
                <?php if (isset($_SESSION['user']) && ($_SESSION['user']['admin'] == 1 || $_SESSION['user']['ID_Utente'] == $rec['ID_Utente'])): ?>
                    <form method="POST" action="elimina_recensione.php" style="display: inline;" onsubmit="return confirm('Sei sicuro di voler eliminare questa recensione?');">
                        <input type="hidden" name="id_recensione" value="<?= $rec['ID_Recensione'] ?>">
                        <input type="hidden" name="redirect" value="scheda_film.php?id=<?= $id_film ?>">
                        <button type="submit" class="btn-delete-review">🗑️ Elimina</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    
    <?php include __DIR__ . '/../src/template/componenti/footer.php'; ?>
    
    <script>
        const stars = document.querySelectorAll('.star-label');
        const votoInput = document.getElementById('voto-input');
        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                const value = index + 1;
                votoInput.value = value;
                stars.forEach((s, i) => {
                    s.classList.toggle('selected', i < value);
                });
            });
        });
    </script>
</body>
</html>