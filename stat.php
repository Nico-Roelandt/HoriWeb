<?php
include("./PageParts/header.php");
if(!isset($_SESSION)){
    session_start();
}
require_once("./PageParts/dbConnect.php");
dbConnect();

$stat = getStat($_SESSION['ID']);

    
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class ="container">
        <h1>Statistiques</h1>
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
                <td>Nombre de likes donnés :</td>
            </tr>
            <tr>
                <td>Nombre de likes donnés par semaine :</td>
            </tr>
            <tr>
                <td>Nombre de likes donnés par mois  :</td>
            </tr>
            <tr>
                <td>Nombre de likes reçus :</td>
            </tr>
            <tr>
                <td>Nombre de likes recçus par semaine :</td>
            </tr>
            <tr>
                <td>Nombre de likes reçus par mois  :</td>
            </tr>
        </table>
        
    </div>
</body>