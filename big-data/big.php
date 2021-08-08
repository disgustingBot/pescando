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



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?=$ELEMS["TIT_INTERACTIVO"]?></title>
  <link rel="stylesheet" href="css/style.css">
  <script type="text/javascript" src="js/main.js"></script>
</head>

<body>

  <?php if ($video) { ?>
    <main class="video">
      <video muted autoplay controls>
        <source src="<?= $DIR_MEDIA.$video['video'] ?>" type="video/mp4">
      </video>
    </main>
  <?php } ?>

  <?php if ($piscina) { ?>
  <!-- Widget screens -->
  <main class="screen">
    <section class="screen_widgets rowcol1">
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

        <?php
        foreach ($piscina['sensors'] as $value) { ?>
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
console.log('<?=$_SESSION["lang"]?>');
    
    var last_show = getCookie('show');
    var last_slug = getCookie('slug');
    var last_lang = getCookie('lang');
    timer = ()=>{setTimeout(()=>{
      var new_slug = getCookie('slug');
      var new_show = getCookie('show');
      var new_lang = getCookie('lang');
      if(last_slug!=new_slug){
        let url_no_params = location.protocol + '//' + location.host + location.pathname;
        window.location.href = url_no_params + '?show=' + new_show + '&slug=' + new_slug + '&lang=' + new_lang
      }
      timer()
    },1000)}
    timer()
  </script>

</body>
</html>
