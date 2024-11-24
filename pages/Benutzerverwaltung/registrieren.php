<?php
/**
 * Die Seite zeigt ein Formular, in welches der Benutzer seine Daten bei der Registrierung eingibt. 
 * 
 */


session_start();
require_once('../../handlers/Benutzerverwaltung/RegistrierenHandler.php');

// RegistrierenHandler-Objekt erstellen
$registrierenHandler = new RegistrierenHandler();

// Fehlermeldung initialisieren
$errorMessage = "";

// Wenn das Registrierungsformular gesendet wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vorname = htmlspecialchars(trim($_POST['reg_vorname']));
    $nachname = htmlspecialchars(trim($_POST['reg_nachname']));
    $username = htmlspecialchars(trim($_POST['reg_username']));
    $password1 = $_POST['reg_password1'];
    $password2 = $_POST['reg_password2'];

    // Registrierung durchführen
    $errorMessage = $registrierenHandler->register($vorname, $nachname, $username, $password1, $password2);

    // Weiterleitung zur Benutzerseite, wenn die Registrierung erfolgreich war
    if (empty($errorMessage)) {
        header('Location: Benutzerseite.php');
        exit();
    }
}
?>

<!-- HTML, um das Formular anzuzeigen --> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <title>Registrieren</title>
</head>

<?php
require_once('../../includes/header.php'); 
require_once('../../includes/navigation.php'); 
?>

<body>
    <div class="login-container">
        <div>
            <h2>Neu hier?</h2>

            <p>Registrieren Sie sich!</p><br><br><br>
            <p>Schon registriert? <button class="anmelden" onclick="window.location.href='Login.php'">Dann klicke
                    hier.</button></p>
        </div>

        <form action="registrieren.php" method="post">
            <label for="vorname">Vorname:</label>
            <input type="text" id="reg_vorname" name="reg_vorname" required>

            <label for="nachname">Nachname:</label>
            <input type="text" id="reg_nachname" name="reg_nachname" required>

            <label for="username">E-Mail Adresse:</label>
            <input type="text" id="reg_username" name="reg_username" required>

            <label for="password">Passwort:</label>
            <input type="password" id="reg_password1" name="reg_password1" required>

            <label>Passwort wiederholen:</label>
            <input type="password" id="reg_password2" name="reg_password2" required>

            <input type="submit" value="Anmelden" class="anmelden">
        </form>

        <?php
        // Fehlermeldung anzeigen, falls Login fehlgeschlagen ist
        if (!empty($errorMessage)) {
            echo '<div class="error-container">
                    <p class="error-message">' . htmlspecialchars($errorMessage) . '<p></div>';
        }
        ?>
    </div>

    
    </div>
</body>

<?php
require_once('../../includes/footer.php'); 
?>

</html>