<?php
/**
 * Die Klasse RegistrierenHandler stellt die Funktion register bereit. 
 * Diese wird beim Registrieren von neuen Benutzern von der page Registrieren.php aufgerufen. 
 */

require_once('../../config/db.php');

class RegistrierenHandler {
    private $DB;

    public function __construct() {
        $this->DB = new DB();
    }

    //Registriere den Benutzer mit den übergebenen Parametern 
    public function register($vorname, $nachname, $username, $password1, $password2) {
        
        // Überprüfen, ob die Passwörter übereinstimmen
        if ($password1 !== $password2) {
            return "Deine Passwörter stimmen nicht überein!";
        }

        // Benutzername in der Datenbank prüfen
        $usedNames = 'SELECT COUNT(*) FROM user WHERE username = :username';
        $checkUsedNames = $this->DB->prepare($usedNames);
        $checkUsedNames->execute([':username' => $username]);
        $userExists = $checkUsedNames->fetchColumn();

        if ($userExists > 0) {
            return "Bitte wähle einen anderen Benutzernamen!";
        }

        // Benutzername ist verfügbar, Passwort hashen und Benutzer registrieren
        $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);
        $insertQuery = 'INSERT INTO user (vorname, nachname, username, password) VALUES (:vorname, :nachname, :username, :password)';
        $stmt = $this->DB->prepare($insertQuery);

        // Datenbankeintrag ausführen
        $stmt->execute([
            ':vorname' => $vorname,
            ':nachname' => $nachname,
            ':username' => $username,
            ':password' => $hashedPassword
        ]);

        // Session-Variablen setzen für den neu erstellten Benutzer
        $_SESSION['user_id'] = $this->DB->lastInsertId();
        $_SESSION['user'] = $username;
        $_SESSION['vorname'] = $vorname;
        $_SESSION['nachname'] = $nachname;

        // Rückgabe eines leeren Fehlermeldungsstrings bei erfolgreicher Registrierung
        return "";
    }
}
