<?php
session_start();

// wenn Benutzer nicht eingeloggt --> weiterleiten an Login 
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\assets\styles\styles.css">
    <title>Recipe Form</title>
</head>

<?php
include '../../includes/header.php';
include '../../includes/navigation.php';
include '../../config/db.php';

$db = new DB('localhost', 'rezepte', 'root', '');

//Rezepte aus Datenbank abrufen 
$user_id = $_SESSION['user_id'];
// Rezepte des Benutzers abrufen
$rezepteQuery = $DB->prepare('SELECT titel FROM rezept r WHERE r.user_id = :user_id');
$rezepteQuery->execute([':user_id' => $user_id]);
$rezepte = $rezepteQuery->fetchAll(PDO::FETCH_ASSOC);

?>

<body>

    <!-- Benutzer-Willkommensnachricht und Menü -->
    <header>
        <h1>Willkommen, <?php echo htmlspecialchars($_SESSION['vorname']); ?>!</h1>
        <p>Schön, dass du wieder da bist.</p>
        <div class="button-container">
            <a href="profilbearbeiten.php" class="button">Persönliche Daten bearbeiten</a>
            <a href="kontakt.php" class="button">Kontaktiere uns</a>
            <a href="rezeptanlegen.php" class="button">Rezept anlegen</a>
            <a href="logout.php" class="button">Logout</a>
        </div>
    </header>


    <!-- Abschnitt für die Rezepte -->
    <section class="rezepte-section">
        <h2>Deine Rezepte</h2>
        <div class="rezepte-container">
            <?php foreach ($rezepte as $rezept): ?>
                <div class="rezept-kachel">
                    <!-- Überprüfen, ob ein Bild vorhanden ist, andernfalls Platzhalter anzeigen -->
                    <img src="<?php echo htmlspecialchars($rezept['bild'] ?: 'platzhalter.png'); ?>"
                        alt="<?php echo htmlspecialchars($rezept['titel']); ?>">
                    <h3><?php echo htmlspecialchars($rezept['titel']); ?></h3>
                </div>
            <?php endforeach; ?>
        </div>
    </section>


    <?php
    include '../../includes/footer.php';
    ?>
</body>

</html>