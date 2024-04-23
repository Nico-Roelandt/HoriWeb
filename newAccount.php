<?php
include("./PageParts/header.php");
?>
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