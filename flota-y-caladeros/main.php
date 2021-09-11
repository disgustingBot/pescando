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
  // $redirect_time = 10;

  // var_dump($ship_types[0]);
  $buttons_color = 'white';
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
    <svg class="in_screen_icon in_screen_icon_animate" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.78 21.79">
      <title>Barco</title>
      <g id="Capa_2" data-name="Capa 2"><g id="Layer_1" data-name="Layer 1"><path d="M29.3,18.78a4.55,4.55,0,0,1-6.1-.11,1.72,1.72,0,0,0-2.2,0,4.55,4.55,0,0,1-6.22,0,1.72,1.72,0,0,0-2.2,0A4.72,4.72,0,0,1,9.47,19.9a4.72,4.72,0,0,1-3.11-1.23,1.72,1.72,0,0,0-2.2,0,5.15,5.15,0,0,1-.68.5L4.29,12H33ZM8.49,8.4H22.61L24,10.15H8.3ZM8.8,5.63H20.49l.68.88H8.7Zm2.1-3.74h6.59a2.18,2.18,0,0,1,2.25,1.85H10.9Zm23.84,18a4.76,4.76,0,0,1-3.06-1.18l4-7.2a.85.85,0,0,0,0-.92,1.08,1.08,0,0,0-.89-.45H26.52l-4.62-6,0-.06V3.93A4.16,4.16,0,0,0,17.49,0H7.78a1,1,0,0,0-1,1,1,1,0,0,0,1,.94h1V3.74h-1a1,1,0,0,0-1,.85l-.61,5.56H4.28a2,2,0,0,0-2.08,1.7l-.41,3.62H1.05a1,1,0,1,0,0,1.89h.53l-.19,1.69h0a1.76,1.76,0,0,0,.11.82l-.45,0a1,1,0,1,0,0,1.89,6.83,6.83,0,0,0,4.21-1.47,6.76,6.76,0,0,0,8.42,0,6.76,6.76,0,0,0,8.42,0,6.76,6.76,0,0,0,8.42,0,6.85,6.85,0,0,0,4.22,1.47.95.95,0,1,0,0-1.89"/></g></g>
    </svg>

    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
  </div>




  <div class="interactive_map all_types">
    <div class="boat_type_selector rowcol1">
      <div class="boat_type_background">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 138.51 138.51"><defs><style>.cls-1{fill:none;stroke:#a0b5c9;stroke-linecap:round;stroke-linejoin:round;}</style></defs><title>rosa-vientosAsset 16</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M69.26,69.26H.5l59.7-8.92Zm0,0H.5l59.7,8.91Zm0,0H138L78.32,78.17Zm68.75,0L78.17,60.2m-8.91,9.06V138L60.34,78.32Zm0,0V138l8.91-59.69Zm0,0V.5l8.91,59.7Zm0,0V.5L61.71,51,60.34,60.2ZM20.64,117.87,51,76.8m9.3,1.37-39.7,39.7L61.71,87.48Zm17.83-18,39.7-39.56-30.33,41Zm0,0,39.7-39.56L76.8,51Zm0,18,39.68,39.68L76.8,87.48Zm39.68,39.68L87.47,76.8M60.34,60.2,20.64,20.64,61.71,51Zm0,0L20.64,20.64,51,61.71Z"/><path class="cls-1" d="M40.6,35.46a44.14,44.14,0,0,1,25-10.36m7.35,0A44.15,44.15,0,0,1,97.88,35.44m5.19,5.19a44.17,44.17,0,0,1,10.34,24.9m0,7.4a44.15,44.15,0,0,1-10.34,24.95m-5.19,5.2a44.14,44.14,0,0,1-24.95,10.33m-7.35,0a44.14,44.14,0,0,1-24.95-10.33m-5.19-5.2A44.15,44.15,0,0,1,25.1,72.93m0-7.35A44.15,44.15,0,0,1,35.44,40.63"/></g></g></svg>
      </div>
      <div class="boat_type_line boat_type_line_vertical"></div>
      <div class="boat_type_line boat_type_line_horizontal"></div>

      <?php
      // var_dump($ship_types[0]['tba_id']);
        ?>
      <?php foreach ($ship_types as $type) { ?>
        <?php // var_dump($type) ?>
        <?php $active = ".boat_positioning_layer.tipo_$type[tba_id] .boat_type.tipo_$type[tba_id] .led_light"; ?>
        <style>

          <?= $active ?> {
            background: currentColor;
            -webkit-animation: blinkRed 0.5s infinite;
            -moz-animation: blinkRed 0.5s infinite;
            -ms-animation: blinkRed 0.5s infinite;
            -o-animation: blinkRed 0.5s infinite;
            animation: blinkRed 0.5s infinite;
          }
          /* No click en categoría activa */
          /* .boat_positioning_layer[class*='tipo_<?= $type['tba_id'] ?>'][class*='boat_']:not([class="boat_positioning_layer"]) <?= ".$type[slug]" ?> {
            pointer-events: none;
          } */
        </style>
        <div
          class="boat_type <?= $type['slug'] ?> tipo_<?= $type['tba_id'] ?>"
          onclick="
            altClassFromSelector('<?= $type['slug'] ?>', '.interactive_map', ['interactive_map', '<?= $type['slug'] ?>']);
            altClassFromSelector('tipo_<?= $type['tba_id'] ?>', '.boat_positioning_layer', ['boat_positioning_layer', 'tipo_<?= $type['tba_id'] ?>']);"
        >
          <!-- <div class="led_light_wrapper">
            <div class="led_light boat_type_icon"></div>
          </div> -->
          <img src="<?= $DIR_ICONS ?>icono-<?= $type['slug'] ?>.svg" class="boat_type_figure">
          <p class="boat_type_name"><?= $type['tra_nombre_tba'] ?></p>
        </div>
      <?php } ?>
    </div>

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
        <!-- <img class="close_boat_lightbox" src="<?=$DIR_ICONS?>cerrar-flota.svg" alt="Icono de equis para cerrar el Lightbox" onclick="altClassFromSelector('<?= $type['slug'] ?>', '.interactive_map')"> -->
        <div class="close_boat_lightbox_around" onclick="altClassFromSelector('<?= $type['slug'] ?>', '.interactive_map')"></div>
        <button class="close_boat_lightbox_text" onclick="altClassFromSelector('<?= $type['slug'] ?>', '.interactive_map')"><?= $type['tra_descubre_tba'] ?></button>
      </div>

    <?php } ?>

    <div class="boat_positioning_layer">
      <?php foreach ($ship_types as $type) { ?>
        <div class="boat_type_name_single tipo_<?= $type['tba_id'] ?>">
          <p class="boat_type_name boat_type_name_sm"><?= $type['slug'] ?></p>
        </div>

        <style>
          [class="interactive_map"] .boat_positioning_layer.tipo_<?= $type['tba_id'] ?> .boat_type_name_single.tipo_<?= $type['tba_id'] ?> {
            opacity: 1;
          }
        </style>
      <?php } ?>

      <?php $anim_delay = 0 ?>

      <?php
      // bar_tipo
      foreach ($ships as $barco) {
        // var_dump($barco['bar_tipo']);
      // foreach ($barcos as $barco) {
        $self_filtered = ".tipo_$barco[bar_tipo] .boat_position.tipo_$barco[bar_tipo]";
        $self_awake = ".boat_$barco[bar_id] .viday.boat_$barco[bar_id]";
        $css_class_led_video  = ".boat_positioning_layer.tipo_$barco[bar_tipo] .viday.boat_$barco[bar_id] + .boat_position.tipo_$barco[bar_tipo] .led_light";
        $css_class_boat_video = ".boat_positioning_layer.tipo_$barco[bar_tipo] .viday.boat_$barco[bar_id] + .boat_position.tipo_$barco[bar_tipo] .boat_icon";
        ?>
        <style media="screen">
          <?= $self_awake ?> {
            opacity:1;
            pointer-events: all;
            transform: translate(-50%, -50%) scale(1);
            transition: all 0.5s var(--normal_curve), opacity 0.5s;
            overflow: visible;
          }
          <?= $self_filtered ?> { z-index: 5 }

          [class='interactive_map'] .boat_positioning_layer:not(<?='.boat_' . $barco['bar_id']?>)<?= $self_filtered ?> {
            pointer-events: all;
            /* opacity:1;
            transform: translate(-50%, -50%) scale(1);
            transition: all 0.5s var(--normal_curve), opacity 0.5s;
            overflow: visible; */
          }
          <?= $css_class_led_video ?> {
            background-color: #A00;
          }

          <?='.boat_positioning_layer.boat_' . $barco['bar_id']?> {
            z-index: 5;
          }

          <?= $css_class_boat_video ?> path {
            fill: currentColor;
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

          <?php $css_class_no_types_on_video = "boat_positioning_layer tipo_$barco[bar_tipo] boat_$barco[bar_tipo]" ?>
          [class="<?= $css_class_no_types_on_video ?>"] .boat_type_selector {
            pointer-events: none;
          }
        </style>

        <div class="viday boat_<?= $barco['bar_id']  ?>">
          <?php // var_dump($barco); ?>
          <img class="live_video_icon" src="<?=$DIR_ICONS?>live.svg" alt="">
          <video
            class="viday_media"
            poster="<?= $DIR_MEDIA . $barco['bar_video'] ?>.jpg"
          >
            <source
              src="<?= $DIR_MEDIA . $barco['bar_video'] ?>.mp4"
              type="video/mp4"
              <?php $video_selector = ".viday.boat_$barco[bar_id]" ?>
              onerror="(function(){event.currentTarget.parentElement.parentElement.classList.add('NOT_VIDEO')})()"
            >
          </video>

          <div class="viday_caption">
            <h2 class="viday_title"><?= $ELEMS['TXT_TRIPULACION'] ?></h2>
            <p
              class="viday_play"
              onclick="
                altClassFromSelector('play', '.viday.boat_<?= $barco['bar_id'] ?>');
                playAudioFromSelector('.viday.boat_<?=$barco['bar_id']?> .viday_media');
                document.querySelector('.viday.boat_<?= $barco['bar_id'] ?>').classList.add('PLAYED_VIDEO');
              "
            ><?= $ELEMS['TXT_VIDEO'] ?></p>
          </div>

          <!-- <img
            class="close_boat_lightbox"
            src="<?=$DIR_ICONS?>cerrar-flota.svg"
            alt="Icono de equis para cerrar el Lightbox"
            onclick="altClassFromSelector('boat_<?= $barco['bar_id'] ?>', '.boat_positioning_layer', ['boat_positioning_layer', 'tipo_<?= $barco['bar_tipo'] ?>']);"
          > -->
          <div class="close_boat_lightbox_around" onclick="altClassFromSelector('boat_<?= $barco['bar_id'] ?>', '.boat_positioning_layer', ['boat_positioning_layer', 'tipo_<?= $barco['bar_tipo'] ?>']);"></div>

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
          class="boat_position pos_<?=$barco['bar_id']?> tipo_<?=$barco['bar_tipo']?>"
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
    </div>








    <div class="panel">
      <!-- TODO: mover este boton a donde corresponda -->

      <div class="panel_buttons">
        <a href="index.php" class="home_btn" style="color: <?= $buttons_color ?>;">
          <?php include $DIR_ICONS.'home.svg' ?>
        </a>

        <button class="back_btn" style="color: <?= $buttons_color ?>;" onclick="
          altClassFromSelector('', '.boat_positioning_layer', ['boat_positioning_layer']);
          altClassFromSelector('all_types', '.interactive_map', ['interactive_map']);"
        >
          <?php include $DIR_ICONS.'atras.svg' ?>
        </button>
      </div>


      <h3 class="panel_title"><?= $ELEMS['MENU_TEXTO'] ?></h3>

      <div class="panel_text_1">
        <p class="panel_text"><?= $ELEMS['TXT_BARCOS_FAENANDO'] ?></p>
        <p class="panel_text panel_text_md"><?= $ELEMS["TXT_SELECCIONA_UNO"] ?></p>
      </div>

      <div class="panel_text_2">
        <p class="panel_text panel_text_md"><?= $ELEMS["TXT_SELECCIONA_BARCO"] ?></p>
      </div>
    </div>







    <img class="map rowcol1" src="<?=$DIR_IMG?>mapa.jpg" alt="Mapa de las ubicaciones de la flota en el mundo">
    <img class="cross_positions rowcol1" src="<?=$DIR_ICONS?>cruces-posicion.svg" alt="Posición de cruces">

  </div>


  <!-- Redirect timer -->
  <script> redirect_time = <?= $redirect_time ?>; </script>
  <script type="text/javascript" src="js/main.js"></script>
  <script>window.onload=_=>{out_animate_screen()}</script>
</body>
</html>
