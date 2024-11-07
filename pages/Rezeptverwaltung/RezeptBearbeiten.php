<?php
session_start();
require_once("../../handlers/Rezeptverwaltung/RezeptDetailansichtHandler.php");
require_once("../../handlers/Rezeptverwaltung/RezeptBearbeitenHandler.php");


// Initialize the handler
$rezeptDetail = new RezeptDetailHandler();
$rezeptBearbeitenHandler = new RezeptBearbeitenHandler();

// Check if the `rezept_id` parameter is provided in the URL
$rezept_id = $_GET['rezept_id'] ?? null;
if (!$rezept_id) {
    die("Rezept-ID nicht angegeben.");
}

$data = $rezeptDetail->getRecipeDetail($rezept_id);

if (!$data) {
    die("Fehler beim Laden der Rezeptdetails.");
}

// Extract data for easy access in the view
$recipe = $data['recipe'];
$ingredients = $data['ingredients'];

//Check if its own recipe
if ($recipe['user_id'] == $_SESSION['user_id']) {

}

// Prepare data for display
$titel = htmlspecialchars($recipe['titel']);
$username = htmlspecialchars($recipe['username']);
$zubereitungsdauer = htmlspecialchars($recipe['zubereitungsdauer']);
$schwierigkeitsgrad = htmlspecialchars($recipe['schwierigkeitsgrad']);
$kueche = htmlspecialchars($recipe['kueche']);
$ernaehrung = htmlspecialchars($recipe['ernaehrung']);
$mahlzeitkategorie = htmlspecialchars($recipe['mahlzeitkategorie']);
$bild_url = htmlspecialchars($recipe['bild_url']);
$portionen = htmlspecialchars($recipe['portionen']);
$zubereitung = nl2br(htmlspecialchars($recipe['zubereitung']));

####################################################
// Hauptlogik zur Verarbeitung der Aktualisierung

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $neuer_titel = $_POST['title'];
    $neue_zutaten = $_POST['ingredients'];
    $neue_anweisungen = $_POST['instructions'];
    $neue_zubereitungsdauer = $_POST['zubereitungsdauer'];
    $neue_schwierigkeitsgrad = $_POST['schwierigkeitsgrad'];
    $neue_kueche = $_POST['kueche'];
    $neue_ernaehrung = $_POST['ernaehrung'];
    $neue_mahlzeitkategorie = $_POST['mahlzeitkategorie'];
    $neue_portionen = $_POST['portionen'];

    // Update the recipe using the handler
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
        $bild_url,
        $neue_zutaten
    );

    if ($isUpdated) {
        header("Location: ../../pages/Rezeptverwaltung/RezeptDetailansicht.php?rezept_id=" . $rezept_id);
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "Fehler beim Aktualisieren des Rezepts.";
        error_log("Failed to update recipe: " . $e->getMessage());

    }
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titel; ?> - Rezeptdetails</title>
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <link rel="stylesheet" href="../../assets/styles/RezDetailStyles.css">
</head>

<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navigation.php'; ?>

    <div class="rezept-detail-container">
        <form action="" method="POST">
            <div class="rezept-topbox">
                <div class="rezept-bild">
                    <img src="<?php echo htmlspecialchars($recipe['bild_url']); ?>"
                        alt="Bild von <?php echo htmlspecialchars($recipe['titel']); ?>">
                </div>
                <div class="rezept-info">
                    <h1><input type="text" name="title" value="<?php echo htmlspecialchars($recipe['titel']); ?>"></h1>
                    <div class="icon-container1">
                        <p><i class="fa fa-clock-o"></i> <input type="number" name="zubereitungsdauer"
                                value="<?php echo $zubereitungsdauer; ?>"> Minuten</p>
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
                                    echo 'selected'; ?>>
                                    Asiatisch</option>
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
                                    echo 'selected'; ?>>Vegan
                                </option>
                                <option value="Vegetarisch" <?php if ($ernaehrung == 'Vegetarisch')
                                    echo 'selected'; ?>>
                                    Vegetarisch</option>
                                <option value="Fleisch" <?php if ($ernaehrung == 'Fleisch')
                                    echo 'selected'; ?>>Fleisch
                                </option>
                                <option value="Fisch" <?php if ($ernaehrung == 'Fisch')
                                    echo 'selected'; ?>>Fisch
                                </option>
                            </select>
                        </p>
                        <p><i class="fa fa-cutlery"></i>
                            <select name="mahlzeitkategorie">
                                <option value="Frühstück" <?php if ($mahlzeitkategorie == 'Frühstück')
                                    echo 'selected'; ?>>Frühstück</option>
                                <option value="Mittagessen" <?php if ($mahlzeitkategorie == 'Mittagessen')
                                    echo 'selected'; ?>>Mittagessen
                                </option>
                                <option value="Abendessen" <?php if ($mahlzeitkategorie == 'Abendessen')
                                    echo 'selected'; ?>>Abendessen
                                </option>
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
            <div class="rezept-bottombox">
                <div class="rezept-zubereitung">
                    <h2>Zubereitung</h2>
                    <textarea name="instructions"><?php echo $zubereitung; ?></textarea>
                </div>
                <div class="rezept-zutaten">
                    <h2>Zutaten für <input type="number" name="portionen" value="<?php echo $portionen; ?>"> Portionen
                    </h2>
                    <ul>
                        <?php foreach ($ingredients as $index => $ingredient): ?>
                        <li>
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
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <button type="submit">Rezept aktualisieren</button>
            </div>

        </form>
    </div>

    <footer>
        <?php include '../../includes/footer.php'; ?>
    </footer>
</body>

</html>