<?php
/**
 * Die Klasse stellt einen BewertungenAnzeigenHandler mit Funktionen zum Abrufen der Bewertugnen eines Rezepts bereit. 
 * 
 * Wird verwendet in Pages: BewertungenAnzeigen.php. 
 */
require_once('../../config/db.php');

class BewertungenAnzeigenHandler
{
    private $DB;

    //Datenbankverbindung aufbauen 
    public function __construct()
    {
        $this->DB = new DB();
    }

    // Methode zur Berechnung der durchschnittlichen Bewertung
    public function berechneDurchschnittlicheBewertung($rezept_id)
    {
        // Eingabe validieren
        $rezept_id = filter_var($rezept_id, FILTER_VALIDATE_INT);
        if ($rezept_id === false) {
            return [0, 0]; // Ungültige ID -> keine Bewertungen
        }

        $query = "SELECT AVG(anzahlsterne) AS durchschnitt, COUNT(*) AS total FROM bewertung WHERE rezept_id = :rezept_id";
        $stmt = $this->DB->prepare($query);
        $stmt->bindParam(':rezept_id', $rezept_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $durchschnitt = $result['durchschnitt'] ? round($result['durchschnitt'], 1) : 0;
        $totalBewertungen = $result['total'];

        return [$durchschnitt, $totalBewertungen];
    }

    // Methode zum Abrufen aller Bewertungen für ein bestimmtes Rezept
    public function getBewertungen($rezept_id)
    {
        // Eingabe validieren
        $rezept_id = filter_var($rezept_id, FILTER_VALIDATE_INT);
        if ($rezept_id === false) {
            return []; // Ungültige ID -> keine Bewertungen
        }

        $query = "SELECT username, anzahlsterne, kommentar FROM bewertung WHERE rezept_id = :rezept_id ORDER BY bewertung_id DESC";
        $stmt = $this->DB->prepare($query);
        $stmt->bindParam(':rezept_id', $rezept_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>