<?php
// Die Funktion zum Laden der JSON-Datei importieren
include 'LoadJson.php';

// Lade die Rezepte aus der JSON-Datei
$rezepte = load_json();

// Rezept löschen, wenn das Formular abgeschickt wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rezept_id'])) {
    $delete_id = $_POST['rezept_id'];

    // Rezept aus dem Array entfernen
    if (isset($rezepte[$delete_id])) {
        unset($rezepte[$delete_id]);

        // Aktualisiere die JSON-Datei mit den verbleibenden Rezepten
        file_put_contents('rezepte.json', json_encode($rezepte, JSON_PRETTY_PRINT));

        // Nach dem Löschen die Seite neu laden, um die Änderungen anzuzeigen
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
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
        /* Grid für die Rezeptkarten */
        .recipe-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        /* Styling für jede Rezeptkarte */
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

        /* Titel der Rezeptkarte */
        .recipe-card h2 {
            font-size: 1.5em;
            margin: 0;
            padding: 15px;
            background-color: #ff88004c;
            color: #333;
            text-align: center;
        }

        /* Bild der Rezeptkarte */
        .recipe-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        /* Inhaltsbereich der Rezeptkarte */
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

        /* Link-Button für löschen */
        .recipe-card form {
            display: block;
            text-align: center;
            padding: 10px;
            background-color: #ff4444;
            color: #fff;
            text-decoration: none;
            border-radius: 0 0 10px 10px;
        }

        .recipe-card form:hover {
            background-color: #ff0000;
        }

        .delete-button {
            background-color: #ff4444;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            width: 100%;
        }

        .delete-button:hover {
            background-color: #ff0000;
        }

        .no-recipes-message {
            text-align: center;
            font-size: 1.2em;
            color: #888;
            padding: 20px;
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
