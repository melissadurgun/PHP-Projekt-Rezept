<!-- die Index.php ist die Startseite, wird z.B. durch den Klick auf das bite-Logo aufgerufen. --> 
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <title>Leckere Rezepte</title>
</head>
<!-- die Seite setzt sich aus den folgenden vier Bestandteilen zusammen, in denen jeweils ein gewisser Teil implementiert ist --> 
<?php
require_once('../../includes/header.php'); 
require_once('../../includes/navigation.php');
require_once('../../pages/Rezeptverwaltung/RezeptOverview.php'); 
require_once('../../includes/footer.php');
?>

</html>