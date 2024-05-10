<?php
require_once("../PageParts/dbConnect.php");
session_start();
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['ID'])) {
    $ID_subject = $_POST['ID_subject'];
    $ID_user = $_SESSION['ID'];
    $result = unfollowSubject($ID_user, $ID_subject);
    if($result == true){
        echo "Sujet suivi";
    } else {
        $_SESSION['error'] = "Erreur lors du suivi du sujet";
    }
} else {
    $_SESSION['error'] = "Vous devez être connecté pour suivre un sujet";
}

// Go back to the index page
header('Location: ../index.php');
?>