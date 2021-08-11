<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");

  $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
  $current_url_no_params = $SERVER_URL.$uri_parts[0];

  $ELEMS      = get_strings();

?>
<!DOCTYPE html>
<html lang="es">
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
  <section class="screen_lang screen">
    <div class="lang_icon">
      <img src="<?=$DIR_ICONS?>dedo-click.svg">
    </div>
    
    <h1 class="lang_title"><?= $ELEMS['INDEX_TITLE'] ?></h1>
    <ul class="lang_list">
      <li>
        <a
          href="main.php?lang=esp"
          class="btn btn_lang <?= ($_SESSION["lang"] == 'esp') ? 'selected' : '' ?>">Español
        </a>
      </li>

      <li>
        <a
          href="main.php?lang=eng"
          class="btn btn_lang <?= ($_SESSION["lang"] == 'eng') ? 'selected' : '' ?>">English
        </a>
      </li>

      <li>
        <a
          href="main.php?lang=glg"
          class="btn btn_lang <?= ($_SESSION["lang"] == 'glg') ? 'selected' : '' ?>">Galego
        </a>
      </li>
    </ul>
  </section>

  <script type="text/javascript" src="../js/scripts_nosocket.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
</body>
</html>
