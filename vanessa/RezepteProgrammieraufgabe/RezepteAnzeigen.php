<?php
// Die Funktion zum Laden der JSON-Datei importieren
include 'LoadJson.php';

// Lade die Rezepte aus der JSON-Datei
$rezepte = load_json();

// Überprüfen, ob es überhaupt Rezepte gibt
if (empty($rezepte)) {
    die('Keine Rezepte gefunden.');
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Alle Rezepte</title>
    <style>
        
        .recipe-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        
        .recipe-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: #fff;
            transition: transform 0.2s;
        }

        .recipe-card:hover {
            transform: scale(1.05);
        }

        
        .recipe-card h2 {
            font-size: 1.5em;
            margin: 0;
            padding: 15px;
            background-color: #ff88004c;
            color: #333;
            text-align: center;
        }

        
        .recipe-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        
        .recipe-card .content {
            padding: 15px;
        }

        .recipe-card p {
            margin: 10px 0;
            color: #555;
        }

        .recipe-card .details {
            font-size: 0.9em;
            color: #888;
        }

        
        .recipe-card a {
            display: block;
            text-align: center;
            padding: 10px;
            background-color: #ff88004c;
            color: #333;
            text-decoration: none;
            border-radius: 0 0 10px 10px;
        }

        .recipe-card a:hover {
            background-color: #ff55004c;
        }

        .recipe-card .link-container {
            display: flex; 
            justify-content: space-around; 
            padding: 10px 0 ;
        }

        .recipe-card a {
            flex: 1; 
            margin: 0 5px; 
        }

    </style>
</head>

<header>
        <div class="logo">
            <img src="Logo.jpg" alt="logo" onclick="location.href='index.php'">
            <h1>Leckere Rezepte</h1>
        </div>
        <div class="suchen">
            <input type="text" placeholder="Worauf hast du Lust?" class="search-bar" />
            <div class="account-container">
                <i class="fa fa-user account-icon"></i>
                <ul class="dropdown-menu">
                    <li onclick="location.href='RezepteAnlegen.php'">Rezepte anlegen</li>
                    <li onclick="location.href='RezepteBearbeiten.php'">Rezepte bearbeiten</li>
                    <li onclick="location.href='RezepteLöschen.php'">Rezepte löschen</li>
                    <li onclick="location.href='RezepteAnzeigen.php'">Rezepte anzeigen</li>
                </ul>
            </div>
        </div>
    </header>

<nav>
    <ul class="filter">
        <li>Mahlzeit</li>
        <li>Ernährung</li>
        <li>Rezeptart</li>
        <li>Kategorie
            <ul>
                <li>Mittag</li>
                <li>Abend</li>
                <li>Snack</li>
            </ul>
        </li>
        <li>Getränke</li>
        <li>Anlass</li>
        <li>Saison</li>
        <li>Backen & Süßes</li>
        <li>Weltweit</li>
    </ul>
</nav>

<body>


<div class="recipe-grid">
    <?php
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
            $bild = 'Logo.jpg'; // Ein Standardbild, falls keine Kategorie zutrifft
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
        
        // Korrigierte Links in einer neuen Container-Div
        echo '<div class="link-container">';
        echo '<a href="RezepteBewerten.php?id=' . urlencode($id) . '">Bewerten</a>';
        echo '<a href="RezeptDetails.php?id=' . urlencode($id) . '">Mehr erfahren</a>';
        echo '</div>';

    }
    ?>
</div>

</body>
</html>
