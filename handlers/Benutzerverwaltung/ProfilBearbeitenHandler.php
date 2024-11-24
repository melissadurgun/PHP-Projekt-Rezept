<?php

/**
 * Die Klasse ProfilBearbeitenHandler stellt Funktionen bereit, die genutzt werden, um die Daten des Nutzers wie
 * Name oder Passwort zu verändern. 
 * 
 * Wird verwendet in Pages: ProfilBearbeiten.php. 
 */
require_once('../../config/db.php');

class ProfilBearbeitenHandler
{
    private $DB;

    //Datenbankverbindung im Konstruktor aufbauen 
    public function __construct()
    {
        $this->DB = new DB();
    }

    //Funktion, die die Daten des Nutzers ändert 
    public function updateProfile($user_id, $vorname, $nachname, $username, $password1 = null, $password2 = null)
    {
        // Wenn beide Passwörter vorhanden sind, prüfen, ob sie übereinstimmen
        if ($password1 && $password1 !== $password2) {
            return "Die eingegebenen Passwörter stimmen nicht überein.";
        }

        // Überprüfen, ob der Benutzername bereits vergeben ist und nicht der aktuelle Benutzer ist
        $checkUsername = $this->DB->prepare("SELECT COUNT(*) FROM user WHERE username = :username AND user_id != :user_id");
        $checkUsername->execute([':username' => $username, ':user_id' => $user_id]);
        if ($checkUsername->fetchColumn() > 0) {
            return "Der Benutzername ist bereits vergeben. Bitte wählen Sie einen anderen.";
        }

        // SQL-Abfrage für das Update ohne Passwort
        $updateQuery = "UPDATE user SET vorname = :vorname, nachname = :nachname, username = :username";

        // Passwort nur dann hinzufügen, wenn es geändert wurde
        $params = [':vorname' => $vorname, ':nachname' => $nachname, ':username' => $username, ':user_id' => $user_id];
        if ($password1) {
            $updateQuery .= ", password = :password";
            $params[':password'] = password_hash($password1, PASSWORD_DEFAULT);
        }

        $updateQuery .= " WHERE user_id = :user_id";

        //Ausführen der Änderungen in der Datenbank 
        $stmt = $this->DB->prepare($updateQuery);
        $stmt->execute($params);

        // Session-Variablen aktualisieren
        $_SESSION['user'] = $username;
        $_SESSION['vorname'] = $vorname;
        $_SESSION['nachname'] = $nachname;

        return ""; // Kein Fehler
    }
}