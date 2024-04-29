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
    $connexion = null;
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

function login($username, $password){

    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT * FROM users WHERE Username = :username");
    $requete->bindParam(':username', $username, PDO::PARAM_STR);
    $requete->execute();
    $result = $requete->fetch();
    if($result != null){
        if(password_verify($password, $result['Password'])){
            $_SESSION['ID'] = $result['ID_user'];
            $_SESSION['Username'] = $result['Username'];
            $_SESSION['Email'] = $result['Email'];
            $_SESSION['Role'] = $result['Role'];
            header('Location: index.php');
        } else {
            $_SESSION['error'] = "Mot de passe incorrect";
            header('Location: index.php');
        }
    } else {
        $_SESSION['error'] = "Utilisateur inconnu";
        header('Location: index.php');
    }

}

function SecurizeString_ForSQL($string) {
    $string = trim($string);
    $string = stripcslashes($string);
    $string = addslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}


function CheckNewAccountForm(){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $creationAttempted = false;
    $creationSuccessful = false;
    $error = NULL;
  
    //Données reçues via formulaire?
    if(isset($_POST["firstname"]) && isset($_POST["name"]) && isset($_POST["date"]) && isset($_POST["mail"]) && isset($_POST["password"]) && isset($_POST["confirm"])){
  
        $creationAttempted = true;
  
        //Form is only valid if password == confirm, and username is at least 4 char long
        
        
        if ( $_POST["password"] != $_POST["confirm"] ){
            $error = "Le mot de passe et sa confirmation sont différents";
        }
        else {
            $firstname = SecurizeString_ForSQL($_POST["firstname"]);
            $name = SecurizeString_ForSQL($_POST["name"]);
            $date = SecurizeString_ForSQL($_POST["date"]);
            $mail = SecurizeString_ForSQL($_POST["mail"]);
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
  
            $query = "INSERT INTO `users` VALUES (NOW(),'$firstname', '$name','$mail','$date', '$password', 'aaa','bdche','cbeih')";
        
            $stmt = $connexion->prepare($query);
            try{
                $stmt->execute();
                return true;
            } catch(PDOException $e){
                echo "Erreur : " . $e->getMessage();
                return $e->getMessage();
            }
                    
        }
  
  } else {
        $error = "Veuillez remplir le formulaire";
        return $error;
    }
  
  }

?>