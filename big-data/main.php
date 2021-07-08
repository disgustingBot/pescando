<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- <title><?=$ELEMS["TIT_INTERACTIVO"]?></title> -->
  <title>Big Data</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <main class="screen Pools">
    <section class="panel panel_top">
      <div class="back_grid">
        <button class="back_btn" onclick="altClassFromSelector('Widgets', 'main.screen'); altClassFromSelector('Pools', 'main.screen');">
          <img src="../icons/atras.svg">
        </button>

        <div>
          <!-- <h3 class="panel_title"><?= $ELEMS['MENU_TEXTO'] ?></h3> -->
          <h3 class="panel_title">Big Data</h3>

          <p class="panel_language">
            <a href="main.php?lang=esp" class="<?= ($_SESSION["lang"] == 'esp') ? 'selected' : '' ?>">Esp</a>
            <span class="panel_stick">|</span>
            <a href="main.php?lang=eng" class="<?= ($_SESSION["lang"] == 'eng') ? 'selected' : '' ?>">Eng</a>
            <span class="panel_stick">|</span>
            <a href="main.php?lang=glg" class="<?= ($_SESSION["lang"] == 'glg') ? 'selected' : '' ?>">Gal</a>
          </p>
        </div>
      </div>
    </section>

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

    <div class="screen_pools rowcol1">
      <img class="rowcol1 screen_pools_interactive" src="../images/background/flota-fondo.jpg">
      <div class="rowcol1 screen_pools_interactive">
        <?= file_get_contents('piscinas-botones-click.svg'); ?>
      </div>
    </div>

    <div class="screen_widgets rowcol1">
      <div class="set_widgets set_widgets_md">
        <section class="widget widget_main">
          <header class="widget_header">
            <h1 class="widget_title">Piscina 2</h1>
            <img class="widget_header_icon" src="">
          </header>

          <footer class="widget_footer">
            <div class="widget_footer_left">
              <img class="widget_footer_icon" src="">

              <div>
                <p class="widget_footer_int">22,8°</p>

                <div>
                  <img src="">
                  <p class="widget_footer_low">29,6°</p>
                </div>

                <div>
                  <img src="">
                  <p class="widget_footer_low">22,2°</p>
                </div>
              </div>
            </div>
            
            <div class="widget_footer_right">
              <div>
                <img src="">
                <p class="widget_footer_nor">25%</p>
              </div>

              <div>
                <img src="">
                <p class="widget_footer_nor">16,7 km/h</p>
              </div>
            </div>
          </footer>
        </section>

        <section class="widget widget_status">
          <header class="widget_header">
            <h1 class="widget_title">Estado de la granja</h1>
          </header>

          <div class="donut_graph Donut_Status"></div>

          <ul class="widget_footer">
            <li class="widget_footer_text">
              <img src="">
              <p>Piscinas sin alertas</p>
            </li>

            <li class="widget_footer_text">
              <img src="">
              <p>Piscinas que requieren atención</p>
            </li>

            <li class="widget_footer_text">
              <img src="">
              <p>Piscinas con avisos</p>
            </li>

            <li class="widget_footer_text">
              <img src="">
              <p>Inactivo</p>
            </li>
          </ul>
        </section>
      </div>

      <div class="set_widgets set_widgets_sm">
        <section class="widget widget_status widget_status_sm">
          <header class="widget_header">
            <h1 class="widget_title">pH</h1>
            <p class="widget_footer_int">11</p>
          </header>

          <div class="donut_graph Donut_PH"></div>

          <ul class="widget_footer">
            <li class="widget_footer_text">
              <p>Min: 0</p>
            </li>

            <li class="widget_footer_text">
              <p>Max: 14</p>
            </li>
          </ul>
        </section>

        <section class="widget widget_status widget_status_sm">
          <header class="widget_header">
            <h1 class="widget_title">Oxígeno</h1>
            <p class="widget_footer_int">4,46 mg/l</p>
          </header>

          <div class="donut_graph Donut_Oxygen"></div>

          <ul class="widget_footer">
            <li class="widget_footer_text">
              <p>Min: 0 mg/l</p>
            </li>

            <li class="widget_footer_text">
              <p>Max: 10 mg/l</p>
            </li>
          </ul>
        </section>

        <section class="widget widget_status widget_status_sm">
          <header class="widget_header">
            <h1 class="widget_title">Salinidad</h1>
            <p class="widget_footer_int">38 g/l</p>
          </header>

          <div class="donut_graph Donut_Salinity"></div>

          <ul class="widget_footer">
            <li class="widget_footer_text">
              <p>Min: 0 g/l</p>
            </li>

            <li class="widget_footer_text">
              <p>Max: 40 g/l</p>
            </li>
          </ul>
        </section>

        <section class="widget widget_status widget_status_sm">
          <header class="widget_header">
            <h1 class="widget_title">Temperatura</h1>
            <p class="widget_footer_int">20° C</p>
          </header>

          <div class="donut_graph Donut_Temperature"></div>

          <ul class="widget_footer">
            <li class="widget_footer_text">
              <p>Min: 0° C</p>
            </li>

            <li class="widget_footer_text">
              <p>Max: 40° C</p>
            </li>
          </ul>
        </section>
      </div>
    </div>
  </main>

  <script type="text/javascript" src="js/main.js"></script>
  <script>
    let donut_radius = 45;

    // ---------------------------
    let donut_data = [{
      value  : 31,
      color : "#80e080",
    },{
      value  : 7,
      color : "#4fc3f7",
    },{
      value  : 4,
      color : "#9575cd",
    },{
      value  : 2,
      color : "#f06292",
    }];
    
    let donut_max_value = 44;
    create_donut_graph(donut_radius, donut_max_value, donut_data, '.Donut_Status');

    // ---------------------------
    donut_data = [{
      value  : 11,
      color : "#4fc3f7",
    }];
    
    donut_max_value = 14;
    create_donut_graph(donut_radius, donut_max_value, donut_data, '.Donut_PH');

    // ---------------------------
    donut_data = [{
      value  : 4.46,
      color : "#9575cd",
    }];
    
    donut_max_value = 10;
    create_donut_graph(donut_radius, donut_max_value, donut_data, '.Donut_Oxygen');

    // ---------------------------
    donut_data = [{
      value  : 38,
      color : "#80e080",
    }];
    
    donut_max_value = 40;
    create_donut_graph(donut_radius, donut_max_value, donut_data, '.Donut_Salinity');

    // ---------------------------
    donut_data = [{
      value  : 20,
      color : "#f06292",
    }];
    
    donut_max_value = 40;
    create_donut_graph(donut_radius, donut_max_value, donut_data, '.Donut_Temperature');
  </script>
</body>
</html>