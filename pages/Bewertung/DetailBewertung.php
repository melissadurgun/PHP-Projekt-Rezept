<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once('../../handlers/Bewertung/DetailBewHandler.php');
require_once('../../includes/header.php');
require_once('../../includes/navigation.php');

//ACHTUNG! hier 6 durch 0 tauschen 
$rezept_id = isset($_GET['id']) ? intval($_GET['id']) : 6;

$handler = new RezeptDetailansichtHandler();
$rezept = $handler->getRezeptDetails($rezept_id);
$zutaten = $handler->getZutaten($rezept_id);

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <title><?php echo htmlspecialchars($rezept['titel']); ?> - Rezept Detailansicht</title>
</head>

<body>

    <div class="bewertung-container">
        <header>
            <h1><?php echo htmlspecialchars($rezept['titel']); ?></h1>
        </header>

        <section class="recipe-detail">
            <div class="recipe-image">
                <img src="<?php echo htmlspecialchars($rezept['bild_url'] ?: 'platzhalter.png'); ?>"
                    alt="<?php echo htmlspecialchars($rezept['titel']); ?>">
            </div>

            <div class="recipe-info">
                <div><strong>Zubereitungsdauer:</strong> <?php echo htmlspecialchars($rezept['zubereitungsdauer']); ?>
                    Minuten</div>
                <div><strong>Portionen:</strong> <?php echo htmlspecialchars($rezept['portionen']); ?></div>
                <div><strong>Schwierigkeitsgrad:</strong> <?php echo htmlspecialchars($rezept['schwierigkeitsgrad']); ?>
                </div>
                <div><strong>Ernährung:</strong> <?php echo htmlspecialchars($rezept['ernaehrung']); ?></div>
                <div><strong>Küche:</strong> <?php echo htmlspecialchars($rezept['kueche']); ?></div>
            </div>

            <section class="recipe-detail">
                <div class="recipe-image">
                    <img src="<?php echo htmlspecialchars($rezept['bild_url'] ?: 'platzhalter.png'); ?>"
                        alt="<?php echo htmlspecialchars($rezept['titel']); ?>">
                </div>

                <div class="recipe-info">
                    <div><strong>Zubereitungsdauer:</strong>
                        <?php echo htmlspecialchars($rezept['zubereitungsdauer']); ?>
                        Minuten</div>
                    <div><strong>Portionen:</strong> <?php echo htmlspecialchars($rezept['portionen']); ?></div>
                    <div><strong>Schwierigkeitsgrad:</strong>
                        <?php echo htmlspecialchars($rezept['schwierigkeitsgrad']); ?>
                    </div>
                    <div><strong>Ernährung:</strong> <?php echo htmlspecialchars($rezept['ernaehrung']); ?></div>
                    <div><strong>Küche:</strong> <?php echo htmlspecialchars($rezept['kueche']); ?></div>
                </div>

                <h3>Zutaten</h3>
                <div class="zutaten-list">
                    <?php foreach ($zutaten as $zutat): ?>
                        <p><?php echo htmlspecialchars($zutat['menge']) . ' ' . htmlspecialchars($zutat['einheit']) . ' ' . htmlspecialchars($zutat['name']); ?>
                        </p>
                    <?php endforeach; ?>
                </div>

                <h3>Zubereitung</h3>
                <div class="zubereitung">
                    <p><?php echo nl2br(htmlspecialchars($rezept['zubereitung'])); ?></p>
                </div>
            </section>

            <!-- Einfügen der BewertungenAnzeigen.php für Bewertungen zum aktuellen Rezept -->
            <section class="bewertungen">
                <?php
                // Übergabe der rezept_id an BewertungenAnzeigen.php
                $rezept_id = $rezept['rezept_id'];
                require_once('../../pages/Bewertung/BewertungenAnzeigen.php');
                ?>
            </section>
    </div>

    <?php
    require_once('../../includes/footer.php');
    ?>

</body>

</html>