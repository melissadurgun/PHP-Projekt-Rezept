<?php

/**
 * Die Klasse RezeptHinzufügenHandler wird verwendet, um ein neues Rezept in die Datenbank einzufügen.
 * 
 * Wird verwendet in Kombination mit RezeptHinzufügen.php.
 */

session_start();
require_once('../../config/db.php');

class RezeptHinzufügenHandler
{
    // Variablendeklaration
    private $db;

    // Datenbankverbindung aufbauen
    public function __construct()
    {
        $this->db = new DB();
    }

    // Rezept speichern
    public function saveRezept($data, $file)
    {
        // Validierung der Benutzersession
        if (!isset($_SESSION['user_id'])) {
            throw new Exception("Benutzer nicht eingeloggt.");
        }
        $user_id = intval($_SESSION['user_id']); // Sicherheitsprüfung der Benutzer-ID

        // Validierung und Bereinigung der Eingabedaten
        $titel = htmlspecialchars(trim($data['titel'] ?? ''), ENT_QUOTES, 'UTF-8');
        $zubereitung = htmlspecialchars(trim($data['zubereitung'] ?? ''), ENT_QUOTES, 'UTF-8');
        $zubereitungsdauer = filter_var($data['zubereitungsdauer'] ?? 0, FILTER_VALIDATE_INT);
        $portionen = filter_var($data['portionen'] ?? 0, FILTER_VALIDATE_INT);
        $ernaehrung = htmlspecialchars(trim($data['ernaehrung'] ?? ''), ENT_QUOTES, 'UTF-8');
        $schwierigkeitsgrad = htmlspecialchars(trim($data['schwierigkeitsgrad'] ?? ''), ENT_QUOTES, 'UTF-8');
        $mahlzeitkategorie = htmlspecialchars(trim($data['mahlzeitkategorie'] ?? ''), ENT_QUOTES, 'UTF-8');
        $kueche = htmlspecialchars(trim($data['kueche'] ?? ''), ENT_QUOTES, 'UTF-8');

        if (empty($titel) || empty($zubereitung) || !$zubereitungsdauer || !$portionen || empty($ernaehrung) || empty($schwierigkeitsgrad) || empty($mahlzeitkategorie) || empty($kueche)) {
            throw new Exception("Alle Pflichtfelder müssen ausgefüllt werden.");
        }

        // Bildverarbeitung
        $bild_content = $this->processImage($file);

        // Rezept-Datenbankeintrag
        $sql = "INSERT INTO rezept (user_id, titel, zubereitung, zubereitungsdauer, portionen, ernaehrung, schwierigkeitsgrad, mahlzeitkategorie, kueche, bild)
                VALUES (:user_id, :titel, :zubereitung, :zubereitungsdauer, :portionen, :ernaehrung, :schwierigkeitsgrad, :mahlzeitkategorie, :kueche, :bild)";
        $this->db->executeQuery($sql, [
            ':user_id' => $user_id,
            ':titel' => $titel,
            ':zubereitung' => $zubereitung,
            ':zubereitungsdauer' => $zubereitungsdauer,
            ':portionen' => $portionen,
            ':ernaehrung' => $ernaehrung,
            ':schwierigkeitsgrad' => $schwierigkeitsgrad,
            ':mahlzeitkategorie' => $mahlzeitkategorie,
            ':kueche' => $kueche,
            ':bild' => $bild_content
        ]);

        $rezept_id = $this->db->lastInsertId();

        // Zutaten speichern
        $this->saveZutaten($rezept_id, $data['zutaten'] ?? []);

        return $rezept_id;
    }

    // Bildverarbeitung
    private function processImage($file)
    {
        if (isset($file['file']) && $file['file']['error'] === UPLOAD_ERR_OK) {
            $file_info = getimagesize($file['file']['tmp_name']); // Überprüfen, ob es ein gültiges Bild ist
            if (!$file_info) {
                throw new Exception("Die hochgeladene Datei ist kein gültiges Bild.");
            }

            // Begrenzung der Bildgröße (z. B. maximal 5 MB)
            if ($file['file']['size'] > 5 * 1024 * 1024) {
                throw new Exception("Das Bild darf nicht größer als 5 MB sein.");
            }

            return file_get_contents($file['file']['tmp_name']);
        } else {
            throw new Exception("Fehler beim Hochladen des Bildes: " . ($file['file']['error'] ?? 'Unbekannter Fehler'));
        }
    }

    // Zutaten speichern
    private function saveZutaten($rezept_id, $zutaten)
    {
        foreach ($zutaten as $zutat) {
            $name = htmlspecialchars(trim($zutat['name'] ?? ''), ENT_QUOTES, 'UTF-8');
            $menge = filter_var($zutat['menge'] ?? 0, FILTER_VALIDATE_FLOAT);
            $einheit = htmlspecialchars(trim($zutat['einheit'] ?? ''), ENT_QUOTES, 'UTF-8');

            if (!empty($name) && $menge > 0 && !empty($einheit)) {
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
    echo "Fehler: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit();
}
