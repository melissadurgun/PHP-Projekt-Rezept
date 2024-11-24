<?php
/**
 * Klasse stellt Funktionen zum Speichern von Bewertungen bereit. 
 * Wird von der Seite RezeptBewerten.php verwendet. 
 */
require_once('../../config/db.php');

class RezeptBewertenHandler
{
    private $DB;

    // Konstruktor stellt die Datenbankverbindung her
    public function __construct()
    {
        $this->DB = new DB();
    }

    // Funktion speichert die entsprechenden übergebenen Parameter in der Tabelle 'bewertung'
    // Gibt true zurück, wenn erfolgreich
    public function saveBewertung($rezept_id, $username, $star, $kommentar)
    {
        // Eingaben validieren
        $rezept_id = filter_var($rezept_id, FILTER_VALIDATE_INT);
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        $star = filter_var($star, FILTER_VALIDATE_INT);
        $kommentar = filter_var($kommentar, FILTER_SANITIZE_STRING);

        // Überprüfen, ob die Eingaben valide sind
        if ($rezept_id === false || $star === false || $star < 1 || $star > 5 || empty($username)) {
            return false; // Ungültige Eingaben -> Abbruch
        }

        $insertQuery = "INSERT INTO bewertung (rezept_id, username, anzahlsterne, kommentar) VALUES (:rezept_id, :username, :anzahlsterne, :kommentar)";
        $stmt = $this->DB->prepare($insertQuery);

        // Ausführen der Abfrage und Rückgabe des Ergebnisses
        return $stmt->execute([
            ':rezept_id' => $rezept_id,
            ':username' => $username,
            ':anzahlsterne' => $star,
            ':kommentar' => $kommentar
        ]);
    }
}
