<?php
/**
 * Die Klasse LoginHandler stellt Funktionen bereit, die im Zusammenhang mit dem Ein- und Ausloggen der Benutzer
 * benötigt werden. 
 * 
 * Wird verwendet in den Pages: Login.php & Logout.php 
 * 
 */

require_once('../../config/db.php');

class LoginHandler
{
    private $DB;

    //Konstruktor etabliert Datenbankverbindung 
    public function __construct()
    {
        // Sicherstellen, dass die Session nur einmal gestartet wird
        if (session_status() === PHP_SESSION_NONE) {
            session_start([
                'cookie_lifetime' => 0, // Session läuft beim Schließen des Browsers ab
                'cookie_secure' => isset($_SERVER['HTTPS']), // Nur über HTTPS
                'cookie_httponly' => true, // Verhindert JavaScript-Zugriff
                'cookie_samesite' => 'Strict' // Schutz vor CSRF
            ]);
        }
        $this->DB = new DB();
    }

    //Funktion loggt den Benutzer aus 
    public function logout()
    {
        // Session-Daten löschen und die Session sicher beenden
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }

    //Funktion prüft, ob Benutzer eingeloggt ist
    public function isLoggedIn()
    {
        return isset($_SESSION['user']);
    }

    //Funktion führt den Login des Benutzers durch 
    public function login($username, $password)
    {
        // Benutzername validieren
        $username = filter_var($username, FILTER_SANITIZE_STRING);

        // Abfrage des Benutzers in der Datenbank vorbereiten
        $statement = $this->DB->prepare('SELECT user_id, username, vorname, nachname, password FROM user WHERE username = :username');
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // Passwort überprüfen und Session-Variablen setzen, falls korrekt
        if ($row && password_verify($password, $row['password'])) {
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_regenerate_id(true); // Session-ID nach erfolgreichem Login regenerieren
            }
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user'] = htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); // Schutz vor XSS
            $_SESSION['vorname'] = htmlspecialchars($row['vorname'], ENT_QUOTES, 'UTF-8');
            $_SESSION['nachname'] = htmlspecialchars($row['nachname'], ENT_QUOTES, 'UTF-8');
            return true;
        } else {
            return false;
        }
    }
}