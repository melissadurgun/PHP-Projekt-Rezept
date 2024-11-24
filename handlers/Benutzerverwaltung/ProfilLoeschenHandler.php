<?php

/**
 * Diese Klasse stellt Funktionen zum löschen eines ganzen Benutzerprofils inklusive erstellter Rezepte. 
 * Dabei wird auf Transaktionsprinzip zurückgegriffen, sodass entweder alle Daten gelöscht werden oder keine. 
 * 
 * Wird verwendet in Pages: ProfilLoeschenHandler.php
 */
session_start();
require_once('../../config/db.php');

class ProfilLoeschenHandler
{
    private $DB;

    //Aufbauen einer Datenbankverbindung 
    public function __construct()
    {
        $this->DB = new DB();
    }

    //Funktion um die Benutzerdaten zu löschen 
    public function deleteUserData($userId)
    {
        // Eingabe validieren
        $userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);

        // Beginne die Datenbanktransaktion
        $this->DB->beginTransaction();

        try {
            // Alle Rezepte des Benutzers löschen
            $this->deleteRezepte($userId);

            // Benutzer selbst löschen
            $query = $this->DB->prepare("DELETE FROM user WHERE user_id = :user_id");
            $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $query->execute();

            // Erfolgreiche Transaktion
            $this->DB->commit();

            // Session-Variablen leeren und Session zerstören
            $_SESSION = [];
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_destroy();
            }

            // Weiterleitung zur Startseite
            header("Location: ../../pages/public/Index.php");
            exit;

        } catch (Exception $e) {
            // Falls ein Fehler auftritt, rolle die Transaktion zurück
            $this->DB->rollBack();
            echo "Fehler beim Löschen des Profils: " . $e->getMessage();
        }
    }

    //Funktion zum Löschen der Rezepte des Nutzers 
    private function deleteRezepte($userId)
    {
        // Löschen aller Bewertungen und Zutaten zu den Rezepten des Benutzers
        $this->deleteBewertungen($userId);
        $this->deleteZutaten($userId);

        // Alle Rezepte des Benutzers löschen
        $query = $this->DB->prepare("DELETE FROM rezept WHERE user_id = :user_id");
        $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $query->execute();
    }

    //Funktion um die Bewertungen der Rezepte zu löschen 
    private function deleteBewertungen($userId)
    {
        $query = $this->DB->prepare("DELETE FROM bewertung WHERE rezept_id IN (SELECT rezept_id FROM rezept WHERE user_id = :user_id)");
        $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $query->execute();
    }

    //Funktion um die Zutaten der Rezepte zu löschen 
    private function deleteZutaten($userId)
    {
        $query = $this->DB->prepare("DELETE FROM zutaten WHERE rezept_id IN (SELECT rezept_id FROM rezept WHERE user_id = :user_id)");
        $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $query->execute();
    }
}

/// Wenn das Löschformular abgesendet wurde und der Benutzer eingeloggt ist
if (isset($_POST['confirm_delete']) && isset($_SESSION['user_id'])) {
    // Eingaben validieren
    $userId = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT);
    $handler = new ProfilLoeschenHandler();
    $handler->deleteUserData($userId);
} else {
    // Fehlermeldung für nicht eingeloggte Benutzer
    $errorMessage = 'Melde dich an, um deine Benutzerdaten zu löschen.';

    // Übergabe der Fehlermeldung per POST an Login.php 
    echo '<form id="redirectForm" method="POST" action="../../pages/Benutzerverwaltung/Login.php">
            <input type="hidden" name="error_message" value="' . htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') . '">
          </form>
          <script>
              document.getElementById("redirectForm").submit();
          </script>';
    exit;
}

?>