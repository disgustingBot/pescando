<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");


$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$current_url_no_params = "https://".$_SERVER["HTTP_HOST"]."$uri_parts[0]";


$slug = (isset($_GET['slug'])) ? $_GET['slug'] : 'piscina1';

$video = False;
$piscina = False;
if (isset($_GET['show']) && $_GET['show'] == 'video') {
  $video = get_video_big_data($_GET['slug']);
}

if (isset($_GET['show']) && $_GET['show'] == 'piscina') {
  $piscina = get_piscina($_GET['slug']);
}


$farm = get_farm();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- <title><?=$ELEMS["TIT_INTERACTIVO"]?></title> -->
  <title>Big Data</title>
  <link rel="stylesheet" href="css/style.css">
  <script type="text/javascript" src="js/main.js"></script>
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

  <?php if ($video) { ?>
    <div class="screen">
      <main class="video">
        <video muted autoplay controls>
          <source src="<?= $DIR_MEDIA.$video['video'] ?>" type="video/mp4">
        </video>
      </main>
    </div>
  <?php } ?>

  <?php if ($piscina) { ?>
  <!-- Widget screens -->
  <main class="screen">
    <section class="screen_widgets rowcol1">
      <div class="set_widgets set_widgets_md">
        <section class="widget widget_main">
          <header class="widget_header">
            <h1 class="widget_title"><?= $piscina['title'] ?></h1>
            <img class="widget_header_icon" src="icons/meteo/<?= $piscina['clima']['icon'] ?>.svg">
          </header>

          <footer class="widget_footer">
            <div class="widget_footer_left">
              <img class="widget_footer_icon" src="icons/test1.png">

              <div class="widget_footer_lina">
                <p class="widget_footer_int"><?= $piscina['clima']['temperature'] ?></p>

                <div class="widget_footer_lino">
                  <img class="widget_arrow_icon" src="icons/otrosbig/flecha-azul-arriba.svg">
                  <p class="widget_footer_low"><?= $piscina['clima']['temperature_max'] ?></p>
                </div>

                <div class="widget_footer_lino">
                  <img class="widget_arrow_icon" src="icons/otrosbig/flecha-azul-abajo.svg">
                  <p class="widget_footer_low"><?= $piscina['clima']['temperature_min'] ?></p>
                </div>
              </div>
            </div>

            <div class="widget_footer_right">
              <div class="widget_footer_lino">
                <img class="widget_footer_nor_icon" src="icons/otrosbig/lluvia-dato.svg">
                <p class="widget_footer_nor"><?= $piscina['clima']['humidity'] ?></p>
              </div>

              <div class="widget_footer_lino">
                <img class="widget_footer_nor_icon" src="icons/meteo/viento.svg">
                <p class="widget_footer_nor"><?= $piscina['clima']['wind_speed'] ?></p>
              </div>
            </div>
          </footer>
        </section>




        <!-- FARM PART -->
        <section class="widget widget_status">
          <header class="widget_header">
            <h1 class="widget_title">Estado de la granja</h1>
          </header>

          <div class="donut_graph Donut_Status">
            <?php
            $count_pools = 0;
            foreach ($farm['donut_data'] as $value) {
              $count_pools += $value['value'];
            }
             ?>
            <div class="donut_graph_count"><?= $count_pools ?></div>
            <div class="donut_graph_deco"></div>
          </div>



          <ul class="widget_footer">
            <li class="widget_footer_text">
              <i class="widget_footer_text_icon" style="background-color: #b4e1a8"></i>
              <p>Piscinas sin alertas</p>
            </li>

            <li class="widget_footer_text">
              <i class="widget_footer_text_icon" style="background-color: #e6984f"></i>
              <p>Piscinas que requieren atención</p>
            </li>

            <li class="widget_footer_text">
              <i class="widget_footer_text_icon" style="background-color: #b93b3e"></i>
              <p>Piscinas con avisos</p>
            </li>

            <li class="widget_footer_text">
              <i class="widget_footer_text_icon" style="background-color: #d9d9da"></i>
              <p>Inactivo</p>
            </li>
          </ul>
        </section>
        <script>
          let donut_radius = 45;
          let donut_max_value = parseFloat(<?= $count_pools ?>);
          let donut_data = <?= json_encode($farm['donut_data']); ?>;

          create_donut_graph(donut_radius, donut_max_value, donut_data, '.Donut_Status', 7);

        </script>



      </div>

      <div class="set_widgets set_widgets_sm">

        <?php
        foreach ($piscina['sensors'] as $value) { ?>
          <section class="widget widget_status widget_status_sm">
            <header class="widget_header">
              <h1 class="widget_title"><?= $value['title'] ?></h1>
              <p class="widget_footer_int"><?= $value['value'] ?></p>
            </header>

            <div class="donut_graph <?= $value['slug'] ?>">
              <!-- <div class="donut_graph_indicator" data-value="<?= $value['value'] ?>"></div> -->
              <img src="icons/otrosbig/puntero.svg" class="donut_graph_indicator" data-value="<?= $value['value'] ?>">
            </div>

            <ul class="widget_footer">
              <li class="widget_footer_text">
                <p>Min: <?= $value['min'].$value['unit'] ?></p>
              </li>

              <li class="widget_footer_text">
                <p>Max: <?= $value['max'].$value['unit'] ?></p>
              </li>
            </ul>
          </section>
          <script>
            donut_max_value = parseFloat(<?= $value['max'] ?>);
            donut_data = <?= json_encode($value['donut_data']); ?>;
            create_donut_graph(donut_radius, donut_max_value, donut_data, '.<?= $value['slug'] ?>');
          </script>
        <?php } ?>
      </div>
    </section>
  </main>
  <?php } ?>

  <script type="text/javascript">
    var last_show = getCookie('show');
    var last_slug = getCookie('slug');
    timer = ()=>{setTimeout(()=>{
      var new_slug = getCookie('slug')
      var new_show = getCookie('show')
      if(last_slug!=new_slug){
        let url_no_params = location.protocol + '//' + location.host + location.pathname;
        window.location.href = url_no_params + '?show=' + new_show + '&slug=' + new_slug
      }
      timer()
    },1000)}
    timer()
  </script>

  <!-- Quitar / Poner fondo cuando empieza o finaliza un video -->
  <script>
    let video = document.querySelector('video');

    if(video) {
      ['play', 'ended', 'emptied'].forEach(event => {
        video.addEventListener(event, () => {
          altClassFromSelector('in_animate_screen_display', '.in_animate_screen');
        });
      });
    }
  </script>
</body>
</html>
