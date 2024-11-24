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
        // Eingaben validieren und mögliche Angriffe verhindern
        $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
        $vorname = filter_var($vorname, FILTER_SANITIZE_STRING);
        $nachname = filter_var($nachname, FILTER_SANITIZE_STRING);
        $username = filter_var($username, FILTER_SANITIZE_STRING);

        // Passwörter nur prüfen, wenn sie gesetzt wurden
        if ($password1 && $password1 !== $password2) {
            return "Die eingegebenen Passwörter stimmen nicht überein.";
        }

        // Prüfen, ob der Benutzername bereits vergeben ist (ohne den aktuellen Benutzer)
        $checkUsername = $this->DB->prepare("SELECT COUNT(*) FROM user WHERE username = :username AND user_id != :user_id");
        $checkUsername->bindParam(':username', $username, PDO::PARAM_STR);
        $checkUsername->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $checkUsername->execute();

        if ($checkUsername->fetchColumn() > 0) {
            return "Der Benutzername ist bereits vergeben. Bitte wählen Sie einen anderen.";
        }

        // SQL-Abfrage für das Update vorbereiten
        $updateQuery = "UPDATE user SET vorname = :vorname, nachname = :nachname, username = :username";
        $params = [
            ':vorname' => $vorname,
            ':nachname' => $nachname,
            ':username' => $username,
            ':user_id' => $user_id
        ];

        // Passwort nur dann aktualisieren, wenn ein neues Passwort gesetzt wurde
        if ($password1) {
            $updateQuery .= ", password = :password";
            $params[':password'] = password_hash($password1, PASSWORD_DEFAULT);
        }

        $updateQuery .= " WHERE user_id = :user_id";

        // Sicherstellen, dass das Statement sicher ausgeführt wird
        $stmt = $this->DB->prepare($updateQuery);
        $stmt->execute($params);

        // Session-Variablen aktualisieren (Eingaben escapen, um XSS zu verhindern)
        $_SESSION['user'] = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        $_SESSION['vorname'] = htmlspecialchars($vorname, ENT_QUOTES, 'UTF-8');
        $_SESSION['nachname'] = htmlspecialchars($nachname, ENT_QUOTES, 'UTF-8');

        return ""; // Kein Fehler
    }
}
