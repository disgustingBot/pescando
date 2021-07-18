<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");


$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$current_url_no_params = "https://".$_SERVER["HTTP_HOST"]."$uri_parts[0]";





$farm = get_farm();


$slug = (isset($_GET['slug'])) ? $_GET['slug'] : 'piscina1';
$piscina = get_piscina($_GET['slug']);





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

  <main class="video">

  </main>

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

</body>
</html>
