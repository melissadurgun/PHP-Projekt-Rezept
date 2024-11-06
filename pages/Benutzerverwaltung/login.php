<?php
session_start();
require_once('../../handlers/Benutzerverwaltung/LoginHandler.php');

// Erstellen eines LoginHandler-Objekts
$loginHandler = new LoginHandler();

// Benutzer ausloggen, wenn `logout`-Parameter gesetzt ist
if (isset($_REQUEST['logout'])) {
    $loginHandler->logout();
}

// Benutzer zur Benutzerseite weiterleiten, wenn er bereits eingeloggt ist
if ($loginHandler->isLoggedIn()) {
    header('Location: Benutzerseite.php');
    exit;
}

// Fehlermeldung initialisieren
$errorMessage = '';

// Login-Prozess, wenn das Formular gesendet wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['username']) && !empty($_POST['password'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    if ($loginHandler->login($username, $password)) {
        // Bei erfolgreichem Login zur Benutzerseite weiterleiten
        header('Location: Benutzerseite.php');
        exit;
    } else {
        // Fehlermeldung bei falschen Login-Daten
        $errorMessage = 'Login fehlgeschlagen. Bitte überprüfen Sie Ihre Eingaben.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <title>Login</title>
</head>

<?php
include '../../includes/header.php';
include '../../includes/navigation.php';
?>

<body>
    <div class="login-container">
        <h2>Anmelden</h2>
        <form action="Login.php" method="post">
            <label>Benutzername (E-Mail Adresse):</label>
            <input type="text" name="username" required>
            
            <label>Passwort:</label>
            <input type="password" name="password" required>
            
            <input type="submit" value="Anmelden">
        </form>
        
        <p>Noch keinen Account? <a href="Registrieren.php">Hier registrieren</a></p>
        
        <?php
        // Fehlermeldung anzeigen, falls Login fehlgeschlagen ist
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
