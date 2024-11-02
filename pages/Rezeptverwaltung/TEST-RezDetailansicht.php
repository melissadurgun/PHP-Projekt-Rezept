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
                <p><i class="fas fa-clock"></i> <?php echo $zubereitungsdauer; ?> Minuten</p>
                <p><i class="fas fa-tachometer-alt"></i> <?php echo $schwierigkeitsgrad; ?></p>
                <p><i class="fas fa-utensils"></i> <?php echo $kueche; ?></p>
                <p><i class="fas fa-leaf"></i> <?php echo $ernaehrung; ?></p>
                <p><i class="fas fa-concierge-bell"></i> <?php echo $mahlzeitkategorie; ?></p>
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

</body>

</html>