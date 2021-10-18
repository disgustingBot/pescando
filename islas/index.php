<?php
require_once("inc.config.php");
require_once("../inc.basic.php");
require_once("../inc.registra_visita.php");
require_once("../inc.salvapantallas.php");
require_once("../inc.alive.php");

$ELEMS      = get_strings();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Islas de plástico</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <section class="lang_screen" style="background-image: url('<?= $DIR_IMG ?>fondo-inicio.jpg')">
    <div class="lang_screen_icon">
      <img src="<?= $DIR_ICONS ?>dedo-click.svg">
    </div>

    <h1 class="lang_screen_title">Las Islas de plástico</h1>
    <h1 class="lang_screen_title lang_screen_title_sm">La contaminación de nuestros océanos</h1>
    <ul class="lang_screen_list">
      <li class="lang_selection_li">
        <a
          href="main.php?lang=es"
          class="lang_screen_btn">Español
        </a>
        <img class="lang_screen_pointer" src="<?= $DIR_ICONS ?>dedo-rojo.svg">
      </li>
      <li class="lang_selection_li">
        <a
          href="main.php?lang=es"
          class="lang_screen_btn">English
        </a>
        <img class="lang_screen_pointer" src="<?= $DIR_ICONS ?>dedo-rojo.svg">
      </li>
      <li class="lang_selection_li">
        <a
          href="main.php?lang=es"
          class="lang_screen_btn">Galego
        </a>
        <img class="lang_screen_pointer" src="<?= $DIR_ICONS ?>dedo-rojo.svg">
      </li>
    </ul>
  </section>

  <script type="text/javascript" src="../js/scripts_nosocket.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
</body>
</html>
