<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $neues_rezept = [
        'titel' => $_POST['titel'],
        'zutatenliste' => $_POST['zutatenliste'],
        'zubereitung' => $_POST['zubereitung'],
        'kategorie' => $_POST['kategorie'],
        'zeitaufwand' => $_POST['zeitaufwand'],
        'schwierigkeitsgrad' => $_POST['schwierigkeitsgrad']
    ];

    // Lesen der bestehenden Rezepte
    $rezepte = [];
    if (file_exists('rezepte.json')) {
        $rezepte = json_decode(file_get_contents('rezepte.json'), true);
    }
    
    // Hinzufügen des neuen Rezepts
    $rezepte[] = $neues_rezept;

    // Schreiben in die JSON-Datei
    file_put_contents('rezepte.json', json_encode($rezepte));
}
?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="\PHP-Projekt\assets\styles\styles.css">
    <title>Leckere Rezepte</title>

</head>

<?php
include '../../includes/header.php';
?>

<body>
    <div class="headline">
    <h2>Rezepte hinzufügen</h2>
    </div>

    <div class="form-container">
        <div class="anlegen">
            <form method="POST">
                <input type="hidden" name="betreff" value="Formular" />
                
                <label for="titel">Titel:</label>
                <input type="text" name="titel" id="titel" required /><br>
                
                <label for="zutatenliste">Zutaten:</label>
                <textarea name="zutatenliste" id="zutatenliste" required></textarea><br>
                
                <label for="zubereitung">Zubereitung:</label>
                <textarea name="zubereitung" id="zubereitung" required></textarea><br>
                
                <label for="kategorie">Kategorie:</label>
                <div class="kategorie-options">
                <label>Mittagessen
                        <input type="radio" name="kategorie" value="Mittagessen" required>
                    </label>
                    <label>Abendessen
                        <input type="radio" name="kategorie" value="Abendessen" required>
                    </label>
                    <label>Nachspeise
                        <input type="radio" name="kategorie" value="Nachspeise" required>
                    </label>
                </div>
                
                <label>Zeitaufwand:</label><br>
                <div class="zeitaufwand-options">
                    <label>Kurz
                        <input type="radio" name="zeitaufwand" value="Kurz" required>
                    </label>
                    <label>Mittel
                        <input type="radio" name="zeitaufwand" value="Mittel" required>
                    </label>
                    <label>Lang
                        <input type="radio" name="zeitaufwand" value="Lang" required>
                    </label>
                </div>
                <br>

                <label>Schwierigkeitsgrad:</label><br>
                <div class="schwierigkeitsgrad-options">
                    <label>Leicht
                        <input type="radio" name="schwierigkeitsgrad" value="Leicht" required>
                    </label>
                    <label>Mittel
                        <input type="radio" name="schwierigkeitsgrad" value="Mittel" required>
                    </label>
                    <label>Schwer
                        <input type="radio" name="schwierigkeitsgrad" value="Schwer" required>
                    </label>
                </div>
                <br>

                <input type="submit" name="submit" value="Rezept hinzufügen">
            </form>
            
            <div class="backbutton">
            <button type="submit" class="button" onclick="window.location.href='index.php';">Zurück zur Rezeptübersicht</button>
            </div>
            
            
        </div>

    </div>
</body>
</html>