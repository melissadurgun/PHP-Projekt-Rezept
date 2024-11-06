<?php
/**
 * Klasse stellt Funktionen zum Speichern von Bewertungen bereit. 
 * Wird von der page RezeptBewerten.php verwendet. 
 */
require_once('../../config/db.php');

class RezeptBewertenHandler {
    private $DB;

    //Konstruktor stellt Datenbankverbindung her 
    public function __construct() {
        $this->DB = new DB();
    }

    //Funktion sichert die entsprechenden übergebenen Parameter in der Tabelle 'bewertung', 
    //gibt true zurück, wenn geklappt 
    public function saveBewertung($rezept_id, $username, $star, $kommentar) {
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
