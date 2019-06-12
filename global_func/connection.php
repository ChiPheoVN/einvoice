<?php
if(isset($database_config)){
    $servername = $database_config['servername'];
    $username   = $database_config['username'];
    $password   = $database_config['password'];
    $db_name    = $database_config['db_name'];
}

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
?>