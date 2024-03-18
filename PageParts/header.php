<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">
<title>HoriWeb</title>
<link rel="stylesheet" href="./Styles/style.css">
</head>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "horiweb";
    global $conn;
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>