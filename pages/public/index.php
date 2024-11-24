<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <title>Leckere Rezepte</title>
</head>

<!-- Header ausgelagert -->
<?php
require_once('../../includes/header.php');
require_once('../../includes/navigation.php');
?>

<!-- <body>
    <main>
        <div class="recipe-cards">
            <div class="recipe-card">
                <img src="../../assets/images/NeusteRezepte.png" alt="Rezept 1" />
                <div class="overlay">NEUESTE REZEPTE</div>
            </div>
            <div class="recipe-card">
                <img src="../../assets/images/Sonntagskuchen.png" alt="Rezept 2" />
                <div class="overlay">SONNTAGS-KUCHEN</div>
            </div>
            <div class="recipe-card">
                <img src="../../assets/images/Vegetarian.png" alt="Rezept 3" />
                <div class="overlay">VEGGIE HAUPTGERICHTE</div>
            </div>
            <div class="recipe-card">
                <img src="../../assets/images/Italienisch.avif" alt="Rezept 4" />
                <div class="overlay">ITALIENISCH</div>
            </div>
        </div>
    </main>
</body> -->
<?php
require_once('../../pages/Rezeptverwaltung/RezeptOverview.php');
require_once('../../includes/footer.php');
?>

</html>