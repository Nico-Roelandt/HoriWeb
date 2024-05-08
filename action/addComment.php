<?php
require_once("../PageParts/dbConnect.php");
session_start();
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['ID'])) {
    $comment = $_POST['comment'];
    $ID_post = $_SESSION['ID_post'];
    $result = addComment($ID_post, $comment);
    if($result == true){
        echo "Commentaire ajouté";
    } else {
        $_SESSION['error'] = "Erreur lors de l'ajout du commentaire";
    }
} else {
    $_SESSION['error'] = "Vous devez être connecté pour ajouter un commentaire";
}

// Go back to the index page
header('Location: ../index.php');
?>