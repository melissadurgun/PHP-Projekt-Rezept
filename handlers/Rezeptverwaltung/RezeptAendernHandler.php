<?php
/**
 * Der Handler bietet eine Klasse, die Funktionen für das Ändern von Rezepten bereitstellt.
 * Wird bei Ausführung des 'Rezept ändern'-Buttons verwendet. 
 * 
 * Eine Überprüfung des Benutzers ist nicht nötig, da Löschen nur in der Benutzeransicht möglich. 
 * Damit wird bereits sichergestellt, dass nur die vom Benutzer erstellten Rezepte gelöscht werden können.
 *  */ 
 
require_once('../../config/db.php'); 

class RezeptAendernHandler {

    // Variablendeklaration
    private $DB;

    public function __construct() {
        // Datenbankverbindung aufbauen
        $this->DB = new DB(); 
    }

    //Zeigt das Formular, in welchem die Änderungen vorgenommen werden können. 

    //Speichert die geänderten Daten in der Datenbank 
    function speicherAenderungen(){$rezeptID}

} 