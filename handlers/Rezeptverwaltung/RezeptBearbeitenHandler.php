<?php
/**
 * Der Handler bietet eine Klasse, die Funktionen für das Ändern von Rezepten bereitstellt.
 * Wird bei Ausführung des 'Rezept ändern'-Buttons verwendet. 
 * 
 * Eine Überprüfung des Benutzers ist nicht nötig, da Änderungen nur in der Benutzeransicht möglich sind. 
 * Damit wird bereits sichergestellt, dass nur die vom Benutzer erstellten Rezepte geändert werden können.
 */

require_once('../../config/db.php');

class RezeptBearbeitenHandler
{
    private $DB;

    public function __construct()
    {
        // Datenbankverbindung aufbauen
        $this->DB = new DB();
    }

    /**
     * Funktion, um zu überprüfen, ob der eingeloggte Benutzer der Besitzer des Rezepts ist
     */
    public function isUserRecipeOwner($rezept_id, $user_id)
    {
        // Eingaben validieren
        $rezept_id = filter_var($rezept_id, FILTER_VALIDATE_INT);
        $user_id = filter_var($user_id, FILTER_VALIDATE_INT);
        if ($rezept_id === false || $user_id === false) {
            return false;
        }

        $query = "SELECT 1 FROM rezept WHERE rezept_id = :rezept_id AND user_id = :user_id";
        $stmt = $this->DB->prepare($query);
        $stmt->bindValue(':rezept_id', $rezept_id, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Überprüfen, ob eine Zeile existiert
        return $stmt->fetch() !== false;
    }

    /**
     * Funktion, um ein Rezept zu aktualisieren
     */
    public function updateRecipe($rezept_id, $title, $zubereitung, $zubereitungsdauer, $portionen, $ernaehrung, $schwierigkeitsgrad, $mahlzeitkategorie, $kueche, $zutaten)
    {
        try {
            // Eingaben validieren
            $rezept_id = filter_var($rezept_id, FILTER_VALIDATE_INT);
            $zubereitungsdauer = filter_var($zubereitungsdauer, FILTER_VALIDATE_INT);
            $portionen = filter_var($portionen, FILTER_VALIDATE_INT);

            if ($rezept_id === false || $zubereitungsdauer === false || $portionen === false) {
                throw new Exception("Ungültige Eingaben für Rezeptdetails.");
            }

            $title = htmlspecialchars(trim($title), ENT_QUOTES, 'UTF-8');
            $zubereitung = htmlspecialchars(trim($zubereitung), ENT_QUOTES, 'UTF-8');
            $ernaehrung = htmlspecialchars(trim($ernaehrung), ENT_QUOTES, 'UTF-8');
            $schwierigkeitsgrad = htmlspecialchars(trim($schwierigkeitsgrad), ENT_QUOTES, 'UTF-8');
            $mahlzeitkategorie = htmlspecialchars(trim($mahlzeitkategorie), ENT_QUOTES, 'UTF-8');
            $kueche = htmlspecialchars(trim($kueche), ENT_QUOTES, 'UTF-8');

            foreach ($zutaten as &$ingredient) {
                $ingredient['name'] = htmlspecialchars(trim($ingredient['name']), ENT_QUOTES, 'UTF-8');
                $ingredient['menge'] = filter_var($ingredient['menge'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $ingredient['einheit'] = htmlspecialchars(trim($ingredient['einheit']), ENT_QUOTES, 'UTF-8');
            }

            // Beginne eine Transaktion
            $this->DB->beginTransaction();

            // Aktualisiere die Hauptdetails des Rezepts
            $query = "UPDATE rezept SET 
                        titel = :title, 
                        zubereitung = :zubereitung, 
                        zubereitungsdauer = :zubereitungsdauer, 
                        portionen = :portionen, 
                        ernaehrung = :ernaehrung, 
                        schwierigkeitsgrad = :schwierigkeitsgrad, 
                        mahlzeitkategorie = :mahlzeitkategorie, 
                        kueche = :kueche
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
            $stmt->bindValue(':rezept_id', $rezept_id, PDO::PARAM_INT);
            $stmt->execute();

            // Lösche bestehende Zutaten für dieses Rezept
            $deleteQuery = "DELETE FROM zutaten WHERE rezept_id = :rezept_id";
            $deleteStmt = $this->DB->prepare($deleteQuery);
            $deleteStmt->bindValue(':rezept_id', $rezept_id, PDO::PARAM_INT);
            $deleteStmt->execute();

            // Füge jede Zutat erneut in die Tabelle "zutaten" ein
            $insertQuery = "INSERT INTO zutaten (rezept_id, name, menge, einheit) VALUES (:rezept_id, :name, :menge, :einheit)";
            $insertStmt = $this->DB->prepare($insertQuery);

            foreach ($zutaten as $ingredient) {
                $insertStmt->bindValue(':rezept_id', $rezept_id, PDO::PARAM_INT);
                $insertStmt->bindValue(':name', $ingredient['name']);
                $insertStmt->bindValue(':menge', $ingredient['menge']);
                $insertStmt->bindValue(':einheit', $ingredient['einheit']);
                $insertStmt->execute();
            }

            // Commit der Transaktion
            $this->DB->commit();

            return true;
        } catch (Exception $e) {
            // Rollback, falls ein Fehler auftritt
            $this->DB->rollBack();
            error_log("Fehler beim Aktualisieren des Rezepts: " . $e->getMessage());
            return false;
        }
    }
}
