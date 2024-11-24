<?php
session_start();
require_once('../../handlers/Bewertung/RezeptBewertenHandler.php');

// Sicherstellen, dass rezept_id per GET übergeben wurde
if (!isset($_GET['rezept_id'])) {
    die("Rezept-ID nicht angegeben.");
}

$rezept_id = intval($_GET['rezept_id']); // `rezept_id` aus GET

// Prüfen, ob alle Felder im Bewertungs-Formular ausgefüllt sind
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kommentar']) && isset($_POST['star'])) {

    // Ausgefüllte Felder in Variablen speichern
    $kommentar = htmlspecialchars(trim($_POST['kommentar']));
    $star = htmlspecialchars(trim($_POST['star']));
    $username = !empty($_SESSION['user']) ? $_SESSION['vorname'] : htmlspecialchars(trim($_POST['reg_vorname']));

    // Wenn also alle Daten vorhanden sind
    if ($rezept_id && $kommentar && $star && $username) {

        // RezeptBewertenHandler aufrufen
        $handler = new RezeptBewertenHandler();

        // Sichern der Daten ausführen
        if ($handler->saveBewertung($rezept_id, $username, $star, $kommentar)) {
            // Erfolgreiche Speicherung, Weiterleitung zur Rezeptdetailansicht
            header("Location: ../../pages/Rezeptverwaltung/RezeptDetailAnsicht.php?rezept_id=" . $rezept_id);
            exit; // Beendet das Skript nach der Weiterleitung
        } else {
            // Fehlermeldung ausgeben
            echo "<p>Fehler beim Speichern der Bewertung. Bitte versuchen Sie es erneut.</p>";
        }
    } else {
        echo "<p>Bitte fülle alle Felder aus!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <title>Rezept bewerten</title>
</head>

<?php
require_once('../../includes/header.php');
require_once('../../includes/navigation.php');
?>

<body>
    <div class="bewertung-container">
        <h2>Rezept bewerten</h2>
        <form method="POST" action="RezeptBewerten.php?rezept_id=<?php echo $rezept_id; ?>">
            <input type="hidden" name="rezept_id" value="<?php echo $rezept_id; ?>">

            <?php
            if (!empty($_SESSION['user'])) {
                echo '<label>Dein Name:</label>';
                echo '<p>' . htmlspecialchars($_SESSION['vorname']) . '</p>';
            } else {
                echo '<label for="reg_vorname">Dein Name:</label>';
                echo '<input type="text" id="reg_vorname" name="reg_vorname" required>';
            }
            ?>

            <label>Bewertung:</label>
            <div class="stars">
                <input class="star star-5" id="star-5" type="radio" name="star" value="5" required />5 Sterne
                <label class="star star-5" for="star-5"></label>
                <input class="star star-4" id="star-4" type="radio" name="star" value="4" />4 Sterne
                <label class="star star-4" for="star-4"></label>
                <input class="star star-3" id="star-3" type="radio" name="star" value="3" />3 Sterne
                <label class="star star-3" for="star-3"></label>
                <input class="star star-2" id="star-2" type="radio" name="star" value="2" />2 Sterne
                <label class="star star-2" for="star-2"></label>
                <input class="star star-1" id="star-1" type="radio" name="star" value="1" />1 Stern
                <label class="star star-1" for="star-1"></label>
            </div>

            <label for="kommentar">Kommentar:</label>
            <textarea name="kommentar" id="kommentar" required></textarea>

            <input type="submit" value="Bewertung absenden">
        </form>
    </div>

    <?php
    require_once('../../includes/footer.php');
    ?>
</body>

</html>