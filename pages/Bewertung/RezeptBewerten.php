<!-- Bereitstellen eines Formulars, um Rezept zu bewerten. Dazu auch verwenden des RezeptBewertenHandlers.php --> 

<?php
session_start();
require_once('../../handlers/Bewertung/RezeptBewertenHandler.php');

// Parameter rezept_id wird aus der Rezept-Detail-Seite übernommen --> so wird auch das richtige Rezept bewertet 
$rezept_id = isset($_POST['rezept_id']) ? intval($_POST['rezept_id']) : 0;

//Prüfen, ob alle Felder im Bewertungs-Formular ausgefüllt sind 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kommentar']) && isset($_POST['star'])) {

    //Ausgefüllte Felder in Variablen speichern 
    $kommentar = htmlspecialchars(trim($_POST['kommentar']));
    $star = htmlspecialchars(trim($_POST['star']));
    $username = !empty($_SESSION['user']) ? $_SESSION['vorname'] : htmlspecialchars(trim($_POST['reg_vorname']));

    //Wenn also alle Daten vorhanden 
    if ($rezept_id && $kommentar && $star && $username) {

        // dann rufe den RezeptBewertenHandler auf 
        $handler = new RezeptBewertenHandler();

        //Sichern der Daten ausführen
        if ($handler->saveBewertung($rezept_id, $username, $star, $kommentar)) {
            //wenn true zurückgegeben wird, dann weiterleiten auf die Rezept-Seite 
            header("Location: DetailBewertung.php?id=" . $rezept_id);
            exit;
        } else {
            //ansonsten ausgeben einer Fehlermeldung 
            echo "<p>Fehler beim Speichern der Bewertung. Bitte versuchen Sie es erneut.</p>";
        }
    } else {
        echo "<p>Bitte fülle alle Felder aus!</p>";
    }
}
?>

<!-- HTML zur Darstellung des Rezept-Bewerten-Formulars --> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <title>Rezept bewerten</title>
</head>

<?php
include '../../includes/header.php';
include '../../includes/navigation.php';
?>

<body>
<div class="container">
    <h2>Rezept bewerten</h2>
    <form method="POST" action="RezeptBewerten.php">
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
            <input class="star star-5" id="star-5" type="radio" name="star" value="5" required />
            <label class="star star-5" for="star-5"></label>
            <input class="star star-4" id="star-4" type="radio" name="star" value="4" />
            <label class="star star-4" for="star-4"></label>
            <input class="star star-3" id="star-3" type="radio" name="star" value="3" />
            <label class="star star-3" for="star-3"></label>
            <input class="star star-2" id="star-2" type="radio" name="star" value="2" />
            <label class="star star-2" for="star-2"></label>
            <input class="star star-1" id="star-1" type="radio" name="star" value="1" />
            <label class="star star-1" for="star-1"></label>
        </div>

        <label for="kommentar">Kommentar:</label>
        <textarea name="kommentar" id="kommentar" required></textarea>

        <input type="submit" value="Bewertung absenden">
    </form>
</div>

<?php
include '../../includes/footer.php';
?>
</body>
</html>
