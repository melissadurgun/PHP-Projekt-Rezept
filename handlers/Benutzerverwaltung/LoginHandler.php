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
        $this->DB = new DB();
    }

    //Funktion loggt den Benutzer aus 
    public function logout()
    {
        session_unset();
        session_destroy();
    }

    //Funktion prüft, ob Benutzer eingeloggt ist
    public function isLoggedIn()
    {
        return isset($_SESSION['user']);
    }

    //Funktion führt den Login des Benutzers durch 
    public function login($username, $password)
    {
        // Abfrage des Benutzers in der Datenbank vorbereiten
        $statement = $this->DB->prepare('SELECT user_id, username, vorname, nachname, password FROM user WHERE username = :username');
        $statement->execute([':username' => $username]);
        $row = $statement->fetch();

        // Passwort überprüfen und Session-Variablen setzen, falls korrekt
        if ($row && password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user'] = $row['username'];
            $_SESSION['vorname'] = $row['vorname'];
            $_SESSION['nachname'] = $row['nachname'];
            return true;
        } else {
            return false;
        }
    }
}