<?php
require_once('../../config/db.php');

class LoginHandler
{
    private $DB;

    public function __construct()
    {
        $this->DB = new DB();
    }

    public function logout()
    {

        session_unset();
        session_destroy();
    }

    public function isLoggedIn()
    {
        // Prüfen, ob der Benutzer eingeloggt ist
        return isset($_SESSION['user']);
    }

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