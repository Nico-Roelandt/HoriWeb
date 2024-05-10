<?php
include("./PageParts/dbConnect.php");
include("./PageParts/header.php");
dbConnect();
if(isset($_SESSION['ID'])){
    header("Location: ./index.php");
    exit();
}
if(isset($_SESSION['error'])){
    echo '<div class="alert alert-danger" role="alert">'.$_SESSION['error'].'</div>';
    unset($_SESSION['error']);
}

?>
<title>Connexion</title>
<?php

?>

  
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
<body>
  <form action="/Horiweb/action/newaccount.php" method="post">
    <div class="container">
      <h2>Créer un compte</h2>

      <label for="firstname">Prénom:</label>
      <input autofocus type="text" id="prenom" name="firstname" required>
      
      <label for="name">Nom:</label>
      <input type="text" id="name" name="name" required>

      <label for="username">Username :</label>
      <input type="text" id="username" name="username" required>

      <label for="date">Date de naissance:</label>
      <input type="date" name="date" required/></br>

      <label for="mail">Adresse e-mail:</label>
      <input type="text" name="mail" required>

      <label for="password">Mot de passe:</label>
      <input type="password" id ="password" name="password" required>

      <label for ="confirm">Confirmer le mot de passe:</label>
      <input type="password" id="confirm" name="confirm"> 

      <input type="submit" value="Créer le compte" required>
    </div>
  </form>
</body>

<?php
dbDisconnect()
?>