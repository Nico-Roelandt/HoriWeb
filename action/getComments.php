<?php
// Vérification de la méthode de requête
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["id"])) {
        $ID = $_POST["id"];

        require_once("../dbConnect.php");

        getComments($ID);


        header("Content-Type: application/json");
        echo json_encode($comments);
    } else {
        http_response_code(400);
        echo "Paramètre manquant";
    }
    
} else {
    http_response_code(405);
    echo "Méthode non autorisée";
}
?>
