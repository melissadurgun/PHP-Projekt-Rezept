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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="..\..\styles\styles.css">
    <link rel="stylesheet" href="styles.css">
    <title>Leckere Rezepte</title>

</head>

<?php
include '../../includes/header.php';
?>

<body>
 
<?php
//Inizialisierung 
require_once('functionals.php'); 
$DSN = 'mysql:host=db;dbname=Rezepte';

//Datenbankverbindung aufbauen 
try { 
    $DB = new Db($DSN, 'root', ''); 
} catch (PDOException $e) { 
    exit('Connect failed: '.$e->getMessage()); 
} 

//Rezepte aus Datenbank abrufen 
$user_id = $_SESSION['user_id']; 
// Rezepte des Benutzers abrufen
$rezepteQuery = $DB->prepare('SELECT titel FROM rezept WHERE ersteller_id = :user_id');
$rezepteQuery->execute([':user_id' => $user_id]);
$rezepte = $rezepteQuery->fetchAll(PDO::FETCH_ASSOC);

?>

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
                <img src="<?php echo htmlspecialchars($rezept['bild'] ?: 'platzhalter.png'); ?>" alt="<?php echo htmlspecialchars($rezept['titel']); ?>">
                <h3><?php echo htmlspecialchars($rezept['titel']); ?></h3>
            </div>
        <?php endforeach; ?>
    </div>
</section>


    
</body>
</html>