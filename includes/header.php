<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <title>Document</title>
</head>

<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <a href="../../public/index.php">
                    <img src="../../assets/images/LogoLight1.png" alt="logo">
                </a>
            </div>
            <h1>Leckere Rezepte</h1>
            <div class="account-container">
                <i class="fa fa-user account-icon"></i>
                <ul class="dropdown-menu">
                    <li onclick="location.href = '../Benutzerverwaltung/benutzerseite.php'">Profil</li>
                    <li onclick="location.href='../Rezeptverwaltung/RezHinzufügen.php'">TEST Rezepte anlegen</li>
                    <li onclick="location.href='../Rezeptverwaltung/RezepteBearbeiten.php'">Rezepte bearbeiten
                    </li>
                    <li onclick="location.href='../Rezeptverwaltung/RezepteLöschen.php'">Rezepte löschen</li>
                    <li onclick="location.href='../Rezeptverwaltung/RezepteAnzeigen.php'">Rezepte anzeigen</li>
                </ul>
            </div>
        </div>
        <br>
        <div class="suchen">
            <i class="fa fa-search search-icon"></i>
            <input type="text" placeholder="Dein perfekter Biss ist nur ein Rezept entfernt" class="search-bar" />
        </div>

    </header>
</body>

</html>