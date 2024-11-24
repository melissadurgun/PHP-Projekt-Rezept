<?php
/**
 * Seite wird aufgerufen, wenn der Benutzer auf Profil löschen drückt. 
 * Zeigt nochmal eine Warnung an, dass alles gelöscht wird, wenn der Benutzer sich tatsächlich für Löschen entscheidet. 
 */


session_start();

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user'])) {
    $_SESSION['errorMessage'] = 'Melde dich an, um deine Benutzerdaten zu löschen.';
    header("Location: Login.php");
    exit();
}
?>

<!-- HTML-Teil, um die Warnung anzuzeigen --> 
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <title>Benutzerdaten löschen</title>
</head>

<?php
require_once('../../includes/header.php'); 
require_once('../../includes/navigation.php'); 
?>

<body>
<div class="login-container">
    <h2>Möchtest du dein Profil wirklich löschen, <?php echo htmlspecialchars($_SESSION['vorname']); ?>?</h2>
    <p>Dann verlieren wir nicht nur dich, sondern auch deine Arbeit.</p> 
    <p>Wenn du dein Profil löschst, werden alle deine Rezepte gelöscht. Deine Kommentare bleiben weiterhin bestehen.</p>
    <br>
    <form name="delete" action="../../handlers/Benutzerverwaltung/ProfilLoeschenHandler.php" method="POST">
        <input type="hidden" name="confirm_delete" value="1">
        <div class="button-container">
        <button type="submit" class="button">Ja, Profil löschen</button>
        <a href="Benutzerseite.php">Zurück zur Benutzerseite</a>
    </div>
    </form>
    
</div>
</body>

<?php
require_once('../../includes/footer.php'); 
?>

</html>
