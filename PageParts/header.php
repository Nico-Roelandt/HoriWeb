<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title> 
    <?php //Change title system ?>
    <link rel="stylesheet" href="./style/sidebar.css">
    <link rel="stylesheet" href="./style/post.css">

</head>
<body>

<div class="sidebar">
    <a href="/WE4A_project/HoriWeb/">
      <img class="logo" src="\WE4A_project\HoriWeb\icon\home.png"/>
    </a>
    <a href="/WE4A_project/HoriWeb/trend.php">
      <img class="logo" src="\WE4A_project\HoriWeb\icon\trend.png"/>
    </a>
    <a href="#"></a>
    <a href="#"></a>
</div>
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