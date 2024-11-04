<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\assets\styles\styles.css">   
    <title>Benutzerdaten löschen</title>
</head>

<?php
include '../../includes/header.php';
include '../../includes/navigation.php';
?>

<body>

<?php

session_start(); 

//Wenn Benutzer angemeldet, dann nochmal nachfragen, ob Daten wirklich gelöscht werden sollen 
if (!empty($_SESSION['user'])) {

    echo'
    <div class="login-container">
    <h2>Möchtest du dein Profil bei uns wirklich löschen, '. $_SESSION['vorname'].'?</h2> 
    <p>Dann verlieren wir nicht nur dich, sondern auch deine Arbeit.</p> 
    <p>Wenn du dein Profil löschst, werden alle deine Rezepte gelöscht. Deine Kommentare bleiben weiterhin bestehen.</p>
    <br>
    <a href="benutzerseite.php" class="button">Nein</a>
    <a href="actualloeschen.php" class="button">Ja</a>
    <a href="benutzerseite.php" class="button">Zurück zur Benutzerseite</a>
    '; 
    
} else {

    //wenn Benutzer nicht angemeldet, dann zuerst Login, dann Daten löschen 
    $_SESSION['errorMessage'] = 'Melde dich an, um deine Benutzerdaten zu löschen.'; 
    header("Location: login.php");
    exit;
}

?>
    
</body>

<?php
include '../../includes/footer.php';
?>

</html>