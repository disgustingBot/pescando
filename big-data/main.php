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

  // var_dump($videos);
  // var_dump($ELEMS);

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
              <img class="viday_poster" src="<?= $DIR_MEDIA.$video['image'] ?>">
            </div>

            <div class="viday_btn_play">
              <img src="icons/otrosbig/triangulo-play.svg">
            </div>

          </div>

          <p class="viday_caption"><?= $video['title'] ?></p>
        </div>
      <?php } ?>
    </section>

    <!-- Pool screens -->
    <div class="screen_pools rowcol1">
      <img class="rowcol1 screen_pools_interactive" src="icons/fondo-menu.jpg">
      <div class="rowcol1 screen_pools_interactive">
        <?= file_get_contents($DIR_IMG.$_SESSION['lang'].'-piscina-noselec.svg'); ?>
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
    var redirect_time = <?= $redirect_time ?>;
    // start_inactivity_redirect(redirect_time);
    is_playing_media = false;
    page = 'inc.session.end.php';
  </script>
  <script type="text/javascript" src="../js/scripts_nosocket.js"></script>
  <script type="text/javascript" src="js/main.js"></script>

</body>
</html>
