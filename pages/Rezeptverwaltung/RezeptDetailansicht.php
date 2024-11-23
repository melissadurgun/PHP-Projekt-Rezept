<?php
session_start();
require_once("../../handlers/Rezeptverwaltung/RezeptDetailansichtHandler.php");

// Rezept Handler initialisieren
$rezeptDetail = new RezeptDetailHandler();

// Rezept-ID aus der URL abrufen
$rezept_id = $_GET['rezept_id'] ?? null;
if (!$rezept_id) {
    die("Rezept-ID nicht angegeben.");
}

$data = $rezeptDetail->getRecipeDetail($rezept_id);

if (!$data) {
    die("Fehler beim Laden der Rezeptdetails.");
}

// Rezeptdaten extrahieren
$recipe = $data['recipe'];
$ingredients = $data['ingredients'];

// Prüfen, ob der eingeloggte Benutzer der Besitzer des Rezepts ist
if (isset($_SESSION['user_id'])){
    $isOwner = ($recipe['user_id'] == $_SESSION['user_id']);
} else {
    $isOwner = false; 
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
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titel; ?> - Rezeptdetails</title>
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <!-- <link rel="stylesheet" href="../../assets/styles/RezDetailStyles.css"> -->
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
                <br><br>
                <div class="icon-container1">
                    <p><i class="fa fa-clock-o"></i> <?php echo $zubereitungsdauer; ?> Minuten</p>
                    <p><i class="fa fa-signal"></i> <?php echo $schwierigkeitsgrad; ?></p>
                </div>
                <div class="icon-container2">
                    <p><i class="fa fa-globe"></i> <?php echo $kueche; ?></p>
                    <p><i class="fa fa-leaf"></i> <?php echo $ernaehrung; ?></p>
                    <p><i class="fa fa-cutlery"></i> <?php echo $mahlzeitkategorie; ?></p>
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
                    <li><?php echo htmlspecialchars($ingredient['menge']) . " " . htmlspecialchars($ingredient['einheit']) . " " . htmlspecialchars($ingredient['name']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Display "Rezept bearbeiten" und "Rezept löschen" button only if the user is the recipe owner -->
        <?php if ($isOwner): ?>
        <div class="link-container-rezepte">
                    <!-- Löschen-Link mit JavaScript-Bestätigungsdialog -->
                    <a href="../../handlers/Rezeptverwaltung/RezeptLoeschenHandler.php?delete_id=<?php echo $rezept_id; ?>"
                        onclick="return confirm('Möchten Sie dieses Rezept wirklich löschen?');">
                        <i class="fa fa-trash-o"> <span> Löschen</span></i>
                    </a>
                    <a
                        href="../../pages/Rezeptverwaltung/RezeptBearbeiten.php?rezept_id=<?php echo $rezept_id; ?>">
                        <i class="fa fa-edit"><span>Bearbeiten</span></i>
                    </a>
                </div>
        
        <?php endif; ?>
    </div>

    <!-- Rezept bewerten Link -->
    <div class="container">
        <h2>Rezeptbewertungen</h2>
        <!-- "Rezept bewerten"-Button als Link zu RezeptBewerten.php mit GET über die URL -->
        <a href="../../pages/Bewertung/RezeptBewerten.php?rezept_id=<?php echo $rezept_id; ?>" class="button">Rezept bewerten</a>
    </div>

    <!-- Bewertungen Ansehen -->
    <?php
    // BewertungenAnzeigen.php einbinden
    require_once('../../pages/Bewertung/BewertungenAnzeigen.php');
    ?>

    <footer>
        <?php include '../../includes/footer.php'; ?>
    </footer>
</body>
</html>
