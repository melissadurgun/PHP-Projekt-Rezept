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
        // Sicherstellen, dass die Session nur einmal gestartet wird
        if (session_status() === PHP_SESSION_NONE) {
            session_start([
                'cookie_lifetime' => 0, // Session endet beim Schließen des Browsers
                'cookie_secure' => isset($_SERVER['HTTPS']), // Nur HTTPS
                'cookie_httponly' => true, // Kein Zugriff über JavaScript
                'cookie_samesite' => 'Strict' // Schutz vor CSRF
            ]);
        }
        $this->DB = new DB();
    }

    //Funktion, die die Daten des Nutzers ändert 
    public function updateProfile($user_id, $vorname, $nachname, $username, $password1 = null, $password2 = null)
    {
        // Eingaben validieren
        $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
        $vorname = filter_var($vorname, FILTER_SANITIZE_STRING);
        $nachname = filter_var($nachname, FILTER_SANITIZE_STRING);
        $username = filter_var($username, FILTER_SANITIZE_STRING);

        // Wenn beide Passwörter vorhanden sind, prüfen, ob sie übereinstimmen
        if ($password1 && $password1 !== $password2) {
            return "Die eingegebenen Passwörter stimmen nicht überein.";
        }

        // Überprüfen, ob der Benutzername bereits vergeben ist und nicht der aktuelle Benutzer ist
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

        // Passwort nur dann hinzufügen, wenn ein neues Passwort gesetzt wurde
        if ($password1) {
            $updateQuery .= ", password = :password";
            $params[':password'] = password_hash($password1, PASSWORD_DEFAULT);
        }

        $updateQuery .= " WHERE user_id = :user_id";

        // Sicheres Ausführen der Abfrage
        $stmt = $this->DB->prepare($updateQuery);
        $stmt->execute($params);

        // Session-Variablen sicher aktualisieren
        $_SESSION['user'] = htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); // Schutz vor XSS
        $_SESSION['vorname'] = htmlspecialchars($vorname, ENT_QUOTES, 'UTF-8');
        $_SESSION['nachname'] = htmlspecialchars($nachname, ENT_QUOTES, 'UTF-8');

        return ""; // Kein Fehler
    }
}