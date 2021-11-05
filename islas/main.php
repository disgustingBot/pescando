<?php
require_once("inc.config.php");
require_once("../inc.basic.php");
require_once("../inc.registra_visita.php");
require_once("../inc.salvapantallas.php");
require_once("../inc.alive.php");
require_once("menu_svg.php");

$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$current_url_no_params = $SERVER_URL.$uri_parts[0];

$ELEMS = get_strings();

$islas = get_islas_full();

$buttons_color = ( isset($ELEMS["BUTTONS_COLOR"]) ? $ELEMS["BUTTONS_COLOR"]:"white");
// var_dump($ELEMS);
// var_dump($islas[0]);
$names = [];
foreach ($islas as $isla) {$names[$isla['slug']] = $isla['nombre'];}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Islas de plástico</title>
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

  <section class="islands_main<?= ($ELEMS["VIDEO_INICIAL"] != '') ? ' FULL_VIDEO' : '' ?>">
    <div class="panel">
      <div class="back_grid">
        <a class="back_btn home_btn" href="index.php" class="home_btn" style="color: <?= $buttons_color ?>;">
          <?php include $DIR_ICONS.'home.svg' ?>
        </a>
        <button class="back_btn" style="color: <?= $buttons_color ?>;" onclick="back_btn()">
          <?php include $DIR_ICONS.'atras.svg' ?>
        </button>
        <h3 class="panel_title"><?=$ELEMS['TIT_INTERACTIVO']?></h3>
      </div>

      <div class="panel_description"><?= $ELEMS['TXT_SELECCIONA'] ?></div>

      <img class="panel_icon" src="<?= $DIR_ICONS ?>icono-basura.svg">
    </div>
    <!-- Video screen -->
    <div class="full_video_screen rowcol1">
      <video class="full_video" autoplay>
        <source src="<?=$DIR_MEDIA.$ELEMS["VIDEO_INICIAL"]?>" type="video/mp4">
      </video>
    </div>

    <!-- Islands map -->
    <div class="islands_map rowcol1">
      <img class="rowcol1" src="<?= $DIR_IMG ?>fondo-menu.jpg">

      <div class="islands_map_menu rowcol1">
        <?php
        // include $DIR_ICONS.'isla-menu.svg';
        get_menu_svg($names);

        ?>
      </div>
    </div>

    <!-- Islands question -->
    <?php

    foreach ($islas as $key => $isla) {
      $self_awake = ".$isla[slug] .islands_question.$isla[slug]";
      ?>
      <style media="screen">
      <?= $self_awake ?> {
        opacity: 1;
        z-index: 1;
        pointer-events: all;
      }
      </style>
      <?php // var_dump($isla); ?>
      <div class="islands_question <?= $isla['slug'] ?>">
        <img class="rowcol1" src="<?= $DIR_IMG ?>fondo-islas2.jpg">

        <?php if($isla['isl_fondo'] != '') { ?>
          <img class="islands_question_peninsula_icon" src="<?= $DIR_IMG . $isla['isl_fondo'] ?>">
        <?php } ?>

        <div class="islands_question_box rowcol1">
          <div class="islands_question_vertical">
            <h1 class="islands_question_title"><?= $isla['nombre'] ?></h1>
            <!-- <h1 class="islands_question_title">Pacífico Norte</h1> -->
            <p class="islands_question_left_info"><?= $isla['tra_txtabajo'] ?></p>
            <!-- <p class="islands_question_left_info"><span>1,8 billones</span><br>de plásticos y microplásticos</p> -->
          </div>

          <div class="islands_question_vertical islands_question_vertical_lg">
            <div class="islands_question_txticon">
              <h2 class="islands_question_txtarriba"><?= $isla['tra_txtarriba'] ?></h2>
              <div class="islands_question_icon">
                <?php include $DIR_ICONS.'plasticos.svg' ?>
              </div>
            </div>

            <div class="question_box" data-42="ans_<?= strtolower($isla['isl_opcionbuena']) ?>">
              <div class="question_box_txticon">
                <p class="question_box_que"><?= $isla['tra_pregunta'] ?></p>
                <div class="question_box_icon">
                  <?php include $DIR_ICONS.'icono-pregunta.svg' ?>
                </div>
              </div>
              <?php
              $options = ['a', 'b', 'c'];
              foreach ($options as $option) {
                if ($isla['tra_opcion'.$option] != '-') {

                  $awake         = ".$isla[slug] .ans_$option .ans.ans_$option";
                  $correct       = ".$isla[slug] .ans_".$option."[data-42='ans_$option']";
                  $correct_awake = ".$isla[slug] .ans_".$option."[data-42='ans_$option'] .ans.ans_$option";
                  $incorrect     = ".$isla[slug] .ans_".$option.":not([data-42='ans_$option']) .ans.ans_$option";
                  ?>

                  <style media="screen">
                  <?= $awake ?> .question_box_btn {
                    height:50px;
                  }
                  <?= $correct ?> .question_box_btn {
                    height:0;
                    padding: 0 2rem;
                    opacity: 0;
                    /* border: solid #f9f9f9 3px; */
                    /* background-color: #b4e1a8; */
                  }
                  <?= $correct ?> .question_box_btn .question_box_opttxt {
                    color: #00587C;
                  }
                  <?= $correct ?> .islands_question_txticon_next{
                    opacity: 1;
                    transform: translateX(0);
                  }
                  <?= $correct ?> .question_box_ans {
                    height:200px;
                    padding: 2rem;
                    border-bottom: solid #b4e1a8 10px;
                  }
                  <?= $correct ?> .question_box_txticon {
                    opacity: 0;
                  }
                  <?= $correct_awake ?> .question_box_btn {
                    height:50px;
                    border: solid #f9f9f9 3px;
                    background-color: #b4e1a8;
                    opacity: 1;
                  }
                  <?= $incorrect ?> .question_box_btn {
                    border: solid #f9f9f9 3px;
                    background-color: #df6e6a;
                  }
                  <?= $incorrect ?> .question_box_btn .question_box_opttxt {
                    color: #00587C;
                  }
                  </style>
                  <div class="ans ans_<?= $option ?>" onclick="altClassFromSelector('ans_<?= $option ?>', '.question_box', ['question_box'])">
                    <button class="question_box_btn">
                      <span class="question_box_optletter"><?= $option ?>:</span>
                      <span class="question_box_opttxt"><?= $isla['tra_opcion'.$option] ?></span>
                    </button>
                    <?php if ($option == strtolower($isla['isl_opcionbuena'])) { ?>
                      <p class="question_box_ans">
                        <?= $isla['tra_respuesta'] ?>
                      </p>
                    <?php } ?>
                  </div>
              <?php }} ?>
              <div class="islands_question_txticon_next">
                <?php $next_isla = $islas[$key+1 % count($islas)] ?>
                <svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M384 44v424c0 6.6-5.4 12-12 12h-48c-6.6 0-12-5.4-12-12V291.6l-195.5 181C95.9 489.7 64 475.4 64 448V64c0-27.4 31.9-41.7 52.5-24.6L312 219.3V44c0-6.6 5.4-12 12-12h48c6.6 0 12 5.4 12 12z"></path></svg>
                <p onclick="back_btn(); altClassFromSelector('<?= $next_isla['isl_slug'] ?>', '.islands_main', ['islands_main']);"><?= $ELEMS['TXT_SEE_LINK'] ?> <?= $next_isla['nombre'] ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </section>

  <!-- <script type="text/javascript" src="../js/scripts_nosocket.js"></script> -->
  <!-- Redirect timer -->
  <!-- <script> redirect_time = <?= $redirect_time ?>; </script> -->
  <script type="text/javascript" src="js/main.js"></script>
  <script>animate_bubbles();</script>
</body>
</html>
