<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="\PHP-Projekt/assets/styles/styles.css">
    <title>Document</title>
</head>


<header>
    <div class="logo">
        <a href="\PHP-Projekt\public\index.php"><img src="\PHP-Projekt\assets\images\LogoLight1.png" alt="logo"></a>
        <h1>Leckere Rezepte</h1>
    </div>
    <div class="suchen">
        <input type="text" placeholder="Worauf hast du Lust?" class="search-bar" />
        <div class="account-container">
            <i class="fa fa-user account-icon"></i>
            <ul class="dropdown-menu">
                <li onclick="location.href = '' ">Profil</li>
                <li onclick="location.href='/PHP-Projekt/pages/Rezeptverwaltung/test2-RezHinzu.php'">TEST Rezepte
                    anlegen</li>
                <li onclick="location.href='/PHP-Projekt/pages/Rezeptverwaltung/RezepteBearbeiten.php'">Rezepte
                    bearbeiten</li>
                <li onclick="location.href='/PHP-Projekt/pages/Rezeptverwaltung/RezepteLöschen.php'">Rezepte löschen
                </li>
                <li onclick="location.href='/PHP-Projekt/pages/Rezeptverwaltung/RezepteAnzeigen.php'">Rezepte anzeigen
                </li>
            </ul>
        </div>
    </div>
</header>

</html>