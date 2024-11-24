<?php

session_start();

require_once('../../config/db.php');


// Datenbankverbindung
$db = new DB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $titel = $_POST['titel'];
    $zubereitung = $_POST['zubereitung'];
    $zubereitungsdauer = $_POST['zubereitungsdauer'];
    $portionen = $_POST['portionen'];
    $ernaehrung = $_POST['ernaehrung'];
    $schwierigkeitsgrad = $_POST['schwierigkeitsgrad'];
    $mahlzeitkategorie = $_POST['mahlzeitkategorie'];
    $kueche = $_POST['kueche'];

    // Bildverarbeitung
    $bild_content = null;
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $bild = $_FILES['file'];
        $bild_content = file_get_contents($bild['tmp_name']); // Bildinhalt lesen
    } else {
        echo "Fehler beim Hochladen des Bildes: " . $_FILES['file']['error'];
        exit();
    }

    // Insert the recipe into the rezept table
    $sql = "INSERT INTO rezept (user_id, titel, zubereitung, zubereitungsdauer, portionen, ernaehrung, schwierigkeitsgrad, mahlzeitkategorie, kueche, bild)
            VALUES (:user_id, :titel, :zubereitung, :zubereitungsdauer, :portionen, :ernaehrung, :schwierigkeitsgrad, :mahlzeitkategorie, :kueche, :bild)";
    $db->executeQuery($sql, [
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

    $rezept_id = $db->lastInsertId();

    // Insert ingredients into the zutaten table
    if (!empty($_POST['zutaten'])) {
        foreach ($_POST['zutaten'] as $zutat) {
            $name = $zutat['name'] ?? '';
            $menge = $zutat['menge'] ?? 0;
            $einheit = $zutat['einheit'] ?? null;

            if (!empty($name) && !empty($menge) && !empty($einheit)) {
                $sql = "INSERT INTO zutaten (rezept_id, name, menge, einheit)
                        VALUES (:rezept_id, :name, :menge, :einheit)";
                $db->executeQuery($sql, [
                    ':rezept_id' => $rezept_id,
                    ':name' => $name,
                    ':menge' => $menge,
                    ':einheit' => $einheit
                ]);
            }
        }
    }

    //echo "Rezept und Zutaten erfolgreich gespeichert!";
    header("Location: ../../pages/Rezeptverwaltung/RezeptDetailansicht.php?rezept_id=" . $rezept_id);
    exit();
}
?>