<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\assets\styles\styles.css">
    <title>Login</title>
</head>

<?php
include '../../includes/header.php';
include '../../includes/navigation.php';
?>
<body>
    <?php

    require_once('functionals.php'); 
    session_start();

    //Initialisierung 
    $DSN = 'mysql:host=db;dbname=Rezepte';

    //Datenbankverbindung aufbauen 
    try { 
        $DB = new Db($DSN, 'root', ''); 
    } catch (PDOException $e) { 
        exit('Connect failed: '.$e->getMessage()); 
    } 

    // User ausloggen wenn gefordert
    if (isset($_REQUEST['logout'])) {
        unset($_SESSION['user']);
    }

    // Benutzer ist noch nicht eingeloggt 
    if (empty($_SESSION['user'])) {

        $loginOk = false;
        
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            // Bereite die Abfrage vor, um sicher auf die Datenbank zuzugreifen
            $statement = $GLOBALS['DB']->prepare('SELECT user_id, username, vorname, nachname, password FROM user WHERE username = :username');
            $statement->execute(['username' => $_POST['username']]);
            $row = $statement->fetch();

            //Prüfe, ob Username und Password korrekt, dann setzen der Session-Variablen 
            if ($row && password_verify($_POST['password'], $row['password'])) {
                // Username und Passwort sind korrekt
                $_SESSION['user_id'] = $row['user_id']; 
                $_SESSION['user'] = $row['username'];
                $_SESSION['vorname'] = $row['vorname'];
                $_SESSION['nachname'] = $row['nachname'];
                $loginOk = true;
                
                //wenn eingeloggt, dann redirect to Benutzerseite 
                header('Location: benutzerseite.php');
                exit;

            } else {
                //setzen der Errormessage, falls Username & Password nicht stimmen 
                $errorMessage = 'Login fehlgeschlagen';
            }
        }

        // User ist noch nicht eingeloggt --> Zeige Login-Formular 
        if (!$loginOk) {
            echo '
            <div class="login-container">
            <h2>Anmelden</h2>
            <form action="' . $_SERVER['SCRIPT_NAME'] . '" method="post">
                <label>Benutzername (E-Mail Adresse):</label>
                <input type="text" name="username">
        
                <label>Passwort:</label>
                <input type="password" name="password">
        
                <input type="submit" value="Anmelden">
            </form>
            <p>Noch keinen Account? <a href="registrieren.php">Hier registrieren</a></p>
            </div>'; 

            //Zeigen der Errormessage (wenn Login Fehlgeschlagen)
            if (isset($errorMessage)) {
                echo '<div style="color:red;">' . htmlspecialchars($errorMessage) . '</div>';
            }

            //Members only 
            exit;
        } 

    }  else {

        // Wenn Benutzer bereits eingeloggt ist, leite zur Benutzerseite weiter 
        header('Location: benutzerseite.php');
        exit;
    }
    ?>


</body>
<?php
include '../../includes/footer.php';
?>
</html>