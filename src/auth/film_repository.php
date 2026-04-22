<?php
require_once __DIR__ . '/../database/php.conndatabase.php';

class FilmRepository {

    private static $conn;

    public static function init($connection) {
        self::$conn = $connection;
    }

    // READ: tutti i film
    public static function getAllFilms() {
        $sql = "
            SELECT f.ID_Film, f.Titolo, f.Anno, f.Durata, f.Trama,
                   r.Nome AS RegistaNome, r.Cognome AS RegistaCognome,
                   i.URL AS poster
            FROM film f
            LEFT JOIN registi r ON f.ID_Regista = r.ID_Regista
            LEFT JOIN immagini i ON f.ID_Film = i.ID_Film
        ";

        $result = self::$conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // READ: singolo film
    public static function getFilmById($id) {
        $stmt = self::$conn->prepare("
            SELECT f.ID_Film, f.Titolo, f.Anno, f.Durata, f.Trama,
                   r.Nome AS RegistaNome, r.Cognome AS RegistaCognome,
                   i.URL AS poster
            FROM film f
            LEFT JOIN registi r ON f.ID_Regista = r.ID_Regista
            LEFT JOIN immagini i ON f.ID_Film = i.ID_Film
            WHERE f.ID_Film = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // CREATE
    public static function createFilm($data) {
        $stmt = self::$conn->prepare("
            INSERT INTO film (Titolo, Anno, Durata, Trama, ID_Regista)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "sissi",
            $data['titolo'],
            $data['anno'],
            $data['durata'],
            $data['trama'],
            $data['regista_id']
        );

        return $stmt->execute();
    }

    // UPDATE
    public static function updateFilm($data) {
        $stmt = self::$conn->prepare("
            UPDATE film
            SET Titolo = ?, Anno = ?, Durata = ?, Trama = ?, ID_Regista = ?
            WHERE ID_Film = ?
        ");
        $stmt->bind_param(
            "sissii",
            $data['titolo'],
            $data['anno'],
            $data['durata'],
            $data['trama'],
            $data['regista_id'],
            $data['id']
        );

        return $stmt->execute();
    }

    // DELETE
    public static function deleteFilm($id) {
        $stmt = self::$conn->prepare("DELETE FROM film WHERE ID_Film = ?");
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    // ottiene TUTTI i dati dei film
    public static function getFilmFull($id) {
        $sql = "
            SELECT 
                f.ID_Film,
                f.Titolo,
                f.Anno,
                f.Durata,
                f.Trama,
                r.Nome AS RegistaNome,
                r.Cognome AS RegistaCognome,
                i.URL AS Immagine,
                g.Nome_Genere
            FROM film f
            LEFT JOIN registi r ON f.ID_Regista = r.ID_Regista
            LEFT JOIN immagini i ON f.ID_Film = i.ID_Film
            LEFT JOIN film_generi fg ON f.ID_Film = fg.ID_Film
            LEFT JOIN generi g ON fg.ID_Genere = g.ID_Genere
            WHERE f.ID_Film = ?
        ";

        $stmt = self::$conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

}
