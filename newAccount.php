<?php
include("./PageParts/dbConnect.php");
dbConnect();
$newAccountStatus = CheckNewAccountForm();

if ($newAccountStatus["Successful"] != NULL){
	  header("Location:http://".$rootpath."/index.php");
}
else{
  echo $newAccountStatus["ErrorMessage"];
}


?>
<title>Connexion</title>
<?php
    if($newAccountStatus["Successful"]){
        echo '<h3 class="successMessage">Nouveau compte crée avec succès!</h3>';
    }
    elseif ($newAccountStatus["Attempted"]){
        echo '<h3 class="errorMessage">'.$newAccountStatus['ErrorMessage'].'</h3>';
    }
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
  <form action="#" method="post">
    <div class="container">
      <h2>Créer un compte</h2>
      <label for="firstname">Prénom:</label>
      <input autofocus type="text" id="prénom" name="firstname">
      <label for="name">Nom:</label>
      <input type="text" id="name" name="name">
      <label for="date">Date de naissance:</label>
      <input type="date"/></br>
      <label for="mail">Adresse e-mail:</label>
      <input type="text" name="mail">
      <label for="password">Mot de passe:</label>
      <input type="password" id ="password" name="password">
      <label for ="confirm">Confirmer le mot de passe:</label>
      <input type="password" id="confirm" name="confirm"> 
      <input type="submit" value="Créer le compte">
    </div>
  </form>
</body>

<?php
dbDisconnect()
?>