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
  // $clickables = get_clickables(1);

  $b = (isset($_GET['barco'])) ? $_GET['barco'] : "";
  $barco = array_values(array_filter( $barcos, function($ship){ global $b; return ($ship['slug'] == $b); }))[0]; // aqui se filtra el barco correcto

  $clickables = get_clickables($barco['bde_id']); // importante ejecutar despues de filtrar el barco correcto

  $c = (isset($_GET['nombre'])) ? $_GET['nombre'] : "";
  $object = array_values(array_filter( $clickables, function($obj){ global $c; return ($obj['slug'] == $c); }))[0];
  // var_dump($barco);
  // echo "<br>";
  // echo "<br>";
  // var_dump($object);
  // echo "<br>";
  // echo "<br>";
  $buttons_color = ( isset($ELEMS["BUTTONS_COLOR"]) ? $ELEMS["BUTTONS_COLOR"]:"white");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>Video</title>
  <link rel="stylesheet" href="css/app.css">
  <style>
    body {
      background-color: #111;
    }
  </style>
</head>
<body class="barcos_hud">
  <div class="top_panel">
    <div class="back_grid">
      <a class="back_btn home_btn" href="index.php" class="home_btn" style="color: <?= $buttons_color ?>;">
        <?php include $DIR_ICONS.'home.svg' ?>
      </a>
      <a class="back_btn" href="main.php?lang=<?= $_SESSION["lang"] ?>&barco=<?= $_GET['barco'] ?>" style="color: <?= $buttons_color ?>;">
        <?php include $DIR_ICONS.'atras.svg' ?>
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

    <div class="turn">
      <div class="turn_caption">
        <h3 class="turn_txt" style="text-shadow: 1px 1px #666;"><?= $ELEMS[$object['slug']] ?></h3>
      </div>
      <div class="turn_icon">
      </div>
    </div>
  </div>

  <video class="video_player" muted autoplay style="width:100vw;height:100vh; object-fit: cover">
    <source src="<?= $DIR_MEDIA . $object['media'] ?>" type="video/mp4">
  </video>

  <script type="text/javascript" src="../js/scripts_nosocket.js"></script>

</body>
</html>
