<?php
session_start();

// wenn Benutzer nicht eingeloggt --> weiterleiten an Login 
if (!isset($_SESSION['user'])) {
    header("Location: Login.php");
    exit;
}

//Requires
require_once('../../config/db.php');
require_once('../../handlers/Rezeptverwaltung/RezeptLoeschenHandler.php');

//Datenbankverbindung aufbauen
$DB = new DB();

//Rezepte aus Datenbank abrufen 
$user_id = $_SESSION['user_id'];
// Rezepte des Benutzers abrufen, inklusive rezept_id
$rezepteQuery = $DB->prepare('SELECT rezept_id, titel, bild FROM rezept WHERE user_id = :user_id ORDER BY rezept_id DESC');
$rezepteQuery->execute([':user_id' => $user_id]);
$rezepte = $rezepteQuery->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\assets\styles\styles.css">
    <title>Benutzerseite</title>
</head>

<?php
include '../../includes/header.php';
include '../../includes/navigation.php';
?>

<body>

    <!-- Benutzer-Willkommensnachricht und Menü -->
    <header>
        <div class="section1">
            <div class="willkommen">
                <h1>Willkommen, <?php echo htmlspecialchars($_SESSION['vorname']); ?>!</h1>
                <p>Schön, dass du wieder da bist.</p>
            </div>
            <div class="button-container">
                <a href="../Benutzerverwaltung/ProfilBearbeiten.php" class="button">Persönliche Daten bearbeiten</a>
                <a href="../Benutzerverwaltung/ProfilLoeschen.php" class="button">Profil löschen</a>
                <a href="../Benutzerverwaltung/Logout.php" class="button">Logout</a>
            </div>
        </div>
    </header>

    <!-- Abschnitt für die Rezepte -->
    <section class="rezepte-section">
        <h2>Deine Rezepte</h2>

        <!-- Button für neues Rezept hinzufügen -->
        <div class="button-container-rezepte">
            <a href="..\..\pages\Rezeptverwaltung\RezeptHinzufügen.php" class="button"> + Neues Rezept hinzufügen</a>
        </div>

        <!-- Anzeigen der Rezepte des Benutzers -->
        <div class="rezepte-container">
    <?php foreach ($rezepte as $rezept): ?>
        <div class="rezept-kachel">
            <!-- Überprüfen, ob ein Bild vorhanden ist, andernfalls Platzhalter anzeigen -->
            <?php if (!empty($rezept['bild'])): ?>
                <img 
                    src="data:image/jpeg;base64,<?= base64_encode($rezept['bild']); ?>" 
                    alt="<?= htmlspecialchars($rezept['titel']); ?>" 
                    class="recipe-image">
            <?php else: ?>
                <img 
                    src="../../assets/images/platzhalter.png" 
                    alt="Platzhalterbild" 
                    class="recipe-image">
            <?php endif; ?>

            <h3>
                <a href="../../pages/Rezeptverwaltung/RezeptDetailansicht.php?rezept_id=<?= $rezept['rezept_id']; ?>">
                    <?= htmlspecialchars($rezept['titel']); ?>
                </a>
            </h3>

            <div class="link-container-rezepte">
                <!-- Löschen-Link mit JavaScript-Bestätigungsdialog -->
                <a href="../../handlers/Rezeptverwaltung/RezeptLoeschenHandler.php?delete_id=<?= $rezept['rezept_id']; ?>"
                   onclick="return confirm('Möchten Sie dieses Rezept wirklich löschen?');">
                    <i class="fa fa-trash-o"> <span> Löschen</span></i>
                </a>
                <a href="../../pages/Rezeptverwaltung/RezeptBearbeiten.php?rezept_id=<?= $rezept['rezept_id']; ?>">
                    <i class="fa fa-edit"><span>Bearbeiten</span></i>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

    </section>

</body>

<?php
include '../../includes/footer.php';
?>

</html>