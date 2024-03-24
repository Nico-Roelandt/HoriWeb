<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="./style/sidebar.css">
    <link rel="stylesheet" href="./style/post.css">
    <!-- #region -->
</head>
<body>

<!-- Barre latérale -->
<div class="sidebar">
    <a href="/WE4A_project/HoriWeb/">
      <img class="logo" src="\WE4A_project\HoriWeb\icon\home.png"/>
    </a>
    <a href="#">
      <img class="logo" src="\WE4A_project\HoriWeb\icon\trend.png"/>
    </a>
    <a href="#"></a>
    <a href="#"></a>
</div>

<!-- Contenu principal -->

<div class="content">
  <h2>Subject 1</h2>
  <div class="subject">
  <?php
  for($i=0; $i<10; $i++ ){
  ?>
    <div class="post">
      <p>  Jean Pierre Pierre Pierre Pierre Pierre Pierre Pierre Pierre Pierre Pierre Pierre Pierre Pierre Pierre Pierre Pierre PierrePierrePierrePierrePierrePierrePierrePierrePierrePierrePierrePierrePierrePierrePierre  </p>
      <div class="react">
        <img class="logo" src="\WE4A_project\HoriWeb\icon\home.png"/>
        <img class="logo" src="\WE4A_project\HoriWeb\icon\home.png"/>
        <img class="logo" src="\WE4A_project\HoriWeb\icon\home.png"/>
      </div>
    </div>
  <?php
  }
  ?>
    <div class="post">
      Bonjour
    </div>
  </div>
  <h2>Subject 2</h2>
  <div class="subject">
    <div class="post">
      Bonjour
    </div>
  </div>
</div>
</body>
</html>
