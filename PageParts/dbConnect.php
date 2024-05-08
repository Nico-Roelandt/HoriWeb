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

function dbSubjectRand(){
	global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    
    $requete = $connexion->prepare("SELECT * FROM subjects s ORDER BY RAND() LIMIT 5");
    $requete->execute();
    $result = $requete->fetchAll();
    return $result;
}

function dbSubject($ID){
	global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    
    $requete = $connexion->prepare("SELECT * FROM subjects s INNER JOIN joint_subject j ON j.ID_subject = s.ID_subject WHERE j.ID_user = :ID");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT);
    $requete->execute();
    $result = $requete->fetchAll();
    return $result;
}
function dbSubjectAll(){
	global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    
    $requete = $connexion->prepare("SELECT * FROM subjects ORDER BY name ASC");
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
    $requete = $connexion->prepare("SELECT jc.ID_comment, c.Text, c.CreationDate, u.Username
        FROM joint_comment jc
        LEFT JOIN posts p ON jc.ID_post = p.ID_post
        LEFT JOIN posts c ON jc.ID_comment = c.ID_post
        LEFT JOIN users u ON c.ID_user = u.ID_user
        WHERE p.ID_post = :ID
    ");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT); // Liaison du paramètre ID
    $requete->execute();
    $result = $requete->fetchAll(PDO::FETCH_ASSOC);
    if($result != null){
        return $result;
    } else {
        return null;
    }
}

function login($username, $password){
    session_start();
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
    if(isset($_POST["firstname"]) && isset($_POST["username"]) && isset($_POST["name"]) && isset($_POST["date"]) && isset($_POST["mail"]) && isset($_POST["password"]) && isset($_POST["confirm"])){
  
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
            $username = SecurizeString_ForSQL($_POST["username"]);
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
  
            $query = "INSERT INTO users (Username, FirstName, Name, email, Birthdate, Password) VALUES ('$username', '$firstname', '$name', '$mail', '$date', '$password')";
        
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
    return "pas de données";
  }
}
function getLike($ID){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT count(*) FROM joint_like WHERE ID_post = :ID");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT); // Liaison du paramètre ID
    $requete->execute();
    $result = $requete->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
        return $row['count(*)'];
    }
}

function isLike($ID, $ID_user){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT * FROM joint_like WHERE ID_post = :ID AND ID_user = :ID_user");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT); // Liaison du paramètre ID
    $requete->bindParam(':ID_user', $ID_user, PDO::PARAM_INT); // Liaison du paramètre ID_user
    $requete->execute();
    $result = $requete->fetchAll(PDO::FETCH_ASSOC);
    if($result != null){
        return true;
    } else {
        return false;
    }
}


function like($ID, $ID_user){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    if(isLike($ID, $ID_user)){
        $_SESSION['error'] = "Vous avez déjà liké ce post";
        return false;
    } else {
        $requete = $connexion->prepare("INSERT INTO joint_like (ID_post, ID_user) VALUES (:ID, :ID_user)");
        $requete->bindParam(':ID', $ID, PDO::PARAM_INT); // Liaison du paramètre ID
        $requete->bindParam(':ID_user', $ID_user, PDO::PARAM_INT); // Liaison du paramètre ID_user
        $requete->execute();
        return true;
        
    }
}

function unlike($ID, $ID_user){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    
    if(!isLike($ID, $ID_user)){
        $_SESSION['error'] = "Vous n'avez pas liké ce post";
        return false;
    } else {
        $requete = $connexion->prepare("DELETE FROM joint_like WHERE ID_post = :ID AND ID_user = :ID_user");
        $requete->bindParam(':ID', $ID, PDO::PARAM_INT); // Liaison du paramètre ID
        $requete->bindParam(':ID_user', $ID_user, PDO::PARAM_INT); // Liaison du paramètre ID_user
        $requete->execute();
        return true;
    }
}




function deleteNotification($ID){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("UPDATE notification SET isDelete = 1 WHERE ID_notif = :ID");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT); // Liaison du paramètre ID
    $requete->execute();
}

function dbNotification($ID){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT * FROM notification ns LEFT JOIN notify ny ON ns.ID_notif = ny.ID_notif WHERE ny.ID_user = :ID AND isDelete = 0");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT); // Liaison du paramètre ID
    $requete->execute();
    $result = $requete->fetchAll(PDO::FETCH_ASSOC);
    if($result != null){
        return $result;
    } else {
        return null;
    }
}

function numberOfnotification($ID){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT count(*) FROM notification ns LEFT JOIN notify ny ON ns.ID_notif = ny.ID_notif WHERE ny.ID_user = :ID AND isDelete = 0");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT); // Liaison du paramètre ID
    $requete->execute();
    $result = $requete->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
        return $row['count(*)'];
    }
}
function addComment($ID_post, $content){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("INSERT INTO posts (ID_post, ID_subject, Text, CreationDate, ID_user) VALUES (NULL, NULL, :content, NOW(), :ID_user)");
    $requete->bindParam(':content', $content, PDO::PARAM_STR);
    $requete->bindParam(':ID_user', $_SESSION['ID'], PDO::PARAM_INT);
    try{
        $requete->execute();
        //Ajout dans joint_comment
        $ID_comment = $connexion->lastInsertId();
        $requete = $connexion->prepare("INSERT INTO joint_comment (ID_post, ID_comment) VALUES (:ID_post, :ID_comment)");
        $requete->bindParam(':ID_post', $ID_post, PDO::PARAM_INT);
        $requete->bindParam(':ID_comment', $ID_comment, PDO::PARAM_INT);
        try{
            $requete->execute();
        } catch(PDOException $e){
            echo "Erreur : " . $e->getMessage();
            return false;
        }
        return true;
    } catch(PDOException $e){
        echo "Erreur : " . $e->getMessage();
        return false;
    }

    
}

function getSubject($ID){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT ID_subject FROM posts WHERE ID_post = :ID");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT); // Liaison du paramètre ID
    $requete->execute();
    $result = $requete->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
        return $row['ID_subject'];
    }
}



function search($query, $type){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    if($type == "posts"){
        $requete = $connexion->prepare("SELECT * FROM posts p INNER JOIN users ON p.ID_user = users.ID_user WHERE Text LIKE :query ORDER BY CreationDate DESC");
    } else if($type == "users"){
        $requete = $connexion->prepare("SELECT * FROM users WHERE Username LIKE :query");
    } else if($type == "subject"){
        $requete = $connexion->prepare("SELECT * FROM subjects WHERE name LIKE :query");
    }
    $query = "%".$query."%";
    $requete->bindParam(':query', $query, PDO::PARAM_STR);
    $requete->execute();
    $result = $requete->fetchAll();
    if($result != null){
        return $result;
    } else {
        return null;
    }
}



?>