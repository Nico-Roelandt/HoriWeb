

<?php
if(!isset($_SESSION)){
    session_start();
}
require_once("../PageParts/dbConnect.php");
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
        $_SESSION['errorNewPost'] = "true";
    } else {
        $_SESSION['errorNewPost'] = "false";
    }
    if(isset($_SESSION['errorNewPost'])){
        echo $_SESSION['errorNewPost'];
    } else {
      echo "errorNewPost is not set";
    }
    // Rediriger l'utilisateur vers une autre page après l'insertion des données
    header("Location: ../");
    exit();
}

?>
