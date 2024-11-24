<?php
/**
 * Der Handler bietet eine Klasse, die Funktionen für das Löschen von Rezepten bereitstellt.
 * Wird bei Ausführung des 'Rezept löschen'-Buttons verwendet. 
 * 
 * Eine Überprüfung des Benutzers ist nicht nötig, da Löschen nur in der Benutzeransicht möglich/Löschen-Buttons werden nur 
 * angezeigt, wenn User eingeloggt und Besitzer eines Rezepts ist.  
 * Damit wird bereits sichergestellt, dass nur die vom Benutzer erstellten Rezepte gelöscht werden können. 
 *  */ 

require_once('../../config/db.php'); 

class RezeptLoeschenHandler {

    // Variablendeklaration
    private $DB;

     // Datenbankverbindung aufbauen
    public function __construct() {
        $this->DB = new DB(); 
    }

    //Löschen von allen Daten eines Rezepts
    public function executeLoescheRezept($rezeptid) {
        $this->loescheBewertungen($rezeptid); 
        $this->loescheZutaten($rezeptid); 
        $this->loescheRezept($rezeptid); 
    }

    // Löschen des Rezepts
    private function loescheRezept($rezeptID) {
        $queryRezept = $this->DB->prepare("DELETE FROM rezept WHERE rezept_id = :rezept_id");
        $queryRezept->execute([':rezept_id' => $rezeptID]);
    }

    // Löschen der zugehörigen Zutaten
    private function loescheZutaten($rezeptID) {
        $queryZutaten = $this->DB->prepare("DELETE FROM zutaten WHERE rezept_id = :rezept_id");
        $queryZutaten->execute([':rezept_id' => $rezeptID]);
    }

    // Löschen der Bewertungen
    private function loescheBewertungen($rezeptID) {
        $queryBewertungen = $this->DB->prepare("DELETE FROM bewertung WHERE rezept_id = :rezept_id");
        $queryBewertungen->execute([':rezept_id' => $rezeptID]);
    }
}

// Prüfen, ob eine Rezept-ID übergeben wurde und die Anfrage per GET kam
if (isset($_GET['delete_id'])) {
    $rezeptID = intval($_GET['delete_id']);
    
    // Lösch-Handler instanziieren und Löschfunktion aufrufen
    $handler = new RezeptLoeschenHandler();
    $handler->executeLoescheRezept($rezeptID);
    
    // Weiterleitung nach dem Löschen, um die Liste zu aktualisieren
    header("Location: ../../pages/Benutzerverwaltung/Benutzerseite.php");
    exit;
}
?>
