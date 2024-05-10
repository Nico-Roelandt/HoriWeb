
<?php
include("./PageParts/header.php");




?>




<!-- Contenu principal -->

<div class="content">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    <?php if(isset($_GET['dropdown'])){
      $type = $_GET['dropdown'];
      if($type == 'subject'){
        echo 'Subject';
      } else {
        echo 'Follow';
      }
    } else {
      echo 'Subject';
    }
    ?>
  </button>
  <div class="dropdown">
    <ul class="dropdown-menu">
      <?php
      if(isset($_GET['dropdown'])){
        $type = $_GET['dropdown'];
        echo '<li><a class="dropdown-item';
        if($type == 'subject'){
          echo ' active';
        }
        echo '" href="/HoriWeb/index.php?dropdown=subject">Subject</a></li>';

        echo '<li><a class="dropdown-item';
        if($type == 'follow'){
          echo ' active';
        }
      echo '" href="/HoriWeb/index.php?dropdown=follow" >Follow</a></li>';
      } else {
        echo '<li><a class="dropdown-item active" href="/HoriWeb/index.php?dropdown=subject">Subject</a></li>';
        echo '<li><a class="dropdown-item" href="/HoriWeb/index.php?dropdown=follow">Follow</a></li>';
        $type = 'subject';
      }
      ?>
    </ul>
  </div>
  <?php

  if(isset($_SESSION['error'])){
    echo '<div class="alert alert-danger" role="alert">'.$_SESSION['error'].'</div>';
    unset($_SESSION['error']);
  }
  
  if($type == 'subject'){
    echo '<div class="subject">';
    if(isset($_SESSION['ID'])){
      $result = dbSubject($_SESSION['ID']);
      if($result == null){
        echo '<div class="alert alert-warning" role="alert">Vous n\'avez pas de sujet suivis. Sujet random pris</div>';
        $result = dbSubjectRand();
      }
    } else {
      $result = dbSubjectRand();
    }

    //Print des sujets
    foreach($result as $row){
    ?>
      
      <div class="subject" id="<?php echo $row['ID_subject'];?>">
        <h2><?php echo $row['name']; ?></h2>
        <!--- ajout d'un bouton de follow de sujet -->
        <?php if(isset($_SESSION['ID'])){
          if(sujetIsFollow($_SESSION['ID'], $row['ID_subject'])){

          ?>
            <form action="./action/unfollowSubject.php" method="POST">
              <input type="hidden" name="ID_subject" value="<?php echo $row['ID_subject'];?>">
              <button type="submit" class="btn btn-primary">Ne plus suivre</button>
            </form>
            <?php
          } else {
            ?>
            <form action="./action/followSubject.php" method="POST">
              <input type="hidden" name="ID_subject" value="<?php echo $row['ID_subject'];?>">
              <button type="submit" class="btn btn-primary">Suivre</button>
            </form>
            <?php
          }
        }
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
    echo '</div>';
  } else {
    echo '<div class="follow">';
    if(isset($_SESSION['ID'])){
      $result = dbFollow($_SESSION['ID']);
      if($result == null){
        echo '<div class="alert alert-warning" role="alert">Vous n\'avez pas de sujet suivis</div>';
      } else {
      
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
        }
        echo '</div>';
      
    } else {
      echo '<div class="alert alert-warning" role="alert">Vous devez être connecté</div>';
    }
  }
  ?>

  </div>

  

  
</div>


</div>
<?php
include("./PageParts/footer.php");
?>