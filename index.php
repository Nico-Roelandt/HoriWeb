
<?php
include("./PageParts/header.php");




?>




<!-- Contenu principal -->

<div class="content">
  <?php

  if(isset($_SESSION['error'])){
    echo '<div class="alert alert-danger" role="alert">'.$_SESSION['error'].'</div>';
    unset($_SESSION['error']);
  }
  if(isset($_SESSION['ID'])){
    $result = dbSubject($_SESSION['ID']);
    if($result == null){
      echo '<div class="alert alert-warning" role="alert">Vous n\'avez pas de sujet suivis</div>';
    }
  } else {
    $result = dbSubjectRand();
  }
  //Print des sujets
  foreach($result as $row){
  ?>
    
    <div class="subject" id="<?php echo $row['ID_subject'];?>">
      <h2><?php echo $row['name']; ?></h2>
    <?php
    $resultpost = dbPost($row['ID_subject'], 10); // METTRE CONST
    if($resultpost != null){

      foreach($resultpost as $rowpost){
        $postHTML = generatePostHTML($rowpost);
        echo $postHTML;
      }
    }
    ?>
    </div>
  <?php
  }
  ?>

  </div>

  

  
</div>


</div>
<?php
include("./PageParts/footer.php");
?>