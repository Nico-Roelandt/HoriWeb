<?php
session_start();
// Vérification de la méthode de requête
require_once("../PageParts/dbConnect.php"); 
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_SESSION['ID']) && isAdmin($_SESSION['ID'])) {
        remove($_GET['ID_post']);
        header('Location: ../index.php');
    } else {
        http_response_code(400);
        echo "Paramètre manquant";
    }
    
} else {
    http_response_code(405);
    echo "Méthode non autorisée";
}



?>