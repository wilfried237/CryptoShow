<?php 
$config = include("./config.php");

$host = $config['host'];
$user = $config['user'];
$password = $config['password'];
$database = $config['database'];
try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query('SELECT * FROM members');
    while ($row = $stmt->fetch())
    {
        print_r($row);
        foreach ($row as $key => $value) {
            echo "$key: $value <br>";
        }
        echo $row['PN'];
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}



?>