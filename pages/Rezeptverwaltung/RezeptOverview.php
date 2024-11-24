<?php
/**
 * RezeptOverview, um alle Rezepte anzuzeigen (wird z.B. auf der Startseite verwendet). 
 * 
 */


require_once('../../handlers/Rezeptsuche/RezeptSucheHandler.php');

// Initialisieren des Suchhandlers
$sucheHandler = new RezeptSucheHandler();

// Filterkriterien abrufen (von der Suchleiste oder der Navigation)
$filters = [
    'zubereitungsdauer' => $_POST['zubereitungsdauer'] ?? 'keinFilter',
    'ernaehrung' => $_POST['ernaehrung'] ?? 'keinFilter',
    'schwierigkeitsgrad' => $_POST['schwierigkeitsgrad'] ?? 'keinFilter',
    'mahlzeit' => $_POST['mahlzeit'] ?? 'keinFilter',
    'kueche' => $_POST['kueche'] ?? 'keinFilter',
    'search' => $_POST['search'] ?? ''
];

// Prüfen, ob Filter angewendet wurden
if ($sucheHandler->hasFilters($filters)) {
    // Filter sind gesetzt, gefilterte Rezepte abrufen
    $rezepte = $sucheHandler->getRezepte($filters);
} else {
    // Keine Filter gesetzt, alle Rezepte abrufen
    $rezepte = $sucheHandler->getRezepte([]);
}
?>

<!--HTML Teil --> 
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <title>Rezept Übersicht</title>
</head>

<body>
    <main>
        <!-- Section, um die Rezeote anzuzeigen --> 
        <div class="rezepte-section">
            <div class="rezepte-container">
                <?php if (empty($rezepte)): ?>
                <p>Keine Rezepte gefunden.</p>
                <?php else: ?>
                <?php foreach ($rezepte as $rezept): ?>
                <div class="rezept-kachel">
    <?php if (!empty($rezept['bild'])): ?>
        <img src="data:image/jpeg;base64,<?= base64_encode($rezept['bild']); ?>"
            alt="<?= htmlspecialchars($rezept['titel']); ?>" class="recipe-image">
    <?php else: ?>
        <img src="../../assets/images/ImagePlaceholder.jpg"
            alt="<?= htmlspecialchars($rezept['titel']); ?>" class="recipe-image">
    <?php endif; ?>
    <h3>
        <a href="../../pages/Rezeptverwaltung/RezeptDetailansicht.php?rezept_id=<?= htmlspecialchars($rezept['rezept_id']); ?>">
            <?= htmlspecialchars($rezept['titel']); ?>
        </a>
    </h3>
    <div class="link-container-rezepte">
        <span class="meta-item">
            <i class="fa fa-clock-o"></i> <?= htmlspecialchars($rezept['zubereitungsdauer']); ?> min
        </span>
        <span class="meta-item">
            <i class="fa fa-signal"></i> <?= htmlspecialchars($rezept['schwierigkeitsgrad']); ?>
        </span>
        <span class="meta-item">
            <i class="fa fa-leaf"></i> <?= htmlspecialchars($rezept['ernaehrung']); ?>
        </span>
    </div>
</div>

                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>

</html>
