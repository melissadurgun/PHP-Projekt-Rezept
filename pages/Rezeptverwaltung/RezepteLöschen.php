<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Alle Rezepte</title>
</head>

<?php
include '../includes/header.php';
include '../includes/navigation.php';
?>

<body>

    <div class="recipe-grid">
        <?php
        if (!empty($rezepte)) {
            foreach ($rezepte as $id => $rezept) {
                // Standardbild auswählen, basierend auf der Kategorie
                $bild = '';
                if ($rezept['kategorie'] === 'Nachspeise') {
                    $bild = 'Sonntagskuchen.jpg';
                } elseif ($rezept['kategorie'] === 'Mittagessen') {
                    $bild = 'Vegetarisch.png';
                } elseif ($rezept['kategorie'] === 'Abendessen') {
                    $bild = 'italienisch.png';
                } else {
                    $bild = 'default.jpg'; // Ein Standardbild, falls keine Kategorie zutrifft
                }

                echo '<div class="recipe-card">';

                // Setze das Bild abhängig von der Kategorie
                echo '<img src="' . ($bild) . '" alt="Rezept Bild">';
                echo '<h2>' . ($rezept['titel']) . '</h2>';
                echo '<div class="content">';
                echo '<p><strong>Kategorie:</strong> ' . ($rezept['kategorie']) . '</p>';
                echo '<p><strong>Zeitaufwand:</strong> ' . ($rezept['zeitaufwand']) . '</p>';
                echo '<p><strong>Schwierigkeitsgrad:</strong> ' . ($rezept['schwierigkeitsgrad']) . '</p>';
                echo '</div>';

                // Lösch-Button anstelle von "Mehr erfahren"
                echo '<form method="POST" action="RezepteLöschen.php">';
                echo '<input type="hidden" name="rezept_id" value="' . urlencode($id) . '">';
                echo '<button type="submit" class="delete-button">Rezept löschen</button>';
                echo '</form>';

                echo '</div>';
            }
        } else {
            // Nachricht anzeigen, wenn keine Rezepte vorhanden sind
            echo '<div class="no-recipes-message">Keine Rezepte vorhanden.</div>';
        }
        ?>
    </div>

</body>

</html>