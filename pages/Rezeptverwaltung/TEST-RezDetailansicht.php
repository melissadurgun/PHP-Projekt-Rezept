<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titel; ?> - Rezeptdetails</title>
    <!-- <link rel="stylesheet" href="../../assets/styles/RezeptCreate.css"> -->
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <link rel="stylesheet" href="../../assets/styles/RezDetailStyles.css">
</head>
<header>
    <?php
    include '../../includes/header.php';
    include '../../includes/navigation.php';
    ?>
</header>

<body>

    <div class="rezept-detail-container">

        <div class="rezept-topbox">
            <!-- Recipe Image -->
            <div class="rezept-bild">
                <img src="<?php echo $bild_url; ?>" alt="Bild von <?php echo $titel; ?>">
            </div>
            <!-- Recipe Information -->
            <div class="rezept-info">
                <h1><?php echo $titel; ?></h1>
                <p>Rezept von <?php echo $username; ?></p>
                <div class="icon-container1">
                <p><i class="fa fa-clock-o"></i><?php echo $zubereitungsdauer; ?> Minuten</p>
                <p><i class="fa fa-signal"></i> <?php echo $schwierigkeitsgrad; ?></p>
                </div>
                <div class="icon-container2">
                <p><i class="fa fa-globe"></i> <?php echo $kueche; ?></p>
                <p><i class="fa fa-leaf"></i> <?php echo $ernaehrung; ?></p>
                <p><i class='fa fa-cutlery'></i> <?php echo $mahlzeitkategorie; ?></p>
                </div>
            </div>
        </div>
        <div class="rezept-bottombox">
            <!-- Instructions -->
            <div class="rezept-zubereitung">
                <h2>Zubereitung</h2>
                <p><?php echo $zubereitung; ?></p>
            </div>

            <!-- Ingredients List -->
            <div class="rezept-zutaten">
                <h2>Zutaten für <?php echo $portionen; ?> Portionen</h2>
                <ul>
                    <?php foreach ($zutaten as $zutat): ?>
                    <li><?php echo htmlspecialchars($zutat['menge']) . " " . htmlspecialchars($zutat['einheit']) . " " . htmlspecialchars($zutat['name']); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php
include '../../includes/footer.php';
?>
</body>

</html>