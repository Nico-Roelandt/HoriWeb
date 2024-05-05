


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
    <script src="/HoriWeb/Javascript/post.js"></script>
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
<?php if(isset($_SESSION['ID']) && $_SERVER['REQUEST_URI'] != '/HoriWeb/newPost.php'){?>
    <a class="btn btn-primary btn-lg float-right" href="newPost.php" role="button">Nouvelle publication</a>
<?php } else if(!isset($_SESSION['ID']) && $_SERVER['REQUEST_URI'] != '/HoriWeb/newAccount.php') { ?>
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
        <form action="./action/login.php" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Username :</label>
            <input type="username" class="form-control" id="username" name="username" autofocus required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Mot de passe :</label>
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
        <h5 class="modal-title" id="loginModalLabel">Commentaires</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer d-flex justify-content-center w-auto">
        <?php if(isset($_SESSION['ID'])){ ?>
        <form>
          <div class="mb-3">
            <label for="comment" class="form-label">Commentaire:</label>
            <input type="text" class="form-control" id="comment" name="comment" autofocus required>
          </div>
          <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
        <?php } else { ?>
          <p>Vous devez être connecté pour commenter</p>
        <?php } ?>
      </div>
    </div>
  </div>
</div>


<?php
// Définition de la fonction pour générer le code HTML d'un post
function generatePostHTML($rowpost) {
    // Extraction des données nécessaires de $rowpost
    $postID = $rowpost['ID_post'];
    $username = $rowpost['Username'];
    $creationDate = $rowpost['CreationDate'];
    $text = $rowpost['Text'];

    // Début du bloc HTML pour le post
    $html = '<div class="post" id="' . $postID . '">';
    $html .= '<h3>' . $username . '</h3>';
    $html .= '<div class="date">' . $creationDate . '</div>';
    $html .= '<p>' . $text . '</p>';
    $html .= '<div class="react" style="width: 500px; height: 80px;">';

    // Bouton de commentaire
    $html .= '<img class="btn postIcon" data-bs-toggle="modal" style="margin-left: 20px; margin-right: 20px;width: 70px; height: 70px;" data-bs-target="#comment" id="' . $postID . '" src="\HoriWeb\icon\comment.png"/>';

    // Bouton de like/dislike
    if (isset($_SESSION['ID']) && isLike($postID, $_SESSION['ID'])) {
        $html .= '<img class="btn postIcon" id="islike" style="margin-left: 20px; margin-right: 20px;width: 70px; height: 70px;" data-like-id="' . $postID . '" src="\HoriWeb\icon\islike.png"/>';
    } else {
        $html .= '<img class="btn postIcon" id="like" style="margin-left: 20px; margin-right: 20px;width: 70px; height: 70px;" data-like-id="' . $postID . '" src="\HoriWeb\icon\like.png"/>';
    }

    // Nombre de likes
    $html .= '<span class="numberOfLike" style="margin-left:20px; margin-bottom:auto; width: 200px; height: 40px; display: inline-flex; font-size: 20px;color: black;max-width: 100%;text-align: center;line-height: normal;">';
    $resultlike = getLike($postID);
    $html .= ($resultlike != null) ? $resultlike : '0';
    $html .= '</span>';

    // Fermeture du bloc HTML pour le post
    $html .= '</div></div>';

    // Retourner le code HTML généré
    return $html;
}
?>