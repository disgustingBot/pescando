<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");

  $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
  $current_url_no_params = $SERVER_URL.$uri_parts[0];

  $ELEMS  = get_strings();
  $ships = get_ships();
  $ship_types = get_ship_types();

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
  <!-- <div class="in_animate_screen in_animate_screen_display">
    <svg class="in_screen_icon in_screen_icon_animate" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.78 21.79">
      <title>Barco</title>
      <g id="Capa_2" data-name="Capa 2"><g id="Layer_1" data-name="Layer 1"><path d="M29.3,18.78a4.55,4.55,0,0,1-6.1-.11,1.72,1.72,0,0,0-2.2,0,4.55,4.55,0,0,1-6.22,0,1.72,1.72,0,0,0-2.2,0A4.72,4.72,0,0,1,9.47,19.9a4.72,4.72,0,0,1-3.11-1.23,1.72,1.72,0,0,0-2.2,0,5.15,5.15,0,0,1-.68.5L4.29,12H33ZM8.49,8.4H22.61L24,10.15H8.3ZM8.8,5.63H20.49l.68.88H8.7Zm2.1-3.74h6.59a2.18,2.18,0,0,1,2.25,1.85H10.9Zm23.84,18a4.76,4.76,0,0,1-3.06-1.18l4-7.2a.85.85,0,0,0,0-.92,1.08,1.08,0,0,0-.89-.45H26.52l-4.62-6,0-.06V3.93A4.16,4.16,0,0,0,17.49,0H7.78a1,1,0,0,0-1,1,1,1,0,0,0,1,.94h1V3.74h-1a1,1,0,0,0-1,.85l-.61,5.56H4.28a2,2,0,0,0-2.08,1.7l-.41,3.62H1.05a1,1,0,1,0,0,1.89h.53l-.19,1.69h0a1.76,1.76,0,0,0,.11.82l-.45,0a1,1,0,1,0,0,1.89,6.83,6.83,0,0,0,4.21-1.47,6.76,6.76,0,0,0,8.42,0,6.76,6.76,0,0,0,8.42,0,6.76,6.76,0,0,0,8.42,0,6.85,6.85,0,0,0,4.22,1.47.95.95,0,1,0,0-1.89"/></g></g>
    </svg>

    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
  </div> -->



  <div class="interactive_map">


    <?php
    foreach ($ship_types as $type) {
      $self_awake = ".$type[slug] .boax.$type[slug]";
      ?>

      <style media="screen">
        <?= $self_awake ?> {
          opacity:1;
          pointer-events: all;
          z-index: 15;
          /* transform: translate(-50%, -50%) scale(1); */
          transform: scale(1);
          transition: all 0.5s var(--normal_curve), opacity 0.5s;
        }
      </style>
      <div class="boax rowcol1 <?= $type['slug'] ?>">
        <img class="boax_main_icon" src="<?=$DIR_ICONS?>barco-flota-azul-oscuro.svg" alt="Icono de bote">
        <p class="boax_title"><?= $type['tra_nombre_tba'] ?></p>
        <img class="boax_deco" src="<?=$DIR_ICONS?>onda-flota.svg" alt="Decoración de ondas maritimas">
        <p class="boax_txt"><?= $type['tra_descr_tba'] ?></p>
        <div class="boax_perk">
          <img class="boax_perk_icon" src="<?=$DIR_ICONS?>pez-flota.svg" alt="Icono de un pez">
          <p class="boax_perk_txt"><?= $type['tra_pesca_tba'] ?></p>
        </div>
        <div class="boax_perk">
          <img class="boax_perk_icon" src="<?=$DIR_ICONS?>localizacion-flota.svg" alt="Icono de un punto de ubicación">
          <p class="boax_perk_txt"><?= $type['tra_barcos_tba'] ?></p>
        </div>
        <img class="close_boat_lightbox" src="<?=$DIR_ICONS?>cerrar-flota.svg" alt="Icono de equis para cerrar el Lightbox" onclick="altClassFromSelector('<?= $type['slug'] ?>', '.interactive_map')">
      </div>

    <?php } ?>

    <div class="boat_positioning_layer">
      <div class="panel">
        <h3 class="panel_title"><?= $ELEMS['MENU_TEXTO'] ?></h3>
        <p class="panel_language">
          <a href="main.php?lang=esp" class="<?= ($_SESSION["lang"] == 'esp') ? 'selected' : '' ?>">Esp</a>
          <span class="panel_stick">|</span>
          <a href="main.php?lang=eng" class="<?= ($_SESSION["lang"] == 'eng') ? 'selected' : '' ?>">Eng</a>
          <span class="panel_stick">|</span>
          <a href="main.php?lang=glg" class="<?= ($_SESSION["lang"] == 'glg') ? 'selected' : '' ?>">Gal</a>
        </p>
      </div>
      <?php $anim_delay = 0 ?>

      <?php
      // bar_tipo
      // var_dump($barco['bar_tipo']);
      foreach ($ships as $barco) {
      // foreach ($barcos as $barco) {
        $self_filtered = ".tipo_$barco[bar_tipo] .boat_position.tipo_$barco[bar_tipo]";
        $self_awake = ".boat_$barco[bar_id] .viday.boat_$barco[bar_id]";
        ?>

        <style media="screen">
          <?= $self_awake ?> {
            opacity:1;
            pointer-events: all;
            transform: translate(-50%, -50%) scale(1);
            transition: all 0.5s var(--normal_curve), opacity 0.5s;
            overflow: visible;
          }

          [class='interactive_map'] .boat_positioning_layer:not(<?='.boat_' . $barco['bar_id']?>)<?= $self_filtered ?> {
            pointer-events: all;
            /* opacity:1;
            transform: translate(-50%, -50%) scale(1);
            transition: all 0.5s var(--normal_curve), opacity 0.5s;
            overflow: visible; */
          }
        </style>

        <?php $css_class_led_video  = ".boat_positioning_layer.tipo_$barco[bar_tipo] .viday.boat_$barco[bar_id] + .boat_position.tipo_$barco[bar_tipo] .led_light"; ?>
        <?php $css_class_boat_video = ".boat_positioning_layer.tipo_$barco[bar_tipo] .viday.boat_$barco[bar_id] + .boat_position.tipo_$barco[bar_tipo] .boat_icon"; ?>

        <style>
          <?= $css_class_led_video ?> {
            background-color: #A00;
          }

          <?= $css_class_boat_video ?> path {
            -webkit-animation: blinkRed 0.5s infinite;
            -moz-animation: blinkRed 0.5s infinite;
            -ms-animation: blinkRed 0.5s infinite;
            -o-animation: blinkRed 0.5s infinite;
            animation: blinkRed 0.5s infinite;
          }

          <?php $css_class_boat_played = ".boat_positioning_layer.tipo_$barco[bar_tipo] .viday.boat_$barco[bar_id].PLAYED_VIDEO + .boat_position.tipo_$barco[bar_tipo] .boat_icon"; ?>
          <?= $css_class_boat_played ?> path {
            fill: #A00;
            animation: none;
          }
        </style>

        <div class="viday boat_<?= $barco['bar_id']  ?>">
          <?php // var_dump($barco); ?>
          <img class="live_video_icon" src="<?=$DIR_ICONS?>live.svg" alt="">
          <video
            class="viday_media"
            poster="<?= $DIR_MEDIA . $barco['bar_video'] ?>.jpg"
          >
            <!-- <source src="<?= $DIR_MEDIA.$barco['bar_video'] ?>.mp4" type="video/mp4"> -->
            <!-- src solo para probar -->
            <!-- src="<?= ($barco['bar_id'] == 1 || $barco['bar_id'] == 3) ? '../hidrofonos/videos/HIDROFONO_PULPO_01.mp4' : '' ?>" -->
            <source
              src="<?= $DIR_MEDIA . $barco['bar_video'] ?>.mp4"
              type="video/mp4"
              <?php $video_selector = ".viday.boat_$barco[bar_id]" ?>
              onerror="(function(){event.currentTarget.parentElement.parentElement.classList.add('NOT_VIDEO')})()"
            >
          </video>

          <div class="viday_caption">
            <h2 class="viday_title">Tripulación</h2>
            <p
              class="viday_play"
              onclick="
                altClassFromSelector('play', '.viday.boat_<?= $barco['bar_id'] ?>');
                playAudioFromSelector('.viday.boat_<?=$barco['bar_id']?> .viday_media');
                document.querySelector('.viday.boat_<?= $barco['bar_id'] ?>').classList.add('PLAYED_VIDEO');
              "
            >Video</p>
          </div>

          <img
            class="close_boat_lightbox"
            src="<?=$DIR_ICONS?>cerrar-flota.svg"
            alt="Icono de equis para cerrar el Lightbox"
            onclick="altClassFromSelector('boat_<?= $barco['bar_id'] ?>', '.boat_positioning_layer', ['boat_positioning_layer', 'tipo_<?= $barco['bar_tipo'] ?>']);"
          >

          <img
            class="close_boat_lightbox back"
            src="<?=$DIR_ICONS?>atras.svg"
            alt="Icono de equis para cerrar el Lightbox"
            onclick="
              altClassFromSelector('play', '.viday.boat_<?= $barco['bar_id']  ?>');
              playAudioFromSelector('.viday.boat_<?=$barco['bar_id']?> .viday_media', true);
            "
          >
        </div>

        <div
          class="boat_position tipo_<?=$barco['bar_tipo']?>"
          onclick="altClassFromSelector('boat_<?= $barco['bar_id']  ?>', '.boat_positioning_layer', ['boat_positioning_layer', 'tipo_<?= $barco['bar_tipo'] ?>'])"
          style="top:<?= $barco['cal_posy'] ?>%;left:<?= $barco['cal_posx'] ?>%;transition-delay:<?= $anim_delay += 0.1 ?>s"
          >
          <div class="boat_icon">
            <?= file_get_contents($DIR_ICONS . 'barco-flota-blanco.svg') ?>
          </div>
          <div class="led_light_wrapper">
            <div class="led_light"></div>
          </div>
        </div>
      <?php } ?>
      <div class="boat_type_selector rowcol1">
        <?php
        // var_dump($ship_types[0]['tba_id']);
         ?>
        <?php foreach ($ship_types as $type) { ?>
          <div
            class="boat_type <?= $type['slug'] ?>"
            onclick="
              altClassFromSelector('<?= $type['slug'] ?>', '.interactive_map', ['interactive_map']);
              altClassFromSelector('tipo_<?= $type['tba_id'] ?>', '.boat_positioning_layer', ['boat_positioning_layer']);"
          >
            <div class="led_light_wrapper">
              <div class="led_light boat_type_icon"></div>
            </div>
            <p class="boat_type_name"><?= $type['tra_nombre_tba'] ?></p>
          </div>
        <?php } ?>
      </div>
    </div>


    <img class="map rowcol1" src="<?=$DIR_IMG?>mapa.jpg" alt="Mapa de las ubicaciones de la flota en el mundo">

  </div>

  <script type="text/javascript" src="js/main.js"></script>
  <script>window.onload=_=>{out_animate_screen()}</script>
</body>
</html>
