<div class="film-card"
    data-title="<?= htmlspecialchars($film['Titolo']) ?>"
    data-desc="<?= htmlspecialchars($film['Trama']) ?>"
    data-year="<?= htmlspecialchars($film['Anno']) ?>"
    data-genre="<?= htmlspecialchars($film['Nome_Genere'] ?? '') ?>"
    data-img="<?= htmlspecialchars($film['poster'] ?? '') ?>"
>
    <?php if (!empty($film['poster'])): ?>
        <img src="<?= htmlspecialchars($film['poster']) ?>" alt="<?= htmlspecialchars($film['Titolo']) ?>">
    <?php else: ?>
        <div class="poster-placeholder">Nessuna immagine</div>
    <?php endif; ?>

    <h3><?= htmlspecialchars($film['Titolo']) ?></h3>
</div>
