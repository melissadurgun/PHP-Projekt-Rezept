<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <title>Rezeptbewertungen</title>
</head>

<?php
include '../../includes/header.php';
include '../../includes/navigation.php';
?>

<body>
<div class="container">
    <h2>Rezeptbewertungen</h2>

    <?php
    // Datenbankverbindung aufbauen
    session_start(); 
    require_once('../../config/db.php');
    $DB = new DB();

    // NUR ZUM TESTEN 
    $rezept_id = 1; 

    // Durchschnittliche Bewertung für das Rezept berechnen
    list($durchschnitt, $totalBewertungen) = berechneDurchschnittlicheBewertung($DB, $rezept_id);
    ?>

    <div class="average-rating">
        <p>Durchschnittliche Bewertung: <strong><?php echo $durchschnitt; ?> / 5</strong> (<?php echo $totalBewertungen; ?> Bewertungen)</p>
        <a href="rating.php">Rezept bewerten</a>
    </div>

    <h3>Alle Bewertungen:</h3>

    <?php
    // Abrufen aller Bewertungen für das Rezept, sortieren nach neuste zuerst 
    $query = "SELECT username, anzahlsterne, kommentar FROM bewertung WHERE rezept_id = :rezept_id ORDER BY bewertung_id DESC";
    $stmt = $DB->prepare($query);
    $stmt->execute([':rezept_id' => $rezept_id]);
    $bewertungen = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($bewertungen) {
        // Bewertungen anzeigen
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



    // Funktion zur Berechnung der durchschnittlichen Bewertung
    function berechneDurchschnittlicheBewertung($db, $rezept_id) {
        $avgQuery = "SELECT AVG(anzahlsterne) as durchschnitt, COUNT(*) as total FROM bewertung WHERE rezept_id = :rezept_id";
        $avgStmt = $db->prepare($avgQuery);
        $avgStmt->execute([':rezept_id' => $rezept_id]);
        $avgResult = $avgStmt->fetch(PDO::FETCH_ASSOC);
        
        $durchschnitt = $avgResult['durchschnitt'] ? round($avgResult['durchschnitt'], 1) : 0;
        $totalBewertungen = $avgResult['total'];
        
        return [$durchschnitt, $totalBewertungen];
    }
    ?>

</div>

<?php
include '../../includes/footer.php';
?>
</body>
</html>
