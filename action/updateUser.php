<?php
session_start();
// Vérification de la méthode de requête
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_SESSION['ID'])) {
        require_once("../PageParts/dbConnect.php"); 
        if(!isset($_GET['password'])){
            $result = updateUser($_SESSION['ID'], $_GET['firstname'], $_GET['name'], $_GET['birthdate'],$_GET['profilePic'], $_GET['description'] );
        } else {
            $result = updateUserWithPassword($_SESSION['ID'], $_GET['firstname'], $_GET['name'], $_GET['birthdate'],$_GET['profilePic'], $_GET['description'], $_GET['password'] );
        }
        if($result == true){
            echo "Utilisateur mis à jour";
            header('Location: ../index.php');
        } else {
            http_response_code(400);
            echo "Erreur lors de la mise à jour de l'utilisateur";
        }
    } else {
        http_response_code(400);
        echo "Paramètre manquant";
    }
    
} else {
    http_response_code(405);
    echo "Méthode non autorisée";
}



?>