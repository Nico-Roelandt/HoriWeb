<?php
include("./PageParts/header.php");
//Récupération du post 
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isAdmin($_SESSION['ID'])) {
    //Récupére le post qui est dans POST
    $post = getPost($_GET['ID_post']);
    //Print le post avec la fonction du header
    $postHTML = generatePostHTML($post);
    ?>
    <div class="d-flex justify-content-center align-items-center">
        <?php echo $postHTML; ?>
    </div>
    <form action="/Horiweb/action/sensible.php" method="POST" style="margin: 250px;">
        <label for="sensible">Raison du masquage</label>
        <input type="text" id="sensible" name="sensible" value="Ce post est sensible." required>
        <input type="hidden" name="ID_post" value="<?php echo $post['ID_post']; ?>">
        <button type="submit" class="btn btn-primary">Envoyer</button>
        
    </form>
    <?php
}?>