<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");


$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$current_url_no_params = "https://".$_SERVER["HTTP_HOST"]."$uri_parts[0]";




$piscinas = get_piscinas();
$videos = get_videos_big_data();





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
      <?php foreach ($videos as $video) { ?>

        <div class="viday">
          <div class="viday_media">
            <div class="viday_btn_play">
              <img src="icons/otrosbig/triangulo-play.svg">
            </div>

            <video class="viday_video" poster="icons/foto-video.png">
            <video class="viday_video" poster="" onclick="setCookie('show', 'video', 1);setCookie('slug', '<?= $video['slug'] ?>', 1)">
              <!-- <source src="" type="video/mp4"> -->
            </video>
          </div>

          <p class="viday_caption"><?= $video['title'] ?></p>
        </div>
      <?php } ?>
    </section>

    <!-- Pool screens -->
    <div class="screen_pools rowcol1">
      <img class="rowcol1 screen_pools_interactive" src="icons/fondo-menu.jpg">
      <div class="rowcol1 screen_pools_interactive">
        <?= file_get_contents('icons/otrosbig/esp-piscina-noselec.svg'); ?>
          <script>
          let piscinas = <?= json_encode($piscinas) ?>;
          piscinas.forEach( piscina => {
            document.querySelector('#'+piscina.slug).onclick = _ => {
              altClassFromSelector('selected', '#'+piscina.slug)
              setCookie('show', 'piscina', 1)
              setCookie('slug', piscina.slug, 1)
            }
          });
          </script>
      </div>
    </div>
  </main>

</body>
</html>
