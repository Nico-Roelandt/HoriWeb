

<?php
if(!isset($_SESSION)){
    session_start();
}
require_once("../PageParts/dbConnect.php");
//Request list of subjects
$result = dbSubjectAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $content = $_POST['content'];
    $destination = null;
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image']['tmp_name'];
        $filename = uniqid() . '_' . $_FILES['image']['name'];
        $destination = 'uploads/' . $filename;
        
        // Vérifier le type de fichier
        $file_info = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($file_info, $tmp_name);
        
        // Autoriser seulement certains types de fichiers (ex. jpeg, png)
        $allowed_types = array('image/jpeg', 'image/png');
        if (in_array($mime_type, $allowed_types)) {
            // Redimensionner l'image si nécessaire
            // Exemple: redimensionner l'image pour avoir une largeur maximale de 800px
            $max_width = 800;
            list($width, $height) = getimagesize($tmp_name);
            if ($width > $max_width) {
                $ratio = $max_width / $width;
                $new_width = $max_width;
                $new_height = $height * $ratio;
                $image_resized = imagecreatetruecolor($new_width, $new_height);
                // Code pour redimensionner l'image
            }
            
            // Déplacer l'image vers le dossier d'uploads
            move_uploaded_file($tmp_name, $destination);
        } else {
            echo "Format d'image non supporté.";
        }
    }
  

    //Recupération du ID du subject
    foreach($result as $row){
        if($row['name'] == $subject){
            $ID_subject = $row['ID_subject'];
        }
    }


    // Insérer les données dans la base de données
    if(newPost($ID_subject, $content, $destination) == false){
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
