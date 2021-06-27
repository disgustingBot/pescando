<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");


$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$current_url_no_params = "https://".$_SERVER["HTTP_HOST"]."$uri_parts[0]";


$ELEMS      = get_strings();

// TODO: cambiar el svg
// DE PEPUS PARA SOFIA acuérdate que los nombres de los clickables cambian a general / cocina / factoria / camarotes / cubierta / comedor / salamaquinas / salacontrol
// Lo ideal sería crear una funcion get_clickables, de momento créala aquí y yo ya la trasladaré al inc.funcs.php del webadmin
$clickables = array(
  array(
    'slug' => 'salamaquinas',
    'image' => 'timothy.jpg',
    'media' => 'timothy.jpg',
    // https://mansilladisseny.com/pescanova/barcos/player.html?type=image&source=panorama8K.jpeg
  ),
  // array(
  //   'slug' => 'deck',
  //   'image' => 'fondobarco-sin-flechas.jpg'
  // ),
  // array(
  //   'slug' => 'diner',
  //   'image' => 'gerson.jpg'
  // ),

);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title>360 Player</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
  <img class="red_arrow_barco red_arrow_top" src="<?=$DIR_ICONS?>triangulo-barco.svg">
  <img class="red_arrow_barco red_arrow_right" src="<?=$DIR_ICONS?>triangulo-barco.svg">
  <img class="red_arrow_barco red_arrow_left" src="<?=$DIR_ICONS?>triangulo-barco.svg">
  <img class="red_arrow_barco red_arrow_bottom" src="<?=$DIR_ICONS?>triangulo-barco.svg">

  <div class="top_panel">
    <div class="back_grid">
      <button class="back_btn" onclick="back_btn()">
        <img src="<?=$DIR_ICONS?>atras.svg">
      </button>
      <div class="title_lang_grid">
        <h3 class="top_panel_title">Ponta Timbue</h3>
        <p class="top_panel_language">
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
        <h3 class="turn_txt">Cubierta</h3>
      </div>
      <div class="turn_icon">
        <img src="<?=$DIR_ICONS?>360-barco.svg">
      </div>
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
