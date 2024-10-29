<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <title>Leckere Rezepte</title>
</head>

<!-- Header ausgelagert -->
<?php
include '../includes/header.php';
?>

<nav>
    <ul class="filter">
        <li>Mahlzeit
            <ul>
                <li>Frühstück</li>
                <li>Mittagessen</li>
                <li>Abendessen</li>
            </ul>
        </li>
        <li>Menü
            <ul>
                <li>Vorspeise</li>
                <li>Hauptspeise</li>
                <li>Nachspeise</li>
                <li>Snack</li>
                <li>Salat</li>
                <li>Beilage</li>
            </ul>
        </li>
        <li>Ernährung
            <ul>
                <li>Vegetarisch</li>
                <li>Vegan</li>
                <li>Fisch</li>
                <li>Fleisch</li>
            </ul>
        </li>
        <li>Weltweit
            <ul>
                <li>Amerikanisch</li>
                <li>Italienisch</li>
                <li>Indisch</li>
                <li>Orientalisch</li>
                <li>Deutsch</li>
                <li>Asiatisch</li>
            </ul>
        </li>
    </ul>
</nav>

<body>
    <main>
        <div class="recipe-cards">
            <div class="recipe-card">
                <img src="../assets/images/NeusteRezepte.png" alt="Rezept 1" />
                <div class="overlay">NEUESTE REZEPTE</div>
            </div>
            <div class="recipe-card">
                <img src="../assets/images/Sonntagskuchen.png" alt="Rezept 2" />
                <div class="overlay">SONNTAGS-KUCHEN</div>
            </div>
            <div class="recipe-card">
                <img src="../assets/images/Vegetarian.png" alt="Rezept 3" />
                <div class="overlay">VEGGIE HAUPTGERICHTE</div>
            </div>
            <div class="recipe-card">
                <img src="../assets/images/Italienisch.avif" alt="Rezept 4" />
                <div class="overlay">ITALIENISCH</div>
            </div>
        </div>
    </main>
</body>

</html>