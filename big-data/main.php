

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




  <main class="screen">
    <!-- Top panel -->
    <section class="panel panel_top">
      <!-- <h3 class="panel_title"><?= $ELEMS['MENU_TEXTO'] ?></h3> -->
      <h3 class="panel_title">Big Data</h3>

      <p class="panel_language">
        <a href="main.php?lang=esp" class="<?= ($_SESSION["lang"] == 'esp') ? 'selected' : '' ?>">Esp</a>
        <span class="panel_stick">|</span>
        <a href="main.php?lang=eng" class="<?= ($_SESSION["lang"] == 'eng') ? 'selected' : '' ?>">Eng</a>
        <span class="panel_stick">|</span>
        <a href="main.php?lang=glg" class="<?= ($_SESSION["lang"] == 'glg') ? 'selected' : '' ?>">Gal</a>
      </p>
    </section>

    <!-- Right panel -->
    <section class="panel panel_right">
      <div class="viday">
        <div class="viday_media">
          <video class="viday_video" poster="">
            <source src="../hidrofonos/videos/HIDROFONO_PULPO_01.mp4" type="video/mp4">
          </video>
        </div>

        <p class="viday_caption">¿Qué es el big data?</p>
      </div>

      <div class="viday">
        <div class="viday_media">
          <video class="viday_video" poster="">
            <source src="../hidrofonos/videos/HIDROFONO_PULPO_01.mp4" type="video/mp4">
          </video>
        </div>

        <p class="viday_caption">Big data en Nueva Pescanova</p>
      </div>

      <div class="viday">
        <div class="viday_media">
          <video class="viday_video" poster="">
            <source src="../hidrofonos/videos/HIDROFONO_PULPO_01.mp4" type="video/mp4">
          </video>
        </div>

        <p class="viday_caption">¿Qué datos analizamos?</p>
      </div>

      <div class="viday">
        <div class="viday_media">
          <video class="viday_video" poster="">
            <source src="../hidrofonos/videos/HIDROFONO_PULPO_01.mp4" type="video/mp4">
          </video>
        </div>

        <p class="viday_caption">El futuro</p>
      </div>
    </section>

    <!-- Pool screens -->
    <div class="screen_pools rowcol1">
      <img class="rowcol1 screen_pools_interactive" src="../images/background/flota-fondo.jpg">
      <div class="rowcol1 screen_pools_interactive">
        <?= file_get_contents('piscinas-botones-click.svg'); ?>
      </div>
    </div>
  </main>





























  <?php

  $farm = array(
    'total' => '44',
    'donut_data' => array(
      0 => ['value' => 31, 'color' => "#b4e1a8"],
      1 => ['value' => 7, 'color' => "#e6984f"],
      2 => ['value' => 4, 'color' => "#b93b3e"],
      3 => ['value' => 2, 'color' => "#d9d9da"],
    ),
  );


  $piscina = array(
    'slug' => 'piscina-2',
    'title' => 'Piscina 2',
    'clima' => array(
      'icon' => 'viento',
      'temperature_min' => '22,8°',
      'temperature_min' => '29,6°',
      'temperature_min' => '22,2°',
      'humidity' => '25%',
      'wind_speed' => '16,7 km/h'
    ),
    'sensors' => array(
      0 => array(
        'slug' => 'ph',
        'title' => 'pH',
        'min' => '0',
        'max' => '14',
        'min_optimal' => '7',
        'max_optimal' => '9.8',
        'value' => '11',
        'unit' => '',
        'color' => "#b93b3e",
      ),
      1 => array(
        'slug' => 'oxigen',
        'title' => 'Oxígeno',
        'min' => '0',
        'max' => '10',
        'min_optimal' => '3',
        'max_optimal' => '10',
        'value' => '4,46',
        'unit' => 'mg/l',
        'color' => "#b93b3e",
      ),
      2 => array(
        'slug' => 'salinity',
        'title' => 'Salinidad',
        'min' => '0',
        'max' => '40',
        'min_optimal' => '4',
        'max_optimal' => '40',
        'value' => '38',
        'unit' => 'g/l',
        'color' => "#e6984f",
      ),
      3 => array(
        'slug' => 'temperature',
        'title' => 'Temperatura',
        'min' => '0',
        'max' => '40',
        'min_optimal' => '25',
        'max_optimal' => '40',
        'value' => '20',
        'unit' => '°C',
        'color' => "#e6984f",
      ),
    ),
  );




  ?>


  <!-- Widget screens -->
  <main class="screen">
    <section class="screen_widgets rowcol1">
      <div class="set_widgets set_widgets_md">
        <section class="widget widget_main">
          <header class="widget_header">
            <h1 class="widget_title">Piscina 2</h1>
            <img class="widget_header_icon" src="icons/test2.png">
          </header>

          <footer class="widget_footer">
            <div class="widget_footer_left">
              <img class="widget_footer_icon" src="icons/test1.png">

              <div class="widget_footer_lina">
                <p class="widget_footer_int">22,8°</p>

                <div class="widget_footer_lino">
                  <i class="widget_triangle_icon_up"></i>
                  <p class="widget_footer_low">29,6°</p>
                </div>

                <div class="widget_footer_lino">
                  <i class="widget_triangle_icon_down"></i>
                  <p class="widget_footer_low">22,2°</p>
                </div>
              </div>
            </div>

            <div class="widget_footer_right">
              <div class="widget_footer_lino">
                <img class="widget_footer_nor_icon" src="icons/test3.png">
                <p class="widget_footer_nor">25%</p>
              </div>

              <div class="widget_footer_lino">
                <img class="widget_footer_nor_icon" src="icons/test4.png">
                <p class="widget_footer_nor">16,7 km/h</p>
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
            <!-- <?php
            $count_pools = 0;
            foreach ($farm as $value) {
              $count_pools += $value['value'];
            }
             ?> -->
            <div class="donut_graph_count"><?= $farm['total'] ?></div>
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
          let donut_max_value = parseFloat(<?= $farm['total'] ?>);
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
              <div class="donut_graph_indicator" data-value="<?= $value['value'] ?>"></div>
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
            console.log(donut_max_value);

            // donut_data = <?= json_encode($value['donut_data']); ?>;
            donut_data = [{
              // No optimo
              'value' : parseFloat(<?= $value['min_optimal'] ?>),
              'color' : '<?= $value['color'] ?>',
            }, {
              // Optimo
              'value' : parseFloat(<?= abs($value['max_optimal']) - abs($value['min_optimal']) ?>),
              'color' : '#b4e1a8',
            }, {
              // No optimo
              'value' : parseFloat(<?= abs($value['max']) - abs($value['max_optimal']) ?>),
              'color' : '<?= $value['color'] ?>',
            }];

            create_donut_graph(donut_radius, donut_max_value, donut_data, '.<?= $value['slug'] ?>');
          </script>
        <?php } ?>
      </div>
    </section>
  </main>

</body>
</html>
