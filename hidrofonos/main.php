<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");

  $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
  $current_url_no_params = $SERVER_URL.$uri_parts[0];

  $ELEMS  = get_strings();
  $sounds = get_sounds();

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
  <div class="in_animate_screen in_animate_screen_display">
    <svg class="in_animate_screen_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 51.26 52">
      <title>Pescanova</title>
      <g id="Capa_2" data-name="Capa 2"><g id="Layer_1" data-name="Layer 1"><path d="M35.7,30.68,32.47,37.6H18.79l-3.23-6.92a3.27,3.27,0,0,1-.06-2.62l3.05-7.42a46.68,46.68,0,0,1,14.16,0l3,7.42a3.23,3.23,0,0,1-.06,2.62M8.87,21.19l0-.14h3.79a4.23,4.23,0,0,1,1.86,1.47l-.78,1.9-2.92-1.13a3.18,3.18,0,0,1-1.91-2.1M8,18a14.13,14.13,0,0,1,0-4.94h3.64a13.67,13.67,0,0,1,0,4.94ZM11.54,3.87a4.33,4.33,0,0,1,3-.81,8.1,8.1,0,0,1-.44,1.3L12.92,6.64l2.54-.08a4.45,4.45,0,0,1,1.26.17c-.71,1.2-2.08,3-3.93,3.28H8.52c.35-2,1.2-4.8,3-6.14M38.66,21.05h3.79l0,.14a3.18,3.18,0,0,1-1.91,2.1l-2.92,1.17-.8-1.94a4.26,4.26,0,0,1,1.88-1.47M34.55,6.73a4.57,4.57,0,0,1,1.27-.17l2.54.08L37.23,4.36a8.1,8.1,0,0,1-.44-1.3,4.33,4.33,0,0,1,3,.81c1.82,1.34,2.67,4.16,3,6.14H38.49c-1.76-.24-3.16-2-3.94-3.28m8.7,6.33a14.13,14.13,0,0,1,0,4.94H39.61a13.67,13.67,0,0,1,0-4.94ZM47.18,27.9H38.9c0-.21-.11-.41-.17-.61l2.89-1.16A6.28,6.28,0,0,0,45.35,22l.59-2.11A17,17,0,0,0,46,11.31c-.08-1.1-.65-7.1-4.43-9.89a7.92,7.92,0,0,0-7-1.07L33.22.7l.24,1.39c0,.14.15.86.37,1.68a4.16,4.16,0,0,0-2.51,1.71l-.42.67.3.72c.09.2,1.85,4.38,5.39,5.77a16.91,16.91,0,0,0,0,6,6.83,6.83,0,0,0-1.12.77L34.9,18l-.79-.17c-.46-.09-.94-.18-1.43-.25v-2.9H29.63V17.2a50.87,50.87,0,0,0-8,0V14.65H18.58v2.9c-.49.07-1,.16-1.43.25l-.79.17-.6,1.46a7.46,7.46,0,0,0-1.11-.77,17.15,17.15,0,0,0,0-6c3.53-1.39,5.29-5.57,5.38-5.77l.3-.72L20,5.48a4.21,4.21,0,0,0-2.52-1.71c.22-.82.35-1.54.37-1.68L18.06.7,16.7.35a7.92,7.92,0,0,0-7,1.07c-3.78,2.79-4.35,8.79-4.43,9.89a17,17,0,0,0,0,8.61L5.93,22a6.27,6.27,0,0,0,3.74,4.1l2.88,1.12a4.84,4.84,0,0,0-.19.65H4.08L0,33.78v5.77H3.05V34.74L5.68,31h6.74a7.3,7.3,0,0,0,.37,1l2.64,5.63h-7L3.35,44.23V52H6.4V45.26l3.54-4.61H41.37l3.53,4.61V52H48V44.23L42.88,37.6h-7L38.47,32a7.3,7.3,0,0,0,.37-1h6.74l2.63,3.79v4.81h3V33.78Z"/></g></g>
    </svg>
  </div>

  <section class="hydrophone_main">

              <div class="top_panel">
                <div class="back_grid">
                  <button class="back_btn" onclick="back_btn()">
                    <img src="<?=$DIR_ICONS?>atras.svg">
                  </button>
                  <div>
                    <h3 class="title" onclick="audio.play()"><?= $ELEMS['TIT_INTERACTIVO'] ?></h3>
                    <p class="language">
                      <a href="main.php?lang=esp" class="<?= ($_SESSION["lang"] == 'esp') ? 'selected' : '' ?>">Esp</a>
                      <span class="stick">|</span>
                      <a href="main.php?lang=eng" class="<?= ($_SESSION["lang"] == 'eng') ? 'selected' : '' ?>">Eng</a>
                      <span class="stick">|</span>
                      <a href="main.php?lang=glg" class="<?= ($_SESSION["lang"] == 'glg') ? 'selected' : '' ?>">Gal</a>
                    </p>
                  </div>
                </div>
              </div>

    <div class="info_content_box step1">
      <h1 class="info_content_box_title full_col_text"><?= $ELEMS['TIT_INTERACTIVO'] ?></h1>
      <p class="info_content_box_txt full_col_text"><?= $ELEMS['TXT_BLOQUE1'] ?></p>
    </div>

    <div class="info_content_box step2">
      <p class="info_content_box_txt full_col_text"><?= $ELEMS['TXT_BLOQUE2'] ?></p>
      <h3 class="info_content_cta full_col_text" onclick="altClassFromSelector('selector', '.hydrophone_main')"><?= $ELEMS['TXT_SELECCIONA'] ?></h3>
    </div>



        <div class="full_screen_media_option_selector">
          <?php foreach ($sounds as $specie) { ?>
            <!-- <div class="full_screen_media_option" data-specie="<?= $specie['slug'] ?>" onclick="playAudioFromSelector('#<?= $specie['slug'] ?>_sound'); altClassFromSelector('active', '[data-specie=<?= $specie['slug'] ?>] .wave_icon')"
            style="background: url('<?= $DIR_IMG.$specie['son_fondo'] ?>') no-repeat center center;"> -->
            <div
              class="full_screen_media_option"
              data-specie="<?= $specie['slug'] ?>"
              onclick="
                playAudioFromSelector('#<?= $specie['slug'] ?>_sound', true);
                // altClassFromSelector('active', '[data-specie=<?= $specie['slug'] ?>] .wave_icon');
                altClassFromSelector('<?= $specie['slug'] ?>', '.full_screen_media_option_selector');
              "
            >
              <style>
                [class='full_screen_media_option_selector <?= $specie['slug'] ?>'] [data-specie=<?= $specie['slug'] ?>] {
                  width: 100%;
                  pointer-events: all;
                }

                [class='full_screen_media_option_selector <?= $specie['slug'] ?>'] [data-specie=<?= $specie['slug'] ?>] .full_screen_media_video {
                  transform: translateX(0);
                }

                [class='full_screen_media_option_selector <?= $specie['slug'] ?>'] [data-specie=<?= $specie['slug'] ?>] .icon_sequence {
                  opacity: 0;
                  transform: scale(0);
                }
                
                [class='full_screen_media_option_selector <?= $specie['slug'] ?>'] [data-specie=<?= $specie['slug'] ?>] .icon_sequence_container {
                  grid-gap: 0;
                  margin: calc(100vh - 68px) auto auto auto;
                  left: 100%;
                  transform: translate(calc(-100% - 68px), calc(-34px - 68px));
                }

              </style>

              <video class="full_screen_media_video rowcol1" id="<?= $specie['slug'] ?>_sound">
                <source src="videos/HIDROFONO_PULPO_01.mp4" type="video/mp4">
              </video>

              <div class="icon_sequence_container rowcol1">
                <div class="icon_sequence">
                  <img class="icon_sequence_img audio_icon" src="<?=$DIR_ICONS?>altavoz.svg" alt="Icono de altavoz">
                  <img class="icon_sequence_img fish_icon" src="<?= $DIR_IMG.$specie['son_icono'] ?>" alt="Icono de animalito">
                  <img class="icon_sequence_img wave_icon" src="<?=$DIR_ICONS?>onda.svg" alt="Icono de onda de audio">
                </div>
                <div class="icon_sequence_txt full_col_text"><?= $specie['tra_nombre_son'] ?></div>
              </div>
            </div>

            <audio id="<?= $specie['slug'] ?>_sound">
              <source src="<?= $DIR_SONIDOS.$specie['son_fichero'] ?>" type="audio/mpeg">
            </audio>
          <?php } ?>
        </div>


    <div class="arrow_next" onclick="altClassFromSelector('step2', '.hydrophone_main')">
      <img class="arrow_next_img" src="<?=$DIR_ICONS?>flecha-azul.svg" alt="flecha para ir al siguiente interactivo">
    </div>
  </section>


  <script type="text/javascript" src="js/main.js"></script>
  <script>window.onload = () => { in_animate_screen(); }</script>
</body>
</html>
