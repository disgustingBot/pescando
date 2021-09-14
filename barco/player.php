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
      <a class="back_btn" href="main.php?lang=<?= $_SESSION["lang"] ?>&barco=<?= $_GET['barco'] ?>">
        <img src="<?=$DIR_ICONS?>atras.svg">
      </a>
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

    <!-- <div class="turn"> -->
      <div class="turn_caption">
        <h3 class="turn_txt" style="text-shadow: 1px 1px #666;"><?= $ELEMS[$object['slug']] ?></h3>
      </div>
    <!-- </div> -->
  </div>

  <div class="turn_background">
    <div class="turn_icon turn_icon_full_screen">
      <!-- <img src="<?=$DIR_ICONS?>360-barco.svg"> -->
      <img src="<?=$DIR_ICONS?>360-blanco.svg">
    </div>

    <div class="triangle_cross">
      <div class="triangle_btn triangle_up">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.51 55.02"><defs><style>.cls-1{fill:#f90022;}</style></defs><title>triangulao bolasRecurso 5</title><g id="Capa_2" data-name="Capa 2"><g id="Layer_1" data-name="Layer 1"><polygon class="cls-1" points="0 27.51 27.51 55.02 27.51 0 0 27.51"/></g></g></svg>
      </div>

      <div class="triangle_cross_half">
        <div class="triangle_btn triangle_left">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.51 55.02"><defs><style>.cls-1{fill:#f90022;}</style></defs><title>triangulao bolasRecurso 5</title><g id="Capa_2" data-name="Capa 2"><g id="Layer_1" data-name="Layer 1"><polygon class="cls-1" points="0 27.51 27.51 55.02 27.51 0 0 27.51"/></g></g></svg>
        </div>
        <div class="triangle_btn triangle_right">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.51 55.02"><defs><style>.cls-1{fill:#f90022;}</style></defs><title>triangulao bolasRecurso 5</title><g id="Capa_2" data-name="Capa 2"><g id="Layer_1" data-name="Layer 1"><polygon class="cls-1" points="0 27.51 27.51 55.02 27.51 0 0 27.51"/></g></g></svg>
        </div>
      </div>

      <div class="triangle_btn triangle_down">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.51 55.02"><defs><style>.cls-1{fill:#f90022;}</style></defs><title>triangulao bolasRecurso 5</title><g id="Capa_2" data-name="Capa 2"><g id="Layer_1" data-name="Layer 1"><polygon class="cls-1" points="0 27.51 27.51 55.02 27.51 0 0 27.51"/></g></g></svg>
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
<script type="text/javascript" src="js/main.js"></script>
<script>
$(document).ready(function() {

  $('#back').on("click", function() {
    document.location.href='index.html';
  });

  $('#play').click();

});

  const IconFullScreen = () => {
    altClassFromSelector('turn_background_off', '.turn_background', ['turn_background']);
    window.removeEventListener('touchstart', IconFullScreen);
  }
  window.addEventListener('touchstart', IconFullScreen);
</script>
</body>
</html>
