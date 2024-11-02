<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\assets\styles\styles.css">
    <link rel="stylesheet" href="..\..\assets\styles\RezeptCreate.css">
    <title>Document</title>
</head>

<?php
include '../../includes/header.php';
include '../../config/db.php';

session_start(); // Start session to access session variables

// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: \PHP-Projekt\pages\Benutzerverwaltung\login.php"); // Redirect to login if not logged in
//     exit();
// }

// Retrieve user_id from session
// $user_id = $_SESSION['user_id'];

//TEST
$user_id = 1;

// Create a new instance of the DB class
$db = new DB('localhost', 'rezepte', 'root', '');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $user_id = $_SESSION['user_id'];
    $user_id = 1;
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

    echo "Rezept und Zutaten erfolgreich gespeichert! <br> Redirecting...";

    // Redirect to the RezeptDetailAnsicht page
    header("Location: ../../handlers/Rezeptverwaltung/RezDetailansichtHandler.php?rezept_id=" . $rezept_id);
    exit(); // Ensure no further code is executed after the redirect
}
?>

</html>