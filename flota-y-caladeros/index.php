<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");

  $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
  $current_url_no_params = $SERVER_URL.$uri_parts[0];

  $ELEMS  = get_strings();

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
  <div class="in_animate_screen">
    <svg class="in_screen_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.78 21.79">
      <title>Pescanova</title>
      <g id="Capa_2" data-name="Capa 2"><g id="Layer_1" data-name="Layer 1"><path d="M29.3,18.78a4.55,4.55,0,0,1-6.1-.11,1.72,1.72,0,0,0-2.2,0,4.55,4.55,0,0,1-6.22,0,1.72,1.72,0,0,0-2.2,0A4.72,4.72,0,0,1,9.47,19.9a4.72,4.72,0,0,1-3.11-1.23,1.72,1.72,0,0,0-2.2,0,5.15,5.15,0,0,1-.68.5L4.29,12H33ZM8.49,8.4H22.61L24,10.15H8.3ZM8.8,5.63H20.49l.68.88H8.7Zm2.1-3.74h6.59a2.18,2.18,0,0,1,2.25,1.85H10.9Zm23.84,18a4.76,4.76,0,0,1-3.06-1.18l4-7.2a.85.85,0,0,0,0-.92,1.08,1.08,0,0,0-.89-.45H26.52l-4.62-6,0-.06V3.93A4.16,4.16,0,0,0,17.49,0H7.78a1,1,0,0,0-1,1,1,1,0,0,0,1,.94h1V3.74h-1a1,1,0,0,0-1,.85l-.61,5.56H4.28a2,2,0,0,0-2.08,1.7l-.41,3.62H1.05a1,1,0,1,0,0,1.89h.53l-.19,1.69h0a1.76,1.76,0,0,0,.11.82l-.45,0a1,1,0,1,0,0,1.89,6.83,6.83,0,0,0,4.21-1.47,6.76,6.76,0,0,0,8.42,0,6.76,6.76,0,0,0,8.42,0,6.76,6.76,0,0,0,8.42,0,6.85,6.85,0,0,0,4.22,1.47.95.95,0,1,0,0-1.89"/></g></g>
    </svg>
  </div>

  <section class="lang_screen full_screen">
    <div class="lang_screen_icon">
      <img src="<?=$DIR_ICONS?>dedo-click.svg">
    </div>

    <h1 class="lang_screen_title"><?= $ELEMS['INDEX_TITLE'] ?></h1>
    <ul class="lang_screen_list">
      <li>
        <a
          href="main.php?lang=esp"
          class="lang_screen_btn <?= ($lang == 'esp') ? 'selected' : '' ?>">Español
        </a>
      </li>

      <li>
        <a
          href="main.php?lang=eng"
          class="lang_screen_btn <?= ($lang == 'eng') ? 'selected' : '' ?>">English
        </a>
      </li>

      <li>
        <a
          href="main.php?lang=glg"
          class="lang_screen_btn <?= ($lang == 'glg') ? 'selected' : '' ?>">Galego
        </a>
      </li>
    </ul>
  </section>

  <script type="text/javascript" src="js/main.js"></script>
</body>
</html>
