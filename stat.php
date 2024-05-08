<?php
include("./PageParts/header.php");
if(!isset($_SESSION)){
    session_start();
}
require_once("./PageParts/dbConnect.php");
dbConnect();

if ($connexion) {
    $sql = "SELECT Username FROM users WHERE ID_User=1";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $nombre_resultats = count($result);
    if ($nombre_resultats > 0) {
        $username = $result[0]["Username"];
    
    } 
    $sql = "SELECT COUNT(*) from posts where ID_user=1";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $nb_posts = $stmt->fetchColumn();

    $sql="SELECT COUNT(*) AS nb_posts FROM posts WHERE ID_user = 1 AND WEEK(CreationDate) = WEEK(CURDATE())";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $nb_postsW = $stmt->fetchColumn();

    $sql="SELECT COUNT(*) AS nb_posts FROM posts WHERE ID_user = 1 AND MONTH(CreationDate) = MONTH(CURDATE())";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $nb_postsM = $stmt->fetchColumn();
    
    $sql = "SELECT COUNT(*) from followers where ID_user=1";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $nb_follower = $stmt->fetchColumn();

    $sql = "SELECT COUNT(*) from followers where ID_follower=1";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $nb_follow = $stmt->fetchColumn();

    $sql = "SELECT COUNT(*) from joint_like where ID_user=1";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $like = $stmt->fetchColumn();

    $sql = "SELECT COUNT(*) from joint_like j INNER JOIN posts p on j.ID_post=p.ID_post where j.ID_user=1 AND WEEK(p.CreationDate) = WEEK(CURDATE())";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $likeW = $stmt->fetchColumn();

    $sql = "SELECT COUNT(*) from joint_like j INNER JOIN posts p on j.ID_post=p.ID_post where j.ID_user=1 AND MONTH(p.CreationDate) = MONTH(CURDATE())";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $likeM = $stmt->fetchColumn();

    $sql = "SELECT COUNT(*) from joint_like j INNER JOIN posts p on j.ID_post=p.ID_post where p.ID_user=1";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $islike = $stmt->fetchColumn();

    $sql = "SELECT COUNT(*) from joint_like j INNER JOIN posts p on j.ID_post=p.ID_post where p.ID_user=1 AND WEEK(p.CreationDate) = WEEK(CURDATE())";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $islikeW = $stmt->fetchColumn();

    $sql = "SELECT COUNT(*) from joint_like j INNER JOIN posts p on j.ID_post=p.ID_post where p.ID_user=1 AND MONTH(p.CreationDate) = MONTH(CURDATE())";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $islikeM = $stmt->fetchColumn();

    
}
else {
    echo "Erreur de connexion à la base de données.";
}
    
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class ="container">
        <h1>Statistiques de <?php echo $username ?></h1>
        <table>
            <tr>
                <th>Post :</th>
            </tr>
            <tr>
                <td>Nombre de posts  : <?php echo $nb_posts?></td>
            </tr>
            <tr>
                <td>Nombre de posts par semaine :<?php echo $nb_postsW?> </td>
            </tr>
            <tr>
                <td>Nombre de posts par mois :<?php echo $nb_postsM?></td>
            </tr>
            </tr>
            <tr>
                <th>Abonnement :</th>
            </tr>
            <tr>
                <td>Nombre de followers : <?php echo $nb_follower?></td>
            </tr>
            <tr>
                <td>Nombre de follows :<?php echo $nb_follow?></td>
            </tr>
            <tr>
                <th>Likes :</th>
            </tr>
            <tr>
                <td>Nombre de likes donnés :<?php echo $like?></td>
            </tr>
            <tr>
                <td>Nombre de likes donnés par semaine :<?php echo $likeW?></td>
            </tr>
            <tr>
                <td>Nombre de likes donnés par mois  :<?php echo $likeM?></td>
            </tr>
            <tr>
                <td>Nombre de likes reçus :<?php echo $islike?></td>
            </tr>
            <tr>
                <td>Nombre de likes recçus par semaine :<?php echo $islikeW?></td>
            </tr>
            <tr>
                <td>Nombre de likes reçus par mois  :<?php echo $islikeM?></td>
            </tr>
        </table>
        
    </div>
</body>