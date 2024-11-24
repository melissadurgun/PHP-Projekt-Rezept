<?php

/** 
 * Die Klasse RezeptDetailHandler stellt eine Funktion bereit, um die Daten eines Rezepts vollständig auszulesen
 * entsprechend zurückzugeben. 
 * 
 * Wird verwendet in Pages: RezeptDetailansicht.php.
 */
require_once('../../config/db.php');

class RezeptDetailHandler
{
    //Variablendeklaration 
    private $db;

    //Datenbankverbindung aufbauen 
    public function __construct()
    {
        $this->db = new DB();
    }

    //Ausgeben aller Daten eines Rezepts 
    public function getRecipeDetail($rezept_id)
    {
        // Eingabe validieren
        $rezept_id = filter_var($rezept_id, FILTER_VALIDATE_INT);
        if ($rezept_id === false) {
            die("Ungültige Rezept-ID."); // Alternativ: Rückgabe einer Fehlermeldung
        }

        // Rezeptdetails abrufen, einschließlich Benutzername
        $query = "SELECT r.*, u.username FROM rezept r
                  JOIN user u ON r.user_id = u.user_id
                  WHERE r.rezept_id = :rezept_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':rezept_id', $rezept_id, PDO::PARAM_INT);
        $stmt->execute();
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$recipe) {
            die("Rezept nicht gefunden."); // Alternativ: Rückgabe einer Fehlermeldung
        }

        // BLOB-Bild in Base64-String konvertieren, falls vorhanden
        if (!empty($recipe['bild'])) {
            $recipe['bild'] = 'data:image/jpeg;base64,' . base64_encode($recipe['bild']);
        } else {
            $recipe['bild'] = null; // Kein Bild vorhanden
        }

        // Zutaten abrufen
        $queryIngredients = "SELECT name, menge, einheit FROM zutaten WHERE rezept_id = :rezept_id";
        $stmtIngredients = $this->db->prepare($queryIngredients);
        $stmtIngredients->bindParam(':rezept_id', $rezept_id, PDO::PARAM_INT);
        $stmtIngredients->execute();
        $ingredients = $stmtIngredients->fetchAll(PDO::FETCH_ASSOC);

        // Daten für die Ansicht vorbereiten
        return [
            'recipe' => $recipe,
            'ingredients' => $ingredients
        ];
    }
}
