<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");

  $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
  $current_url_no_params = "https://".$_SERVER["HTTP_HOST"]."$uri_parts[0]";

  $ELEMS = get_strings();

  $clima = get_clima();
  $farm = get_farm();

  $slug = (isset($_GET['slug'])) ? $_GET['slug'] : 'piscina1';

  $video = False;
  $piscina = False;
  if (isset($_GET['show']) && $_GET['show'] == 'video') {
    $video = get_video_big_data($slug);
  }

  if (isset($_GET['show']) && $_GET['show'] == 'piscina') {
    $piscina = get_piscina($slug);
  }


  // $redirect_time = 15;

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?=$ELEMS["TIT_INTERACTIVO"]?></title>
  <link rel="stylesheet" href="css/style.css">


  <script>
    redirect_time = <?=$redirect_time?>;
    page = 'big.php';
    is_playing_media = false;
    <?php if ($video) { ?>
      is_playing_media = true;
    <?php } ?>
  </script>
  <script type="text/javascript" src="../js/scripts_nosocket.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
</head>

<body>



    <section class="screen screen_lang rowcol1" style="background: url('icons/fondo.jpg') no-repeat center center;">
      <div class="screen_lang_icon">
        <!-- <img src="<?=$DIR_ICONS?>dedo-click.svg"> -->
        <img src="../icons/dedo-click.svg">
      </div>

      <h1 class="screen_lang_title"><?= $ELEMS['INDEX_TITLE'] ?></h1>
    </section>



  <?php if ($video) { ?>
  <main class="video rowcol1">
    <video id="video1" autoplay>
      <source src="<?= $DIR_MEDIA.$video['video'] ?>" type="video/mp4">
    </video>
  </main>
  <?php } ?>

  <?php if ($piscina) { ?>
  <!-- Widget screens -->
  <main class="screen rowcol1">
    <section class="screen_widgets rowcol1">
      <div class="set_widgets set_widgets_title">
        <h3 class="panel_title"><?=$ELEMS["TIT_BIG_DATA"]?></h3>
        <div class="widget widget_status">
          <header class="widget_header">
            <h1 class="widget_title"><?=$ELEMS["TIT_ECUADOR"]?><h1>
          </header>
        </div>
      </div>

      <div class="set_widgets set_widgets_md">
        <section class="widget widget_main">
          <header class="widget_header">
            <h1 class="widget_title"><?= $piscina['title'] ?></h1>
            <img class="widget_header_icon" src="icons/meteo/<?= $clima['icon'] ?>.svg">
          </header>

          <footer class="widget_footer">
            <div class="widget_footer_left">
              <img class="widget_footer_icon" src="icons/otrosbig/termometro.svg">

              <div class="widget_footer_lina">
                <p class="widget_footer_int"><?= $clima['temperature'] ?></p>

                <div class="widget_footer_lino">
                  <img class="widget_arrow_icon" src="icons/otrosbig/flecha-azul-arriba.svg">
                  <p class="widget_footer_low"><?= $clima['temperature_max'] ?></p>
                </div>

                <div class="widget_footer_lino">
                  <img class="widget_arrow_icon" src="icons/otrosbig/flecha-azul-abajo.svg">
                  <p class="widget_footer_low"><?= $clima['temperature_min'] ?></p>
                </div>
              </div>
            </div>

            <div class="widget_footer_right">
              <div class="widget_footer_lino">
                <img class="widget_footer_nor_icon" src="icons/otrosbig/lluvia-dato.svg">
                <p class="widget_footer_nor"><?= $clima['humidity'] ?></p>
              </div>

              <div class="widget_footer_lino">
                <img class="widget_footer_nor_icon" src="icons/meteo/viento.svg">
                <p class="widget_footer_nor"><?= $clima['wind_speed'] ?></p>
              </div>
            </div>
          </footer>
        </section>




        <!-- FARM PART -->
        <section class="widget widget_status">
          <header class="widget_header">
            <h1 class="widget_title"><?=$ELEMS["TXT_ESTADO_GRANJA"]?></h1>
          </header>

          <div class="donut_graph Donut_Status">
            <div class="donut_graph_count">4/4</div>
            <div class="donut_graph_deco"></div>
          </div>



          <ul class="widget_footer">
            <li class="widget_footer_text">
              <i class="widget_footer_text_icon" style="background-color: #b4e1a8"></i>
              <p><?=$ELEMS["TXT_PISCINAS_OK"]?></p>
            </li>

            <li class="widget_footer_text">
              <i class="widget_footer_text_icon" style="background-color: #e6984f"></i>
              <p><?=$ELEMS["TXT_PISCINAS_WARNING"]?></p>
            </li>
            <!--

            <li class="widget_footer_text">
              <i class="widget_footer_text_icon" style="background-color: #b93b3e"></i>
              <p>Piscinas con avisos</p>
            </li>

            <li class="widget_footer_text">
              <i class="widget_footer_text_icon" style="background-color: #d9d9da"></i>
              <p>Inactivo</p>
            </li>
-->
          </ul>
        </section>
        <script>
          let donut_radius = 45;
          let donut_max_value = 4;
          let donut_data = <?= json_encode($farm['donut_data']); ?>;

          create_donut_graph(donut_radius, donut_max_value, donut_data, '.Donut_Status');

        </script>



      </div>

      <div class="set_widgets set_widgets_sm">

        <?php foreach ($piscina['sensors'] as $value) { ?>
          <section class="widget widget_status widget_status_sm">
            <header class="widget_header">
              <h1 class="widget_title"><?php

                $val = 0;
                switch($value['slug']) {
                  case "ph": echo $ELEMS["TXT_PH"]; $val = number_format($value['value'],1,",","."); break;
                  case "oxigen": echo $ELEMS["TXT_OXIGENO"]; $val = number_format($value['value'],2,",","."); break;
                  case "salinity": echo $ELEMS["TXT_SALINIDAD"]; $val = number_format($value['value'],0,",","."); break;
                  case "temperature": echo $ELEMS["TXT_TEMPERATURA"]; $val = number_format($value['value'],1,",","."); break;
                  default: echo "- - -"; break;
                }
              ?></h1>
              <p class="widget_footer_int"><?=$val.$value['unit']?></p>
            </header>

            <div class="donut_graph <?= $value['slug'] ?>">
              <!-- <div class="donut_graph_indicator" data-value="<?= $value['value'] ?>"></div> -->
              <img src="icons/otrosbig/puntero.svg" class="donut_graph_indicator" data-value="<?= $value['value'] ?>">
            </div>

            <ul class="widget_footer">
              <li class="widget_footer_text">
                <p><?=$ELEMS["TXT_MIN"]?>: <?= $value['min'].$value['unit'] ?></p>
              </li>

              <li class="widget_footer_text">
                <p><?=$ELEMS["TXT_MAX"]?>: <?= $value['max'].$value['unit'] ?></p>
              </li>
            </ul>
          </section>
        <?php } ?>
        <script>
          window.onload=()=>{
            <?php foreach ($piscina['sensors'] as $value) { ?>
              donut_max_value = parseFloat(<?= $value['max'] ?>);
              donut_data = <?= json_encode($value['donut_data']); ?>;
              create_donut_graph(donut_radius, donut_max_value, donut_data, '.<?= $value['slug'] ?>');
            <?php } ?>
          }
        </script>
      </div>
    </section>
  </main>
  <?php } ?>
  <script type="text/javascript" src="../plugins/jquery/jquery.min.js"></script>


  <script type="text/javascript">
let is_redirecting = false;

$(document).ready(function() {
<?php if ( isset($_GET['show']) && $_GET['show'] == 'video' ) { ?>

  $('#play').on("click", function () {
    $('#video1').get(0).load();
    $('#video1').get(0).play();
  });

  $('#video1').on("ended", function() {
    is_redirecting = true;
    location.href = './big.php';
  });

  $('#play').click();

<?php } ?>
});

    last_show = getCookie('show');
    last_slug = getCookie('slug');
    last_lang = getCookie('lang');

    console.log(last_slug);
    <?php if ($video || $piscina) { ?>
      if (last_slug != 0) {
        console.log('no mostrar pantalla pausa');
        document.querySelector('.screen_lang').style.opacity = 0;
        document.querySelector('.screen_lang').style.pointerEvents = 'none';

      }
    <?php } ?>
    timer = ()=>{setTimeout(()=>{
      new_slug = getCookie('slug');
      new_show = getCookie('show');
      new_lang = getCookie('lang');
      if((last_slug!=new_slug) && (new_slug!=0)){
        // console.log('new slug: ', new_slug);
        is_redirecting = true;

        if(new_slug == 'redirect_page') {
          setCookie('slug', 0, 1);
          location.href = './big.php';
        }

        else {
          let url_no_params = location.protocol + '//' + location.host + location.pathname;
          window.location.href = url_no_params + '?show=' + new_show + '&slug=' + new_slug + '&lang=' + new_lang
        }
      }

      if(!is_redirecting) timer();
    },1000)}
    timer()
  </script>

</body>
</html>
