
<?php
include("./PageParts/header.php");
?>
<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">
<title>HoriWeb-Login </title>
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
      border: 1px solid #ccc;
      box-sizing: border-box;
      
    }
    input[type="submit"] {
      background-color: blue;
      color: white;
      
    }
    input[type="submit"]:hover {
      background-color: blue;
    }
  </style>
</head> 
<body>



</div>
    <form action="./login.php" method="post">
        <div class="container">
        <h2>Connexion</h2> 
        <label for="username">Adresse e-mail:</label>		
        <input autofocus type="text" name="mail">
        <label for="password">Mot de passe:</label>
        <input type="password" name="password">
        <input type="submit" value="Se connecter">
        <div class="create-account">
            <p>Vous n'avez pas de compte ? <a href="./newAccount.php">Créer un compte</a></p>
        </div>
        </div>
</body>


?>
  