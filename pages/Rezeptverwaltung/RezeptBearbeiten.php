<?php
/**
 * Die Seite stellt ein Formular bereit, mit welchem sich die Daten eines Rezepts ändern lassen. 
 * 
 */


session_start();
require_once("../../handlers/Rezeptverwaltung/RezeptDetailansichtHandler.php");
require_once("../../handlers/Rezeptverwaltung/RezeptBearbeitenHandler.php");

// Initialisieren des Handlers 
$rezeptDetail = new RezeptDetailHandler();
$rezeptBearbeitenHandler = new RezeptBearbeitenHandler();

// Rezept-ID validieren
$rezept_id = filter_input(INPUT_GET, 'rezept_id', FILTER_VALIDATE_INT);
if (!$rezept_id) {
    die("Ungültige Rezept-ID.");
}

//Details des rezepts mithilfe des Handlers abrufen 
$data = $rezeptDetail->getRecipeDetail($rezept_id);
if (!$data) {
    die("Fehler beim Laden der Rezeptdetails.");
}

// Daten extrahieren, um sie anzeigen zu können 
$recipe = $data['recipe'];
$ingredients = $data['ingredients'];

// Eingaben bereinigen und vorbereiten
$titel = htmlspecialchars($recipe['titel']);
$username = htmlspecialchars($recipe['username']);
$zubereitungsdauer = htmlspecialchars($recipe['zubereitungsdauer']);
$schwierigkeitsgrad = htmlspecialchars($recipe['schwierigkeitsgrad']);
$kueche = htmlspecialchars($recipe['kueche']);
$ernaehrung = htmlspecialchars($recipe['ernaehrung']);
$mahlzeitkategorie = htmlspecialchars($recipe['mahlzeitkategorie']);
$portionen = htmlspecialchars($recipe['portionen']);
$zubereitung = htmlspecialchars($recipe['zubereitung']);
$bild = $recipe['bild']; // Bilddaten aus der Datenbank (BLOB)

// Bilddaten vorbereiten
$bild_src = $recipe['bild']
    ? $recipe['bild']
    : "../../assets/images/ImagePlaceholder.jpg"; // Fallback-Bild, falls kein Bild vorhanden

// Bilddaten vorbereiten
$bild_src = $recipe['bild']
    ? $recipe['bild']
    : "../../assets/images/ImagePlaceholder.jpg"; // Fallback-Bild, falls kein Bild vorhanden

// Formularverarbeitung
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Eingaben validieren und bereinigen
    $neuer_titel = htmlspecialchars(trim($_POST['title']));
    $neue_zubereitungsdauer = filter_input(INPUT_POST, 'zubereitungsdauer', FILTER_VALIDATE_INT);
    $neue_schwierigkeitsgrad = htmlspecialchars(trim($_POST['schwierigkeitsgrad']));
    $neue_kueche = htmlspecialchars(trim($_POST['kueche']));
    $neue_ernaehrung = htmlspecialchars(trim($_POST['ernaehrung']));
    $neue_mahlzeitkategorie = htmlspecialchars(trim($_POST['mahlzeitkategorie']));
    $neue_portionen = filter_input(INPUT_POST, 'portionen', FILTER_VALIDATE_INT);
    $neue_anweisungen = htmlspecialchars(trim($_POST['instructions']));
    $neue_zutaten = $_POST['ingredients'] ?? [];

    // Zutaten validieren
    foreach ($neue_zutaten as &$zutat) {
        $zutat['name'] = htmlspecialchars(trim($zutat['name']));
        $zutat['menge'] = htmlspecialchars(trim($zutat['menge']));
        $zutat['einheit'] = htmlspecialchars(trim($zutat['einheit']));
    }

    // Rezept aktualisieren
    $isUpdated = $rezeptBearbeitenHandler->updateRecipe(
        $rezept_id,
        $neuer_titel,
        $neue_anweisungen,
        $neue_zubereitungsdauer,
        $neue_portionen,
        $neue_ernaehrung,
        $neue_schwierigkeitsgrad,
        $neue_mahlzeitkategorie,
        $neue_kueche,
        $neue_zutaten
    );

    if ($isUpdated) {
        header("Location: ../../pages/Rezeptverwaltung/RezeptDetailansicht.php?rezept_id=" . $rezept_id);
        exit();
    } else {
        echo "Fehler beim Aktualisieren des Rezepts.";
    }
}
?>

<!-- Formular zum Anzeigen der Rezeptdaten -->
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titel; ?> - Rezeptdetails</title>
    <link rel="stylesheet" href="../../assets/styles/styles.css">
</head>

<?php
require_once('../../includes/header.php');
require_once('../../includes/navigation.php');
?>

<body>
    <div class="rezept-detail-container">
        <form action="" method="POST">
            <!-- in der Topbox werden Bild, Name und Dauer, Küche, Ernährung sowie Kategorie angezeigt -->
            <div class="rezept-topbox">
                <div class="rezept-bild">
                    <img src="<?php echo $bild_src; ?>" alt="Bild von <?php echo $titel; ?>">
                </div>
                <div class="rezept-info">
                    <h1><input type="text" name="title" value="<?php echo $recipe['titel']; ?>"></h1>
                    <div class="icon-container1">
                        <p><i class="fa fa-clock-o"></i>
                            <input type="number" name="zubereitungsdauer" value="<?php echo $zubereitungsdauer; ?>">
                            Minuten
                        </p>
                        <p><i class="fa fa-signal"></i>
                            <select name="schwierigkeitsgrad">
                                <option value="Leicht" <?php if ($schwierigkeitsgrad == 'Leicht')
                                    echo 'selected'; ?>>
                                    Leicht</option>
                                <option value="Mittel" <?php if ($schwierigkeitsgrad == 'Mittel')
                                    echo 'selected'; ?>>
                                    Mittel</option>
                                <option value="Schwer" <?php if ($schwierigkeitsgrad == 'Schwer')
                                    echo 'selected'; ?>>
                                    Schwer</option>
                            </select>
                        </p>
                    </div>
                    <div class="icon-container2">
                        <p><i class="fa fa-globe"></i>
                            <select name="kueche">
                                <option value="Amerikanisch" <?php if ($kueche == 'Amerikanisch')
                                    echo 'selected'; ?>>
                                    Amerikanisch</option>
                                <option value="Italienisch" <?php if ($kueche == 'Italienisch')
                                    echo 'selected'; ?>>
                                    Italienisch</option>
                                <option value="Indisch" <?php if ($kueche == 'Indisch')
                                    echo 'selected'; ?>>Indisch
                                </option>
                                <option value="Asiatisch" <?php if ($kueche == 'Asiatisch')
                                    echo 'selected'; ?>>Asiatisch
                                </option>
                                <option value="Orientalisch" <?php if ($kueche == 'Orientalisch')
                                    echo 'selected'; ?>>
                                    Orientalisch</option>
                                <option value="Deutsch" <?php if ($kueche == 'Deutsch')
                                    echo 'selected'; ?>>Deutsch
                                </option>
                            </select>
                        </p>
                        <p><i class="fa fa-leaf"></i>
                            <select name="ernaehrung">
                                <option value="Vegan" <?php if ($ernaehrung == 'Vegan')
                                    echo 'selected'; ?>>Vegan</option>
                                <option value="Vegetarisch" <?php if ($ernaehrung == 'Vegetarisch')
                                    echo 'selected'; ?>>
                                    Vegetarisch</option>
                                <option value="Fleisch" <?php if ($ernaehrung == 'Fleisch')
                                    echo 'selected'; ?>>Fleisch
                                </option>
                                <option value="Fisch" <?php if ($ernaehrung == 'Fisch')
                                    echo 'selected'; ?>>Fisch</option>
                            </select>
                        </p>
                        <p><i class="fa fa-cutlery"></i>
                            <select name="mahlzeitkategorie">
                                <option value="Frühstück" <?php if ($mahlzeitkategorie == 'Frühstück')
                                    echo 'selected'; ?>>Frühstück</option>
                                <option value="Mittagessen" <?php if ($mahlzeitkategorie == 'Mittagessen')
                                    echo 'selected'; ?>>Mittagessen</option>
                                <option value="Abendessen" <?php if ($mahlzeitkategorie == 'Abendessen')
                                    echo 'selected'; ?>>Abendessen</option>
                                <option value="Dessert" <?php if ($mahlzeitkategorie == 'Dessert')
                                    echo 'selected'; ?>>
                                    Dessert</option>
                                <option value="Snack" <?php if ($mahlzeitkategorie == 'Snack')
                                    echo 'selected'; ?>>Snack
                                </option>
                            </select>
                        </p>
                    </div>
                </div>
            </div>
            <!-- in der unteren Box werden Zubereitung und Zutaten angezeigt -->
            <div class="rezept-bottombox">
                <div class="rezept-zubereitung">
                    <h2>Zubereitung</h2>
                    <textarea name="instructions"><?php echo htmlspecialchars($zubereitung); ?></textarea>
                </div>
                <div class="rezept-zutaten">
                    <h2>Zutaten für <input type="number" name="portionen" value="<?php echo $portionen; ?>"> Portionen
                    </h2>
                    <div class="zutaten">
                        <div class="zutaten-container" id="zutaten">
                            <ul>
                                <?php foreach ($ingredients as $index => $ingredient): ?>
                                    <li class="zutaten">
                                        <div class="zutaten-row">
                                            <input type="text" name="ingredients[<?php echo $index; ?>][name]"
                                                value="<?php echo htmlspecialchars($ingredient['name']); ?>">
                                            <input type="text" name="ingredients[<?php echo $index; ?>][menge]"
                                                value="<?php echo htmlspecialchars($ingredient['menge']); ?>">
                                            <select name="ingredients[<?php echo $index; ?>][einheit]">
                                                <option value="g" <?php if ($ingredient['einheit'] == 'g')
                                                    echo 'selected'; ?>>g</option>
                                                <option value="ml" <?php if ($ingredient['einheit'] == 'ml')
                                                    echo 'selected'; ?>>ml</option>
                                                <option value="Stück" <?php if ($ingredient['einheit'] == 'Stück')
                                                    echo 'selected'; ?>>Stück</option>
                                                <option value="TL" <?php if ($ingredient['einheit'] == 'TL')
                                                    echo 'selected'; ?>>TL</option>
                                                <option value="EL" <?php if ($ingredient['einheit'] == 'EL')
                                                    echo 'selected'; ?>>EL</option>
                                                <option value="L" <?php if ($ingredient['einheit'] == 'L')
                                                    echo 'selected'; ?>>L</option>
                                                <option value="kg" <?php if ($ingredient['einheit'] == 'kg')
                                                    echo 'selected'; ?>>kg</option>
                                            </select>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <button type="submit">Rezept aktualisieren</button>
            </div>
        </form>
    </div>
</body>
<?php
require_once('../../includes/footer.php');
?>

</html>