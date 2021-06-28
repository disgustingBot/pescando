<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");


$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$current_url_no_params = "https://".$_SERVER["HTTP_HOST"]."$uri_parts[0]";


$ELEMS      = get_strings();

$barcos = array(
  array(
    'image' => 'tangonero.jpg',
    'nombre' => 'Tangonero',
    'slug' => 'tangonero',
    'svg' => 'timbue-esp.svg',
  ),
  array(
    'image' => 'arrastrero.jpg',
    'nombre' => 'Arrastrero',
    'slug' => 'arrastrero',
    'svg' => 'timbue-esp.svg',
  ),
);
// TODO: cambiar el svg
// DE PEPUS PARA SOFIA acuérdate que los nombres de los clickables cambian a general / cocina / factoria / camarotes / cubierta / comedor / salamaquinas / salacontrol
// Lo ideal sería crear una funcion get_clickables, de momento créala aquí y yo ya la trasladaré al inc.funcs.php del webadmin
$clickables = array(
  array(
    'slug' => 'salamaquinas',
    'nombre' => 'Sala de máquinas',
    'barco' => 'tangonero',
    'type' => 'image',
    'media' => 'panorama8K.jpeg',
  ),
  array(
    'slug' => 'salacontrol',
    'nombre' => 'Sala de mandos',
    'barco' => 'arrastrero',
    'type' => 'video',
    'media' => 'barco_previo360_low.mp4',
  ),
);


$b = (isset($_GET['barco'])) ? $_GET['barco'] : "";
$barco = array_values(array_filter( $barcos, function($ship){ global $b; return ($ship['slug'] == $b); }))[0];

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

    <title>360 Player</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
  <svg class="red_arrow_barco red_arrow_top" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.51 55.02"><defs><style>.cls-1{fill:#f90022;}</style></defs><title>triangulao bolasRecurso 5</title><g id="Capa_2" data-name="Capa 2"><g id="Layer_1" data-name="Layer 1"><polygon class="cls-1" points="0 27.51 27.51 55.02 27.51 0 0 27.51"/></g></g></svg>
  <svg class="red_arrow_barco red_arrow_right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.51 55.02"><defs><style>.cls-1{fill:#f90022;}</style></defs><title>triangulao bolasRecurso 5</title><g id="Capa_2" data-name="Capa 2"><g id="Layer_1" data-name="Layer 1"><polygon class="cls-1" points="0 27.51 27.51 55.02 27.51 0 0 27.51"/></g></g></svg>
  <svg class="red_arrow_barco red_arrow_left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.51 55.02"><defs><style>.cls-1{fill:#f90022;}</style></defs><title>triangulao bolasRecurso 5</title><g id="Capa_2" data-name="Capa 2"><g id="Layer_1" data-name="Layer 1"><polygon class="cls-1" points="0 27.51 27.51 55.02 27.51 0 0 27.51"/></g></g></svg>
  <svg class="red_arrow_barco red_arrow_bottom" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.51 55.02"><defs><style>.cls-1{fill:#f90022;}</style></defs><title>triangulao bolasRecurso 5</title><g id="Capa_2" data-name="Capa 2"><g id="Layer_1" data-name="Layer 1"><polygon class="cls-1" points="0 27.51 27.51 55.02 27.51 0 0 27.51"/></g></g></svg>


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
