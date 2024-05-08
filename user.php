
<?php
include("./PageParts/header.php");
if(!isset($_SESSION)){
    session_start();
}
require_once("./PageParts/dbConnect.php");
dbConnect();

if ($connexion) {
    $sql = "SELECT * FROM users WHERE ID_User=1";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $nombre_resultats = count($result);
    if ($nombre_resultats > 0) {
        $username = $result[0]["Username"];
        $name=$result[0]["Name"];
        $firstname=$result[0]["FirstName"];
        $description=$result[0]["ProfilDescription"];
        $picture=$result[0]["ProfilePicture"];
    }

    $sql = "SELECT COUNT(*) from posts where ID_user=1";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $nb_posts = $stmt->fetchColumn();

    $sql = "SELECT COUNT(*) from followers where ID_user=1";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $nb_follower = $stmt->fetchColumn();

    $sql="SELECT * FROM posts WHERE ID_User=1 ORDER BY CreationDate DESC LIMIT :2";
    $stmt->execute();
    $result = $stmt->fetchAll(); 
} else {
    echo "Erreur de connexion à la base de données.";
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #fafafa;
            text-align: center;
        }
        .profile {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column; /* Modification */
            align-items: center;
        }
        .profile img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px; /* Modification */
            cursor: pointer;
        }
        input[type="file"] {
            display: none;
        }
        label {
            cursor: pointer;
            color: #007bff;
            text-decoration: underline;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #dbdbdb;
            border-radius: 4px;
            resize: vertical;
            background-color: #fafafa;
        }
        input[type="submit"] {
            background-color: #0095f6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 10px;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #0086e5;
        }
        p {
            margin: 5px 0;
            font-size: 14px;
            color: #262626;
        }
        span {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="profile">
        <h1><?php echo $username?></h1>
        <img id="profilePic" src="./icon/user.png" alt="Photo de profil">
        <p><?php echo $firstname," ", $name?></p>
        <p><span id="postCount"><?php echo $nb_posts?></span> publications <span id="followerCount"><?php echo $nb_follower?></span> abonnés</p>
        
        <form id="profileForm">
            <?php echo $description?>
        </form>
        <a href="./stat.php">Voir les statistiques</a>
    </div>
    <a href="./updateProfile.php">Modifier le profil</a></br>
    <a>Modifier le mot de passe</a>

    <section class="posts">
        <h2>Publications</h2>
        <?php
        if($result != null){
            foreach($result as $rowpost){
            $postHTML = generatePostHTML($rowpost);
            echo $postHTML;
            }
        }?>
      
    </section>
</body>
</html>
<?php 
dbDisconnect();
?>
