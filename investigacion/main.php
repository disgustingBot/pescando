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

/*
var_dump($items);
die;
$items = array(
  array(
    'slug' => 'cultivo',
    'title' => 'Cultivo',
    'video' => 'videos/rocket.mp4',
    'fondo' => '<?=$DIR_IMG?>background/menuinves2b-1.png'
  ),
  array(
    'slug' => 'especies-futuro',
    'title' => 'Especies de futuro',
    'video' => 'videos/rocket.mp4',
    'fondo' => '<?=$DIR_IMG?>background/menuinves2b-2.png'
  ),
  array(
    'slug' => 'sostenibilidad',
    'title' => 'Sostenibilidad',
    'video' => 'videos/rocket.mp4',
    'fondo' => '<?=$DIR_IMG?>background/menuinves2b-3.png'
  ),
);
*/
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?=$ELEMS["TIT_INTERACTIVO"]?></title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="in_animate in_animate_display">
    <svg class="in_animate_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 51.26 52">
      <title>Pescanova</title>
      <g id="Capa_2" data-name="Capa 2"><g id="Layer_1" data-name="Layer 1"><path d="M35.7,30.68,32.47,37.6H18.79l-3.23-6.92a3.27,3.27,0,0,1-.06-2.62l3.05-7.42a46.68,46.68,0,0,1,14.16,0l3,7.42a3.23,3.23,0,0,1-.06,2.62M8.87,21.19l0-.14h3.79a4.23,4.23,0,0,1,1.86,1.47l-.78,1.9-2.92-1.13a3.18,3.18,0,0,1-1.91-2.1M8,18a14.13,14.13,0,0,1,0-4.94h3.64a13.67,13.67,0,0,1,0,4.94ZM11.54,3.87a4.33,4.33,0,0,1,3-.81,8.1,8.1,0,0,1-.44,1.3L12.92,6.64l2.54-.08a4.45,4.45,0,0,1,1.26.17c-.71,1.2-2.08,3-3.93,3.28H8.52c.35-2,1.2-4.8,3-6.14M38.66,21.05h3.79l0,.14a3.18,3.18,0,0,1-1.91,2.1l-2.92,1.17-.8-1.94a4.26,4.26,0,0,1,1.88-1.47M34.55,6.73a4.57,4.57,0,0,1,1.27-.17l2.54.08L37.23,4.36a8.1,8.1,0,0,1-.44-1.3,4.33,4.33,0,0,1,3,.81c1.82,1.34,2.67,4.16,3,6.14H38.49c-1.76-.24-3.16-2-3.94-3.28m8.7,6.33a14.13,14.13,0,0,1,0,4.94H39.61a13.67,13.67,0,0,1,0-4.94ZM47.18,27.9H38.9c0-.21-.11-.41-.17-.61l2.89-1.16A6.28,6.28,0,0,0,45.35,22l.59-2.11A17,17,0,0,0,46,11.31c-.08-1.1-.65-7.1-4.43-9.89a7.92,7.92,0,0,0-7-1.07L33.22.7l.24,1.39c0,.14.15.86.37,1.68a4.16,4.16,0,0,0-2.51,1.71l-.42.67.3.72c.09.2,1.85,4.38,5.39,5.77a16.91,16.91,0,0,0,0,6,6.83,6.83,0,0,0-1.12.77L34.9,18l-.79-.17c-.46-.09-.94-.18-1.43-.25v-2.9H29.63V17.2a50.87,50.87,0,0,0-8,0V14.65H18.58v2.9c-.49.07-1,.16-1.43.25l-.79.17-.6,1.46a7.46,7.46,0,0,0-1.11-.77,17.15,17.15,0,0,0,0-6c3.53-1.39,5.29-5.57,5.38-5.77l.3-.72L20,5.48a4.21,4.21,0,0,0-2.52-1.71c.22-.82.35-1.54.37-1.68L18.06.7,16.7.35a7.92,7.92,0,0,0-7,1.07c-3.78,2.79-4.35,8.79-4.43,9.89a17,17,0,0,0,0,8.61L5.93,22a6.27,6.27,0,0,0,3.74,4.1l2.88,1.12a4.84,4.84,0,0,0-.19.65H4.08L0,33.78v5.77H3.05V34.74L5.68,31h6.74a7.3,7.3,0,0,0,.37,1l2.64,5.63h-7L3.35,44.23V52H6.4V45.26l3.54-4.61H41.37l3.53,4.61V52H48V44.23L42.88,37.6h-7L38.47,32a7.3,7.3,0,0,0,.37-1h6.74l2.63,3.79v4.81h3V33.78Z"/></g></g>
    </svg>
  </div>

  <!-- <section class="screen"> -->
  <!-- </section> -->

  <section class="screen_menu first_video">

    <video class="first_vid video_player rowcol1" playsinline autoplay muted poster="<?=$DIR_IMG?>background/investigacion-video.png" onclick="this.play()">
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
          color: #D6001C;
          right: 68px;
          bottom: 100px;
          transform: translateX(0);
          letter-spacing: 2px;
        }
        <?= $self_awake ?> .menem_next {
          transform: translateX(0);
          transition-delay: .8s;
          opacity:1;
          pointer-events: all;
        }
        </style>
        <li class="menem <?= $item['slug'] ?>">

          <video class="video_player rowcol1" muted poster="<?= $DIR_IMG.$item['are_fondo'] ?>" onclick="play_video('<?= $item['slug'] ?>')">
            <!-- <source src="<?= $DIR_VIDEOS.$item['are_video'] ?>" type="video/mp4"> -->
            <source src="<?= $DIR_MEDIA.$item['are_video'] ?>" type="video/mp4">
          </video>
          <p class="menem_txt" onclick="play_video('<?= $item['slug'] ?>')"><?= $item['tra_nombre_area'] ?></p>
          <p class="menem_next" onclick="back_btn();play_video('<?= $items[ ($i+1) % count($items) ]['slug'] ?>')">Ver <?= $items[ ($i+1) % count($items) ]['tra_nombre_area'] ?></p>
        </li>
      <?php $i+=1;} ?>
    </ul>

    <div class="panel panel_bottom">
      <div class="back_grid">
        <button class="btn btn_back" onclick="back_btn()">
          <img src="<?=$DIR_ICONS?>atras.svg">
        </button>

        <div class="title_lang_grid">
          <h3 class="panel_title"><?=$ELEMS["TIT_INTERACTIVO"]?></h3>
          <p class="panel_language">
            <a href="main.php?lang=esp" class="<?= ($_SESSION["lang"] == 'esp') ? 'selected' : '' ?>">Esp</a>
            <span class="panel_stick">|</span>
            <a href="main.php?lang=eng" class="<?= ($_SESSION["lang"] == 'eng') ? 'selected' : '' ?>">Eng</a>
            <span class="panel_stick">|</span>
            <a href="main.php?lang=glg" class="<?= ($_SESSION["lang"] == 'glg') ? 'selected' : '' ?>">Gal</a>
          </p>
        </div>
      </div>
    </div>

  </section>

  <script type="text/javascript" src="js/main.js"></script>
  <script>
    first_vid_init();
    window.onload = () => { in_animate(); }
  </script>
</body>
</html>
