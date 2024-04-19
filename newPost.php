
<?php
include("PageParts/header.php");
//Request list of subjects
$result = dbSubject();
?>
<div class="container mt-5">
    <h2 class="mb-4">Nouvelle publication</h2>
    <form method="POST" action="./action/newPost.php">
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