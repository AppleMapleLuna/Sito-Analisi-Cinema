<?php
require_once __DIR__ . '/../src/database/php.conndatabase.php';
require_once __DIR__ . '/../src/auth/film_repository.php';

FilmRepository::init($conn);
?>

<!DOCTYPE html>
<html lang="it">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Analisi Cinema</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/homepagestyle.css">
</head>


<body>

<!-- NAVBAR -->
<?php include __DIR__ . '/assets/components/navbar.php'; ?>

<!-- HERO -->

<div class="hero">

<div class="hero-text">

<h1>Il mondo delle recensioni cinematografiche</h1>

<p>
Scopri nuovi film, leggi recensioni degli utenti e trova cosa guardare al cinema.
</p>

<button>Scopri i film</button>

</div>

</div>


<!-- FILM POPOLARI -->

<?php
$popular = $conn->query("
    SELECT f.ID_film, f.Titolo, 
           COALESCE(i.URL, 'https://via.placeholder.com/300x450') AS Immagine,
           COALESCE(AVG(v.Voto), 0) AS media_voto
    FROM film f
    LEFT JOIN immagini i ON f.ID_film = i.ID_Film
    LEFT JOIN valutazioni v ON f.ID_film = v.ID_Film
    GROUP BY f.ID_film
    ORDER BY media_voto DESC
    LIMIT 4
")->fetch_all(MYSQLI_ASSOC);
?>

<section>
    <h2 class="title">🔥 Film Popolari</h2>

    <div class="movies">
        <?php foreach ($popular as $film): ?>
            <div class="movie" onclick="location.href='film.php?id=<?= $film['ID_film'] ?>'">
                <img src="<?= htmlspecialchars($film['Immagine']) ?>" alt="<?= htmlspecialchars($film['Titolo']) ?>">
                <div class="movie-info">
                    <h3><?= htmlspecialchars($film['Titolo']) ?></h3>
                    <p>⭐ <?= round($film['media_voto'], 1) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>



<!-- RECENSIONI -->
<?php
$reviews = $conn->query("
    SELECT r.Testo, r.Data,
           f.Titolo,
           COALESCE(v.Voto, 'N/A') AS Voto
    FROM recensioni r
    JOIN film f ON r.ID_Film = f.ID_film
    LEFT JOIN valutazioni v ON r.ID_Film = v.ID_Film AND r.ID_Utente = v.ID_Utente
    ORDER BY r.Data DESC
    LIMIT 3
")->fetch_all(MYSQLI_ASSOC);
?>

<section>
    <h2 class="title">📝 Ultime Recensioni</h2>

    <div class="reviews">
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $r): ?>
                <div class="review">
                    <h4><?= htmlspecialchars($r['Titolo']) ?></h4>
                    <p><?= htmlspecialchars($r['Testo']) ?></p>
                    <p>⭐ <?= $r['Voto'] ?>/10</p>
                    <small><?= $r['Data'] ?></small>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nessuna recensione disponibile.</p>
        <?php endif; ?>
    </div>
</section>




<!-- STATISTICHE -->

<?php
$totFilm = $conn->query("SELECT COUNT(*) FROM film")->fetch_row()[0];
$totRec = $conn->query("SELECT COUNT(*) FROM recensioni")->fetch_row()[0];
$totUsers = $conn->query("SELECT COUNT(*) FROM utenti")->fetch_row()[0];
?>

<section>
    <h2 class="title">📊 Statistiche del sito</h2>

    <div class="stats">
        <div class="stat">
            <h2><?= $totFilm ?></h2>
            <p>Film</p>
        </div>

        <div class="stat">
            <h2><?= $totRec ?></h2>
            <p>Recensioni</p>
        </div>

        <div class="stat">
            <h2><?= $totUsers ?></h2>
            <p>Utenti</p>
        </div>
    </div>
</section>


<?php include __DIR__ . '/assets/components/componente_footer.php'; ?>

<script>

const movies=document.querySelectorAll(".movie")

movies.forEach(movie=>{
movie.addEventListener("mouseenter",()=>{
movie.style.boxShadow="0 0 20px #facc15"
})

movie.addEventListener("mouseleave",()=>{
movie.style.boxShadow="none"
})
})

</script>

</body>
</html>