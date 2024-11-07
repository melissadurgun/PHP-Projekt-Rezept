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
                <a href="../../pages/public/index.php">
                    <img src="../../assets/images/LogoLight1.png" alt="logo">
                </a>
            </div>
            <h1>Leckere Rezepte</h1>
            <div class="account-container">
                <i class="fa fa-user account-icon"></i>
                <ul class="dropdown-menu">
                    <li onclick="location.href = '../../pages/Benutzerverwaltung/Benutzerseite.php'">Profil</li>
                    <li onclick="location.href='../../pages/Rezeptverwaltung/RezeptHinzufügen.php'">Neues Rezept Anlegen
                    </li>
                    <li onclick="location.href='../../pages/Benutzerverwaltung/Logout.php'">Logout</li>
                </ul>
            </div>
        </div>
        <br>

        <!-- Suchleiste als Formular für Weiterleitung zu Rezeptsuche.php -->
            <form name ="Suchleiste" action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                <i class="fa fa-search search-icon"></i>
                <input type="text" name="search" placeholder="Dein perfekter Biss ist nur ein Rezept entfernt"
                    class="search-bar" />
            </form>
    </header>
</body>

</html>