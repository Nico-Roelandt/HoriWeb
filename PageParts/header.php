


<?php
require_once("dbConnect.php");

  if(!isset($_SESSION)){
    session_start();
  }







?>





<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Accueil</title> 
    <?php //Change title system ?>
    <link rel="stylesheet" href="./style/sidebar.css">
    <link rel="stylesheet" href="./style/post.css">
    <link rel="stylesheet" href="./style/newPost.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </head>
<body>


<div class="sidebar">
    <a href="/HoriWeb/">
      <img class="logo" src="\HoriWeb\icon\home.png"/>
    </a>
    <a href="/HoriWeb/trend.php">
      <img class="logo" src="\HoriWeb\icon\trend.png"/>
    </a>
    <a href="#"></a>
    <a href="#"></a>
</div>
<div class="button">
<?php if(isset($_COOKIE['TOKEN']) && $_SERVER['REQUEST_URI'] != '/HoriWeb/newPost.php'){ ?>
    <a class="btn btn-primary btn-lg float-right" href="newPost.php" role="button">Nouvelle publication</a>
<?php } else { ?>
    <a class="btn btn-primary btn-lg float-right" href="login.php" role="button">Se connecter</a>
    <a class="btn btn-primary btn-lg float-right" href="newAccount.php" role="button">Inscription</a>

  <?php } ?>
</div>
