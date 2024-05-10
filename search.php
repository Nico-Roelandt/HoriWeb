<?php
// Inclusion du fichier d'en-tête
include("./PageParts/header.php");

// Vérification des erreurs de session
if(isset($_SESSION['error'])){
  echo '<div class="alert alert-danger" role="alert">'.$_SESSION['error'].'</div>';
  unset($_SESSION['error']);
}
?>

<!-- Contenu principal -->
<div class="content">
  <h1>Recherche de Posts</h1>

  <!-- Formulaire de recherche -->
  <form action="search.php" method="GET">
    <div class="input-group mb-3">
      <input type="text" class="form-control" placeholder="Rechercher" name="query">
        <div class="input-group-append">
            <select class="form-select" name="type">
              <option value="posts">Posts</option>
              <option value="users">Utilisateurs</option>
              <option value="subject">Sujets</option>
            </select>
        </div>
      <button class="btn btn-outline-secondary" type="submit">Rechercher</button>
    </div>
  </form>

  <?php
    if(isset($_GET['query']) && isset($_GET['type'])){
      $query = $_GET['query'];
      $type = $_GET['type'];
      $result = search($query, $type);
      if($result == null){
        echo '<div class="alert alert-warning" role="alert">Aucun résultat</div>';
      } else {
        foreach($result as $row){
          if($type == "posts"){
            $postHTML = generatePostHTML($row);
            echo $postHTML;
          } else if($type == "users"){
            $userHTML = generateUserHTML($row);
            echo $userHTML;
          } else if($type == "subject"){
            ?>
            <div class="subject" id="<?php echo $row['ID_subject'];?>">
            <h2><?php echo $row['name']; ?></h2>
            <?php
            if(isset($_SESSION['ID'])){
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
          }
        }
      }
    } else {
      echo '<div class="alert alert-warning" role="alert">Veuillez entrer une recherche</div>';
    }
  ?>

</div>

<?php
// Inclusion du fichier de pied de page
include("./PageParts/footer.php");
?>
