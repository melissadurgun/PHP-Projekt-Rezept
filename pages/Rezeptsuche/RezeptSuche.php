<?php
/**
 * Die Seite wird bei der Rezeptsuche verwendet und bietet ein Freitextfeld sowie diverse Filtermöglichkeiten. 
 * 
 */


session_start(); 

require_once('../../includes/header.php'); 
require_once('../../includes/navigation.php'); 

require_once('../../handlers/Rezeptsuche/RezeptSucheHandler.php');

// Filter aus dem POST-Request abrufen 
$filters = [
    'ernaehrung' => $_POST['ernaehrung'] ?? null,
    'schwierigkeitsgrad' => $_POST['schwierigkeitsgrad'] ?? null,
    'mahlzeit' => $_POST['mahlzeit'] ?? null,
    'kueche' => $_POST['kueche'] ?? null,
    'search' => $_POST['search'] ?? null, // Nur POST für die Suche verwenden
];

// Rezepte mit dem Handler abrufen
$sucheHandler = new RezeptSucheHandler();
$rezepte = $sucheHandler->getRezepte($filters);
?>

<!-- HTML-Teil, um die Suchoptionen und Ergebnisse anzuzeigen --> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\assets\styles\styles.css">
    <title>Rezeptsuche</title>
    <script>
        // JavaScript für automatisches Neuladen bei Filteränderungen
        document.addEventListener("DOMContentLoaded", function() {
            const filters = document.querySelectorAll(".dropdown, .filter-title input");

            filters.forEach(filter => {
                filter.addEventListener("change", function() {
                    // Formular absenden bei jeder Änderung eines Filters
                    document.getElementById("filter-form").submit();
                });
            });
        });
    </script>
</head>

<body>

<!-- Suchleiste und Kategorien-->
<header>
    <div class="section1">
        <form id="filter-form" method="POST" action="">
            <div class="filter-title">
                <input type="text" name="search" placeholder="Deine Suche" value="<?php echo isset($filters['search']) ? htmlspecialchars($filters['search']) : ''; ?>">
            </div>

            <div class="dropdown-container">
                <div class="dropdown-group">
                    <label for="ernaehrung">Ernährung:</label>
                    <select id="ernaehrung" name="ernaehrung" class="dropdown">
                        <option value="">Kein Filter</option>
                        <option value="vegetarisch" <?php echo (isset($filters['ernaehrung']) && $filters['ernaehrung'] == 'vegetarisch') ? 'selected' : ''; ?>>Vegetarisch</option>
                        <option value="vegan" <?php echo (isset($filters['ernaehrung']) && $filters['ernaehrung'] == 'vegan') ? 'selected' : ''; ?>>Vegan</option>
                        <option value="fleisch" <?php echo (isset($filters['ernaehrung']) && $filters['ernaehrung'] == 'fleisch') ? 'selected' : ''; ?>>Fleisch</option>
                        <option value="fisch" <?php echo (isset($filters['ernaehrung']) && $filters['ernaehrung'] == 'fisch') ? 'selected' : ''; ?>>Fisch</option>
                    </select>
                </div>

                <div class="dropdown-group">
                    <label for="schwierigkeitsgrad">Schwierigkeitsgrad:</label>
                    <select id="schwierigkeitsgrad" name="schwierigkeitsgrad" class="dropdown">
                        <option value="">Kein Filter</option>
                        <option value="leicht" <?php echo (isset($filters['schwierigkeitsgrad']) && $filters['schwierigkeitsgrad'] == 'leicht') ? 'selected' : ''; ?>>Leicht</option>
                        <option value="mittel" <?php echo (isset($filters['schwierigkeitsgrad']) && $filters['schwierigkeitsgrad'] == 'mittel') ? 'selected' : ''; ?>>Mittel</option>
                        <option value="schwer" <?php echo (isset($filters['schwierigkeitsgrad']) && $filters['schwierigkeitsgrad'] == 'schwer') ? 'selected' : ''; ?>>Schwer</option>
                    </select>
                </div>

                <div class="dropdown-group">
                    <label for="mahlzeit">Mahlzeit:</label>
                    <select id="mahlzeit" name="mahlzeit" class="dropdown">
                        <option value="">Kein Filter</option>
                        <option value="fruehstueck" <?php echo (isset($filters['mahlzeit']) && $filters['mahlzeit'] == 'fruehstueck') ? 'selected' : ''; ?>>Frühstück</option>
                        <option value="mittagessen" <?php echo (isset($filters['mahlzeit']) && $filters['mahlzeit'] == 'mittagessen') ? 'selected' : ''; ?>>Mittagessen</option>
                        <option value="abendessen" <?php echo (isset($filters['mahlzeit']) && $filters['mahlzeit'] == 'abendessen') ? 'selected' : ''; ?>>Abendessen</option>
                        <option value="dessert" <?php echo (isset($filters['mahlzeit']) && $filters['mahlzeit'] == 'dessert') ? 'selected' : ''; ?>>Dessert</option>
                        <option value="snack" <?php echo (isset($filters['mahlzeit']) && $filters['mahlzeit'] == 'snack') ? 'selected' : ''; ?>>Snack</option>
                    </select>
                </div>

                <div class="dropdown-group">
                    <label for="kueche">Küche:</label>
                    <select id="kueche" name="kueche" class="dropdown">
                        <option value="">Kein Filter</option>
                        <option value="amerikanisch" <?php echo (isset($filters['kueche']) && $filters['kueche'] == 'amerikanisch') ? 'selected' : ''; ?>>Amerikanisch</option>
                        <option value="italienisch" <?php echo (isset($filters['kueche']) && $filters['kueche'] == 'italienisch') ? 'selected' : ''; ?>>Italienisch</option>
                        <option value="indisch" <?php echo (isset($filters['kueche']) && $filters['kueche'] == 'indisch') ? 'selected' : ''; ?>>Indisch</option>
                        <option value="asiatisch" <?php echo (isset($filters['kueche']) && $filters['kueche'] == 'asiatisch') ? 'selected' : ''; ?>>Asiatisch</option>
                        <option value="deutsch" <?php echo (isset($filters['kueche']) && $filters['kueche'] == 'deutsch') ? 'selected' : ''; ?>>Deutsch</option>
                    </select>
                </div>

            </div>
        </form>
    </div>
</header>

<!-- Anzeigen der Rezepte --> 
<section class="rezepte-section">
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
</section>

</body>
<?php
require_once('../../includes/footer.php'); 
?>
</html>
