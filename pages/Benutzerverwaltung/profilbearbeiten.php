<?php
session_start();
require_once('../../handlers/Benutzerverwaltung/ProfilBearbeitenHandler.php');

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$profilBearbeitenHandler = new ProfilBearbeitenHandler();
$errorMessage = "";

// Wenn das Formular gesendet wurde, die Eingaben verarbeiten
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vorname = htmlspecialchars(trim($_POST['vorname']));
    $nachname = htmlspecialchars(trim($_POST['nachname']));
    $username = htmlspecialchars(trim($_POST['username']));
    $password1 = $_POST['password1'] ?? null;
    $password2 = $_POST['password2'] ?? null;

    // Profil aktualisieren
    $errorMessage = $profilBearbeitenHandler->updateProfile($_SESSION['user_id'], $vorname, $nachname, $username, $password1, $password2);

    // Weiterleitung zur Benutzerseite, wenn die Aktualisierung erfolgreich war
    if (empty($errorMessage)) {
        header('Location: benutzerseite.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <title>Profil bearbeiten</title>
</head>

<?php
include '../../includes/header.php';
include '../../includes/navigation.php';
?>

<body>
<div class="profile-container">
    <h2>Profil bearbeiten</h2>

    <form action="profilbearbeiten.php" method="post">
        <label for="vorname">Vorname:</label>
        <input type="text" id="vorname" name="vorname" value="<?php echo htmlspecialchars($_SESSION['vorname']); ?>" required>

        <label for="nachname">Nachname:</label>
        <input type="text" id="nachname" name="nachname" value="<?php echo htmlspecialchars($_SESSION['nachname']); ?>" required>

        <label for="username">E-Mail Adresse:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['user']); ?>" required>

        <label for="password1">Neues Passwort:</label>
        <input type="password" id="password1" name="password1">

        <label for="password2">Passwort wiederholen:</label>
        <input type="password" id="password2" name="password2">

        <input type="submit" value="Änderungen speichern">
    </form>

    <?php
    // Fehlermeldung anzeigen, falls vorhanden
    if (!empty($errorMessage)) {
        echo '<div style="color:red;">' . htmlspecialchars($errorMessage) . '</div>';
    }
    ?>
</div>
</body>

<?php
include '../../includes/footer.php';
?>
</html>
