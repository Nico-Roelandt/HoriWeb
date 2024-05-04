
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
          <div class="react" style="width: 500px; height: 80px;">
            <img class="btn postIcon" data-bs-toggle="modal" style="margin-left: 20px; margin-right: 20px;width: 70px; height: 70px;" data-bs-target="#comment" id="<?php echo $rowpost['ID_post']; ?>" src="\HoriWeb\icon\comment.png"/>

            <?php
            if(isset($_SESSION['ID']) && isLike($rowpost['ID_post'], $_SESSION['ID'])){
              ?>
              <img class="btn postIcon" id="islike" style="margin-left: 20px; margin-right: 20px;width: 70px; height: 70px;" data-like-id=<?php echo $rowpost['ID_post']; ?> src="\HoriWeb\icon\islike.png"/>
              <?php
            } else {
              ?>
              <img class="btn postIcon" id="like" style="margin-left: 20px; margin-right: 20px;width: 70px; height: 70px;" data-like-id=<?php echo $rowpost['ID_post']; ?> src="\HoriWeb\icon\like.png"/>
              <?php
            }
            ?>


    
            <p class="numberOfLike" style="margin-left:20px; margin-bottom:auto; width: 200px; height: 40px; display: inline-flex; font-size: 20px;max-width: 100%;text-align: center;line-height: normal;";>
              <?php
                $resultlike = getLike($rowpost['ID_post']);
                if($resultlike != null){
                  echo $resultlike;
                } else {
                  echo "0";
                }
              ?>

              </p>

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