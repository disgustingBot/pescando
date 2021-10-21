<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");

  $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
  $current_url_no_params = $SERVER_URL.$uri_parts[0];

  $ELEMS = get_strings();
  $items = get_lineas();

  $buttons_color = ( isset($ELEMS["BUTTONS_COLOR"]) ? $ELEMS["BUTTONS_COLOR"]:"white");
  // $redirect_time = 10;

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?=$ELEMS["TIT_INTERACTIVO"]?></title>
  <link rel="stylesheet" href="css/style.css">
  <style>
  [class="screen_menu"] .menem{
    height:calc((100vh - 190px) / <?=count($items)?>);
  }
  </style>  
</head>

<body>
  <div class="in_animate_screen in_animate_screen_display">
    <svg class="in_screen_icon in_screen_icon_animate" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 68.34 68">
      <defs><style>.cls-2{fill:none;}</style></defs>
      <title>Pez</title>
      <g id="Layer_2" data-name="Layer 2"><g id="Capa_1" data-name="Capa 1"><path class="cls-1" d="M66.4,33.22A29.18,29.18,0,0,0,49.83,19.69a31,31,0,0,0-5.19-1.16A21.22,21.22,0,0,0,25.72,7.06h-2V21.65a72,72,0,0,0-7.14,3.27L1.32,17.13V29.24a6.74,6.74,0,0,0,2.05,4.87,6.76,6.76,0,0,0-2,4.88v12.1l15.26-7.78a71.83,71.83,0,0,0,7.14,3.26V61.16h2A21.23,21.23,0,0,0,44.64,49.7a30,30,0,0,0,5.19-1.17A29.18,29.18,0,0,0,66.4,35l.21-.44v-.93Zm-51.8,6.6L5.32,44.56V39a2.93,2.93,0,0,1,3.11-2.88H14.6Zm0-7.71H8.43a2.92,2.92,0,0,1-3.11-2.87V23.66L14.6,28.4ZM27.72,11.18a17.24,17.24,0,0,1,12.07,7.06,42.83,42.83,0,0,0-12.07,2Zm0,45.87V48a42.86,42.86,0,0,0,12.07,2A17.25,17.25,0,0,1,27.72,57.05ZM18.6,39.85V28.38c10.18-5.28,19.29-7.16,27.13-5.62a16.8,16.8,0,0,0,0,22.7C37.89,47,28.78,45.13,18.6,39.85Zm31.58,4.31a12.83,12.83,0,0,1,0-20.1A25.88,25.88,0,0,1,62.3,34.12,25.67,25.67,0,0,1,50.18,44.16Z"/><path class="cls-1" d="M53.79,32a1.73,1.73,0,1,0,1.73,1.73A1.73,1.73,0,0,0,53.79,32Z"/><rect class="cls-2" width="68.34" height="68"/></g></g>
    </svg>
  </div>

  <!-- <section class="screen"> -->
  <!-- </section> -->

  <section class="screen_menu first_video">

    <video class="first_video video_player rowcol1" playsinline autoplay poster="<?=$DIR_IMG?>background/investigacion-video.png" onclick="this.play()">
      <source src="<?=$DIR_MEDIA.$ELEMS["VIDEO_INICIAL"]?>" type="video/mp4">
    </video>
    <ul class="menem_container">
      <?php
      $i=0;
      foreach ($items as $item) {
        $self_awake = ".$item[slug] .menem.$item[slug]";
        ?>
        <style>
        <?= $self_awake ?> {
          height:100vh;
        }
        <?= $self_awake ?> .menem_txt {
          font-size: 30px;
          line-height: 30px;
          color: white;
          right: 68px;
          bottom: 100px;
          transform: translateX(0);
          letter-spacing: 2px;
        }
        <?= $self_awake ?> .menem_txt .menem_txt_pointer {
          display: none;
        }
        <?= $self_awake ?> .menem_next {
          transform: translateX(0);
          transition-delay: .8s;
          opacity:1;
          pointer-events: all;
        }
        </style>
        <li class="menem <?= $item['slug'] ?>">

          <video class="video_player rowcol1" poster="<?= $DIR_IMG.$item['are_fondo'] ?>" onclick="play_video('<?= $item['slug'] ?>')">
            <!-- <source src="<?= $DIR_VIDEOS.$item['are_video'] ?>" type="video/mp4"> -->
            <source src="<?= $DIR_MEDIA.$item['are_video'] ?>" type="video/mp4">
          </video>
          <p class="menem_txt" onclick="play_video('<?= $item['slug'] ?>')">
            <?= $item['tra_nombre_area'] ?>
            <img class="menem_txt_pointer" src="<?=$DIR_ICONS?>dedo-rojo.svg">
          </p>
          <p class="menem_next" onclick="back_btn();play_video('<?= $items[ ($i+1) % count($items) ]['slug'] ?>')"><?=$ELEMS["TXT_SEE_LINK"]?> <?= $items[ ($i+1) % count($items) ]['tra_nombre_area'] ?></p>
        </li>
      <?php $i+=1;} ?>
    </ul>

    <div class="panel panel_bottom">
      <div class="back_grid">
        <a class="back_btn home_btn" href="index.php" class="home_btn" style="color: <?= $buttons_color ?>;">
          <?php include $DIR_ICONS.'home.svg' ?>
        </a>
        <button class="back_btn" style="color: <?= $buttons_color ?>;" onclick="back_btn()">
          <?php include $DIR_ICONS.'atras.svg' ?>
        </button>

        <!-- <button class="btn btn_back" onclick="back_btn()">
          <img src="<?=$DIR_ICONS?>atras.svg">
        </button> -->

        <div class="title_lang_grid">
          <h3 class="panel_title"><?=$ELEMS["TIT_INTERACTIVO"]?></h3>
          <!-- <p class="panel_language">
            <a href="main.php?lang=esp" class="<?= ($_SESSION["lang"] == 'esp') ? 'selected' : '' ?>">Esp</a>
            <span class="panel_stick">|</span>
            <a href="main.php?lang=eng" class="<?= ($_SESSION["lang"] == 'eng') ? 'selected' : '' ?>">Eng</a>
            <span class="panel_stick">|</span>
            <a href="main.php?lang=glg" class="<?= ($_SESSION["lang"] == 'glg') ? 'selected' : '' ?>">Gal</a>
          </p> -->
        </div>
      </div>
    </div>

  </section>

  <script type="text/javascript" src="../js/scripts_nosocket.js"></script>
  <!-- Redirect timer -->
  <script> redirect_time = <?= $redirect_time ?>; </script>
  <script>
    var has_video = <?=$ELEMS["VIDEO_INICIAL_ACTIVO"]?>;
  </script>
  
  <script type="text/javascript" src="js/main.js"></script>

  <script>
    first_vid_init();
    animate_bubbles();
  </script>
</body>
</html>
