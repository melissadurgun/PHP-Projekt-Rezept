<?php
include '../includes/header.php';  // Include the header
include '../config/db.php';        // Include the DB class

// Create an instance of the DB class
$db = new DB('localhost', 'rezepte', 'root', '');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve recipe details
    $titel = $_POST['titel'];
    $zubereitung = $_POST['zubereitung'];
    $zubereitungsdauer = $_POST['zubereitungsdauer'];
    $portionen = $_POST['portionen'];
    $ernaehrung = $_POST['ernaehrung'];

    // Insert the recipe into the rezept table
    $sql = "INSERT INTO rezept (titel, zubereitung, zubereitungsdauer, portionen, ernaehrung)
            VALUES (:titel, :zubereitung, :zubereitungsdauer, :portionen, :ernaehrung)";
    $db->executeQuery($sql, [
        ':titel' => $titel,
        ':zubereitung' => $zubereitung,
        ':zubereitungsdauer' => $zubereitungsdauer,
        ':portionen' => $portionen,
        ':ernaehrung' => $ernaehrung
    ]);

    // Get the ID of the last inserted recipe
    $rezept_id = $db->lastInsertId();

    // Insert each ingredient into the zutaten table
    foreach ($_POST['zutaten'] as $zutat) {
        $name = $zutat['name'];
        $menge = $zutat['menge'];
        $einheit = $zutat['einheit'];

        $sql = "INSERT INTO zutaten (rezept_id, name, menge, einheit)
                VALUES (:rezept_id, :name, :menge, :einheit)";
        $db->executeQuery($sql, [
            ':rezept_id' => $rezept_id,
            ':name' => $name,
            ':menge' => $menge,
            ':einheit' => $einheit
        ]);
    }

    echo "Rezept und Zutaten erfolgreich gespeichert!";
}
?>