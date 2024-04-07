
<?php
include("./PageParts/header.php");


//Request list of subjects
$result = dbSubject();





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Le formulaire a été soumis, donc traitons les données

    // Récupérer les données soumises par le formulaire
    $subject = $_POST['subject'];
    $content = $_POST['content'];
    // Vous pouvez également traiter le fichier image ici si nécessaire
    if(isset($_FILES['picture'])){
        $picture = $_FILES['picture'];
    } else {
      $picture = null;
    }
  

    //Recupération du ID du subject
    foreach($result as $row){
        if($row['name'] == $subject){
            $ID_subject = $row['ID'];
        }
    }


    // Insérer les données dans la base de données
    if(newPost($ID_subject, $content, $picture) == false){
        $_SESSION['error'] = "Erreur lors de l'insertion des données";
    }



    // Rediriger l'utilisateur vers une autre page après l'insertion des données
    header("Location: index.php");
    exit();
}

?>

<div class="container mt-5">
    <h2 class="mb-4">Nouvelle publication</h2>
    <form method="POST">
      <div class="mb-3">
        <label for="title" class="form-label">Sujet</label>
        <select class="form-select" id="subject" name="subject" required>
          <option>Choisissez un sujet</option>
            <?php
            foreach($result as $row){
            ?>
            <option><?php echo $row['name']; ?></option>
            <?php
            }
            ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="content" class="form-label">Contenu</label>
        <textarea class="form-control" id="content" rows="4" name="content" placeholder="Entrez le contenu du post" required></textarea>
      </div>
      <div class="mb-3">
        <label for="formFile" class="form-label">Importer une image</label>
        <input class="form-control" type="file" id="formFile" accept="image/*">
      </div>
      <button type="submit" class="btn btn-primary">Publier</button>
    </form>
  </div>

</body>
</html>