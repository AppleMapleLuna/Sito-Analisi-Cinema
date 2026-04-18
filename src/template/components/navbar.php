<!-- NAVBAR -->

<style>
    nav{
display:flex;
justify-content:space-between;
align-items:center;
padding:20px 80px;
background:#020617;
position:sticky;
top:0;
z-index:1000;
}

.logo{
font-size:26px;
font-weight:600;
color:#facc15;
}

nav ul{
display:flex;
gap:30px;
list-style:none;
}

nav a{
color:white;
text-decoration:none;
transition:0.3s;
}

nav a:hover{
color:#facc15;
}
</style>
<nav>

<div class="logo">🎬 <a href="../../../public/index.php">Analisi Cinema</a></div>

<ul>
<li><a href="../../../public/dashboard.php">Home</a></li>
<li><a href="../../../public/ricerca_film.php">Film</a></li>
<li><a href="../../../public/recensioni.php">Recensioni</a></li>
<li><a href="#">Preferiti</a></li>
<li><a href="../../../public/login.php">Login</a></li>
</ul>

<input class="search" placeholder="Cerca film...">

</nav>