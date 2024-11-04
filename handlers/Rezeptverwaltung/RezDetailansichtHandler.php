<?php
include '../../config/db.php';

// Create a new database connection
$db = new DB('db', 'Rezepte', 'root', '');

// Get the recipe ID from the URL
$rezept_id = $_GET['rezept_id'] ?? null;
if (!$rezept_id) {
    echo "Rezept-ID nicht angegeben.";
    exit();
}

// Fetch recipe details
$query = "SELECT r.*, u.username FROM rezept r
          JOIN user u ON r.user_id = u.user_id
          WHERE r.rezept_id = :rezept_id";
$stmt = $db->prepare($query);
$stmt->execute([':rezept_id' => $rezept_id]);
$rezept = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$rezept) {
    echo "Rezept nicht gefunden.";
    exit();
}

// Fetch ingredients for the recipe
$queryZutaten = "SELECT * FROM zutaten WHERE rezept_id = :rezept_id";
$stmtZutaten = $db->prepare($queryZutaten);
$stmtZutaten->execute([':rezept_id' => $rezept_id]);
$zutaten = $stmtZutaten->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for the template
$titel = htmlspecialchars($rezept['titel']);
$username = htmlspecialchars($rezept['username']);
$zubereitungsdauer = htmlspecialchars($rezept['zubereitungsdauer']);
$schwierigkeitsgrad = htmlspecialchars($rezept['schwierigkeitsgrad']);
$kueche = htmlspecialchars($rezept['kueche']);
$ernaehrung = htmlspecialchars($rezept['ernaehrung']);
$mahlzeitkategorie = htmlspecialchars($rezept['mahlzeitkategorie']);
$bild_url = htmlspecialchars($rezept['bild_url']);
$portionen = htmlspecialchars($rezept['portionen']);
$zubereitung = nl2br(htmlspecialchars($rezept['zubereitung']));

// Include the HTML template
include '../../pages/Rezeptverwaltung/TEST-RezDetailansicht.php';