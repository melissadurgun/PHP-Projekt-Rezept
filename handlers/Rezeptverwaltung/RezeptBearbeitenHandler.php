<?php
/**
 * Der Handler bietet eine Klasse, die Funktionen für das Ändern von Rezepten bereitstellt.
 * Wird bei Ausführung des 'Rezept ändern'-Buttons verwendet. 
 * 
 * Eine Überprüfung des Benutzers ist nicht nötig, da Löschen nur in der Benutzeransicht möglich. 
 * Damit wird bereits sichergestellt, dass nur die vom Benutzer erstellten Rezepte gelöscht werden können.
 *  */

require_once('../../config/db.php');

class RezeptBearbeitenHandler
{

    // Variablendeklaration
    private $DB;

    public function __construct()
    {
        // Datenbankverbindung aufbauen
        $this->DB = new DB();
    }

    // //Zeigt das Formular, in welchem die Änderungen vorgenommen werden können. 

    // //Speichert die geänderten Daten in der Datenbank 
    // function speicherAenderungen($rezeptID)
    // {
    // }


    // Melissa:
    // Funktion, um zu überprüfen, ob der eingeloggte Benutzer der Besitzer des Rezepts ist
    public function isUserRecipeOwner($rezept_id, $user_id)
    {
        $query = "SELECT 1 FROM rezept WHERE rezept_id = :rezept_id AND user_id = :user_id";
        $stmt = $this->DB->prepare($query);
        $stmt->bindValue(':rezept_id', $rezept_id, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Check if a row exists
        $isOwner = $stmt->fetch() !== false;

        return $isOwner;
    }


    // Function to update the recipe
    public function updateRecipe($rezept_id, $title, $zubereitung, $zubereitungsdauer, $portionen, $ernaehrung, $schwierigkeitsgrad, $mahlzeitkategorie, $kueche, $bild_url, $zutaten)
    {
        // try {
        // Begin a transaction
        $this->DB->beginTransaction();

        // Update the main recipe details
        $query = "UPDATE rezept SET 
                    titel = :title, 
                    zubereitung = :zubereitung, 
                    zubereitungsdauer = :zubereitungsdauer, 
                    portionen = :portionen, 
                    ernaehrung = :ernaehrung, 
                    schwierigkeitsgrad = :schwierigkeitsgrad, 
                    mahlzeitkategorie = :mahlzeitkategorie, 
                    kueche = :kueche, 
                    bild_url = :bild_url 
                  WHERE rezept_id = :rezept_id";
        $stmt = $this->DB->prepare($query);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':zubereitung', $zubereitung);
        $stmt->bindValue(':zubereitungsdauer', $zubereitungsdauer, PDO::PARAM_INT);
        $stmt->bindValue(':portionen', $portionen, PDO::PARAM_INT);
        $stmt->bindValue(':ernaehrung', $ernaehrung);
        $stmt->bindValue(':schwierigkeitsgrad', $schwierigkeitsgrad);
        $stmt->bindValue(':mahlzeitkategorie', $mahlzeitkategorie);
        $stmt->bindValue(':kueche', $kueche);
        $stmt->bindValue(':bild_url', $bild_url);
        $stmt->bindValue(':rezept_id', $rezept_id, PDO::PARAM_INT);
        $stmt->execute();

        // Clear existing ingredients for this recipe
        $deleteQuery = "DELETE FROM zutaten WHERE rezept_id = :rezept_id";
        $deleteStmt = $this->DB->prepare($deleteQuery);
        $deleteStmt->bindValue(':rezept_id', $rezept_id, PDO::PARAM_INT);
        $deleteStmt->execute();

        // Insert each ingredient in the zutaten table
        $insertQuery = "INSERT INTO zutaten (rezept_id, name, menge, einheit) VALUES (:rezept_id, :name, :menge, :einheit)";
        $insertStmt = $this->DB->prepare($insertQuery);

        foreach ($zutaten as $ingredient) {
            $insertStmt->bindValue(':rezept_id', $rezept_id, PDO::PARAM_INT);
            $insertStmt->bindValue(':name', $ingredient['name']);
            $insertStmt->bindValue(':menge', $ingredient['menge']);
            $insertStmt->bindValue(':einheit', $ingredient['einheit']);
            $insertStmt->execute();
        }

        // Commit the transaction
        $this->DB->commit();

        return true;

        // }
        //  catch (Exception $e) {
        //     // Rollback the transaction if something failed
        //     $this->DB->rollBack();
        //     error_log("Failed to update recipe: " . $e->getMessage());
        //     return false;
        // }
    }

}