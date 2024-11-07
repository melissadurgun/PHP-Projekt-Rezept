<?php
$rezeptDetail = new RezeptDetailHandler();
$rezept = $handler->getRezeptDetails($rezept_id);
$data = $rezeptDetail->getRecipeDetail($rezept_id);

$rezeptSucheHandler = new RezeptSucheHandler();

if (!$data) {
    die("Fehler beim Laden der Rezeptdetails.");
}

// Extract data for easy access in the view
$recipe = $data['recipe'];
$ingredients = $data['ingredients'];

// Prepare data for display
$titel = htmlspecialchars($recipe['titel']);
$username = htmlspecialchars($recipe['username']);
$zubereitungsdauer = htmlspecialchars($recipe['zubereitungsdauer']);
$schwierigkeitsgrad = htmlspecialchars($recipe['schwierigkeitsgrad']);
$kueche = htmlspecialchars($recipe['kueche']);
$ernaehrung = htmlspecialchars($recipe['ernaehrung']);
$mahlzeitkategorie = htmlspecialchars($recipe['mahlzeitkategorie']);
$bild_url = htmlspecialchars($recipe['bild_url']);
$portionen = htmlspecialchars($recipe['portionen']);
$zubereitung = nl2br(htmlspecialchars($recipe['zubereitung']));
?>


<div class="recipe-container">
    <div class="recipe-grid">
        <!-- Recipe Card 1 -->
        <div class="recipe-card">
            <div class="recipe-image">
                <img src="path/to/your/image.jpg" alt="Recipe Image">
            </div>
            <div class="recipe-info">
                <h3 class="recipe-title">Titel Rezept Nummer 1</h3>
                <div class="recipe-meta">
                    <span class="meta-item"><i class="fa fa-clock-o"></i> 20min</span>
                    <span class="meta-item"><i class="fa fa-signal"></i> Leicht</span>
                    <span class="meta-item"><i class="fa fa-leaf"></i> Vegetarisch</span>
                </div>
            </div>
        </div>

        <!-- Repeat Recipe Card for additional recipes -->
        <div class="recipe-card">
            <div class="recipe-image">
                <img src="path/to/your/image.jpg" alt="Recipe Image">
            </div>
            <div class="recipe-info">
                <h3 class="recipe-title">Titel Rezept Nummer 1</h3>
                <div class="recipe-meta">
                    <span class="meta-item"><i class="fa fa-clock-o"></i> 20min</span>
                    <span class="meta-item"><i class="fa fa-signal"></i> Leicht</span>
                    <span class="meta-item"><i class="fa fa-leaf"></i> Vegetarisch</span>
                </div>
            </div>
        </div>

        <!-- Add more recipe cards as needed -->
    </div>
</div>