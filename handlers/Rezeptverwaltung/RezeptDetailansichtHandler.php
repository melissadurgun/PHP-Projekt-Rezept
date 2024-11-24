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
        // Abfrage an Datenbank schicken 
        $query = "SELECT r.*, u.username FROM rezept r
                  JOIN user u ON r.user_id = u.user_id
                  WHERE r.rezept_id = :rezept_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':rezept_id' => $rezept_id]);
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$recipe) {
            return "Rezept nicht gefunden.";
        }

        // BLOB Image konvertieren 
        if ($recipe['bild']) {
            $recipe['bild'] = 'data:image/jpeg;base64,' . base64_encode($recipe['bild']);
        } else {
            $recipe['bild'] = null; // Kein Bild vorhanden
        }

        // Zutaten eines Rezepts aus der Tabelle 'zutaten' auslesen 
        $queryIngredients = "SELECT * FROM zutaten WHERE rezept_id = :rezept_id";
        $stmtIngredients = $this->db->prepare($queryIngredients);
        $stmtIngredients->execute([':rezept_id' => $rezept_id]);
        $ingredients = $stmtIngredients->fetchAll(PDO::FETCH_ASSOC);

        // Rezeptdaten zurückgeben
        return [
            'recipe' => $recipe,
            'ingredients' => $ingredients
        ];
    }
}
