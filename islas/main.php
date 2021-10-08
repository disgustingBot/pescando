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

  <section class="islands_main FULL_VIDEO">
    <div class="panel">
      <div class="back_grid">
        <a class="back_btn home_btn" href="index.php" class="home_btn">
          <?= file_get_contents('./../icons/home.svg') ?>
        </a>
        <button class="back_btn">
          <?= file_get_contents('./../icons/atras.svg') ?>
        </button>
        <h3 class="panel_title">Las islas de plástico</h3>
      </div>

      <p class="panel_description">Selecciona una isla de plástico</p>

      <img class="panel_icon" src="./../icons/islas/icono-basura.svg">
    </div>

    <!-- Video screen -->
    <div class="full_video_screen rowcol1">
      <video class="full_video" autoplay>
        <source src="" type="video/mp4">
      </video>
    </div>

    <!-- Islands map -->
    <div class="islands_map rowcol1">
      <img class="rowcol1" src="./../images/islas/fondo-menu.jpg">

      <div class="islands_map_menu rowcol1">
        <?= file_get_contents('./../icons/islas/isla-menu.svg') ?>">
      </div>
    </div>

    <!-- Islands question -->
    <div class="islands_question rowcol1">
      <img class="rowcol1" src="./../images/islas/fondo-islas2.jpg">

      <div class="islands_question_box rowcol1">
        <div class="islands_question_vertical">
          <h1 class="islands_question_title">Pacífico Norte</h1>
          <p class="islands_question_left_info"><span>1,8 billones</span><br>de plásticos y microplásticos</p>
        </div>
      </div>
    </div>
  </section>

  <script type="text/javascript" src="../js/scripts_nosocket.js"></script>
  <!-- Redirect timer -->
  <!-- <script> redirect_time = <?= $redirect_time ?>; </script> -->
  <script type="text/javascript" src="js/main.js"></script>
  <script>animate_bubbles();</script>
</body>
</html>
