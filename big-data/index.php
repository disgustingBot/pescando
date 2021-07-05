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
  <section class="screen screen_lang" style="background: url('../images/background/flota-fondo.jpg') no-repeat center center;">
    <div class="screen_lang_icon">
      <!-- <img src="<?=$DIR_ICONS?>dedo-click.svg"> -->
      <img src="../icons/dedo-click.svg">
    </div>

    <!-- <h1 class="screen_lang_title"><?= $ELEMS['INDEX_TITLE'] ?></h1> -->
    <h1 class="screen_lang_title">¡Conoce cómo utilizamos<br>el Big Data en la acuicultura!</h1>

    <ul class="screen_lang_list">
      <li>
        <a
          href="main.php?lang=esp"
          class="screen_lang_btn <?= ($lang == 'esp') ? 'selected' : '' ?>">Español
        </a>
      </li>

      <li>
        <a
          href="main.php?lang=eng"
          class="screen_lang_btn <?= ($lang == 'eng') ? 'selected' : '' ?>">English
        </a>
      </li>

      <li>
        <a
          href="main.php?lang=glg"
          class="screen_lang_btn <?= ($lang == 'glg') ? 'selected' : '' ?>">Galego
        </a>
      </li>
    </ul>
  </section>
</body>
</html>