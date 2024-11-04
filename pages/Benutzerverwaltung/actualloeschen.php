<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<!-- Diese Page wird nach dem Bestätigen des Löschens der Benutzerdaten aufgerufen -->    

<?php
session_start(); 

//Prüfen ob Benutzter angemeldet 
if (!empty ($_SESSION['user'])){

    //Löschen der Benutzerdaten 
    $user = $_SESSION['user']; 
    deleteRezepte($user); 
    deleteUser($user); 

    //Session Variablen leeren und beenden
    $_SESSION = [];
    header("Location: ../public/index.php");
    session_destroy(); 

} else {
    //wenn Benutzer nicht angemeldet, dann zuerst Login, dann Daten löschen 
    $_SESSION['errorMessage'] = 'Melde dich an, um deine Benutzerdaten zu löschen.'; 
    header("Location: login.php");
    exit;
}

//Löscht alle Rezepte zu der angegebenen UserID
function deleteRezepte($userId){

    //Datenbankverbindung aufbauen
    require_once('../../config/db.php'); 
    $DB = new DB(); 

    $query = $DB->prepare("DELETE FROM rezept WHERE user_id = :user_id");
    $query->execute([':user_id' => $userId]);

}

//Löscht den User selber 
function deleteUser($userId){
    
    //Datenbankverbindung aufbauen
    require_once('../../config/db.php'); 
    $DB = new DB(); 

    $query = $DB->prepare("DELETE FROM benutzer WHERE user_id = :user_id");
    $query->execute([':user_id' => $userId]);
}

//TODO: Löschen aller Bewertungen zu den gelöschten Rezepten? 





?>


</body>
</html>