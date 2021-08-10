<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");

  $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
  $current_url_no_params = "https://".$_SERVER["HTTP_HOST"]."$uri_parts[0]";

  $ELEMS = get_strings();

  $piscinas = get_piscinas();
  $videos = get_videos_big_data();

  $redirect_time = 60;
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

  <main class="screen">
    <!-- Top panel -->
    <section class="panel panel_top">
      <h3 class="panel_title"><?= $ELEMS['MENU_TEXTO'] ?></h3>

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
            
            <div class="viday_video" poster="" onclick="video_click('<?= $video['slug'] ?>', '<?= $_SESSION['lang'] ?>')">
            <!-- <video class="viday_video" poster="" onclick="setCookie('show', 'video', 1);setCookie('slug', '<?= $video['slug'] ?>', 1);setCookie('lang', '<?= $_SESSION['lang'] ?>', 1);altClassFromSelector('', 'div.screen_pools_interactive', ['screen_pools_interactive', 'rowcol1'])"> -->
              <!-- <source src="" type="video/mp4"> -->
              <img class="viday_poster" src="icons/foto-video.png">
            </div>
          
            <div class="viday_btn_play">
              <img src="icons/otrosbig/triangulo-play.svg">
            </div>

            <!--<div class="viday_video" onclick="setCookie('show', 'video', 1);setCookie('slug', '<?= $video['slug'] ?>', 1);setCookie('lang', '<?= $_SESSION['lang'] ?>', 1);altClassFromSelector('selected', '[id*=piscina].selected');">
            </div>-->
          
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
              altClassFromSelector(piscina.slug, 'div.screen_pools_interactive', ['screen_pools_interactive', 'rowcol1'])
              setCookie('show', 'piscina', 1);
              setCookie('slug', piscina.slug, 1);
              setCookie('lang', '<?=$_SESSION["lang"]?>', 1);
            }
          });
          </script>
          <?php foreach ($piscinas as $piscina) { ?>
            <style>
            <?= ".screen_pools_interactive.$piscina[slug] #$piscina[slug] path" ?> {
              stroke: #d6001c;
              fill: #0875bd36;
            }

            <?= ".screen_pools_interactive.$piscina[slug] #$piscina[slug] path:last-of-type" ?> {
              fill: #d6001c;
              stroke: white;
            }
            </style>
          <?php } ?>
      </div>
    </div>
  </main>

  <!-- Redirect timer -->
  <script>
    let redirect_time = <?= $redirect_time ?>;
    start_inactivity_redirect(redirect_time);
  </script>

</body>
</html>
