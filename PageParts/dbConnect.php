<?php

global $connexion;
// Connexion à la base de données à chaque page (sinon non)
if(!isset($connexion)){
    $connexion = dbConnect();
}
function dbConnect(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "horiweb";
    global $connexion;


    // Check connection
    try {
        $connexion = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    } catch(PDOException $e) {
        // Gestion des erreurs de connexion
        echo "Erreur de connexion : " . $e->getMessage();
    }
}


function dbDisconnect(){
	global $connexion;
	$connexion->close();
}



function dbSubject(){
	global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT * FROM subjects s INNER JOIN joint_subject j ON j.ID_subject = s.ID WHERE j.ID_user = 1");
    $requete->execute();
    $result = $requete->fetchAll();
    return $result;
}

function dbPost($ID_subject, $limit){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT * FROM posts p INNER JOIN users ON p.ID_user = users.ID WHERE p.ID_subject = :ID_subject ORDER BY CreationDate DESC LIMIT :limit ");
    $requete->bindParam(':ID_subject', $ID_subject, PDO::PARAM_INT);
    $requete->bindParam(':limit', $limit, PDO::PARAM_INT);
    $requete->execute();
    $result = $requete->fetchAll();
    return $result;
}


?>