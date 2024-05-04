<?php
// Vérification de la méthode de requête
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["id"])) {
        $ID = $_POST["id"];
        require_once("../PageParts/dbConnect.php");
        $result = unlike($ID);
        header("Content-Type: application/json");
    } else {
        http_response_code(400);
        echo "Paramètre manquant";
    }
    
} else {
    http_response_code(405);
    echo "Méthode non autorisée";
}



?>