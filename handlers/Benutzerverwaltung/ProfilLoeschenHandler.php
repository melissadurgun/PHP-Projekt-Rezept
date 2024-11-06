<?php

/**
 * Diese Klasse stellt Funktionen zum löschen eines ganzen Benutzerprofils inklusive erstellter Rezepte. 
 * Dabei wird auf Transaktionsprinzip zurückgegriffen, sodass entweder alle Daten gelöscht werden oder keine. 
 */
session_start();
require_once('../../config/db.php');

class ProfilLoeschenHandler {
    private $DB;

    public function __construct() {
        $this->DB = new DB();
    }

    public function deleteUserData($userId) {
        // Beginne die Datenbanktransaktion
        $this->DB->beginTransaction();
        
        try {
            // Alle Rezepte des Benutzers löschen
            $this->deleteRezepte($userId);

            // Benutzer selbst löschen
            $query = $this->DB->prepare("DELETE FROM user WHERE user_id = :user_id");
            $query->execute([':user_id' => $userId]);

            // Erfolgreiche Transaktion
            $this->DB->commit();
            
            // Session-Variablen leeren und Session zerstören
            $_SESSION = [];
            session_destroy();

            // Weiterleitung zur Startseite
            header("Location: ../../pages/public/index.php");
            exit;

        } catch (Exception $e) {
            // Falls ein Fehler auftritt, rolle die Transaktion zurück
            $this->DB->rollBack();
            echo "Fehler beim Löschen des Profils: " . $e->getMessage();
        }
    }

    private function deleteRezepte($userId) {
        // Löschen aller Bewertungen und Zutaten zu den Rezepten des Benutzers
        $this->deleteBewertungen($userId);
        $this->deleteZutaten($userId);

        // Alle Rezepte des Benutzers löschen
        $query = $this->DB->prepare("DELETE FROM rezept WHERE user_id = :user_id");
        $query->execute([':user_id' => $userId]);
    }

    private function deleteBewertungen($userId) {
        $query = $this->DB->prepare("DELETE FROM bewertung WHERE rezept_id IN (SELECT rezept_id FROM rezept WHERE user_id = :user_id)");
        $query->execute([':user_id' => $userId]);
    }

    private function deleteZutaten($userId) {
        $query = $this->DB->prepare("DELETE FROM zutaten WHERE rezept_id IN (SELECT rezept_id FROM rezept WHERE user_id = :user_id)");
        $query->execute([':user_id' => $userId]);
    }
}

// Wenn das Löschformular abgesendet wurde und der Benutzer eingeloggt ist
if (isset($_POST['confirm_delete']) && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $handler = new ProfilLoeschenHandler();
    $handler->deleteUserData($userId);
} else {
    // Wenn kein gültiger Benutzer eingeloggt ist, Weiterleitung zur Login-Seite
    $_SESSION['errorMessage'] = 'Melde dich an, um deine Benutzerdaten zu löschen.';
    header("Location: Login.php");
    exit;
}
?>
