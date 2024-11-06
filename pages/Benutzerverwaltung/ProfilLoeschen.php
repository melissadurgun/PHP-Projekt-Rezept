<?php
session_start();

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user'])) {
    $_SESSION['errorMessage'] = 'Melde dich an, um deine Benutzerdaten zu löschen.';
    header("Location: Login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <title>Benutzerdaten löschen</title>
</head>

<?php
include '../../includes/header.php';
include '../../includes/navigation.php';
?>

<body>
<div class="login-container">
    <h2>Möchtest du dein Profil wirklich löschen, <?php echo htmlspecialchars($_SESSION['vorname']); ?>?</h2>
    <p>Dann verlieren wir nicht nur dich, sondern auch deine Arbeit.</p> 
    <p>Wenn du dein Profil löschst, werden alle deine Rezepte gelöscht. Deine Kommentare bleiben weiterhin bestehen.</p>
    <br>
    <form action="../../handlers/Benutzerverwaltung/ProfilLoeschenHandler.php" method="POST">
        <input type="hidden" name="confirm_delete" value="1">
        <button type="submit" class="button">Ja, Profil löschen</button>
    </form>
    <a href="Benutzerseite.php" class="button">Zurück zur Benutzerseite</a>
</div>
</body>

<?php
include '../../includes/footer.php';
?>

</html>
