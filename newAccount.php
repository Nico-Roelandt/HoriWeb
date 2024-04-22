
<?php
include("./PageParts/header.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      
    }
    .container {
      max-width: 400px;
      margin: 100px auto;
      padding: 20px;
    }
    h2 {
      text-align: center;
    }
    input[type="text"],
    input[type="password"],
    input[type="submit"] {  
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
    }
    input[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <form method="$_GET" class="container">
    <h2>Créer un compte</h2>
    <label for="firstname">Prénom:</label>
    <input autofocus type="text" name="prénom">
    <label for="name">Nom:</label>
    <input type="text" name="name">
    <label for="username">Adresse e-mail:</label>
    <input type="text" name="mail">
    <label for="password">Mot de passe:</label>
    <input type="password" id ="password" name="password">
    <label for="date">Date de naissance:</label>
    <input type="date"/>
    <label for ="password">Confirmer le mot de passe:</label>
    <input type="password" name="password">
    <input type="submit" value="Créer le compte">
  </form>
</body>

</html>