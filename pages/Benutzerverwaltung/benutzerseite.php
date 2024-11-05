<?php
session_start();

// wenn Benutzer nicht eingeloggt --> weiterleiten an Login 
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\assets\styles\styles.css">
    <title>Benutzerseite</title>
</head>

<?php
include '../../includes/header.php';
include '../../includes/navigation.php';
?>

<body>

    <?php

    //Datenbankverbindung aufbauen
    require_once('../../config/db.php');
    $DB = new DB();


    //Rezepte aus Datenbank abrufen 
    $user_id = $_SESSION['user_id'];
    // Rezepte des Benutzers abrufen, sortieren nach neustem Rezept zuerst
    $rezepteQuery = $DB->prepare('SELECT titel, bild_url FROM rezept WHERE user_id = :user_id ORDER BY rezept_id DESC');
    $rezepteQuery->execute([':user_id' => $user_id]);
    $rezepte = $rezepteQuery->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <!-- Benutzer-Willkommensnachricht und Menü -->
    <header>
        <div class="section1">
            <div class="willkommen">
        <h1>Willkommen, <?php echo htmlspecialchars($_SESSION['vorname']); ?>!</h1>
        <p>Schön, dass du wieder da bist.</p>
        </div>
        <div class="button-container">
            <a href="../Benutzerverwaltung/" class="button">Persönliche Daten bearbeiten</a>
            <a href="../Rezeptverwaltung/RezHinzufügen.php" class="button">Rezept anlegen</a>
            <a href="../Benutzerverwaltung/datenloeschen.php" class="button">Profil löschen</a>
            <a href="../Benutzerverwaltung/" class="button">Logout</a>
        </div>
        </div>
    </header>


    <!-- Abschnitt für die Rezepte -->
    <section class="rezepte-section">
        <h2>Deine Rezepte</h2>
        <div class="button-container-rezepte">
            <!-- Button für neues Rezept hinzufügen -->
            <a href="..\..\pages\Rezeptverwaltung\RezHinzufügen.php" class="button"> + Neues Rezept hinzufügen</a>
        </div>
        <div class="rezepte-container">
            <?php foreach ($rezepte as $rezept): ?>
                <div class="rezept-kachel">
                    <!-- Überprüfen, ob ein Bild vorhanden ist, andernfalls Platzhalter anzeigen -->
                    <img src="<?php echo htmlspecialchars($rezept['bild_url'] ?: 'platzhalter.png'); ?>"
                        alt="<?php echo htmlspecialchars($rezept['titel']); ?>">
                    <h3><?php echo htmlspecialchars($rezept['titel']); ?></h3>
                    <div class="link-container-rezepte">
                <a href="">
                <i class="fa fa-trash-o">
                <span> Löschen</span></a></i>
                <a href="../../handlers/Rezeptverwaltung/RezDetailansichtHandler.php?id=">
                <i class="fa fa-edit">
                <span>Bearbeiten</span></a></i>
                </div>
                </div>
                
            <?php endforeach; ?>
            
        </div>
    </section>

</body>

<?php
include '../../includes/footer.php';
?>

</html>