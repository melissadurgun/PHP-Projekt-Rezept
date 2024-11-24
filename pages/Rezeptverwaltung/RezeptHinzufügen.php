<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Form</title>
    <link rel="stylesheet" href="../../assets/styles/RezeptCreate.css">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <script></script>
</head>

<?php
include '../../includes/header.php';
include '../../includes/navigation.php';
?>


<body>
    <div class="form">
        <form class="RezeptHinzufügenForm" action="..\..\pages\BildTest\Hinzufügen.php"
            method="POST" enctype="multipart/form-data">
            <div class="recipe-form">
                <div class="recipe-header">
                    <!-- feature needs to be implemented: add picture -->
                    <div class="image-placeholder">
                        <input type="file" id="file" name="file" accept="image/*" style="display: none;" required
                            onchange="previewImage(event)">
                        <label for="file" class="file-label">
                            <img class="preview" id="preview" src="../../assets/images/ImagePlaceholder.jpg"
                                alt="Recipe Image" style="width: 100%; height: auto; cursor: pointer;">
                        </label>
                    </div>
                    <div class="titel">
                        <label for="titel">Titel</label>
                        <input type="text" id="titel" name="titel" required>
                    </div>
                </div>

                <div class="info">
                    <div>
                        <label for="portionen">Portionen</label>
                        <input type="number" id="portionen" name="portionen" required>
                    </div>
                    <div>
                        <label for="zubereitungsdauer">Zubereitungsdauer</label>
                        <input type="number" id="zubereitungsdauer" name="zubereitungsdauer" placeholder="in Minuten"
                            required>
                    </div>
                    <div>
                        <label for="schwierigkeitsgrad">Schwierigkeitsgrad</label>
                        <!-- TODO! Handler has to be able to read schwierigkeitsgrad-->
                        <select id="schwierigkeitsgrad" name="schwierigkeitsgrad" required>
                            <option value="Leicht">Leicht</option>
                            <option value="Mittel">Mittel</option>
                            <option value="Schwer">Schwer</option>
                        </select>
                    </div>
                </div>

                <div class="zubereitung">
                    <label for="zubereitung">Zubereitung</label>
                    <textarea id="zubereitung" name="zubereitung" required></textarea>
                </div>

                <div class="zutaten">
                    <label>Zutaten</label>
                    <div class="zutaten-container" id="zutaten">
                        <div class="zutaten-row">
                            <input type="text" name="zutaten[0][name]" placeholder="Zutat" required>
                            <input type="number" name="zutaten[0][menge]" placeholder="Menge" step="0.1" required>
                            <select name="zutaten[0][einheit]" required>
                                <option value="g">g</option>
                                <option value="ml">ml</option>
                                <option value="Stück">Stück</option>
                                <option value="TL">TL</option>
                                <option value="EL">EL</option>
                                <option value="L">L</option>
                                <option value="kg">kg</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" onclick="zutatHinzufügen()">+ Zutat hinzufügen</button>
                </div>
                <div class="additional-options">
                    <div>
                        <label for="mahlzeitkategorie">Menüart</label>
                        <!-- TODO! Handler has to be able to read -->
                        <select id="mahlzeitkategorie" name="mahlzeitkategorie" required>
                            <option value="Frühstück">Frühstück</option>
                            <option value="Mittagessen">Mittagessen</option>
                            <option value="Abendessen">Abendessen</option>
                            <option value="Dessert">Dessert</option>
                            <option value="Snack">Snack</option>
                        </select>
                    </div>
                    <div>
                        <label for="ernaehrung">Ernährung</label>
                        <!-- TODO! Handler has to be able to read -->
                        <select id="ernaehrung" name="ernaehrung" required>
                            <option value="Vegan">Vegan</option>
                            <option value="Vegetarisch">Vegetarisch</option>
                            <option value="Fleisch">Fleisch</option>
                            <option value="Fisch">Fisch</option>
                        </select>
                    </div>
                    <div>
                        <label for="kueche">Küche</label>
                        <!-- TODO! Handler has to be able to read -->
                        <select id="kueche" name="kueche" required>
                            <option value="Amerikanisch">Amerikanisch</option>
                            <option value="Italienisch">Italienisch</option>
                            <option value="Indisch">Indisch</option>
                            <option value="Asiatisch">Asiatisch</option>
                            <option value="Orientalisch">Orientalisch</option>
                            <option value="Deutsch">Deutsch</option>
                        </select>
                    </div>
                </div>

                <div class="buttonsContainer">
                    <a href="../Benutzerverwaltung/benutzerseite.php">
                        <button type="button" class="back">Zurück zum Profil</button>
                    </a>
                    <button type="submit" class="rezeptSpeichern">Rezept speichern</button>
                </div>
            </div>
        </form>
    </div>
    <!-- Dynamisches Hinzufügen der Zutaten -->
    <script src="..\..\js\zutatHinzufügen.js"></script>
    <script src="..\..\js\imagePreview.js"></script>
    <script src="..\..\js\formValidation.js"></script>


</body>
<?php
include '../../includes/footer.php';
?>

</html>