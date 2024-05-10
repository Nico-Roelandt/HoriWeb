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

function dbSubjectUser($ID, $limit){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    //Récuperation de la liste des sujets ou l'user a posté
    $requete = $connexion->prepare("SELECT DISTINCT s.ID_subject, s.name FROM subjects s INNER JOIN posts p ON s.ID_subject = p.ID_subject WHERE p.ID_user = :ID ORDER BY s.name ASC LIMIT :limit");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT);
    $requete->bindParam(':limit', $limit, PDO::PARAM_INT);
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


function getPost($ID_post){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT * FROM posts p INNER JOIN users ON p.ID_user = users.ID_user WHERE p.ID_post = :ID_post");
    $requete->bindParam(':ID_post', $ID_post, PDO::PARAM_INT);
    $requete->execute();
    $result = $requete->fetch();
    return $result;

}
function dbPostUser($ID, $limit){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT * FROM posts p INNER JOIN users ON p.ID_user = users.ID_user WHERE p.ID_user = :ID ORDER BY CreationDate DESC LIMIT :limit ");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT);
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
        //Create notif
        $ID_post = $connexion->lastInsertId();
        $requete = $connexion->prepare("SELECT ID_followers FROM followers WHERE ID_user = :ID_user");
        $requete->bindParam(':ID_user', $_SESSION['ID'], PDO::PARAM_INT);
        $requete->execute();
        $result = $requete->fetchAll();
        //Creation d'une notif
        
        $requete = $connexion->prepare("INSERT INTO notification (ID_notif, Message, Date_Notification, isDelete) VALUES (NULL, :message ,NOW(), 0)");
        $message =  "Nouveau post de ".$_SESSION['Username'];
        $requete->bindParam(':message', $message, PDO::PARAM_STR);
        $requete->execute();
        foreach($result as $row){
            $requete = $connexion->prepare("INSERT INTO notify (ID_notif, ID_user) VALUES (:ID_notif, :ID_user)");
            $lastID = $connexion->lastInsertId();
            $requete->bindParam(':ID_notif', $lastID, PDO::PARAM_INT);
            $requete->bindParam(':ID_user', $row['ID_followers'], PDO::PARAM_INT);
            $requete->execute();
        }




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
        } else {
            $_SESSION['error'] = "Mot de passe incorrect";
        }
    } else {
        $_SESSION['error'] = "Utilisateur inconnu";
    }

}

function SecurizeString_ForSQL($string) {
    $string = trim($string);
    $string = stripcslashes($string);
    $string = addslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}


function newAccount($firstname, $name, $username, $password, $confirm, $birthdate, $mail){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $creationAttempted = false;
    $creationSuccessful = false;
    $error = NULL;
  
    //Données reçues via formulaire?
    if($firstname != null && $name != null && $username != null && $password != null && $confirm != null && $birthdate != null && $mail != null){
  
        $creationAttempted = true;
  
        //Form is only valid if password == confirm, and username is at least 4 char long
        
        
        if ( $_POST["password"] != $_POST["confirm"] ){
            $error = "Le mot de passe et sa confirmation sont différents";
        } else {
            $firstname = SecurizeString_ForSQL($firstname);
            $name = SecurizeString_ForSQL($name);
            $date = SecurizeString_ForSQL($birthdate);
            $mail = SecurizeString_ForSQL($mail);
            $username = SecurizeString_ForSQL($username);
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


function updateUser($ID, $firstname, $name, $birthdate, $profilePicture, $description){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("UPDATE users SET FirstName = :firstname, Name = :name, Birthdate = :birthdate, ProfilePicture = :profilePicture, Description = :description WHERE ID_user = :ID");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT);
    $requete->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $requete->bindParam(':name', $name, PDO::PARAM_STR);
    $requete->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
    $requete->bindParam(':profilePicture', $profilePicture, PDO::PARAM_STR);
    $requete->bindParam(':description', $description, PDO::PARAM_STR);
    try{
        $requete->execute();
        return true;
    } catch(PDOException $e){
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}


function userIsFollow($ID_user, $ID_follower) {
    global $connexion;
    if (!isset($connexion)) {
        dbConnect();
    }

    $requete = $connexion->prepare("SELECT * FROM followers WHERE ID_user = :ID_user AND ID_follower = :ID_follower");
    $requete->bindParam(':ID_user', $ID_user, PDO::PARAM_INT);
    $requete->bindParam(':ID_follower', $ID_follower, PDO::PARAM_INT);
    $requete->execute();
    $result = $requete->fetch(PDO::FETCH_ASSOC);

    return ($result !== false);
}

function unfollowUser($ID_user, $ID_follower) {
    global $connexion;
    if (!isset($connexion)) {
        dbConnect();
    }

    if (!userIsFollow($ID_user, $ID_follower)) {
        return false;
    }

    $requete = $connexion->prepare("DELETE FROM followers WHERE ID_user = :ID_user AND ID_follower = :ID_follower");
    $requete->bindParam(':ID_user', $ID_user, PDO::PARAM_INT);
    $requete->bindParam(':ID_follower', $ID_follower, PDO::PARAM_INT);
    $requete->execute();

    try{
        $requete->execute();
        return true;
    } catch(PDOException $e){
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}

function followUser($ID_user, $ID_follower) {
    global $connexion;
    if (!isset($connexion)) {
        dbConnect();
    }

    if (userIsFollow($ID_user, $ID_follower)) {
        return false;
    }

    $requete = $connexion->prepare("INSERT INTO followers (ID_user, ID_follower) VALUES (:ID_user, :ID_follower)");
    $requete->bindParam(':ID_user', $ID_user, PDO::PARAM_INT);
    $requete->bindParam(':ID_follower', $ID_follower, PDO::PARAM_INT);
    $requete->execute();
    try{
        $requete->execute();
        return true;
    } catch(PDOException $e){
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}

function updateUserWithPassword($ID, $firstname, $name, $birthdate, $profilePicture, $description, $password){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("UPDATE users SET FirstName = :firstname, Name = :name, Birthdate = :birthdate, ProfilePicture = :profilePicture, ProfilDescription = :description, Password = :password WHERE ID_user = :ID");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT);
    $requete->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $requete->bindParam(':name', $name, PDO::PARAM_STR);
    $requete->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
    $requete->bindParam(':profilePicture', $profilePicture, PDO::PARAM_STR);
    $requete->bindParam(':description', $description, PDO::PARAM_STR);
    $password = password_hash($password, PASSWORD_DEFAULT);
    $requete->bindParam(':password', $password, PDO::PARAM_STR);
    try{
        $requete->execute();
        return true;
    } catch(PDOException $e){
        echo "Erreur : " . $e->getMessage();
        return false;
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
    $requete = $connexion->prepare("UPDATE notify SET isDelete = 1 WHERE ID_notif = :ID");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT); // Liaison du paramètre ID
    $requete->execute();
}

function dbNotification($ID){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT * FROM notification ns LEFT JOIN notify ny ON ns.ID_notif = ny.ID_notif WHERE ny.ID_user = :ID AND ny.isDelete = 0 ORDER BY ns.Date_Notification DESC");
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
    $requete = $connexion->prepare("SELECT count(*) FROM notification ns LEFT JOIN notify ny ON ns.ID_notif = ny.ID_notif WHERE ny.ID_user = :ID AND ny.isDelete = 0");
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
        $requete = $connexion->prepare("SELECT * FROM users u LEFT JOIN u.ID_user = p.ID_user WHERE Username LIKE :query");
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


function getUser($ID){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $sql = "SELECT * FROM users WHERE ID_User= :ID";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
}


function getNumberOfPost($ID){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT count(*) FROM posts WHERE ID_user = :ID");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT); // Liaison du paramètre ID
    $requete->execute();
    $result = $requete->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
        return $row['count(*)'];
    }
}


function getNumberOfFollower($ID){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT count(*) FROM followers WHERE ID_user = :ID");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT); // Liaison du paramètre ID
    $requete->execute();
    $result = $requete->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
        return $row['count(*)'];
    }
}

function dbFollow($ID){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT * FROM followers f LEFT JOIN users u ON f.ID_follower = u.ID_user WHERE f.ID_user = :ID");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT); // Liaison du paramètre ID
    $requete->execute();
    $result = $requete->fetchAll(PDO::FETCH_ASSOC);
    if($result != null){
        return $result;
    } else {
        return null;
    }
}

function getUserByUsername($username){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT * FROM users WHERE Username = :username");
    $requete->bindParam(':username', $username, PDO::PARAM_STR); // Liaison du paramètre ID
    $requete->execute();
    $result = $requete->fetch();
    return $result;
}

function isAdmin($ID){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("SELECT * FROM users WHERE ID_user = :ID AND isAdmin = 1");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT); // Liaison du paramètre ID
    $requete->execute();
    $result = $requete->fetch();

    return ($result !== false);
}


function sujetIsFollow($ID_user, $ID_subject) {
    global $connexion;
    if (!isset($connexion)) {
        dbConnect();
    }

    $requete = $connexion->prepare("SELECT * FROM joint_subject WHERE ID_user = :ID_user AND ID_subject = :ID_subject");
    $requete->bindParam(':ID_user', $ID_user, PDO::PARAM_INT);
    $requete->bindParam(':ID_subject', $ID_subject, PDO::PARAM_INT);
    $requete->execute();
    $result = $requete->fetch(PDO::FETCH_ASSOC);

    return ($result !== false);
}

function followSubject($ID_user, $ID_subject) {
    global $connexion;
    if (!isset($connexion)) {
        dbConnect();
    }

    if (sujetIsFollow($ID_user, $ID_subject)) {
        return false;
    }

    $requete = $connexion->prepare("INSERT INTO joint_subject (ID_user, ID_subject) VALUES (:ID_user, :ID_subject)");
    $requete->bindParam(':ID_user', $ID_user, PDO::PARAM_INT);
    $requete->bindParam(':ID_subject', $ID_subject, PDO::PARAM_INT);
    $requete->execute();

    return true;
}

function unfollowSubject($ID_user, $ID_subject) {
    global $connexion;
    if (!isset($connexion)) {
        dbConnect();
    }

    if (!sujetIsFollow($ID_user, $ID_subject)) {
        return false;
    }

    $requete = $connexion->prepare("DELETE FROM joint_subject WHERE ID_user = :ID_user AND ID_subject = :ID_subject");
    $requete->bindParam(':ID_user', $ID_user, PDO::PARAM_INT);
    $requete->bindParam(':ID_subject', $ID_subject, PDO::PARAM_INT);
    $requete->execute();

    return true;
}


function sensible($ID_post, $message){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("UPDATE posts SET isSensible = 1 WHERE ID_post = :ID_post");
    $requete->bindParam(':ID_post', $ID_post, PDO::PARAM_INT);
    $requete->execute();
    //Creation de la notification
    $requete = $connexion->prepare("SELECT ID_user FROM posts WHERE ID_post = :ID_post");
    $requete->bindParam(':ID_post', $ID_post, PDO::PARAM_INT);
    $requete->execute();
    $result = $requete->fetch();
    $requete = $connexion->prepare("INSERT INTO notification (ID_notif, Message, Date_Notification, isDelete) VALUES (NULL, :message ,NOW(), 0)");
    $requete->bindParam(':message', $message, PDO::PARAM_STR);

}


function remove($ID_post){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("DELETE FROM posts WHERE ID_post = :ID_post");
    $requete->bindParam(':ID_post', $ID_post, PDO::PARAM_INT);
    $requete->execute();
    $requete = $connexion->prepare("DELETE FROM joint_like WHERE ID_post = :ID_post");
    $requete->bindParam(':ID_post', $ID_post, PDO::PARAM_INT);
    $requete->execute();
    $requete = $connexion->prepare("DELETE FROM joint_comment WHERE ID_post = :ID_post");
    $requete->bindParam(':ID_post', $ID_post, PDO::PARAM_INT);
    $requete->execute();
    //Creation de la notification
    $requete = $connexion->prepare("SELECT ID_user FROM posts WHERE ID_post = :ID_post");
    $requete->bindParam(':ID_post', $ID_post, PDO::PARAM_INT);
    $requete->execute();
    $result = $requete->fetch();
    $requete = $connexion->prepare("INSERT INTO notification (ID_notif, Message, Date_Notification, isDelete) VALUES (NULL, :message ,NOW(), 0)");
    $message = "Votre post a été supprimé";
    $requete->bindParam(':message', $message, PDO::PARAM_STR);
    $requete->execute();
    //Ajout dans notify
    foreach($result as $row){
        $requete = $connexion->prepare("INSERT INTO notify (ID_notif, ID_user) VALUES (:ID_notif, :ID_user)");
        $lastID = $connexion->lastInsertId();
        $requete->bindParam(':ID_notif', $lastID, PDO::PARAM_INT);
        $requete->bindParam(':ID_user', $row['ID_user'], PDO::PARAM_INT);
        $requete->execute();
    }

}




function getStat($ID){
    global $connexion;
    if(!isset($connexion)){
        dbConnect();
    }
    $requete = $connexion->prepare("CREATE VIEW `user_stats` AS SELECT 
        u.ID_user,
        COUNT(DISTINCT f.ID_follower) AS followers_count,
        COUNT(DISTINCT fl.ID_user) AS following_count,
        COUNT(DISTINCT p.ID_post) AS total_posts,
        COUNT(DISTINCT l.ID_user) AS total_likes_given,
        COALESCE((COUNT(DISTINCT l.ID_user) / DATEDIFF(NOW(), MIN(p.CreationDate))) * 7, 0) AS avg_likes_per_week,
        COALESCE((COUNT(DISTINCT l.ID_user) / DATEDIFF(NOW(), MIN(p.CreationDate))) * 30.4368, 0) AS avg_likes_per_month,
        COUNT(DISTINCT jl.ID_user) AS total_likes_received,
        COALESCE((COUNT(DISTINCT jl.ID_user) / DATEDIFF(NOW(), MIN(p.CreationDate))) * 7, 0) AS avg_likes_received_per_week,
        COALESCE((COUNT(DISTINCT jl.ID_user) / DATEDIFF(NOW(), MIN(p.CreationDate))) * 30.4368, 0) AS avg_likes_received_per_month
    FROM 
        users u
    LEFT JOIN 
        followers f ON u.ID_user = f.ID_user
    LEFT JOIN 
        followers f2 ON u.ID_user = f2.ID_follower
    LEFT JOIN 
        posts p ON u.ID_user = p.ID_user
    LEFT JOIN 
        joint_like l ON p.ID_post = l.ID_post
    LEFT JOIN 
        joint_like jl ON u.ID_user = jl.ID_user
    LEFT JOIN 
        joint_like jl2 ON p.ID_post = jl2.ID_post AND u.ID_user != jl2.ID_user
    WHERE 
        u.ID_user = :ID
    GROUP BY 
        u.ID_user;
    ");
    $requete->bindParam(':ID', $ID, PDO::PARAM_INT); // Liaison du paramètre ID

    $requete->execute();
    $result = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}





?>