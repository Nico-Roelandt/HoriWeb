<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">
<title>HoriWeb-Login </title>
</head>
<body>
<div id="MainContainer">
	<h1>Login</h1>
    <p><a href="./newAccount.php" class="endlink">Créer un nouveau compte >></a><br><br></p>
    <?php
	if(isset($_POST["name"]) && isset($_POST["password"])){
		$mail = $_POST["mail"];
		$password = md5($_POST["password"]);
		$loginAttempted = true;
	}
	
	elseif ( isset( $_COOKIE["mail"] ) && isset( $_COOKIE["password"] ) ) {
		$name = $_COOKIE["mail"];
		$password = $_COOKIE["password"];
		$loginAttempted = true;
	}
	else {
		$loginAttempted = false;
	}
	
	
	$loginSuccessful = false;

	if ( $loginAttempted ){
		$loginSuccessful = ($mail == "elie.vitrai@gmail.com") && ($password == md5("Elie"));
	}
	
	if ($loginSuccessful == false){
	
		if ($loginAttempted == false){
			echo '<h3>Pas de données recues = le formulaire s\'affiche</h3>';
		}
		else {
			echo '<h3 class="warning">Login tenté, mais Incorrect!</h3>';
		}


	?>
	<form action="./login.php" method="post">
	
		<div class="formbutton">Login</div>
		<div>
			<label for="name">Login :</label>
			<input autofocus type="text" name="name">
		</div>
		<div>
			<label for="password">Password :</label>
			<input type="password" name="password">
		</div>
		<div class="formbutton">
			<button type="submit">connexion</button>
		</div>
	</form>
	<hr>
	<?php

	}
	else {

	echo '<h3>Login réussi!</h3>';

	
	setcookie('name', $name, time()+3600*24);
    setcookie('password', $password, time()+3600*24);

	?>
	
	<hr>
	<p><a class="endlink" href="./home.php">Aller sur la page d'acceuil &gt;&gt;</a></p>
	<br>
	<br>
	<?php

	
}	

?>

</div>
</body>


