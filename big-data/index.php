<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");

  $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
  $current_url_no_params = $SERVER_URL.$uri_parts[0];

  $ELEMS = get_strings();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?=$ELEMS["TIT_INTERACTIVO"]?></title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <section class="screen screen_lang" style="background: url('icons/fondo.jpg') no-repeat center center;">
    <div class="screen_lang_icon">
      <img src="<?=$DIR_ICONS?>dedo-click.svg">
    </div>

    <h1 class="screen_lang_title"><?= $ELEMS['INDEX_TITLE'] ?></h1>

    <ul class="screen_lang_list">
    <?php foreach ( $LANG_MENU as $key => $value ) { ?>
      <li>
        <a
          href="main.php?lang=<?=$key?>"
          class="screen_lang_btn <?= ($_SESSION["lang"] == $key) ? 'selected' : '' ?>"><?=$value?>
        </a>
      </li>
    <?php } ?>
    </ul>
  </section>

  <script language="Javascript">

    function setCookie(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }
    setCookie('slug', 'redirect_page', 1);
    setCookie('show', '', 1);
  </script>
  <script type="text/javascript" src="../js/scripts_nosocket.js"></script>
</body>
</html>
