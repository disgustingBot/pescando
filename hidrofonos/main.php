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
  // var_dump($sounds);
  // $redirect_time = 60;

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
    <svg class="in_screen_icon in_screen_icon_animate" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 68.34 68">
      <defs><style>.cls-2{fill:none;}</style></defs>
      <title>Pulpo</title>
      <g id="Layer_2" data-name="Layer 2"><g id="Capa_1" data-name="Capa 1"><path class="cls-1" d="M60,36.73a9.41,9.41,0,0,0,3.57-7.38,9.28,9.28,0,0,0-9.27-9.27h-2v4h2a5.27,5.27,0,0,1,5.27,5.27,5.32,5.32,0,0,1-5.27,5.37H49.09V18.39a15.13,15.13,0,0,0-30.26,0V34.72H13.64a5.39,5.39,0,0,1-5.26-5.37,5.27,5.27,0,0,1,5.26-5.27h2v-4h-2a9.27,9.27,0,0,0-9.26,9.27A9.41,9.41,0,0,0,8,36.73a9.44,9.44,0,0,0-3.57,7.41,9.27,9.27,0,0,0,9.26,9.26v-4a5.27,5.27,0,0,1-5.26-5.26,5.41,5.41,0,0,1,5.26-5.42h9.19V18.39a11.13,11.13,0,0,1,22.26,0V38.72h9.19a5.41,5.41,0,0,1,5.27,5.42,5.27,5.27,0,0,1-5.27,5.26v4a9.27,9.27,0,0,0,9.27-9.26A9.44,9.44,0,0,0,60,36.73Z"/><path class="cls-1" d="M27.59,55.52A5.45,5.45,0,0,1,22.14,61v4a9.45,9.45,0,0,0,9.45-9.44V36.72h-4Z"/><path class="cls-1" d="M40.34,55.52V36.72h-4v18.8A9.45,9.45,0,0,0,45.78,65V61A5.45,5.45,0,0,1,40.34,55.52Z"/><path class="cls-1" d="M28.17,25.45a2.48,2.48,0,0,0-.25.3,2.31,2.31,0,0,0-.18.35,2.29,2.29,0,0,0-.12.37,2.56,2.56,0,0,0,0,.39,2,2,0,0,0,2,2,2.09,2.09,0,0,0,.76-.15,1.7,1.7,0,0,0,.35-.19,2.25,2.25,0,0,0,.3-.24,2,2,0,0,0,0-2.83A2.07,2.07,0,0,0,28.17,25.45Z"/><path class="cls-1" d="M36.67,28a3.76,3.76,0,0,0,.25.31,1.83,1.83,0,0,0,.31.24,1.41,1.41,0,0,0,.34.19,1.66,1.66,0,0,0,.38.11,2,2,0,0,0,1.15-.11,1.7,1.7,0,0,0,.35-.19,1.76,1.76,0,0,0,.3-.24A2.42,2.42,0,0,0,40,28a2.21,2.21,0,0,0,.18-.34,2.4,2.4,0,0,0,.12-.38,2.58,2.58,0,0,0,0-.39,2,2,0,0,0-.59-1.41,2.06,2.06,0,0,0-2.83,0,2.48,2.48,0,0,0-.25.3,2.31,2.31,0,0,0-.18.35,1.58,1.58,0,0,0-.11.37,1.92,1.92,0,0,0,0,.78,1.66,1.66,0,0,0,.11.38A2.21,2.21,0,0,0,36.67,28Z"/><rect class="cls-2" width="68.34" height="68"/></g></g>
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
      <p class="info_content_box_txt full_col_text"><?= $ELEMS['TXT_BLOQUE2'] ?></p>
      <h3 class="info_content_cta full_col_text" onclick="altClassFromSelector('selector', '.hydrophone_main')"><?= $ELEMS['TXT_SELECCIONA'] ?></h3>
    </div>

    <!-- <div class="info_content_box step2">
    </div> -->



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

              <video class="full_screen_media_video rowcol1" id="<?= $specie['slug'] ?>_sound" poster="<?= $DIR_IMG . $specie['son_fondo'] ?>">
                <source src="<?= $DIR_MEDIA . $specie['son_video'] ?>" type="video/mp4">
                <!-- <source src="videos/HIDROFONO_PULPO_01.mp4" type="video/mp4"> -->
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


    <!-- <div class="arrow_next" onclick="altClassFromSelector('step2', '.hydrophone_main')">
      <img class="arrow_next_img" src="<?=$DIR_ICONS?>flecha-azul.svg" alt="flecha para ir al siguiente interactivo">
    </div> -->
  </section>



  <!-- Redirect timer -->
  <script> redirect_time = <?= $redirect_time ?>; </script>
  <script type="text/javascript" src="js/main.js"></script>
  <script>animate_bubbles();</script>
</body>
</html>
