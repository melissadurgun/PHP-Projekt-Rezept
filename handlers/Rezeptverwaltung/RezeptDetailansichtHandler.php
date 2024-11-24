<?php
include '../../config/db.php';

class RezeptDetailHandler
{
    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function getRecipeDetail($rezept_id)
    {
        // Fetch the recipe details, including the BLOB image
        $query = "SELECT r.*, u.username FROM rezept r
                  JOIN user u ON r.user_id = u.user_id
                  WHERE r.rezept_id = :rezept_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':rezept_id' => $rezept_id]);
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$recipe) {
            die("Rezept nicht gefunden.");
        }

        // Convert the BLOB image to a Base64 string if it exists
        if ($recipe['bild']) {
            $recipe['bild'] = 'data:image/jpeg;base64,' . base64_encode($recipe['bild']);
        } else {
            $recipe['bild'] = null; // Kein Bild vorhanden
        }

        // Fetch the ingredients
        $queryIngredients = "SELECT * FROM zutaten WHERE rezept_id = :rezept_id";
        $stmtIngredients = $this->db->prepare($queryIngredients);
        $stmtIngredients->execute([':rezept_id' => $rezept_id]);
        $ingredients = $stmtIngredients->fetchAll(PDO::FETCH_ASSOC);

        // Prepare data to pass to the view
        return [
            'recipe' => $recipe,
            'ingredients' => $ingredients
        ];
    }
}
