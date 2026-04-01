<?php
require_once '../database/php.conndatabase.php';

if (!isset($_SESSION['ID_Utente']) || $_SESSION['admin'] !== 1) {
    header('Location: ../../public/login.php');
    exit;
}

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

$stmt = $pdo->query("
    SELECT f.ID_Film, f.Titolo, f.Anno, f.Durata, f.Trama, r.Nome, r.Cognome
    FROM Film f
    LEFT JOIN Registi r ON f.ID_Regista = r.ID_Regista
    ORDER BY f.Anno DESC
");

$films = $stmt->fetchAll(PDO::FETCH_ASSOC);

$directorsStmt = $pdo->query("SELECT ID_Regista, Nome, Cognome FROM Registi ORDER BY Cognome");
$directors = $directorsStmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestione Film</title>
    <link rel="stylesheet" href="../template/pages/admin_style.css">
    <script src="../scripts/admin_script.js" defer></script>
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>Area Amministratore</h1>
            <div class="user-info">
                <span>Ciao, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="../../public/logout.php" class="logout-btn">Logout</a>
            </div>
        </header>

        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="admin-grid">
            <section class="create-film-card">
                <h2>Crea Nuovo Film</h2>
                <form action="film_create.php" method="POST" class="film-form">
                    <div class="form-group">
                        <label for="titolo">Titolo</label>
                        <input type="text" id="titolo" name="titolo" required>
                    </div>
                    <div class="form-group">
                        <label for="anno">Anno</label>
                        <input type="number" id="anno" name="anno" required min="1900" max="2026">
                    </div>
                    <div class="form-group">
                        <label for="durata">Durata (minuti)</label>
                        <input type="number" id="durata" name="durata">
                    </div>
                    <div class="form-group">
                        <label for="trama">Trama</label>
                        <textarea id="trama" name="trama" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="regista">Regista</label>
                        <select id="regista" name="regista_id" required>
                            <option value="">Seleziona regista</option>
                            <?php foreach ($directors as $dir): ?>
                                <option value="<?php echo $dir['ID_Regista']; ?>">
                                    <?php echo htmlspecialchars($dir['Nome'] . ' ' . $dir['Cognome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <a href="admin_add_director.php" class="small-link">+ Nuovo regista</a>
                    </div>
                    <button type="submit" class="btn-create">Crea Film</button>
                </form>
            </section>

            <section class="films-list-card">
                <h2>Elenco Film</h2>
                <div class="table-responsive">
                    <table class="films-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titolo</th>
                                <th>Anno</th>
                                <th>Durata</th>
                                <th>Regista</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($films) > 0): ?>
                                <?php foreach ($films as $film): ?>
                                    <tr>
                                        <td><?php echo $film['ID_Film']; ?></td>
                                        <td><?php echo htmlspecialchars($film['Titolo']); ?></td>
                                        <td><?php echo $film['Anno']; ?></td>
                                        <td><?php echo $film['Durata'] ? $film['Durata'] . ' min' : '-'; ?></td>
                                        <td><?php echo htmlspecialchars($film['Nome'] . ' ' . $film['Cognome']); ?></td>
                                        <td>
                                            <form action="film_delete.php" method="POST" class="delete-form" data-film="<?php echo htmlspecialchars($film['Titolo']); ?>">
                                                <input type="hidden" name="film_id" value="<?php echo $film['ID_Film']; ?>">
                                                <button type="submit" class="btn-delete">Elimina</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6">Nessun film presente.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</body>
</html>