<a href="/pages/film.php?id=<?= $film['ID_Film'] ?>" class="film-card">
    <?php if (!empty($film['poster'])): ?>
        <img src="<?= htmlspecialchars($film['poster']) ?>" alt="<?= htmlspecialchars($film['Titolo']) ?>">
    <?php else: ?>
        <div class="poster-placeholder">Nessuna immagine</div>
    <?php endif; ?>

    <h3><?= htmlspecialchars($film['Titolo']) ?></h3>
</a>
