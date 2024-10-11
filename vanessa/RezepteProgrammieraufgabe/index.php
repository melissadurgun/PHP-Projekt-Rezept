<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Leckere Rezepte</title>
    <style>

        .recipe-cards {
            display: flex;
            justify-content: space-around;
            flex-wrap: nowrap; 
            padding: 20px;
            margin-top: 10px; 
            transition: margin-top 0.3s ease; 
        }

        .recipe-card {
            position: relative;
            margin: 10px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .recipe-card img {
            width: 300px;
            height: auto;
            display: block;
        }

        .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            text-align: center;
            padding: 10px 0;
        }

    </style>
</head>

<header>
      <div class="logo">
    <img src="Logo.jpg" alt="logo">
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
    <main>
        <div class="recipe-cards">
            <div class="recipe-card">
                <img src="NeusteRezepte.png" alt="Rezept 1" />
                <div class="overlay">NEUESTE REZEPTE</div>
            </div>
            <div class="recipe-card">
                <img src="Sonntagskuchen.png" alt="Rezept 2" />
                <div class="overlay">SONNTAGS-KUCHEN</div>
            </div>
            <div class="recipe-card">
                <img src="Vegetarian.png" alt="Rezept 3" />
                <div class="overlay">VEGGIE HAUPTGERICHTE</div>
            </div>
            <div class="recipe-card">
                <img src="Italienisch.avif" alt="Rezept 4" />
                <div class="overlay">ITALIENISCH</div>
            </div>
        </div>
    </main>
</body>
</html>
