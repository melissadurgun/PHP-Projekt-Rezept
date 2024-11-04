<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\assets\styles\styles.css">  
    <title>Logout</title>
</head>
<?php
include '../../includes/header.php';
include '../../includes/navigation.php';
?>
<body>

<?php
session_start();
$_SESSION=[]; 
session_destroy();
 
echo '
<div class="login-container">
<h2>Du willst uns schon verlassen?</h2>
<a href="login.php">Melde dich hier erneut an!</a>
';
?>
    
</body>
<?php
include '../../includes/footer.php';
?>
</html>