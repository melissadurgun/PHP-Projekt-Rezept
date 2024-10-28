<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Form</title>
    <link rel="stylesheet" href="\PHP-Projekt\pages\Rezeptverwaltung\test2-styles.css">
</head>

<?php
include '../../includes/header.php';
?>

<body>
    <div class="recipe-form">
        <div class="header">
            <div class="image-placeholder">
                <img src="\PHP-Projekt\assets\images\ImagePlaceholder.jpg" alt="Recipe Image">
            </div>
            <div class="titel">
                <label for="title">Titel</label>
                <input type="text" id="title" placeholder="placeholder">
            </div>
        </div>
        
        <div class="info">
            <div>
                <label for="portionen">Portionen</label>
                <input type="text" id="portionen">
            </div>
            <div>
                <label for="zubereitungsdauer">Zubereitungsdauer</label>
                <input type="text" id="zubereitungsdauer">
            </div>
            <div>
                <label for="schwierigkeitsgrad">Schwierigkeitsgrad</label>
                <select id="schwierigkeitsgrad">
                    <option>Leicht</option>
                    <option>Mittel</option>
                    <option>Schwer</option>
                </select>
            </div>
        </div>

        <div class="zubereitung">
            <label for="zubereitung">Zubereitung</label>
            <textarea id="zubereitung"></textarea>
        </div>

        <div class="zutaten">
            <label>Zutaten</label>
            <div class="zutaten-row">
                <input type="text" placeholder="Zutat">
                <input type="text" placeholder="Menge">
                <select>
                    <option>Menu Item</option>
                </select>
            </div>
            <button type="button">+ Zutat hinzufügen</button>
        </div>

        <div class="additional-options">
            <div>
                <label for="menu-type">Menüart</label>
                <select id="menu-type">
                    <option>Menu Item</option>
                </select>
            </div>
            <div>
                <label for="nutrition">Ernährung</label>
                <select id="nutrition">
                    <option>Menu Item</option>
                </select>
            </div>
            <div>
                <label for="cuisine">Küche</label>
                <select id="cuisine">
                    <option>Menu Item</option>
                </select>
            </div>
        </div>

        <div class="submit">
            <button type="button">Rezept speichern</button>
        </div>
    </div>
</body>
</html>
