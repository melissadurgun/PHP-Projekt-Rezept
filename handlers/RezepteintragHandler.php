<?php
include '../includes/header.php';
include '../config/db.php';

session_start(); // Start session to access session variables

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ..\pages\Benutzerverwaltung\login.php"); // Redirect to login if not logged in
    exit();
}

// Retrieve user_id from session
$user_id = $_SESSION['user_id'];

// Create a new instance of the DB class
$db = new DB('localhost', 'rezepte', 'root', '');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve recipe details from form
    $titel = $_POST['titel'] ?? '';
    $zubereitung = $_POST['zubereitung'] ?? '';
    $zubereitungsdauer = $_POST['zubereitungsdauer'] ?? 0;
    $portionen = $_POST['portionen'] ?? 0;
    $ernaehrung = $_POST['ernaehrung'] ?? '';
    $schwierigkeitsgrad = $_POST['schwierigkeitsgrad'] ?? '';
    $mahlzeitkategorie = $_POST['mahlzeitkategorie'] ?? '';
    $kueche = $_POST['kueche'] ?? '';
    $bild_url = $_POST['bild_url'] ?? '';

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

    echo "Rezept und Zutaten erfolgreich gespeichert!";
}
?>