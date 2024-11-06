<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="..\..\assets\styles\styles.css">
    <title>Alle Rezepte</title>
</head>
<?php
include '../../includes/header.php';
include '../../includes/navigation.php';
?>

<body>


    <div class="recipe-grid">
        <?php
        foreach ($rezepte as $id => $rezept) {
            $bild = 'Logo.png';
            if ($rezept['kategorie'] === 'Nachspeise') {
                $bild = 'Sonntagskuchen.png';
            } elseif ($rezept['kategorie'] === 'Mittagessen') {
                $bild = 'Vegetarian.png';
            } elseif ($rezept['kategorie'] === 'Abendessen') {
                $bild = 'Italienisch.avif';
            }

            echo '<div class="recipe-card-show">';
            echo '<img src="' . ($bild) . '" alt="Rezept Bild">';
            echo '<h2>' . htmlspecialchars($rezept['titel']) . '</h2>';
            echo '<div class="content">';
            echo '<p><strong>Kategorie:</strong> ' . htmlspecialchars($rezept['kategorie']) . '</p>';
            echo '<p><strong>Zeitaufwand:</strong> ' . htmlspecialchars($rezept['zeitaufwand']) . '</p>';
            echo '<p><strong>Schwierigkeitsgrad:</strong> ' . htmlspecialchars($rezept['schwierigkeitsgrad']) . '</p>';
            echo '</div>';

            echo '<div class="link-container">';
            echo '<a href="RezepteBewerten.php?id=' . urlencode($id) . '">Bewerten</a>';
            echo '<a href="RezeptDetails.php?id=' . urlencode($id) . '">Mehr erfahren</a>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</body>

</html>