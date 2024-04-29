


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
    <?php if($_SERVER['REQUEST_URI'] == '/HoriWeb/newAccount.php'){
      echo '<link rel="stylesheet" href="./style/newAccount.css">';
    } ?>
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
<?php if(isset($_COOKIE['TOKEN']) && $_SERVER['REQUEST_URI'] != '/HoriWeb/newPost.php'){ //PAS SUR DE LAISSER UN COOKIE ?>
    <a class="btn btn-primary btn-lg float-right" href="newPost.php" role="button">Nouvelle publication</a>
<?php } else { ?>
    <a class="btn btn-primary btn-lg float-right" data-bs-toggle="modal" data-bs-target="#loginModal">Se connecter</button>
    <?php if($_SERVER['REQUEST_URI'] != '/HoriWeb/newAccount.php'){ ?> 
      <a class="btn btn-primary btn-lg float-right" href="newAccount.php" role="button">Inscription</a>
    <?php } ?>
<?php } ?>
</div>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Comments</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="./login.php" method="post">
          <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail:</label>
            <input type="email" class="form-control" id="email" name="email" autofocus required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Mot de passe:</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
      </div>
      <div class="modal-footer">
        <div class="create-account">
          <p>Vous n'avez pas de compte ? <a href="./newAccount.php">Créer un compte</a></p>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="comment" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Connexion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer d-flex justify-content-center w-auto">
        <!--- ajoute de commentaire baser dans le footer --->
        <form>
          <div class="mb-3">
            <label for="comment" class="form-label">Commentaire:</label>
            <input type="text" class="form-control" id="comment" name="comment" autofocus required>
          </div>
          <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
      </div>
    </div>
  </div>
</div>