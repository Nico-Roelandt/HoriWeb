


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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Accueil</title> 
    <?php //Change title system ?>
    <link rel="stylesheet" href="./style/sidebar.css">
    <link rel="stylesheet" href="./style/post.css">
    <link rel="stylesheet" href="./style/newPost.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../HoriWeb/JavaScript/login.js"></script>
  </head>
<body>


<div class="sidebar">
    <a href="/HoriWeb/">
      <img class="logo" src="\HoriWeb\icon\home.png"/>
    </a>
    <a href="/HoriWeb/trend.php">
      <img class="logo" src="\HoriWeb\icon\trend.png"/>
    </a>
    <a href="/HoriWeb/user.php">
      <img class="logo" src="\HoriWeb\icon\user.png"/>
    </a>
    <a href="#"></a>
    <a href="#"></a>
</div>
<div class="button">
<?php if(isset($_COOKIE['TOKEN']) && $_SERVER['REQUEST_URI'] != '/HoriWeb/newPost.php'){ //PAS SUR DE LAISSER UN COOKIE ?>
    <a class="btn btn-primary btn-lg float-right" href="newPost.php" role="button">Nouvelle publication</a>
<?php } else { ?>
    <a class="btn btn-primary btn-lg float-right" id="popup-button" role="button" >Se connecter</a>
    <a class="btn btn-primary btn-lg float-right" href="newAccount.php" role="button">Inscription</a>

  <?php } ?>
</div>


<div class="popup">
    <div class="popup-content">
    <form action="./login.php" method="post">
        <div class="container">
        <h2>Connexion</h2> 
        <label for="username">Adresse e-mail:</label>		
        <input autofocus type="text" name="mail">
        <label for="password">Mot de passe:</label>
        <input type="password" name="password">
        <input type="submit" value="Se connecter">
        <div class="create-account">
            <p>Vous n'avez pas de compte ? <a href="./newAccount.php">Créer un compte</a></p>
        </div>
</body>
    </div>
</div>

<style>
  .popup {
      display: none;
      z-index: 2000;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: white;
      padding: 20px;
      border-radius: 5px;
  }

  .popup-content {
      width: 300px;
      margin: 0 auto;
  }
</style>





<style>
    body {
      font-family: Arial, sans-serif;
      
    }
    .container {
      max-width: 400px;
      margin: 100px auto;
      padding: 20px;
    }
    h2 {
      text-align: center;
    }
    input[type="text"],
    input[type="password"],
    input[type="submit"] {  
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      box-sizing: border-box;
      
    }
    input[type="submit"] {
      background-color: blue;
      color: white;
      
    }
    input[type="submit"]:hover {
      background-color: blue;
    }
  </style>





  