<?php
session_start();
require_once("../../handlers/Rezeptverwaltung/RezeptDetailansichtHandler.php");

// Initialize the handler
$rezeptDetail = new RezeptDetailHandler();

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
        <div class="rezept-topbox">
            <div class="rezept-bild">
                <img src="<?php echo $bild_url; ?>" alt="Bild von <?php echo $titel; ?>">
            </div>
            <div class="rezept-info">
                <h1><?php echo $titel; ?></h1>
                <p>Rezept von <?php echo $username; ?></p>
                <div class="icon-container1">
                    <p><i class="fa fa-clock-o"></i> <?php echo $zubereitungsdauer; ?> Minuten</p>
                    <p><i class="fa fa-signal"></i> <?php echo $schwierigkeitsgrad; ?></p>
                </div>
                <div class="icon-container2">
                    <p><i class="fa fa-globe"></i> <?php echo $kueche; ?></p>
                    <p><i class="fa fa-leaf"></i> <?php echo $ernaehrung; ?></p>
                    <p><i class='fa fa-cutlery'></i> <?php echo $mahlzeitkategorie; ?></p>
                </div>
            </div>
        </div>
        <div class="rezept-bottombox">
            <div class="rezept-zubereitung">
                <h2>Zubereitung</h2>
                <p><?php echo $zubereitung; ?></p>
            </div>
            <div class="rezept-zutaten">
                <h2>Zutaten für <?php echo $portionen; ?> Portionen</h2>
                <ul>
                    <?php foreach ($ingredients as $ingredient): ?>
                    <li><?php echo htmlspecialchars($ingredient['menge']) . " " . htmlspecialchars($ingredient['einheit']) . " " . htmlspecialchars($ingredient['name']); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <footer>
        <?php include '../../includes/footer.php'; ?>
    </footer>
</body>

</html>