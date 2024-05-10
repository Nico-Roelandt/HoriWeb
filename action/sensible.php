<?php
session_start();
// Vérification de la méthode de requête
require_once("../PageParts/dbConnect.php"); 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION['ID']) && isAdmin($_SESSION['ID'])) {
        sensible($_POST['ID_post'], $_POST['sensible']);
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