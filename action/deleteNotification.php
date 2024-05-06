<?php
session_start();
// Vérification de la méthode de requête
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['id'])){
        // Inclusion du fichier de connexion à la base de données
        require_once("../PageParts/dbConnect.php");
        // Récupération de l'ID de la notification
        $id = $_POST['id'];
        // Appel de la fonction deleteNotification() du fichier dbConnect.php
        deleteNotification($id);
        // Redirection vers la page de notification
        header('Location: ../notification.php');

    } else {
        http_response_code(400);
        echo "Paramètre manquant";
    }
    
} else {
    http_response_code(405);
    echo "Méthode non autorisée";
}



?>