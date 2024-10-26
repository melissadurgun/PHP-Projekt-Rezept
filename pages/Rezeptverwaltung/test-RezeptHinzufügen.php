<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <title>Rezept hinzufügen</title>
</head>
<!-- Header ausgelagert -->

<?php
include '../../includes/header.php';
?>

<body>
<h2>Rezept hinzufügen</h2>
<div class="form-container">
    <div class="anlegen">
        <form action="..\handlers\RezepteintragHandler.php" method="POST">
            <label for="titel">Titel:</label>
            <input type="text" id="titel" name="titel" required><br>

            <label for="zubereitung">Zubereitung:</label>
            <textarea id="zubereitung" name="zubereitung" required></textarea><br>

            <label for="zubereitungsdauer">Zubereitungsdauer (Minuten):</label>
            <input type="number" id="zubereitungsdauer" name="zubereitungsdauer" required><br>

            <label for="portionen">Portionen:</label>
            <input type="number" id="portionen" name="portionen" required><br>

            <label for="ernaehrung">Ernährung:</label>
            <select id="ernaehrung" name="ernaehrung">
                <option value="Vegan">Vegan</option>
                <option value="Vegetarisch">Vegetarisch</option>
                <option value="Normal">Normal</option>
                <option value="Fleisch">Fleisch</option>
                <option value="Fisch">Fisch</option>
            </select><br>

            <!-- Ingredients section -->
            <h3>Zutaten</h3>
            <div id="ingredients">
                <label for="zutat1">Zutat:</label>
                <input type="text" name="zutaten[0][name]" placeholder="Zutat" required>
                <input type="number" name="zutaten[0][menge]" placeholder="Menge" step="0.1" required>
                <select name="zutaten[0][einheit]">
                    <option value="g">g</option>
                    <option value="ml">ml</option>
                    <option value="Stück">Stück</option>
                    <option value="TL">TL</option>
                    <option value="EL">EL</option>
                    <option value="L">L</option>
                    <option value="kg">kg</option>
                </select><br>
            </div>
            <button type="button" onclick="addIngredient()">Weitere Zutat hinzufügen</button><br>

            <button type="submit">Rezept speichern</button>
        </form>
    </div>
</div>

<script>
function addIngredient() {
    const ingredientsDiv = document.getElementById('ingredients');
    const index = ingredientsDiv.childElementCount / 3;  // Calculate the next index for new ingredient fields

    // Create new ingredient fields
    const nameField = `<input type="text" name="zutaten[${index}][name]" placeholder="Zutat" required>`;
    const mengeField = `<input type="number" name="zutaten[${index}][menge]" placeholder="Menge" step="0.1" required>`;
    const einheitField = `<select name="zutaten[${index}][einheit]">
                             <option value="g">g</option>
                             <option value="ml">ml</option>
                             <option value="Stück">Stück</option>
                             <option value="TL">TL</option>
                             <option value="EL">EL</option>
                             <option value="L">L</option>
                             <option value="kg">kg</option>
                          </select><br>`;

    ingredientsDiv.insertAdjacentHTML('beforeend', nameField + mengeField + einheitField);
}
</script>

</body>
</html>
