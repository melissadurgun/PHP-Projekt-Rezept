<?php
require_once('../../config/db.php');

class BewertungenAnzeigenHandler {
    private $DB;

    public function __construct() {
        $this->DB = new DB();
    }

    // Methode zur Berechnung der durchschnittlichen Bewertung
    public function berechneDurchschnittlicheBewertung($rezept_id) {
        $query = "SELECT AVG(anzahlsterne) AS durchschnitt, COUNT(*) AS total FROM bewertung WHERE rezept_id = :rezept_id";
        $stmt = $this->DB->prepare($query);
        $stmt->execute([':rezept_id' => $rezept_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $durchschnitt = $result['durchschnitt'] ? round($result['durchschnitt'], 1) : 0;
        $totalBewertungen = $result['total'];

        return [$durchschnitt, $totalBewertungen];
    }

    // Methode zum Abrufen aller Bewertungen für ein bestimmtes Rezept
    public function getBewertungen($rezept_id) {
        $query = "SELECT username, anzahlsterne, kommentar FROM bewertung WHERE rezept_id = :rezept_id ORDER BY bewertung_id DESC";
        $stmt = $this->DB->prepare($query);
        $stmt->execute([':rezept_id' => $rezept_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
