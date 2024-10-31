<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>
<body>

<?php
session_start();
session_destroy();
 
echo '
<div class="login-container">
<h2>Du wurdest abgemeldet.</h2>
<a href="login.php">Melde dich hier erneut an!</a>
';
?>
    
</body>
<?php
include '../includes/footer.php';
?>
</html>