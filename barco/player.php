<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");


$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$current_url_no_params = "https://".$_SERVER["HTTP_HOST"]."$uri_parts[0]";


$ELEMS      = get_strings();

$barcos = get_detalles();
// $barcos = [$barcos[1]];
$clickables = get_clickables(1);






// var_dump($_SESSION["lang"]);

$b = (isset($_GET['barco'])) ? $_GET['barco'] : "";
$barco = array_values(array_filter( $barcos, function($ship){ global $b; return ($ship['slug'] == $b); }))[0]; // aqui se filtra el barco correcto

$clickables = get_clickables($barco['bde_id']); // importante ejecutar despues de filtrar el barco correcto

$c = (isset($_GET['nombre'])) ? $_GET['nombre'] : "";
$object = array_values(array_filter( $clickables, function($obj){ global $c; return ($obj['slug'] == $c); }))[0];

// var_dump(array_values($barco)[0]);
// var_dump($object);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title>360º Player</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>

  <div class="top_panel">
    <div class="back_grid">
      <button class="back_btn" onclick="window.history.back()">
        <img src="<?=$DIR_ICONS?>atras.svg">
      </button>
      <div class="title_lang_grid">
        <h3 class="top_panel_title" style="text-shadow: 1px 1px #666;"><?= $barco['nombre'] ?></h3>
        <p class="top_panel_language" style="text-shadow: 1px 1px #666;">
          <a href="main.php?lang=esp" class="<?= ($_SESSION["lang"] == 'esp') ? 'selected' : '' ?>">Esp</a>
          <span class="top_panel_stick">|</span>
          <a href="main.php?lang=eng" class="<?= ($_SESSION["lang"] == 'eng') ? 'selected' : '' ?>">Eng</a>
          <span class="top_panel_stick">|</span>
          <a href="main.php?lang=glg" class="<?= ($_SESSION["lang"] == 'glg') ? 'selected' : '' ?>">Gal</a>
        </p>
      </div>
    </div>

    <div class="turn">
      <div class="turn_caption">
        <h3 class="turn_txt" style="text-shadow: 1px 1px #666;"><?= $ELEMS[$object['slug']] ?></h3>
      </div>
      <div class="turn_icon">
        <img src="<?=$DIR_ICONS?>360-barco.svg">
      </div>
    </div>
  </div>
<div class="loader">
    <div class="loading text-center text-white">
        <h1>Loading...</h1>
        <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>
</div>
<div class="controls" style="display:none;">
    <button id="play" class="btn btn-outline-primary">
        Play
    </button>
    <button id="stop" class="btn btn-outline-danger">
        Pause
    </button>
    <button id="back" class="btn btn-outline-warning">
        Volver atrás
    </button>
</div>
<canvas id="renderCanvas" class=""></canvas>
<script type="text/javascript" src="js/app.js"></script>
<script>
$(document).ready(function() {

  $('#back').on("click", function() {
    document.location.href='index.html';
  });

  $('#play').click();

});

</script>
</body>
</html>
