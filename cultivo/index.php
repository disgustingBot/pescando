<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");

  $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
  $current_url_no_params = $SERVER_URL.$uri_parts[0];

  $ELEMS  = get_strings();

  if ( isset($_GET['central']) ) {
    $_SESSION["central"] = intval(trim($_GET["central"]));
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Refresco salvapantallas cada 30 minutos //-->
  <meta http-equiv="refresh" content="1800" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?=$ELEMS["TIT_INTERACTIVO"]?></title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <section class="lang_screen full_screen">
    <div class="lang_screen_icon">
      <img src="<?=$DIR_ICONS?>dedo-click.svg">
    </div>

    <h1 class="lang_screen_title"><?= $ELEMS['INDEX_TITLE'] ?></h1>
    <ul class="lang_screen_list">
    <?php foreach ( $LANG_MENU as $key => $value ) { ?>
      <li class="lang_selection_li">
        <a
          href="main.php?lang=<?=$key?>"
          class="lang_screen_btn <?=($_SESSION["lang"] == $key) ? 'selected' : ''?>">
          <?=$value?>
        </a>
        <img class="lang_screen_pointer" src="<?=$DIR_ICONS?>dedo-rojo.svg">
      </li>
    <?php } ?>
    </ul>
  </section>

  <script type="text/javascript" src="../js/scripts_nosocket.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
</body>
</html>
