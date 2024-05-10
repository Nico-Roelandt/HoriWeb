<?php
include("./PageParts/header.php");
if(!isset($_SESSION)){
    session_start();
}
require_once("./PageParts/dbConnect.php");
dbConnect();
if(!isset($_SESSION['ID'])){
    header("Location: ./login.php");
    exit();
}
$User = getUser($_SESSION['ID']);
$username = $User['Username'];
$firstname = $User['FirstName'];
$name = $User['Name'];
$birthdate = $User['Birthdate'];
$description = $User['ProfilDescription'];


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #fafafa;
            text-align: center;
        }
        .profile {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column; /* Modification */
            align-items: center;
        }
        .profile img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px; /* Modification */
            cursor: pointer;
        }
        input[type="file"] {
            display: none;
        }
        label {
            cursor: pointer;
            color: #007bff;
            text-decoration: underline;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #dbdbdb;
            border-radius: 4px;
            resize: vertical;
            background-color: #fafafa;
        }
        input[type="submit"] {
            background-color: #0095f6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 10px;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #0086e5;
        }
        p {
            margin: 5px 0;
            font-size: 14px;
            color: #262626;
        }
        span {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="profile">
        <h1>Modifier le profil</h1>
        <img id="profilePic" src="./icon/user.png" alt="Photo de profil">
        <form id="profileForm" action="./action/updateUser.php">

            <label for="description">Changer la photo de profil</label></br>
            <input type="file" id="profilePic" name="profilePic">

            <span for="username">Nom d'utilisateur</>
            <input type="text" name="username" value="<?php echo $username?>" required>

            <span for="firstname">Prénom</>
            <input type="text" name="firstname" value="<?php echo $firstname?>" required>

            <span for="name">Nom</>
            <input type="text" name="name" value="<?php echo $name?>" required>

            <span for="birthdate">Date de naissance</></br>
            <input type="date" name="birthdate" value="<?php echo $birthdate?>" required></br>

            <span for="password">Changer le mot de passe</>
            <input type="password" name="password">

            <span for="description">Description</>
            <textarea name="description" rows="5" required><?php echo $description?></textarea>

            <input type="submit" value="Enregistrer">
        </form>
    </div>
</body>
</html>
<?php
dbDisconnect();
?>