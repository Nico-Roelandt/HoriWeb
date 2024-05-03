
<?php
include("./PageParts/header.php");




?>




<!-- Contenu principal -->

<div class="content">
  <?php

  if(isset($_SESSION['error'])){
    echo '<div class="alert alert-danger" role="alert">'.$_SESSION['error'].'</div>';
  }

  $result = dbSubject();
  //Print des sujets
  foreach($result as $row){
  ?>
    <div class="subject" id="<?php echo $row['ID_subject'];?>">
      <h2><?php echo $row['name']; ?></h2>
    <?php
    $resultpost = dbPost($row['ID_subject'], 10); // METTRE CONST
    if($resultpost != null){

      foreach($resultpost as $rowpost){
      ?>
        <div class="post" id="<?php echo $rowpost['ID_post']; ?>">
          <h3><?php echo $rowpost['Username']; ?></h3>
          <div class="date"><?php echo $rowpost['CreationDate']; ?></div>
          <p><?php echo $rowpost['Text']; ?></p>
          <div class="react">
            <img class="btn postIcon" data-bs-toggle="modal" style="margin-left: 20px; margin-right: 20px;width: 70px; height: 70px;" data-bs-target="#comment" id="<?php echo $rowpost['ID_post']; ?>" src="\HoriWeb\icon\comment.png"/>
            <script src="./JavaScript/rollComment.js"></script>
            <img class="btn postIcon" style="margin-left: 20px; margin-right: 20px;width: 70px; height: 70px;" src="\HoriWeb\icon\like.png"/>
            <img class="btn postIcon" style="margin-left: 20px; margin-right: 20px;width: 70px; height: 70px;" src="\HoriWeb\icon\unlike.png" />
          </div>
        </div>




      <?php
      }
    }
    ?>
    </div>
  <?php
  }
  ?>

  </div>

  <script>
  


  </script>
  

  
</div>


</div>
<?php
include("./PageParts/footer.php");
?>