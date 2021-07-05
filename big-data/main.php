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
  <main class="screen">
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

    <div class="screen_pool rowcol1">
      <img class="rowcol1" src="../images/background/flota-fondo.jpg">
    </div>
  </main>
</body>
</html>