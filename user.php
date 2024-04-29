
<?php
include("./PageParts/header.php");
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
            background-color: #f0f0f0;
            text-align: center;
        }
        .profile {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
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
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="profile">
        <form id="profileForm">
            <label for="profilePicInput">
                <img id="profilePic" src="lien-de-votre-photo-de-profil.jpg" alt="Photo de profil">
                <br>
                Modifier la photo de profil
            </label>
            <input type="file" id="profilePicInput" name="profilePic" accept="image/*">
            <label for="username">Nom du Compte:</label>
            <input type="text" id="username" name="username" value="Nom du Compte">
            <label for="description">Description de l'utilisateur:</label>
            <textarea id="description" name="description" rows="4" cols="50">Description de l'utilisateur</textarea>
            <p>Nombre de posts: <span id="postCount">XX</span></p>
            <p>Nombre de followers: <span id="followerCount">XX</span></p>
            <input type="submit" value="Enregistrer">
        </form>
    </div>

    <script>
        document.getElementById("profilePicInput").addEventListener("change", function() {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("profilePic").src = e.target.result;
            };
            reader.readAsDataURL(file);
        });

        document.getElementById("profileForm").addEventListener("submit", function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            document.getElementById("profilePic").src = formData.get("profilePic");
            document.getElementById("username").textContent = formData.get("username");
            document.getElementById("description").textContent = formData.get("description");
        });
    </script>
</body>
</html>
