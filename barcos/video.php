<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>Video</title>
  <link rel="stylesheet" href="css/app.css">
</head>
<body class="barcos_hud">
  <div class="top_panel">
    <div class="back_grid">
      <button class="back_btn" onclick="back_btn()">
        <img src="<?=$DIR_ICONS?>atras.svg">
      </button>
      <div class="title_lang_grid">
        <h3 class="top_panel_title"><?= $barco['nombre'] ?></h3>
        <p class="top_panel_language">
          <a href="<?= $current_url_no_params ?>?lang=esp" class="<?= ($_SESSION["lang"] == 'esp') ? 'selected' : '' ?>">Esp</a>
          <span class="top_panel_stick">|</span>
          <a href="<?= $current_url_no_params ?>?lang=eng" class="<?= ($_SESSION["lang"] == 'eng') ? 'selected' : '' ?>">Eng</a>
          <span class="top_panel_stick">|</span>
          <a href="<?= $current_url_no_params ?>?lang=glg" class="<?= ($_SESSION["lang"] == 'glg') ? 'selected' : '' ?>">Gal</a>
        </p>
      </div>
    </div>

    <div class="turn">
      <div class="turn_caption">
        <h3 class="turn_txt"><?= $object['nombre'] ?></h3>
      </div>
      <div class="turn_icon">
        <img src="<?=$DIR_ICONS?>360-barco.svg">
      </div>
    </div>
  </div>

  <video class="video_player" src=""></video>



</body>
</html>
