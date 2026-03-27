<h2>Aggiungi Film</h2>

<form action="/dashboard.php?page=film_save" method="POST">
    <label>Titolo</label><br>
    <input type="text" name="titolo"><br><br>

    <label>Anno</label><br>
    <input type="number" name="anno"><br><br>

    <label>Durata</label><br>
    <input type="time" name="durata"><br><br>

    <label>Trama</label><br>
    <textarea name="trama"></textarea><br><br>

    <button type="submit">Salva</button>
</form>
