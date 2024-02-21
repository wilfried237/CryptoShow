<?php
    function connection_to_database(){
        $config = include("./config.php");
    
        $host = $config['host'];
        $user = $config['user'];
        $password = $config['password'];
        $database = $config['database'];
    
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
            } 
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            }
    }

    function connection_to_Sqlite_DB() {
        $database_file = "./DB/CryptoShowDB.db";
    
        // Create a new SQLite3 database connection
        $db = new SQLite3($database_file);
    
        if (!$db) {
            die("Failed to connect to SQLite database: " . $db->lastErrorMsg());
        }
    
        return $db;
    }
?>