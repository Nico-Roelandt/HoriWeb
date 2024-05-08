<?php
include("./PageParts/header.php");
if(!isset($_SESSION)){
    session_start();
}
require_once("./PageParts/dbConnect.php");
dbConnect();
$update=update();
if (isset($_POST['submit'])){
    if($update != "pas de données"){
        header('Location : user.php');
    }
}
  

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
        $date=$result[0]["Birthdate"];
        $mail=$result[0]["email"];
    }

    $sql = "SELECT COUNT(*) from posts where ID_user=1";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $nb_posts = $stmt->fetchColumn();

    $sql = "SELECT COUNT(*) from followers where ID_user=1";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $nb_follower = $stmt->fetchColumn();
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
            color: black;
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
        .blue-underline {
        color: #007bff;
        text-decoration: underline;
        }

    </style>
</head>
<body>
    <div class="profile">
        <h1>Modifier le profil</h1>
        <img id="profilePic" src="./icon/user.png" alt="Photo de profil">
        <form id="profileForm">
        <label for="profilePicInput"><span class="blue-underline">Modifier la photo de profil</span></label><br>
            <label for="firstname">Prénom:</label>
            <input type="text" id="firstname" name="firstname" required value=<?php echo $firstname?>>
            <label for="name">Nom:</label>
            <input type="text" id="name" name="name" required value=<?php echo $name?>>
            <label for="name">Username:</label>
            <input type="text" id="username" name="username" required value=<?php echo $username?>>
            <label for="date">Date de naissance:</label>
            <input type="date" name="date" required value=<?php echo $date?>></br>
            <label for="mail">Adresse e-mail:</label>
            <input type="text" name="mail" required value=<?php echo $mail?>>
            <label for="name">Description:</label>
            <input type="text" name="description" value="<?php echo $description?>" >
            <input type="submit" value="Enregistrer les modifications">
        </form>
    </div>
</body>

</html>
<?php

dbDisconnect();

?>