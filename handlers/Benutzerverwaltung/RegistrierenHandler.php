<?php
/**
 * Die Klasse RegistrierenHandler stellt die Funktion register bereit. 
 * Diese wird beim Registrieren von neuen Benutzern von der Seite Registrieren.php aufgerufen. 
 */

require_once('../../config/db.php');

class RegistrierenHandler
{
    private $DB;

    public function __construct()
    {
        // Sicherstellen, dass die Session gestartet ist
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

    // Benutzer mit den übergebenen Parametern registrieren
    public function register($vorname, $nachname, $username, $password1, $password2)
    {
        // Eingaben validieren
        $vorname = filter_var($vorname, FILTER_SANITIZE_STRING);
        $nachname = filter_var($nachname, FILTER_SANITIZE_STRING);
        $username = filter_var($username, FILTER_SANITIZE_STRING);

        // Überprüfen, ob die Passwörter übereinstimmen
        if ($password1 !== $password2) {
            return "Deine Passwörter stimmen nicht überein!";
        }

        // Überprüfen, ob der Benutzername bereits verwendet wird
        $usedNamesQuery = 'SELECT COUNT(*) FROM user WHERE username = :username';
        $checkUsedNames = $this->DB->prepare($usedNamesQuery);
        $checkUsedNames->bindParam(':username', $username, PDO::PARAM_STR);
        $checkUsedNames->execute();
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

        // Session-Variablen sicher setzen
        $_SESSION['user_id'] = $this->DB->lastInsertId();
        $_SESSION['user'] = htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); // Schutz vor XSS
        $_SESSION['vorname'] = htmlspecialchars($vorname, ENT_QUOTES, 'UTF-8');
        $_SESSION['nachname'] = htmlspecialchars($nachname, ENT_QUOTES, 'UTF-8');

        // Rückgabe eines leeren Fehlermeldungsstrings bei erfolgreicher Registrierung
        return "";
    }
}
