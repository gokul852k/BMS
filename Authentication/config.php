<?php
// MySQL server credentials
// $servername = "localhost";
// $username = "u632564128_authentication";
// $password = "e~/]JD/4L";
// $database = "u632564128_authentication";

$servername = "localhost";
$username = "root";
$password = "";
$database = "authentication";

try {
    // Create a PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    // Connection failed
    echo "Connection failed: " . $e->getMessage();
}