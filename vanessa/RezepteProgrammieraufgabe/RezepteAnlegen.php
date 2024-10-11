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
    <link rel="stylesheet" href="styles.css">
    <title>Leckere Rezepte</title>
    <style>
        .form-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        form {
            border: 1px solid black;
            border-radius: 15px;
            width: 370px;
            padding: 20px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            border-color: grey;
            margin: 20px;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.1);
            background-color: white; /* Hintergrundfarbe des Formulars */
        }

        input[type="text"]:not(.search-bar),
        textarea,
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid rgba(128, 128, 128, 0.461);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        input[type="text"].search-bar {
            background-color: #ffffff; 
        }

        input[type="text"]:not(.search-bar) {
            background-color: #00ffb34c;
        }

        textarea {
            background-color: #95ff004c;
        }

        input[type="submit"] {
            background-color: #ff88004c;
            border: 1px solid rgba(128, 128, 128, 0.461);
            cursor: pointer;
            margin-top: 5px;
        }

        input[type="submit"]:hover {
            background-color: #ff55004c;
        }

        .zeitaufwand-options,
        .schwierigkeitsgrad-options,
        .kategorie-options {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
        }

        .zeitaufwand-options label,
        .schwierigkeitsgrad-options label,
        .kategorie-options label {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 5px;
        }

        button {
            background-color: lightgray;
            border: 1px solid rgba(128, 128, 128, 0.461);
            border-radius: 5px;
            cursor: pointer;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            width: 100%;
            box-sizing: border-box;
            text-align: center;
        }

        button:hover {
            background-color: gray;
        }

        .anlegen {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 370px;
            text-align: center;
            margin: 50px;
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
            <button type="button" onclick="window.location.href='index.php';">Zurück zur Rezeptübersicht</button>
        </div>

    </div>
</body>
</html>
