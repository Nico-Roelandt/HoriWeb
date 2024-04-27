
<?php
include("./PageParts/header.php");




?>




<!-- Contenu principal -->

<div class="content">
  <?php


  $result = dbSubject();
  //Print des sujets
  foreach($result as $row){
  ?>
    <div class="subject" id="<?php echo $row['ID'];?>">
      <h2><?php echo $row['name']; ?></h2>
    <?php
    $resultpost = dbPost($row['ID'], 10); // METTRE CONST
    if($resultpost != null){

      foreach($resultpost as $rowpost){
      ?>
        <div class="post" id="<?php echo $rowpost['ID']; ?>">
          <h3><?php echo $rowpost['Username']; ?></h3>
          <div class="date"><?php echo $rowpost['CreationDate']; ?></div>
          <p><?php echo $rowpost['Text']; ?></p>
          <div class="react">
            <img class="logo" id="comment" src="\HoriWeb\icon\comment.png"/>
            <script src="./JavaScript/rollComment.js"></script>
            <img class="logo" src="\HoriWeb\icon\like.png"/>
            <img class="logo" src="\HoriWeb\icon\unlike.png" />
          </div>
          <div class="comment" style="display: none">
            <div class="comment-content">
              <div class="comment-header">
                <h3>Username</h3>
                <div class="date">Date de création</div>
              </div>
            </div>
          </div>
        </div>




      <?php
      }
    }
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