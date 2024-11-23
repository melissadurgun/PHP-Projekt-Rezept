<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <title>Navigation</title>
</head>

<body>
    <nav>
        <ul class="filter">
            <li style="font-weight:bold;" onclick="window.location.href = '../../pages/public/index.php'">Startseite
            </li>
            <li>Mahlzeit
                <ul>
                    <li>
                        <form action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                            <button type="submit" name="mahlzeit" value="fruehstueck">Frühstück</button>
                        </form>
                    </li>
                    <li>
                        <form action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                            <button type="submit" name="mahlzeit" value="mittagessen">Mittagessen</button>
                        </form>
                    </li>
                    <li>
                        <form action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                            <button type="submit" name="mahlzeit" value="abendessen">Abendessen</button>
                        </form>
                    </li>
                    <li>
                        <form action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                            <button type="submit" name="mahlzeit" value="dessert">Dessert</button>
                        </form>
                    </li>
                    <li>
                        <form action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                            <button type="submit" name="mahlzeit" value="snack">Snack</button>
                        </form>
                    </li>
                </ul>
            </li>
            <li>Ernährung
                <ul>
                    <li>
                        <form action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                            <button type="submit" name="ernaehrung" value="vegetarisch">Vegetarisch</button>
                        </form>
                    </li>
                    <li>
                        <form action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                            <button type="submit" name="ernaehrung" value="vegan">Vegan</button>
                        </form>
                    </li>
                    <li>
                        <form action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                            <button type="submit" name="ernaehrung" value="fleisch">Fleisch</button>
                        </form>
                    </li>
                    <li>
                        <form action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                            <button type="submit" name="ernaehrung" value="fisch">Fisch</button>
                        </form>
                    </li>
                </ul>
            </li>
            <li>Schwierigkeitsgrad
                <ul>
                    <li>
                        <form action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                            <button type="submit" name="schwierigkeitsgrad" value="leicht">Leicht</button>
                        </form>
                    </li>
                    <li>
                        <form action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                            <button type="submit" name="schwierigkeitsgrad" value="mittel">Mittel</button>
                        </form>
                    </li>
                    <li>
                        <form action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                            <button type="submit" name="schwierigkeitsgrad" value="schwer">Schwer</button>
                        </form>
                    </li>
                </ul>
            </li>
            <li>Küche
                <ul>
                    <li>
                        <form action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                            <button type="submit" name="kueche" value="amerikanisch">Amerikanisch</button>
                        </form>
                    </li>
                    <li>
                        <form action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                            <button type="submit" name="kueche" value="italienisch">Italienisch</button>
                        </form>
                    </li>
                    <li>
                        <form action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                            <button type="submit" name="kueche" value="indisch">Indisch</button>
                        </form>
                    </li>
                    <li>
                        <form action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                            <button type="submit" name="kueche" value="asiatisch">Asiatisch</button>
                        </form>
                    </li>
                    <li>
                        <form action="../../pages/Rezeptsuche/RezeptSuche.php" method="POST">
                            <button type="submit" name="kueche" value="deutsch">Deutsch</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</body>

</html>