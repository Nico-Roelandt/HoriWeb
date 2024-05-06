<?php
require_once("../PageParts/dbConnect.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo $_POST['id'];
    if (isset($_POST['id'])){
        $id = $_POST['id'];
        deleteNotification($id);
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