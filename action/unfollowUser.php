<?php
require_once("../PageParts/dbConnect.php");
session_start();
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['ID'])) {
    $ID_followed = $_POST['ID_followed'];
    $ID_follower = $_SESSION['ID'];
    $result = unfollowUser($ID_follower, $ID_followed);
    if($result == true){
        echo "Utilisateur suivi";
    } else {
        $_SESSION['error'] = "Erreur lors du suivi de l'utilisateur";
    }
} else {
    $_SESSION['error'] = "Vous devez être connecté pour suivre un utilisateur";
}

// Go back to the index page
$user = getUser($_POST['ID_followed']);
header('Location: /Horiweb/user.php?user=' . $user['Username']);
?>