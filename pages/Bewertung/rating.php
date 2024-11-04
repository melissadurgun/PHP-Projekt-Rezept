<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <title>Rezept bewerten</title>
</head>

<?php
include '../../includes/header.php';
include '../../includes/navigation.php';
?>

<body>
<div class="container">
    <h2>Rezept bewerten</h2>
    <form method="POST" action="">
        <!-- <input type="hidden" name="rezept_id" value="$id" /> -->

        <label for="rezept_id">Rezept ID:</label>
        <input type="number" id="rezept_id" name="rezept_id" required> <br>

        <!-- PHP-Teil, um zwischen angemeldet und unangemeldet zu unterscheiden --> 
        <?php
        session_start(); 
        // Überprüfung, ob der Benutzer angemeldet ist
        if (!empty($_SESSION['user'])) {
            // Wenn der Benutzer angemeldet ist, Benutzername anzeigen
            echo '<label>Dein Name:</label>';
            echo '<p>' . htmlspecialchars($_SESSION['vorname']) . '</p>';
        } else {
            // Wenn der Benutzer nicht angemeldet ist, Eingabefeld für den Namen anzeigen
            echo '<label for="username">Dein Name:</label>';
            echo '<input type="text" id="reg_vorname" name="reg_vorname" required>';
        }
        ?>

        <label>Bewertung:</label>
        <div class="stars">
            <input class="star star-5" id="star-5" type="radio" name="star" value="5" required />
            <label class="star star-5" for="star-5"></label>
            <input class="star star-4" id="star-4" type="radio" name="star" value="4" />
            <label class="star star-4" for="star-4"></label>
            <input class="star star-3" id="star-3" type="radio" name="star" value="3" />
            <label class="star star-3" for="star-3"></label>
            <input class="star star-2" id="star-2" type="radio" name="star" value="2" />
            <label class="star star-2" for="star-2"></label>
            <input class="star star-1" id="star-1" type="radio" name="star" value="1" />
            <label class="star star-1" for="star-1"></label>
        </div>

        <label for="kommentar">Kommentar:</label>
        <textarea name="kommentar" id="kommentar" required></textarea>

        <input type="submit" value="Bewertung absenden">
    </form>
</div>

<?php
// Datenbankverbindung aufbauen
require_once('../../config/db.php'); 
$DB = new DB(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formulardaten sichern
    $rezept_id = htmlspecialchars(trim($_POST['rezept_id']));
    $kommentar = htmlspecialchars(trim($_POST['kommentar']));
    $star = isset($_POST['star']) ? htmlspecialchars(trim($_POST['star'])) : null;
    $username = !empty($_SESSION['user']) ? $_SESSION['vorname'] : htmlspecialchars(trim($_POST['reg_vorname']));

    // Überprüfung, ob alle Felder ausgefüllt sind
    if ($rezept_id && $kommentar && $star && $username) {
        // SQL-Statement zum Einfügen der Bewertung
        $insertQuery = "INSERT INTO bewertung (rezept_id, username, anzahlsterne, kommentar) VALUES (:rezept_id, :username, :anzahlsterne, :kommentar)"; 
        $stmt = $DB->prepare($insertQuery);
        $stmt->execute([
            ':rezept_id' => $rezept_id,
            ':username' => $username,
            ':anzahlsterne' => $star,
            ':kommentar' => $kommentar
        ]);

        echo "<p>Bewertung erfolgreich abgesendet!</p>";
    } else {
        echo "<p>Bitte fülle alle Felder aus!</p>";
    }
}
?>

<?php
include '../../includes/footer.php';
?>
</body>
</html>
