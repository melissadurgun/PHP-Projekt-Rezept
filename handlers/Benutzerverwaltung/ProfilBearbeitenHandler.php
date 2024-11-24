<?php
require_once('../../config/db.php');

class ProfilBearbeitenHandler
{
    private $DB;

    public function __construct()
    {
        $this->DB = new DB();
    }

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

        $stmt = $this->DB->prepare($updateQuery);
        $stmt->execute($params);

        // Session-Variablen aktualisieren
        $_SESSION['user'] = $username;
        $_SESSION['vorname'] = $vorname;
        $_SESSION['nachname'] = $nachname;

        return ""; // Kein Fehler
    }
}