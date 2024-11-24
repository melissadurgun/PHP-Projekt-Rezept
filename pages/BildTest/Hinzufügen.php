<?php
/**
 * Diese Klasse verarbeitet das Hinzufügen von Rezepten und speichert diese in der Datenbank.
 */

require_once('../../config/db.php');

class RezeptHinzufügenHandler
{
    private $DB;

    public function __construct()
    {
        $this->DB = new DB();
    }

    public function addRezept($user_id, $titel, $zubereitung, $zubereitungsdauer, $portionen, $ernaehrung, $schwierigkeitsgrad, $mahlzeitkategorie, $kueche, $bild, $zutaten)
    {
        try {
            // Bildinhalt vorbereiten, falls vorhanden
            $bildInhalt = null;
            if ($bild && $bild['error'] === UPLOAD_ERR_OK) {
                $bildInhalt = file_get_contents($bild['tmp_name']); // Bildinhalt als BLOB laden
            }

            // Rezept in die Tabelle einfügen
            $insertRezept = 'INSERT INTO rezept (user_id, titel, zubereitung, zubereitungsdauer, portionen, ernaehrung, schwierigkeitsgrad, mahlzeitkategorie, kueche, bild)
                             VALUES (:user_id, :titel, :zubereitung, :zubereitungsdauer, :portionen, :ernaehrung, :schwierigkeitsgrad, :mahlzeitkategorie, :kueche, :bild)';
            $stmt = $this->DB->prepare($insertRezept);

            $stmt->execute([
                ':user_id' => $user_id,
                ':titel' => $titel,
                ':zubereitung' => $zubereitung,
                ':zubereitungsdauer' => $zubereitungsdauer,
                ':portionen' => $portionen,
                ':ernaehrung' => $ernaehrung,
                ':schwierigkeitsgrad' => $schwierigkeitsgrad,
                ':mahlzeitkategorie' => $mahlzeitkategorie,
                ':kueche' => $kueche,
                ':bild' => $bildInhalt
            ]);

            // ID des eingefügten Rezepts abrufen
            $rezept_id = $this->DB->lastInsertId();

            // Zutaten einfügen
            if (!empty($zutaten)) {
                $insertZutaten = 'INSERT INTO zutaten (rezept_id, name, menge, einheit) VALUES (:rezept_id, :name, :menge, :einheit)';
                $stmtZutaten = $this->DB->prepare($insertZutaten);

                foreach ($zutaten as $zutat) {
                    $name = $zutat['name'] ?? '';
                    $menge = $zutat['menge'] ?? 0;
                    $einheit = $zutat['einheit'] ?? null;

                    // Sicherstellen, dass alle Felder Werte haben
                    if (!empty($name) && !empty($menge) && !empty($einheit)) {
                        $stmtZutaten->execute([
                            ':rezept_id' => $rezept_id,
                            ':name' => $name,
                            ':menge' => $menge,
                            ':einheit' => $einheit
                        ]);
                    }
                }
            }

            return $rezept_id; // Erfolgreich eingefügte Rezept-ID zurückgeben
        } catch (Exception $e) {
            return "Fehler beim Hinzufügen des Rezepts: " . $e->getMessage();
        }
    }
}

// Nutzung der Klasse im Skript
session_start();

// Prüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user'])) {
    header("Location: ../../pages/Benutzerverwaltung/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Formulardaten sammeln
    $user_id = $_SESSION['user_id'];
    $titel = $_POST['titel'];
    $zubereitung = $_POST['zubereitung'];
    $zubereitungsdauer = $_POST['zubereitungsdauer'];
    $portionen = $_POST['portionen'];
    $ernaehrung = $_POST['ernaehrung'];
    $schwierigkeitsgrad = $_POST['schwierigkeitsgrad'];
    $mahlzeitkategorie = $_POST['mahlzeitkategorie'];
    $kueche = $_POST['kueche'];
    $zutaten = $_POST['zutaten'] ?? [];
    $bild = $_FILES['file'] ?? null;

    // Rezept hinzufügen
    $handler = new RezeptHinzufügenHandler();
    $result = $handler->addRezept($user_id, $titel, $zubereitung, $zubereitungsdauer, $portionen, $ernaehrung, $schwierigkeitsgrad, $mahlzeitkategorie, $kueche, $bild, $zutaten);

    if (is_numeric($result)) {
        // Erfolgreich, zur Detailansicht weiterleiten
        header("Location: ../../pages/Rezeptverwaltung/RezeptDetailansicht.php?rezept_id=" . $result);
        exit;
    } else {
        // Fehler anzeigen
        echo $result;
    }
}
?>