<!DOCTYPE html>
<html lang="it">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Analisi Cinema</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../src/template/pages/homepagestyle.css">
</head>


<body>

<!-- NAVBAR -->

<nav>

<div class="logo">🎬 <a href="index.php">Analisi Cinema</a></div>

<ul>
<li><a href="dashboard.php">Home</a></li>
<li><a href="ricerca_film.php">Film</a></li>
<li><a href="recensioni.php">Recensioni</a></li>
<li><a href="#">Preferiti</a></li>
<li><a href="login.php">Login</a></li>
</ul>

<input class="search" placeholder="Cerca film...">

</nav>


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

<section>

<h2 class="title">🔥 Film Popolari</h2>

<div class="movies">

<div class="movie">
<img src="https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg">
<div class="movie-info">
<h3>Interstellar</h3>
<p>⭐ 9.0</p>
</div>
</div>

<div class="movie">
<img src="https://image.tmdb.org/t/p/w500/8UlWHLMpgZm9bx6QYh0NFoq67TZ.jpg">
<div class="movie-info">
<h3>The Dark Knight</h3>
<p>⭐ 9.1</p>
</div>
</div>

<div class="movie">
<img src="https://image.tmdb.org/t/p/w500/6FfCtAuVAW8XJjZ7eWeLibRLWTw.jpg">
<div class="movie-info">
<h3>Avengers</h3>
<p>⭐ 8.5</p>
</div>
</div>

<div class="movie">
<img src="https://image.tmdb.org/t/p/w500/rSPw7tgCH9c6NqICZef4kZjFOQ5.jpg">
<div class="movie-info">
<h3>Guardians of the Galaxy</h3>
<p>⭐ 8.4</p>
</div>
</div>

</div>

</section>


<!-- RECENSIONI -->

<section>

<h2 class="title">📝 Ultime Recensioni</h2>

<div class="reviews">

<div class="review">
<h4>Interstellar</h4>
<p>
Un capolavoro di fantascienza con una trama emozionante e una colonna sonora incredibile.
</p>
<p>⭐ 9/10</p>
</div>

<div class="review">
<h4>The Dark Knight</h4>
<p>
Il miglior film su Batman mai realizzato.
</p>
<p>⭐ 9.5/10</p>
</div>

<div class="review">
<h4>Avengers</h4>
<p>
Azione spettacolare e grande cast.
</p>
<p>⭐ 8/10</p>
</div>

</div>

</section>


<!-- STATISTICHE -->

<section>

<h2 class="title">📊 Statistiche del sito</h2>

<div class="stats">

<div class="stat">
<h2>1200+</h2>
<p>Film</p>
</div>

<div class="stat">
<h2>3500+</h2>
<p>Recensioni</p>
</div>

<div class="stat">
<h2>2000+</h2>
<p>Utenti</p>
</div>

</div>

</section>

<?php include __DIR__ . '/../src/template/components/componente_footer.php'; ?>

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