<?php

// $servername1 = "localhost";
// $username1 = "u632564128_bms";
// $password1 = "[FcxD0v4";
// $database1 = "u632564128_bms";

$servername1 = "localhost";
$username1 = "root";
$password1 = "";
$database1 = "bms";

try {
    // Create a PDO instance
    $bmsDB = new PDO("mysql:host=$servername1;dbname=$database1", $username1, $password1);
    
    // Set PDO error mode to exception
    $bmsDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    // Connection failed
    echo "Connection failed: " . $e->getMessage();
}

// $servername2 = "localhost";
// $username2 = "u632564128_master_admin";
// $password2 = "UVyW+Wp/5";
// $database2 = "u632564128_master_admin";

$servername2 = "localhost";
$username2 = "root";
$password2 = "";
$database2 = "master_admin";

try {
    // Create a PDO instance
    $masterAdminDB = new PDO("mysql:host=$servername2;dbname=$database2", $username2, $password2);
    
    // Set PDO error mode to exception
    $masterAdminDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    // Connection failed
    echo "Connection failed: " . $e->getMessage();
}

// $servername3 = "localhost";
// $username3 = "u632564128_authentication";
// $password3 = "e~/]JD/4L";
// $database3 = "u632564128_authentication";

$servername3 = "localhost";
$username3 = "root";
$password3 = "";
$database3 = "authentication";

try {
    // Create a PDO instance
    $authenticationDB = new PDO("mysql:host=$servername3;dbname=$database3", $username3, $password3);
    
    // Set PDO error mode to exception
    $authenticationDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    // Connection failed
    echo "Connection failed: " . $e->getMessage();
}
