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
?>