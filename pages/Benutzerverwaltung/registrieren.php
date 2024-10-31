<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\assets\styles\styles.css">
    <title>Registrieren</title>
</head>

<?php
include '../../includes/header.php';
include '../../includes/navigation.php';
?>

<body>
    <?php
    require_once('functionals.php'); 
    session_start();

    // Inizialisierung 
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

        $registerOk = false; 

        // Prüfen, ob Felder ausgefüllt und Benutzername noch nicht in der DB ist
        if (!empty($_REQUEST['reg_vorname']) && 
            !empty($_REQUEST['reg_nachname']) && 
            !empty($_REQUEST['reg_username']) && 
            !empty($_REQUEST['reg_password1']) && 
            !empty($_REQUEST['reg_password2'])) {

            // Übergabedaten an Variablen übergeben
            $vn = $_REQUEST['reg_vorname']; 
            $nn = $_REQUEST['reg_nachname']; 
            $un = $_REQUEST['reg_username']; 
            $p1 = $_REQUEST['reg_password1']; 
            $p2 = $_REQUEST['reg_password2'];

            // Prüfen, ob die eingegebenen Passwörter übereinstimmen
            if ($p1 === $p2) {

                // Check, ob Benutzername bereits vorhanden ist
                $usedNames = 'SELECT COUNT(*) FROM user WHERE username = :username'; 
                $checkUsedNames = $GLOBALS['DB']->prepare($usedNames);
                $checkUsedNames->execute(['username' => $un]);
                $userExists = $checkUsedNames->fetchColumn();

                // Wenn Benutzername noch nicht enthalten ist, Daten in die Datenbank einfügen
                if ($userExists == 0) {

                    // Passwort hashen
                    $hashedPassword = password_hash($p1, PASSWORD_DEFAULT);

                    // Daten einfügen
                    $insertQuery = 'INSERT INTO user (vorname, nachname, username, password) VALUES (:vorname, :nachname, :username, :password)'; 
                    $stmt = $DB->prepare($insertQuery);
                    $stmt->execute([
                        ':vorname'  => $vn,
                        ':nachname' => $nn,
                        ':username' => $un,
                        ':password' => $hashedPassword
                        
                    ]);

                    //Userid zwischenspeichern 
                    $uid = $DB->lastInsertId();

                    // Benutzer in der Session speichern
                    $_SESSION['user_id'] = $uid; 
                    $_SESSION['user'] = $un;
                    $_SESSION['vorname'] = $vn;
                    $_SESSION['nachname'] = $nn;
                    $registerOk = true; 

                    // Weiterleitung auf die Benutzerseite
                    header('Location: benutzerseite.php');
                    exit();  

                } else {
                    $errorMessage = 'Bitte wähle einen anderen Benutzernamen!'; 
                }

            } else {
                $errorMessage = 'Deine Passwörter stimmen nicht überein!'; 
            }
        }


        //solange nicht eingeloggt und auch noch nicht registriert --> zeige Registrierformular 
        if (! $registerOk){

            echo '
            <div class="login-container">
                <h2>Neu hier?</h2>
                <p>Registrieren Sie sich!</p><br>

                <form action="' . $_SERVER['SCRIPT_NAME'] . '" method="post">

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

                <input type="submit" value="Anmelden">
                </form>

                <p>Schon angemeldet? <a href="login.php">Dann klicke hier.</a></p>
            </div> '; 
            
            //Zeigen der Errormessage, wenn vorhanden 
            if (isset($errorMessage)) {
                echo '<div style="color:red;">' . htmlspecialchars($errorMessage) . '</div>';
            }

            //Members only!
            exit; 
        }

        
    } else {
        //Wenn Benutzer bereits eingeloggt, leite weiter zur Benutzerseite 
        header('Location: benutzerseite.php');
        exit;
    }

    ?>

    
</body>
<?php
include '../includes/footer.php';
?>
</html>