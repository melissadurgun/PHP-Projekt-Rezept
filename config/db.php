<?php
/**
 * Die Klasse stellt Grundfunktionen bereit, um eine Datenbankverbindung aufzubauen. 
 * Beim Benutzen von Docker muss der Code für XAMPP, beim Benutzen von XAMPP der Code von Docker auskommentiert werden.
 */

class DB extends PDO
{
    public function __construct()
    {
        //---Code für XAMPP - auskommentieren, wenn Docker benutzt wird 
        $host = 'localhost';

        //---Code für Docker - auskommentieren, wenn XAMPP benutzt wird 
        // $host = "db";

        //---Gemeinsamer Code - nicht auskommentieren
        $dbname = 'rezepte';
        $user = 'root';
        $password = '';

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

        //Aufbau einer Connection 
        try {
            parent::__construct($dsn, $user, $password);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // eigene Methode, um eine Query auszuführen 
    public function executeQuery($sql, $params = [])
    {
        $stmt = $this->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
?>