<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");


$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$current_url_no_params = "https://".$_SERVER["HTTP_HOST"]."$uri_parts[0]";


$ELEMS      = get_strings();


$barcos = get_detalles();
// $barcos = [$barcos[1]];
$clickables = [];
foreach ($barcos as $barco) {
  $clickables[$barco['bde_id']] = get_clickables($barco['bde_id']);
}


// var_dump(json_encode($clickables));
// echo "<br>";
// echo "<br>";
// var_dump($barcos);
// echo "<br>";
// echo "<br>";
// var_dump($clickables[2]);
// echo "<br>";
// echo "<br>";

// TODO: cambiar el svg
// DE PEPUS PARA SOFIA acuérdate que los nombres de los clickables cambian a general / cocina / factoria / camarotes / cubierta / comedor / salamaquinas / salacontrol
// Lo ideal sería crear una funcion get_clickables, de momento créala aquí y yo ya la trasladaré al inc.funcs.php del webadmin



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
          <button class="back_btn" onclick="back_btn()">
            <?php if (count($barcos) > 1) { ?>
            <img src="<?=$DIR_ICONS?>atras.svg">
          <?php } ?>
          </button>
        <div class="title_lang_grid">
          <h3 class="top_panel_title"><?= $ELEMS['TIT_INTERACTIVO'] ?></h3>
          <p class="top_panel_language">
            <a href="main.php?lang=esp" class="<?= ($_SESSION["lang"] == 'esp') ? 'selected' : '' ?>">Esp</a>
            <span class="top_panel_stick">|</span>
            <a href="main.php?lang=eng" class="<?= ($_SESSION["lang"] == 'eng') ? 'selected' : '' ?>">Eng</a>
            <span class="top_panel_stick">|</span>
            <a href="main.php?lang=glg" class="<?= ($_SESSION["lang"] == 'glg') ? 'selected' : '' ?>">Gal</a>
          </p>
        </div>
      </div>

      <div class="turn">
        <div class="turn_caption">
          <!-- <h3 class="turn_txt">Cubierta</h3> -->
        </div>
        <div class="turn_icon">
          <img src="<?=$DIR_ICONS?>360-barco.svg">
        </div>
      </div>
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
            <img class="boats_screen_img rowcol1" src="<?= $DIR_IMG . $barco['bde_foto'] ?>" onclick="activate_barco('<?= $barco['slug'] ?>', <?= $barco['bde_id'] ?>)">
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


  <script type="text/javascript" src="js/main.js"></script>
<?php



 ?>
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

  <script>window.onload = () => { out_animate_screen(); }</script>
  <?php if(isset($_GET['barco'])){ ?>
    <script>
      document.querySelector('.boats_screen_boat.<?= $_GET['barco'] ?> img').click()
    </script>
  <?php } ?>

  <!-- Redirect timer -->
  <?php $redirect_time = 10; ?>
  <script>
    (() => {
      let redirect_time = <?= $redirect_time ?>;
      let inactivity_timer = inactivity_redirect(redirect_time);
      
      // Reset timer each click in the app
      window.addEventListener('click', () => {
        inactivity_timer = reset_inactivity_redirect(inactivity_timer, redirect_time);
      });
    })();
  </script>
</body>
</html>
