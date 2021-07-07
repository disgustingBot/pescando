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

        <div class="widget">
          <div class="donut_graph Donut_Status"></div>
        </div>
      </div>

      <div class="set_widgets set_widgets_sm">
        <div class="widget"></div>
        <div class="widget"></div>
        <div class="widget"></div>
        <div class="widget"></div>
      </div>
    </div>
  </main>

  <script type="text/javascript" src="js/main.js"></script>
  <script>
    const donut_data = [{
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
    
    const donut_radius = 45;
    const donut_max_value = 44;
    create_donut_graph(donut_radius, donut_max_value, donut_data, '.Donut_Status');
  </script>
</body>
</html>