<?php
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
        <div class="rezepte-container">
            <?php if (empty($rezepte)): ?>
            <p>Keine Rezepte gefunden.</p>

            <?php else: ?>
            <?php foreach ($rezepte as $rezept): ?>

            <div class="rezept-kachel">
                <img src="../../assets/images/<?php echo htmlspecialchars($rezept['bild_url']); ?>"
                    alt="<?php echo htmlspecialchars($rezept['titel']); ?>" class="recipe-image">
                <h3><a
                        href="../../pages/Rezeptverwaltung/RezeptDetailansicht.php?rezept_id=<?php echo htmlspecialchars($rezept['rezept_id']); ?>"><?php echo htmlspecialchars($rezept['titel']); ?></a>
                </h3>
                <div class="link-container-rezepte">
                    <span class="meta-item">
                        <i class="fa fa-clock-o"></i> <?php echo htmlspecialchars($rezept['zubereitungsdauer']); ?>
                        min
                        <!-- Placeholder for actual time -->
                    </span>
                    <span class="meta-item">
                        <i class="fa fa-signal"></i> <?php echo htmlspecialchars($rezept['schwierigkeitsgrad']); ?>
                        <!-- Placeholder for actual difficulty -->
                    </span>
                    <span class="meta-item">
                        <i class="fa fa-leaf"></i> <?php echo htmlspecialchars($rezept['ernaehrung']); ?>
                        <!-- Placeholder for actual dietary info -->
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>