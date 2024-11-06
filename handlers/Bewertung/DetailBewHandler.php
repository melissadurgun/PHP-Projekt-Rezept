<?php
require_once('../../config/db.php');

class RezeptDetailansichtHandler {
    private $DB;

    public function __construct() {
        $this->DB = new DB();
    }

    // Methode zum Abrufen der Rezeptdetails
    public function getRezeptDetails($rezept_id) {
        $query = "SELECT rezept_id, titel, zubereitung, zubereitungsdauer, portionen, ernaehrung, schwierigkeitsgrad, mahlzeitkategorie, kueche, bild_url
                  FROM rezept 
                  WHERE rezept_id = :rezept_id";
        $stmt = $this->DB->prepare($query);
        $stmt->execute([':rezept_id' => $rezept_id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Methode zum Abrufen der Zutaten für ein Rezept
    public function getZutaten($rezept_id) {
        $query = "SELECT name, menge, einheit FROM zutaten WHERE rezept_id = :rezept_id ORDER BY zutaten_id";
        $stmt = $this->DB->prepare($query);
        $stmt->execute([':rezept_id' => $rezept_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>