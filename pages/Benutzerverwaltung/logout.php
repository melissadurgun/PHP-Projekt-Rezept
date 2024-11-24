<!-- Seite wird aufgerufen, wenn der Benutzer auf Logout klickt. 
 Sorgt dafür, dass die aktuelle Session zerstört wird und Benutzer somit abgemeldet ist. -->


<?php
session_start();
require_once('../../handlers/Benutzerverwaltung/LoginHandler.php');

// Instanz von LoginHandler erstellen 
$loginHandler = new LoginHandler();
//aufrufen der Funktion Logout und damit Ausloggen des Benutzers 
$loginHandler->logout();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <title>Logout</title>
</head>
<?php
require_once('../../includes/header.php');
require_once('../../includes/navigation.php');
?>

<body>
    <div class="logout">
        <h2>Du willst uns schon verlassen?</h2>
        <div class="logout-buttons">
            <a href="Login.php">Melde dich hier erneut an!</a>
            <a href="../../pages/public/index.php">Zurück zur Startseite</a>
        </div>
    </div>
</body>
<?php
require_once('../../includes/footer.php');
?>

</html>