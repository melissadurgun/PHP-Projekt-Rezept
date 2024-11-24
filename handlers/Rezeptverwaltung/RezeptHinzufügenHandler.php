<?php

/**
 * Die Klasse RezeptHinzufügenHandler wird verwendet, um ein neues Rezept in die Datenbank einzufügen. 
 * 
 * Wird verwendet in Kombination mit RezeptHinzufügen.php. 
 */

 session_start(); 
require_once('../../config/db.php');

class RezeptHinzufügenHandler {

    //Variablendeklaration
    private $db;

    //Datenbankverbindung aufbauen 
    public function __construct() {
        $this->db = new DB();
    }

    // Rezept speichern
    public function saveRezept($data, $file) {

        // Validierung der Benutzersession
        if (!isset($_SESSION['user_id'])) {
            throw new Exception("Benutzer nicht eingeloggt.");
        }
        $user_id = $_SESSION['user_id'];

        // Bildverarbeitung
        $bild_content = $this->processImage($file);

        // Rezept-Datenbankeintrag
        $sql = "INSERT INTO rezept (user_id, titel, zubereitung, zubereitungsdauer, portionen, ernaehrung, schwierigkeitsgrad, mahlzeitkategorie, kueche, bild)
                VALUES (:user_id, :titel, :zubereitung, :zubereitungsdauer, :portionen, :ernaehrung, :schwierigkeitsgrad, :mahlzeitkategorie, :kueche, :bild)";
        $this->db->executeQuery($sql, [
            ':user_id' => $user_id,
            ':titel' => $data['titel'],
            ':zubereitung' => $data['zubereitung'],
            ':zubereitungsdauer' => $data['zubereitungsdauer'],
            ':portionen' => $data['portionen'],
            ':ernaehrung' => $data['ernaehrung'],
            ':schwierigkeitsgrad' => $data['schwierigkeitsgrad'],
            ':mahlzeitkategorie' => $data['mahlzeitkategorie'],
            ':kueche' => $data['kueche'],
            ':bild' => $bild_content
        ]);

        $rezept_id = $this->db->lastInsertId();

        // Zutaten speichern
        $this->saveZutaten($rezept_id, $data['zutaten'] ?? []);

        return $rezept_id;
    }

    // Bildverarbeitung
    private function processImage($file) {
        if (isset($file['file']) && $file['file']['error'] === UPLOAD_ERR_OK) {
            return file_get_contents($file['file']['tmp_name']);
        } else {
            throw new Exception("Fehler beim Hochladen des Bildes: " . ($file['file']['error'] ?? 'Unbekannter Fehler'));
        }
    }

    // Zutaten speichern
    private function saveZutaten($rezept_id, $zutaten) {
        foreach ($zutaten as $zutat) {
            $name = $zutat['name'] ?? '';
            $menge = $zutat['menge'] ?? 0;
            $einheit = $zutat['einheit'] ?? null;

            if (!empty($name) && !empty($menge) && !empty($einheit)) {
                $sql = "INSERT INTO zutaten (rezept_id, name, menge, einheit)
                        VALUES (:rezept_id, :name, :menge, :einheit)";
                $this->db->executeQuery($sql, [
                    ':rezept_id' => $rezept_id,
                    ':name' => $name,
                    ':menge' => $menge,
                    ':einheit' => $einheit
                ]);
            }
        }
    }
}

// Hauptlogik -- außerhalb von der Klasse, da in RezeptHinzufügen.php action="RezeptHinzufügenHandler.php"
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $handler = new RezeptHinzufügenHandler();
        $rezept_id = $handler->saveRezept($_POST, $_FILES);

        // Erfolgreich speichern, Weiterleitung
        header("Location: ../../pages/Rezeptverwaltung/RezeptDetailansicht.php?rezept_id=" . $rezept_id);
        exit();
    }
} catch (Exception $e) {
    echo "Fehler: " . $e->getMessage();
    exit();
}
