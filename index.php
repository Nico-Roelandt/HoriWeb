
<?php
include("./PageParts/header.php");

if(isset($_SESSION['error'])){
  $hasError = '1';
  unset($_SESSION['error']);
  echo "<script src='./JavaScript/script.js'></script>";
} else {
  $hasError = '0';
  echo "<script src='./JavaScript/script.js'></script>";
}
echo $hasError;



?>

<div onload="errorPost(1)" />

<!-- Contenu principal -->

<div class="content">
  <?php


  $result = dbSubject();
  //Print des sujets
  foreach($result as $row){
  ?>
    <div class="subject">
      <h2><?php echo $row['name']; ?></h2>
    <?php
    $resultpost = dbPost($row['ID'], 10); // METTRE CONST
    if($resultpost != null){

      foreach($resultpost as $rowpost){
      ?>
        <div class="post">
          <h3><?php echo $rowpost['Username']; ?></h3>
          <div class="date"><?php echo $rowpost['CreationDate']; ?></div>
          <p><?php echo $rowpost['Text']; ?></p>
          <div class="react">
            <img class="logo" src="\HoriWeb\icon\home.png"/>
            <img class="logo" src="\HoriWeb\icon\home.png"/>
            <img class="logo" src="\HoriWeb\icon\home.png"/>
          </div>
        </div>




      <?php
      }
    }
  }
  ?>

  </div>
  





</div>
</body>
</html>
