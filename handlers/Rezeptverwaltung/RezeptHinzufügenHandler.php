<?php

session_start();

include '../../includes/header.php';
require_once('../../config/db.php');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ..\..\pages\Benutzerverwaltung\login.php");
    exit;
}

//Datenbankverbindung
$db = new DB();

// Check if the form was submitted
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

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $bild = $_FILES['file'];

        echo 'Bild erhalten';

        // Zielverzeichnis und Dateiname festlegen
        $upload_dir = __DIR__ . '/../../uploads/'; // Absoluter Pfad zum uploads-Ordner
        $bild_name = uniqid() . '-' . basename($bild['name']);
        $bild_path = $upload_dir . $bild_name;

        echo 'Bildname geändert';

        // Bild speichern
        if (move_uploaded_file($bild['tmp_name'], $bild_path)) {
            $bild_url = '../../uploads/' . $bild_name; // Pfad für die Datenbank

            echo 'Bild gespeichert';
        } else {
            echo "Fehler beim Hochladen des Bildes.";
            exit();
        }
    } else {
        echo "Fehler beim speichern des Bildes <br>" . $_FILES['file']['error'];
    }

    // Insert the recipe into the rezept table, including user_id
    $sql = "INSERT INTO rezept (user_id, titel, zubereitung, zubereitungsdauer, portionen, ernaehrung, schwierigkeitsgrad, mahlzeitkategorie, kueche, bild_url)
            VALUES (:user_id, :titel, :zubereitung, :zubereitungsdauer, :portionen, :ernaehrung, :schwierigkeitsgrad, :mahlzeitkategorie, :kueche, :bild_url)";
    $db->executeQuery($sql, [
        ':user_id' => $user_id,  // Bind the user ID from session
        ':titel' => $titel,
        ':zubereitung' => $zubereitung,
        ':zubereitungsdauer' => $zubereitungsdauer,
        ':portionen' => $portionen,
        ':ernaehrung' => $ernaehrung,
        ':schwierigkeitsgrad' => $schwierigkeitsgrad,
        ':mahlzeitkategorie' => $mahlzeitkategorie,
        ':kueche' => $kueche,
        ':bild_url' => $bild_url
    ]);

    // Get the ID of the last inserted recipe
    $rezept_id = $db->lastInsertId();

    // Insert each ingredient into the zutaten table
    if (!empty($_POST['zutaten'])) {
        foreach ($_POST['zutaten'] as $zutat) {
            $name = $zutat['name'] ?? '';
            $menge = $zutat['menge'] ?? 0;
            $einheit = $zutat['einheit'] ?? null;

            // Check that all fields have values before inserting
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

    echo "Rezept und Zutaten erfolgreich gespeichert! <br> Redirecting...";

    // Redirect to the RezeptDetailAnsicht page
    header("Location: ../../pages/Rezeptverwaltung/RezeptDetailansicht.php?rezept_id=" . $rezept_id);
    exit(); // Ensure no further code is executed after the redirect
}
?>

</html>