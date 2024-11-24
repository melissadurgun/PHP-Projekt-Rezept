<?php
/**
 * Der Handler bietet eine Klasse, die Funktionen für das Löschen von Rezepten bereitstellt.
 * Wird bei Ausführung des 'Rezept löschen'-Buttons verwendet. 
 * 
 * Eine Überprüfung des Benutzers ist nicht nötig, da Löschen nur in der Benutzeransicht möglich ist. 
 * Damit wird bereits sichergestellt, dass nur die vom Benutzer erstellten Rezepte gelöscht werden können. 
 */

require_once('../../config/db.php');

class RezeptLoeschenHandler
{

    // Variablendeklaration
    private $DB;

    public function __construct()
    {
        // Datenbankverbindung aufbauen
        $this->DB = new DB();
    }

    public function executeLoescheRezept($rezeptID)
    {
        // Eingabe validieren
        $rezeptID = filter_var($rezeptID, FILTER_VALIDATE_INT);
        if ($rezeptID === false) {
            throw new Exception("Ungültige Rezept-ID.");
        }

        try {
            // Beginne eine Transaktion
            $this->DB->beginTransaction();

            // Löschen der Bewertungen, Zutaten und des Rezepts
            $this->loescheBewertungen($rezeptID);
            $this->loescheZutaten($rezeptID);
            $this->loescheRezept($rezeptID);

            // Transaktion abschließen
            $this->DB->commit();
        } catch (Exception $e) {
            // Rollback bei Fehlern
            $this->DB->rollBack();
            error_log("Fehler beim Löschen des Rezepts: " . $e->getMessage());
            throw $e;
        }
    }

    // Löschen des Rezepts
    private function loescheRezept($rezeptID)
    {
        $queryRezept = $this->DB->prepare("DELETE FROM rezept WHERE rezept_id = :rezept_id");
        $queryRezept->bindValue(':rezept_id', $rezeptID, PDO::PARAM_INT);
        $queryRezept->execute();
    }

    // Löschen der zugehörigen Zutaten
    private function loescheZutaten($rezeptID)
    {
        $queryZutaten = $this->DB->prepare("DELETE FROM zutaten WHERE rezept_id = :rezept_id");
        $queryZutaten->bindValue(':rezept_id', $rezeptID, PDO::PARAM_INT);
        $queryZutaten->execute();
    }

    // Löschen der Bewertungen
    private function loescheBewertungen($rezeptID)
    {
        $queryBewertungen = $this->DB->prepare("DELETE FROM bewertung WHERE rezept_id = :rezept_id");
        $queryBewertungen->bindValue(':rezept_id', $rezeptID, PDO::PARAM_INT);
        $queryBewertungen->execute();
    }
}

// Prüfen, ob eine Rezept-ID übergeben wurde und die Anfrage per GET kam
if (isset($_GET['delete_id'])) {
    try {
        // Rezept-ID validieren
        $rezeptID = filter_var($_GET['delete_id'], FILTER_VALIDATE_INT);
        if ($rezeptID === false) {
            throw new Exception("Ungültige Rezept-ID.");
        }

        // Lösch-Handler instanziieren und Löschfunktion aufrufen
        $handler = new RezeptLoeschenHandler();
        $handler->executeLoescheRezept($rezeptID);

        // Weiterleitung nach dem Löschen, um die Liste zu aktualisieren
        header("Location: ../../pages/Benutzerverwaltung/Benutzerseite.php");
        exit;
    } catch (Exception $e) {
        error_log("Fehler beim Löschen des Rezepts: " . $e->getMessage());
        header("Location: ../../pages/Benutzerverwaltung/Benutzerseite.php?error=RezeptLoeschen");
        exit;
    }
}
?>