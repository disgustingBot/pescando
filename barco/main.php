<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");


$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$current_url_no_params = "https://".$_SERVER["HTTP_HOST"]."$uri_parts[0]";


$ELEMS      = get_strings();

// $redirect_time = 60;

$barcos = get_detalles();
$ship_types = get_ship_types();

$clickables = [];
foreach ($barcos as $barco) {
  $clickables[$barco['bde_id']] = get_clickables($barco['bde_id']);
}


$buttons_color = 'white';

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

<body class="body<?= (!isset($_GET['barco'])) ? ' step1' : '' ?>">
  <div class="in_animate_screen in_animate_screen_display">
    <svg class="in_screen_icon in_screen_icon_animate" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 68.34 68">
      <defs><style>.cls-2{fill:none;}</style></defs>
      <title>Alga</title>
      <g id="Layer_2" data-name="Layer 2"><g id="Capa_1" data-name="Capa 1"><path d="M57.39,60.79A31.23,31.23,0,0,0,66.05,39a6,6,0,0,0-5.94-5.91h0a5.93,5.93,0,0,0-5.9,5.95,19.52,19.52,0,0,1-5.66,13.83,9.53,9.53,0,0,0-4.74.63c-.15-.2-.32-.37-.48-.56a9.47,9.47,0,0,0,0-1,18.58,18.58,0,0,1,5.44-13.26l.11-.11a29.9,29.9,0,0,0,8.75-21.32l0-6.32a5.7,5.7,0,0,0-5.68-5.67h0A5.68,5.68,0,0,0,46.19,11l0,6.32a18.6,18.6,0,0,1-1.9,8.25,19.46,19.46,0,0,1-3.9-11.62A5.94,5.94,0,0,0,34.48,8h0A5.94,5.94,0,0,0,28.54,14a31.27,31.27,0,0,0,8.39,21.28,29.29,29.29,0,0,0-3,5.69A30.06,30.06,0,0,0,27.22,30.7l-.12-.12a18.57,18.57,0,0,1-5.52-13.21l0-6.32a5.7,5.7,0,0,0-5.69-5.67h0a5.7,5.7,0,0,0-5.67,5.7l0,6.32a29.91,29.91,0,0,0,8.89,21.26l.12.12a18.53,18.53,0,0,1,5.51,13,11.33,11.33,0,0,0-2.66-.33h0a11.64,11.64,0,0,0-3.41.54,19.47,19.47,0,0,1-4.86-12.8,6,6,0,0,0-5.93-5.92h0a5.94,5.94,0,0,0-5.91,6,32.53,32.53,0,0,0,8.83,21.69L4.15,61v4l59.77-.19,0-4ZM32.5,13.94a2,2,0,0,1,2-2h0a2,2,0,0,1,2,2,23.33,23.33,0,0,0,5.6,15.17,17.47,17.47,0,0,1-1.29,1.44l-.11.11c-.45.45-.87.92-1.28,1.39A27.27,27.27,0,0,1,32.5,13.94Zm11,19.51.12-.12a22.61,22.61,0,0,0,6.59-16l0-6.33a1.72,1.72,0,0,1,1.72-1.73h0a1.73,1.73,0,0,1,1.73,1.72l0,6.32A26,26,0,0,1,46,35.77l-.12.12A22.56,22.56,0,0,0,39.4,50.1,11.14,11.14,0,0,0,36,49.17,25.91,25.91,0,0,1,43.46,33.45ZM22,36l-.12-.12a25.94,25.94,0,0,1-7.72-18.46l0-6.32a1.74,1.74,0,0,1,1.73-1.74h0a1.73,1.73,0,0,1,1.73,1.73l0,6.32a22.54,22.54,0,0,0,6.69,16l.12.12A25.89,25.89,0,0,1,32,49.45h0a11.54,11.54,0,0,0-3.38,1.46A22.48,22.48,0,0,0,22,36Zm-9.63,21a27.31,27.31,0,0,1-6.53-17.7,2,2,0,0,1,2-2h0a2,2,0,0,1,2,2A23.38,23.38,0,0,0,15,53.93,11.57,11.57,0,0,0,12.37,56.93ZM15,60.86A7.38,7.38,0,0,1,22,55.47h0a7.37,7.37,0,0,1,4,1.2l1.6,1,1.12-1.55a7.42,7.42,0,0,1,5.95-3.07h0a7.34,7.34,0,0,1,6.54,4l1,2,1.86-1.23a5.93,5.93,0,0,1,7.44.74A6,6,0,0,1,53,60.74Zm39.48-5.14a9.74,9.74,0,0,0-1.85-1.43,23.29,23.29,0,0,0,5.53-15.22,2,2,0,0,1,2-2h0a2,2,0,0,1,2,2A27.32,27.32,0,0,1,55.51,57,10.55,10.55,0,0,0,54.45,55.72Z"/><rect class="cls-2" width="68.34" height="68"/></g></g>
    </svg>

    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
  </div>

  <section class="shape_screen">
    <div class="top_panel">
      <div class="back_grid">

        <a class="back_btn home_btn" href="index.php" class="home_btn" style="color: <?= $buttons_color ?>;">
          <?php include $DIR_ICONS.'home.svg' ?>
        </a>
        <div class="div" style="display:grid">
        <!-- <div class="back_btn"> -->


          <span class="back_btn rowcol1 second_arrow" style="color: <?= $buttons_color ?>;" onclick="altClassFromSelector('step1', '.body')">
            <?php include $DIR_ICONS.'atras.svg' ?>
          </span>
          <!-- <img class="back_btn rowcol1 second_arrow" onclick="altClassFromSelector('step1', '.body')" src="<?=$DIR_ICONS?>atras.svg"> -->

          <?php if (count($barcos) > 1) { ?>
            <span class="back_btn rowcol1 first_arrow" style="color: <?= $buttons_color ?>;" onclick="back_btn()">
              <?php include $DIR_ICONS.'atras.svg' ?>
            </span>
            <!-- <img class="back_btn rowcol1 first_arrow" onclick="back_btn()" src="<?=$DIR_ICONS?>atras.svg"> -->
          <?php } ?>


        </div>
        <div class="title_lang_grid">
          <h3 class="top_panel_title"><?= $ELEMS['TIT_INTERACTIVO'] ?></h3>

          <?php foreach ($ship_types as $type) { ?>
            <p class="boat_type_name type_<?= $type['slug'] ?>"><?= $type['tba_nombre'] ?></p>
            <style>
              .shape_screen.type_<?= $type['slug'] ?> .boat_type_name.type_<?= $type['slug'] ?> {
                opacity: 1;
                transform: translateY(0);
                transition-delay: 0.5s;
              }
            </style>
          <?php } ?>

          <!-- <p class="top_panel_language">
            <a href="main.php?lang=esp" class="<?= ($_SESSION["lang"] == 'esp') ? 'selected' : '' ?>">Esp</a>
            <span class="top_panel_stick">|</span>
            <a href="main.php?lang=eng" class="<?= ($_SESSION["lang"] == 'eng') ? 'selected' : '' ?>">Eng</a>
            <span class="top_panel_stick">|</span>
            <a href="main.php?lang=glg" class="<?= ($_SESSION["lang"] == 'glg') ? 'selected' : '' ?>">Gal</a>
          </p> -->
        </div>
      </div>

      <p class="top_panel_text_lg" >Selecciona la estancia que quieras visitar</p>

      <div class="turn">
        <!-- <div class="turn_caption">
          <h3 class="turn_txt">Cubierta</h3>
        </div> -->
        <div class="turn_icon">
          <!-- <img src="<?=$DIR_ICONS?>360-blanco.svg"> -->
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 397 441.97"><title>360 blancoAsset 2</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g id="Layer_2-2" data-name="Layer 2"><g id="Layer_1-2-2" data-name="Layer 1-2"><path d="M391.45,323.34a18.82,18.82,0,0,0-13.36-5.55,19.39,19.39,0,0,0-8.32,2,18.67,18.67,0,0,0-18.27-15.18h-.28a19.32,19.32,0,0,0-8.33,2,18.69,18.69,0,0,0-18.29-15.19h-.25a19.29,19.29,0,0,0-8,1.89v-7.27c42-8.83,63.38-21,63.38-36.09,0-11.55-12.63-21.46-37.5-29.46l-3.53,10.83c21.79,7,29.57,14.21,29.57,18.6,0,5-11.11,15.57-51.78,24.46v-3.83a18.2,18.2,0,0,0-5.39-13.33,18.43,18.43,0,0,0-13.43-5.55A19.7,19.7,0,0,0,278.4,271l-.22,15-.64-5.17a716,716,0,0,1-79.62,5.08l-28.18-28.09-8.08,8.08,20.1,20C76,284.94,11.41,264.62,11.41,249.85c0-4.38,7.77-11.57,29.59-18.6L37.51,220.4C12.6,228.56,0,238.47,0,250c0,30.37,90.17,46.53,181.87,47.45l-20.21,20.18,8.08,8.08L198,297.44a729.39,729.39,0,0,0,80.23-5L277.21,362l-30.13-21.76a22.21,22.21,0,0,0-28.87,2.47,15.38,15.38,0,0,0-4.44,10.72A14.56,14.56,0,0,0,218,364l62.88,62.86A51.57,51.57,0,0,0,317.66,442h.77l21.27-.31a55.25,55.25,0,0,0,54-51.55l3.3-53.53a18.47,18.47,0,0,0-5.55-13.24m-86.37-12.85v.44l-.39,27.76a5.23,5.23,0,0,0,1.56,3.86,5.12,5.12,0,0,0,3.85,1.58,5.72,5.72,0,0,0,5.56-5.55l.41-27.76a8.33,8.33,0,0,1,8.33-7.94,7.48,7.48,0,0,1,5.55,2.33,7.71,7.71,0,0,1,2.28,5.55l-.39,27.77a5.24,5.24,0,0,0,1.56,3.85,5.32,5.32,0,0,0,3.86,1.59,5.73,5.73,0,0,0,5.55-5.56l.19-14.29a8.34,8.34,0,0,1,8.33-8h0A7.9,7.9,0,0,1,359.1,324l-.25,13.88-.27.27.16.2h0a5.31,5.31,0,0,0,5.56,4.91,5.68,5.68,0,0,0,5.55-5.55v-.8a8.32,8.32,0,0,1,8.33-7.94,8.06,8.06,0,0,1,7.88,7.6l-3.3,53.22a43.92,43.92,0,0,1-42.89,41l-21.3.3H318a40.79,40.79,0,0,1-29.15-12l-63-63a4.12,4.12,0,0,1,0-5.78,11.49,11.49,0,0,1,8.05-3.33,10.93,10.93,0,0,1,6.5,2.11l38.86,28a5.61,5.61,0,0,0,8.81-4.55l1.52-101.56a8.33,8.33,0,0,1,8.33-8.16,7.38,7.38,0,0,1,5.55,2.28,7.69,7.69,0,0,1,2.25,5.55Z"/><path d="M145.22,154.3a18,18,0,0,0,4-1.86,11.08,11.08,0,0,0,3-2.78,11.75,11.75,0,0,0,1.86-3.75,17.6,17.6,0,0,0,.64-5,14.52,14.52,0,0,0-1.25-6,14.76,14.76,0,0,0-3.49-4.83,16.74,16.74,0,0,0-5.56-3.25,22.18,22.18,0,0,0-7.41-1.16,24.29,24.29,0,0,0-7.38,1.08,18,18,0,0,0-6.11,3.25,18.81,18.81,0,0,0-4.42,5.38,22.68,22.68,0,0,0-2.38,7.53l5.36.91a7.1,7.1,0,0,0,1.38.14,3.45,3.45,0,0,0,2.28-.69A4.64,4.64,0,0,0,127,141a9.74,9.74,0,0,1,3.11-5,9.23,9.23,0,0,1,5.88-1.86,8.87,8.87,0,0,1,6.31,2.16,8.35,8.35,0,0,1,2.3,6.39,10.72,10.72,0,0,1-.58,3.64,6.28,6.28,0,0,1-2,2.77,10.92,10.92,0,0,1-3.94,1.83,24.16,24.16,0,0,1-6.22.67v7.27a30.71,30.71,0,0,1,7.22.7,10.18,10.18,0,0,1,4.14,1.94,5.56,5.56,0,0,1,1.88,3,15.47,15.47,0,0,1,.48,3.89,9.21,9.21,0,0,1-2.59,6.38,9.62,9.62,0,0,1-3.22,2.2,11.12,11.12,0,0,1-4.52.86,10,10,0,0,1-4-.7,10.2,10.2,0,0,1-2.78-1.75,12.89,12.89,0,0,1-2.11-2.49c-.58-1-1.14-1.89-1.61-2.78a3.2,3.2,0,0,0-1.3-1.33,4,4,0,0,0-1.92-.45,5.67,5.67,0,0,0-2.33.5l-4.5,1.84a33.21,33.21,0,0,0,3,6.74,17.77,17.77,0,0,0,4.19,4.94,16.66,16.66,0,0,0,5.81,3,27.37,27.37,0,0,0,7.8,1,24.91,24.91,0,0,0,7.8-1.2,19.51,19.51,0,0,0,6.47-3.52,16.44,16.44,0,0,0,4.44-5.72,17.64,17.64,0,0,0,1.66-7.86,13.86,13.86,0,0,0-2.77-8.69,15.39,15.39,0,0,0-8-5.13"/><path d="M198.47,153.07a16.27,16.27,0,0,0-5.55-3.36,19.72,19.72,0,0,0-6.55-1.11,18,18,0,0,0-4.33.5,17.44,17.44,0,0,0-3.72,1.36c.3-.44.66-.86,1-1.27l1.08-1.34,17.66-21.57h-9.14a7.11,7.11,0,0,0-3.27.7,5.92,5.92,0,0,0-2.17,1.66l-14.13,19.05a38.68,38.68,0,0,0-5.28,9.22,23.89,23.89,0,0,0-1.72,8.6,24.67,24.67,0,0,0,1.45,8.55,18.51,18.51,0,0,0,4.11,6.58,18.93,18.93,0,0,0,6.44,4.25,24.68,24.68,0,0,0,17.15,0,20.09,20.09,0,0,0,6.56-4.44,19.44,19.44,0,0,0,4.27-6.33,19.81,19.81,0,0,0,1.53-7.55,18.74,18.74,0,0,0-1.5-7.78,16.8,16.8,0,0,0-3.89-5.55m-5.55,18.43a10.92,10.92,0,0,1-2.33,3.23,10.64,10.64,0,0,1-3.5,2.3,11.57,11.57,0,0,1-4.47.8,12,12,0,0,1-4.55-.77,8.92,8.92,0,0,1-5.33-5.72,14.22,14.22,0,0,1-.61-4.44,11.83,11.83,0,0,1,.77-4.28,8.9,8.9,0,0,1,5.42-5.75,11.15,11.15,0,0,1,4.38-.83,12.73,12.73,0,0,1,4.45.75,9.92,9.92,0,0,1,3.47,2.17,9.79,9.79,0,0,1,2.22,3.44,13.17,13.17,0,0,1,.77,4.61,10.94,10.94,0,0,1-.83,4.33"/><path d="M245.83,133a18.83,18.83,0,0,0-7-5.55,21.29,21.29,0,0,0-17.27,0,18.81,18.81,0,0,0-6.89,5.55,27.67,27.67,0,0,0-4.55,9.47A48.78,48.78,0,0,0,208.49,156a49,49,0,0,0,1.67,13.52,27.54,27.54,0,0,0,4.55,9.46,18.63,18.63,0,0,0,6.89,5.56,21.29,21.29,0,0,0,17.27,0,18.58,18.58,0,0,0,7-5.56,28,28,0,0,0,4.61-9.46A48.61,48.61,0,0,0,252.11,156a48.78,48.78,0,0,0-1.67-13.55,28,28,0,0,0-4.61-9.47m-5.16,33.71a21.48,21.48,0,0,1-2.53,6.74,9.33,9.33,0,0,1-3.63,3.53,9.92,9.92,0,0,1-4.28,1,9.52,9.52,0,0,1-4.22-1,9.35,9.35,0,0,1-3.61-3.53,22.65,22.65,0,0,1-2.5-6.74A51.88,51.88,0,0,1,219,156a51.76,51.76,0,0,1,.91-10.69,22.6,22.6,0,0,1,2.5-6.75,9.12,9.12,0,0,1,3.61-3.52,9.39,9.39,0,0,1,4.22-1,9.64,9.64,0,0,1,4.28,1,9.11,9.11,0,0,1,3.63,3.52,21.45,21.45,0,0,1,2.53,6.75,49.73,49.73,0,0,1,.86,10.69,49.85,49.85,0,0,1-.94,10.69"/><path d="M279.87,129a12.6,12.6,0,0,0-4.25-2.58,16.1,16.1,0,0,0-5.55-.89,16.63,16.63,0,0,0-5.55.89,12.6,12.6,0,0,0-4.25,2.58,11.57,11.57,0,0,0-2.78,4.09,16.05,16.05,0,0,0,0,11.1,11.84,11.84,0,0,0,2.78,4.16,12,12,0,0,0,4.25,2.61,16.13,16.13,0,0,0,5.55.92,15.23,15.23,0,0,0,5.55-.92,11.89,11.89,0,0,0,4.25-2.61,11.71,11.71,0,0,0,2.78-4.16,16.36,16.36,0,0,0,0-11.1,11.35,11.35,0,0,0-2.78-4.09m-5.55,15a4.81,4.81,0,0,1-4.08,1.75A5.05,5.05,0,0,1,266,144a11.65,11.65,0,0,1,0-10.8,5.11,5.11,0,0,1,4.28-1.72,4.84,4.84,0,0,1,4.05,1.8,11.59,11.59,0,0,1,0,10.8"/><path d="M69.93,202.16l117.77,49h.75a5.4,5.4,0,0,0,1.44.22h0a5.9,5.9,0,0,0,1.39-.2H192l117.77-49a5.72,5.72,0,0,0,3.52-5.28V54.63A5.76,5.76,0,0,0,310.94,50a5.85,5.85,0,0,0-1.75-.73L192.09.44a5.67,5.67,0,0,0-4.39,0l-117,48.69a7,7,0,0,0-1.75.72,5.76,5.76,0,0,0-2.52,4.78V196.88a5.72,5.72,0,0,0,3.49,5.28m125.68,35.2V213.93a5.72,5.72,0,0,0-11.41-.8,5.34,5.34,0,0,0,0,.8v23.43L77.73,193.08V63.26l109.61,45.48.36.16h0a6.54,6.54,0,0,0,1.06.34h.44c.22,0,.44,0,.67,0H191a6.54,6.54,0,0,0,1-.34h0l.38-.16,109.5-45.48V193.08ZM189.89,11.9,292.61,54.66,189.89,97.44,87.17,54.66Z"/></g></g></g></g></svg>
        </div>
      </div>
    </div>


    <div class="info_content_box step1">
      <h1 class="info_content_box_title full_col_text"></h1>

      <p class="info_content_box_txt full_col_text"><?= $ELEMS['TXT_ENTRADA'] ?></p>
      <h3 class="info_content_cta full_col_text" onclick="altClassFromSelector('step1', 'body')"><?= $ELEMS['TXT_SIGUIENTE'] ?></h3>
    </div>



     <style>
       [class="shape_screen"] .boats_screen_boat {
         width:calc(100% / <?= count($barcos) ?>);
       }
     </style>
    <div class="boats_screen">
      <?php
      foreach ($barcos as $barco) {
        $self_awake = ".$barco[slug] .boats_screen_boat.$barco[slug]";
        ?>
        <style>
          <?= $self_awake ?> {
            width:100vw;
          }
          <?= $self_awake ?> .boats_screen_img {
            opacity:0;
            pointer-events: none;
          }
          <?= $self_awake ?> .boats_screen_title {
            transition-delay: .4s;
            transform: translateY(200%);
          }
        </style>
        <div class="boats_screen_boat <?= $barco['slug'] ?>">
          <?php if (count($barcos) > 1) { ?>
            <?php
            $all_types_id = array_column($ship_types, 'tba_id');
            $type_id_key = array_search($barco['bde_tipo'], $all_types_id);
            ?>
            <img
              class="boats_screen_img rowcol1"
              src="<?= $DIR_IMG . $barco['bde_foto'] ?>"
              onclick="
                activate_barco('<?= $barco['slug'] ?>', <?= $barco['bde_id'] ?>);
                altClassFromSelector('type_<?= $ship_types[$type_id_key]['slug'] ?>', '.shape_screen', ['shape_screen', '<?= $barco['slug'] ?>']);
              "
            >
            <button class="boats_screen_title rowcol1" onclick="activate_barco('<?= $barco['slug'] ?>', <?= $barco['bde_id'] ?>)"><?= $barco['nombre'] ?></button>
          <?php } ?>
          <div class="shape_screen_img ponta rowcol1">
            <template class="template">
              <?= file_get_contents( $DIR_IMG . $barco['svg'] ) ?>

            </template>
          </div>
        </div>
      <?php } ?>
    </div>



    <!-- <div class="ship_screen_cross rowcol1">
      <button class="triangle_btn triangle_up"></button>
      <div class="ship_screen_cross_half">
        <button class="triangle_btn triangle_left"></button>
        <button class="triangle_btn triangle_right"></button>
      </div>
      <button class="triangle_btn triangle_down"></button>
    </div> -->
  </section>

    <!-- Redirect timer -->
    <script> redirect_time = <?= $redirect_time ?>; </script>
    <script type="text/javascript" src="js/main.js"></script>

        <script type="text/javascript">

        clickables = JSON.parse('<?= json_encode($clickables) ?>');
        // console.log(clickables);

        const activate_barco = (slug, id) => {
          // console.log(id);
          // console.log(clickables[id]);
          altClassFromSelector(slug, '.shape_screen', ['shape_screen'])
          // let test = document.querySelector('.boats_screen_boat.' + slug + ' defs')

          let draw = document.importNode(document.querySelector('.boats_screen_boat.' + slug + ' template').content, true);
          clickables[id].forEach( object => {
            // console.log(draw.querySelector('#' + object['slug']));

            if (draw.querySelector('#' + object['slug'])) {
              draw.querySelector('#' + object['slug']).onclick = ()=>{
                console.log('url');
                let base_url = (object['type'] == 'videoplano') ? 'video.php?' : 'player.php?';
                // let base_url = "https://mansilladisseny.com/pescanova/barcos/player.html?type=image&source=panorama8K.jpeg"
                let url = base_url + 'type=' + object['type'] + '&source=' + object['media'] + '&barco=' + object['barco'] + '&nombre=' + object['slug'] + '&lang=<?= $_SESSION["lang"] ?>';
                location.href = url;
              }
            }
          });


          let parent = document.querySelector( '.boats_screen_boat.' + slug + ' .shape_screen_img' );
          parent.insertBefore(draw, parent.children[ 0 ]);
          anim_texts();
          // console.log(test);
        }




        // let base_url = "http://localhost/pescando/barcos/player.php?"
        // let base_url = "http://localhost/pescando/barcos/player.php?"

        // let base_url = "https://mansilladisseny.com/pescanova/barcos/player.html?type=image&source=panorama8K.jpeg"


        </script>

  <?php if(isset($_GET['barco'])){ ?>
    <script>
      document.querySelector('.boats_screen_boat.<?= $_GET['barco'] ?> img').click()
    </script>
  <?php } ?>

  <!-- Forced Style until we resolve correctly -->
  <style>
    .arrastrero #salamaquinas { display: none !important; }
    .trawler #salamaquinas { display: none !important; }
    .arrastreiro #salamaquinas { display: none !important; }
  </style>

  <script>window.onload = () => { out_animate_screen(); }</script>

</body>
</html>
