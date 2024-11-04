<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\assets\styles\styles.css">  
    <title>Document</title>
</head>

<?php
include '../../includes/header.php';
include '../../includes/navigation.php';
?>

<body>

<?php
    
    session_start();

    //Datenbankverbindung aufbauen
    require_once('../../config/db.php'); 
    $DB = new DB(); 
    
     // User ausloggen wenn gefordert
    if (isset($_REQUEST['logout'])) {
        unset($_SESSION['user']);
    }

    // Prüfen, ob Benutzer eingeloggt 
    if (!empty($_SESSION['user'])) {

        $datenchanged = false; 

        // Prüfen, ob mindestens ein Feld ausgefüllt ist
        if (!empty($_REQUEST['new_vorname']) || 
            !empty($_REQUEST['new_nachname']) || 
            !empty($_REQUEST['new_username']) || 
            !empty($_REQUEST['new_password1']) && !empty($_REQUEST['new_password2'])) {

            // Vorname, Nachname, Username und Passwort aus den Request-Daten holen
            $vn = !empty($_REQUEST['new_vorname']) ? $_REQUEST['new_vorname'] : $_SESSION['vorname'];
            $nn = !empty($_REQUEST['new_nachname']) ? $_REQUEST['new_nachname'] : $_SESSION['nachname'];
            $un = !empty($_REQUEST['new_username']) ? $_REQUEST['new_username'] : $_SESSION['user'];

            // Wenn das Passwort geändert werden soll, die Passwörter vergleichen
            if (!empty($_REQUEST['new_password1']) && $_REQUEST['new_password1'] === $_REQUEST['new_password2']) {
                $hashedPassword = password_hash($_REQUEST['new_password1'], PASSWORD_DEFAULT);
            } else {
                $hashedPassword = null;
            }

            // Prüfen, ob Benutzername schon existiert und nicht dem aktuellen Benutzer gehört
            $usedNames = 'SELECT COUNT(*) FROM user WHERE username = :username AND user_id != :u_id';
            $checkUsedNames = $DB->prepare($usedNames);
            $checkUsedNames->execute([
                'username' => $un,
                'u_id' => $_SESSION['user_id']
            ]);
            $userExists = $checkUsedNames->fetchColumn();

            // Update-Query vorbereiten
            if ($userExists == 0) {
                $updateFields = [
                    'vorname' => $vn,
                    'nachname' => $nn,
                    'username' => $un,
                ];

                if ($hashedPassword !== null) {
                    $updateFields['password'] = $hashedPassword;
                }

                // Dynamisch SQL-Update erstellen
                $updateQuery = 'UPDATE user SET ';
                $updateParts = [];
                foreach ($updateFields as $field => $value) {
                    $updateParts[] = "$field = :$field";
                }
                $updateQuery .= implode(', ', $updateParts);
                $updateQuery .= ' WHERE user_id = :us_id';

                // Query ausführen
                $stmt = $DB->prepare($updateQuery);
                $updateFields['us_id'] = $_SESSION['user_id'];
                $stmt->execute($updateFields);

                // Session-Daten aktualisieren
                $_SESSION['user'] = $un;
                $_SESSION['vorname'] = $vn;
                $_SESSION['nachname'] = $nn;
                $datenChanged = true;

                // Weiterleitung auf die Benutzerseite
                header('Location: benutzerseite.php');
                exit();
            } else {
                $errorMessage = 'Bitte wähle einen anderen Benutzernamen!';
            }
        }

        



        //Formular anzeigen, um Daten zu ändern 
        if (! $datenchanged){

         echo '
            <div class="login-container">
                <h2>Benutzerdaten ändern: </h2><br>

                <form action="' . $_SERVER['SCRIPT_NAME'] . '" method="post">

                <label for="vorname">Vorname:</label>
                <input type="text" id="new_vorname" name="new_vorname" value="'. $_SESSION['vorname'].'" required>

                <label for="nachname">Nachname:</label>
                <input type="text" id="new_nachname" name="new_nachname" value="'. $_SESSION['nachname'].'"required>

                <label for="username">Username/E-Mail Adresse:</label>
                <input type="text" id="new_username" name="new_username" value="'. $_SESSION['user'].'" required>

                <h2> </h2> <br>
                <h2>Passwort ändern: </h2><br>

                <label for="password">Neues Passwort:</label>
                <input type="password" id="new_password1" name="new_password1"> 

                <label>Neues Passwort wiederholen:</label>
                <input type="password" id="new_password2" name="new_password2">

                <input type="submit" value="Speichern">
                </form>
                <a href="login.php">Zurück zur Benutzerseite..</a>
            </div>'; 

            //Zeigen der Errormessage, wenn vorhanden 
            if (isset($errorMessage)) {
              echo '<div style="color:red;">' . htmlspecialchars($errorMessage) . '</div>';
             }

            //Members only!
            exit;    
        }
        


    } else {
        //Benutzer ist noch nicht eingeloggt --> redirect zu Login
        $errorMessage = 'Melde dich an, um deine Daten zu bearbeiten.'; //TODO globale Variable ErrorMessage 
        header('Location: login.php');
        exit;
    }   
?>
    
</body>
<?php
include '../../includes/footer.php';
?>
</html>