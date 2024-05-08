
<?php
include("./PageParts/header.php");
if(!isset($_SESSION['ID'])){
    header('Location: index.php');
}
?>

<div class="content">
    <!--- Liste des notifs -->
    <div class="notification">
        <h2>Notifications</h2>
        <?php
        $result = dbNotification($_SESSION['ID']);
        if($result == null){
            echo '<div class="alert alert-warning" role="alert">Vous n\'avez pas de notification</div>';
        } else {
            foreach($result as $row){
                ?>
                <div class="card notif border">
                    <div class="card-body">
                        <p><?php echo $row['Message']?></p>
                        <p><?php echo $row['Date_Noficitation']?></p>
                        <button class="btn btn-danger btn-sm deleteNotif" data-id="<?php echo $row['ID_notif']?>">Supprimer</button>
                    </div>
                </div>
                <?php
            }
        }
        ?>
</div>

