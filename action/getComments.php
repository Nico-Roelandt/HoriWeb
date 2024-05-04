<?php
// Vérification de la méthode de requête
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["id"])) {
        $ID = $_POST["id"];
        require_once("../PageParts/dbConnect.php");
        $result = getComments($ID);
        header("Content-Type: application/json");
        if($result != null){
            http_response_code(200);
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo "Aucun commentaire trouvé";
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
