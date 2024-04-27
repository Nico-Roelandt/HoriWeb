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
    $requete = $connexion->prepare("SELECT * FROM subjects s INNER JOIN joint_subject j ON j.ID_subject = s.ID_subject WHERE j.ID_user = 1");
    $requete->execute();
    $result = $requete->fetchAll();
    return $result;
}

function dbPost($ID_subject, $limit){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT * FROM posts p INNER JOIN users ON p.ID_user = users.ID_user WHERE p.ID_subject = :ID_subject ORDER BY CreationDate DESC LIMIT :limit ");
    $requete->bindParam(':ID_subject', $ID_subject, PDO::PARAM_INT);
    $requete->bindParam(':limit', $limit, PDO::PARAM_INT);
    $requete->execute();
    $result = $requete->fetchAll();
    return $result;
}

function newPost($ID_subject, $content, $picture){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    if($picture != null){
        $sql = "INSERT INTO posts (ID_subject, Text, Picture, CreationDate, ID_user) VALUES (?, ?, ?, NOW(), ?)";
    } else {
        $sql = "INSERT INTO posts (ID_subject, Text, CreationDate, ID_user) VALUES (?, ?, NOW(), ?)";
    }
    // Exécuter la requête SQL pour insérer les données dans la base de données
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(1, $ID_subject, PDO::PARAM_INT);
    $stmt->bindParam(2, $content, PDO::PARAM_STR);
    if($picture != null){
        $stmt->bindParam(3, $picture, PDO::PARAM_STR);
        $stmt->bindParam(4, $_SESSION['ID'], PDO::PARAM_INT);
    } else {
        $stmt->bindParam(3, $_SESSION['ID'], PDO::PARAM_INT);
    }
    try{
        $stmt->execute();
        return true;
    } catch(PDOException $e){
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}

function getComments($ID){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT *
        FROM joint_comment jc
        LEFT JOIN posts p ON jc.ID_post = p.ID_post
        LEFT JOIN posts c ON jc.ID_comment = p.ID_post
        LEFT JOIN users u ON c.ID_user = u.ID_user
        WHERE p.ID_post = :ID
    ");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT); // Liaison du paramètre ID
    $requete->execute();
    $result = $requete->fetchAll();
    if($result != null){
        return $result;
    } else {
        return $requete->errorInfo();
    }
}





?>