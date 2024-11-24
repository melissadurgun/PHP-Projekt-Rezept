<?php
require_once('../../config/db.php');

class LoginHandler
{
    private $DB;

    public function __construct()
    {
        $this->sichereSession(); // Sichere Session-Einstellungen implementieren
        $this->DB = new DB();
    }

    private function sichereSession()
    {
        // Sichere Session-Cookie-Einstellungen
        session_set_cookie_params([
            'lifetime' => 0, // Session endet, wenn der Browser geschlossen wird
            'path' => '/',
            'domain' => $_SERVER['HTTP_HOST'], // Domain dynamisch setzen
            'secure' => true, // Nur über HTTPS zulassen
            'httponly' => true, // JavaScript-Zugriff verhindern
            'samesite' => 'Strict' // Cross-Site-Request-Forgery (CSRF) verhindern
        ]);
        session_start();

        // Verhindern von Session-Hijacking durch Prüfung von IP-Adresse und User-Agent
        if (!isset($_SESSION['ip_address'])) {
            $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
        }
        if (!isset($_SESSION['user_agent'])) {
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        }
        if ($_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR'] || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
            session_unset();
            session_destroy();
            session_start();
        }
    }

    public function logout()
    {
        // Session-Daten löschen und beenden
        session_unset();
        session_destroy();
        // Session-ID regenerieren, um Fixierungsangriffe zu verhindern
        session_regenerate_id(true);
    }

    public function isLoggedIn()
    {
        // Prüfen, ob der Benutzer eingeloggt ist und die Session sicher ist
        return isset($_SESSION['user']) && $_SESSION['ip_address'] === $_SERVER['REMOTE_ADDR'];
    }

    public function login($username, $password)
    {
        // Eingabe des Benutzernamens validieren
        $username = filter_var($username, FILTER_SANITIZE_STRING);

        // Abfrage des Benutzers in der Datenbank vorbereiten
        $statement = $this->DB->prepare('SELECT user_id, username, vorname, nachname, password FROM user WHERE username = :username');
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // Passwort überprüfen und Session-Variablen setzen, falls korrekt
        if ($row && password_verify($password, $row['password'])) {
            // Session-ID regenerieren, um Fixierungsangriffe zu verhindern
            session_regenerate_id(true);
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user'] = htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8');
            $_SESSION['vorname'] = htmlspecialchars($row['vorname'], ENT_QUOTES, 'UTF-8');
            $_SESSION['nachname'] = htmlspecialchars($row['nachname'], ENT_QUOTES, 'UTF-8');
            return true;
        } else {
            return false;
        }
    }
}
