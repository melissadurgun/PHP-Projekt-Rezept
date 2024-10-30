<?php
class DB extends PDO {
    // Constructor to initialize the database connection
    public function __construct($host = 'localhost', $dbname = 'rezepte', $user = 'root', $password = '') {
        // DSN (Data Source Name) for the database connection
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

        try {
            // Call the PDO constructor to establish the connection
            parent::__construct($dsn, $user, $password);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // Custom query method to avoid conflict with PDO::query
    public function executeQuery($sql, $params = []) {
        $stmt = $this->prepare($sql); // Prepare the SQL statement
        $stmt->execute($params);      // Execute with parameters
        return $stmt;                 // Return the statement object for further use
    }
}
?>