
<?php
include("./PageParts/header.php");
if(!isset($_SESSION)){
    session_start();
}
dbConnect();
//Déconnecter et user est null
if(!isset($_SESSION['ID']) && !isset($_GET['user'])){
    header("Location: ./login.php");
    exit();
}

if(!isset($_GET['user']) || $_GET['user'] == null){
    //Page de l'utilisateur
    $ID = $_SESSION['ID'];
    $User = getUser($ID);
    $firstname = $User['FirstName'];
    $name = $User['Name'];
} else {
    // Page de l'utilisateur dans le GET
    $User = getUserByUsername($_GET['user']);
    if($User == null){
        $_SESSION['error'] = "Utilisateur introuvable";
        header("Location: ./index.php");
        exit();
    }
    $ID = $User['ID_user'];

    $firstname = null;
    $name = null;
}
$username = $User['Username'];
$description = $User['ProfilDescription'];
$nb_posts = getNumberOfPost($ID);
$nb_follower = getNumberOfFollower($ID);


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
        <?php if(isset($_SESSION['ID']) && $_SESSION['ID'] != $ID){

          if(userIsFollow($_SESSION['ID'], $ID)){
          ?>
            <form action="./action/unfollowUser.php" method="POST">
              <input type="hidden" name="ID_followed" value="<?php echo $ID;?>">
              <button type="submit" class="btn btn-primary">Ne plus suivre</button>
            </form>
            <?php
          } else {
            ?>
            <form action="./action/followUser.php" method="POST">
              <input type="hidden" name="ID_followed" value="<?php echo $ID;?>">
              <button type="submit" class="btn btn-primary">Suivre</button>
            </form>
            <?php
          
          }
        }?>
        
        <form id="profileForm">
            <?php echo $description?>
        </form>
        <a href="./stat.php">Voir les statistiques</a>
    </div>
    <a href="./updateProfile.php">Modifier le profil</a></br>
    <a>Modifier le mot de passe</a>

    <section class="posts" style="margin: 150px; margin-top: 50px;">
        <h2>Publications</h2>
        <?php
        $result = dbSubjectUser($ID, 10);
        if($result == null){
            echo '<div class="alert alert-warning" role="alert">Vous n\'avez pas de publications sur des sujets</div>';
        } else {
            foreach($result as $row){
                ?>
                <div class="subject " id="<?php echo $row['ID_subject'];?>">
                    <h2 style="text-align: left;"><?php echo $row['name']; ?></h2>
                    <?php
                    $resultpost = dbPost($row['ID_subject'], 10); // METTRE CONST
                    if($resultpost != null){
                        foreach($resultpost as $rowpost){
                            $postHTML = generatePostHTML($rowpost);
                            echo $postHTML;
                        }
                    }
                }
            }
        

        ?>
      
    </section>
</body>
</html>
<?php 
dbDisconnect();
?>
