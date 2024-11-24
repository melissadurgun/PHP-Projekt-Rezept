<?php

// Überprüfen, ob die Rezept-ID über GET verfügbar ist
if (!isset($_GET['rezept_id'])) {
    die("Ungültige Anfrage. Keine Rezept-ID gefunden.");
}

$rezept_id = intval($_GET['rezept_id']); // Rezept-ID aus GET erhalten

require_once('../../handlers/Bewertung/BewertungenAnzeigenHandler.php');
$handler = new BewertungenAnzeigenHandler();

// Durchschnittliche Bewertung und Anzahl der Bewertungen für das spezifische Rezept abrufen
list($durchschnitt, $totalBewertungen) = $handler->berechneDurchschnittlicheBewertung($rezept_id);
?>

<div class="bewertung-container">
    <h2>Rezeptbewertungen</h2>

    <div class="average-rating">
        <p>Durchschnittliche Bewertung: <strong><?php echo $durchschnitt; ?> / 5</strong> (<?php echo $totalBewertungen; ?> Bewertungen)</p>
    </div>

    <h3>Alle Bewertungen:</h3>

    <?php
    // Alle Bewertungen für das spezifische Rezept abrufen
    $bewertungen = $handler->getBewertungen($rezept_id);

    if ($bewertungen) {
        foreach ($bewertungen as $bewertung) {
            echo "<hr><div class='review'>";
            echo "<p><strong>Name:</strong> " . htmlspecialchars($bewertung['username']) . "</p>";
            echo "<p><strong>Sterne:</strong> " . htmlspecialchars($bewertung['anzahlsterne']) . " / 5</p>";
            echo "<p><strong>Kommentar:</strong> " . htmlspecialchars($bewertung['kommentar']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>Es liegen noch keine Bewertungen für dieses Rezept vor.</p>";
    }
    ?>
</div>
