<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");

  $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
  $current_url_no_params = "https://".$_SERVER["HTTP_HOST"]."$uri_parts[0]";
  // $lang = isset($_GET['lang']) ? $_GET['lang'] : false;

  $alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];


  $categories = get_categories();
  $species    = get_species();
  // var_dump($species);
  $ELEMS      = get_strings();
  $central = trim($_GET["central"]);



  // $redirect_time = 60;
  $is_center_screen = ( intval($central) == 1 ? True : False );
  $timer_ficha_in_seconds = 5;

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?=$ELEMS["TIT_INTERACTIVO"]?></title>
  <link rel="stylesheet" href="css/style.css">
<?php if ( $is_center_screen ) { ?>
  <script type="text/javascript" src="../js/socket.js"></script>
<?php } ?>
  <script>
    var species  = <?= json_encode($species); ?>;
    var alphabet = <?= json_encode($alphabet); ?>;
  </script>
</head>
<body class="general">
  <div class="in_animate_screen in_animate_screen_display">
    <svg class="in_screen_icon in_screen_icon_animate" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 51.26 52">
      <title>Cangrejo</title>
      <g id="Capa_2" data-name="Capa 2"><g id="Layer_1" data-name="Layer 1"><path d="M35.7,30.68,32.47,37.6H18.79l-3.23-6.92a3.27,3.27,0,0,1-.06-2.62l3.05-7.42a46.68,46.68,0,0,1,14.16,0l3,7.42a3.23,3.23,0,0,1-.06,2.62M8.87,21.19l0-.14h3.79a4.23,4.23,0,0,1,1.86,1.47l-.78,1.9-2.92-1.13a3.18,3.18,0,0,1-1.91-2.1M8,18a14.13,14.13,0,0,1,0-4.94h3.64a13.67,13.67,0,0,1,0,4.94ZM11.54,3.87a4.33,4.33,0,0,1,3-.81,8.1,8.1,0,0,1-.44,1.3L12.92,6.64l2.54-.08a4.45,4.45,0,0,1,1.26.17c-.71,1.2-2.08,3-3.93,3.28H8.52c.35-2,1.2-4.8,3-6.14M38.66,21.05h3.79l0,.14a3.18,3.18,0,0,1-1.91,2.1l-2.92,1.17-.8-1.94a4.26,4.26,0,0,1,1.88-1.47M34.55,6.73a4.57,4.57,0,0,1,1.27-.17l2.54.08L37.23,4.36a8.1,8.1,0,0,1-.44-1.3,4.33,4.33,0,0,1,3,.81c1.82,1.34,2.67,4.16,3,6.14H38.49c-1.76-.24-3.16-2-3.94-3.28m8.7,6.33a14.13,14.13,0,0,1,0,4.94H39.61a13.67,13.67,0,0,1,0-4.94ZM47.18,27.9H38.9c0-.21-.11-.41-.17-.61l2.89-1.16A6.28,6.28,0,0,0,45.35,22l.59-2.11A17,17,0,0,0,46,11.31c-.08-1.1-.65-7.1-4.43-9.89a7.92,7.92,0,0,0-7-1.07L33.22.7l.24,1.39c0,.14.15.86.37,1.68a4.16,4.16,0,0,0-2.51,1.71l-.42.67.3.72c.09.2,1.85,4.38,5.39,5.77a16.91,16.91,0,0,0,0,6,6.83,6.83,0,0,0-1.12.77L34.9,18l-.79-.17c-.46-.09-.94-.18-1.43-.25v-2.9H29.63V17.2a50.87,50.87,0,0,0-8,0V14.65H18.58v2.9c-.49.07-1,.16-1.43.25l-.79.17-.6,1.46a7.46,7.46,0,0,0-1.11-.77,17.15,17.15,0,0,0,0-6c3.53-1.39,5.29-5.57,5.38-5.77l.3-.72L20,5.48a4.21,4.21,0,0,0-2.52-1.71c.22-.82.35-1.54.37-1.68L18.06.7,16.7.35a7.92,7.92,0,0,0-7,1.07c-3.78,2.79-4.35,8.79-4.43,9.89a17,17,0,0,0,0,8.61L5.93,22a6.27,6.27,0,0,0,3.74,4.1l2.88,1.12a4.84,4.84,0,0,0-.19.65H4.08L0,33.78v5.77H3.05V34.74L5.68,31h6.74a7.3,7.3,0,0,0,.37,1l2.64,5.63h-7L3.35,44.23V52H6.4V45.26l3.54-4.61H41.37l3.53,4.61V52H48V44.23L42.88,37.6h-7L38.47,32a7.3,7.3,0,0,0,.37-1h6.74l2.63,3.79v4.81h3V33.78Z"/></g></g>
    </svg>

    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
  </div>

  <section class="anakin">

    <div class="panel panel_top">
      <div class="back_grid">
        <button class="back_btn" onclick="back_btn()">
          <img src="<?=$DIR_ICONS?>atras.svg">
        </button>
        <div>
          <h3 class="panel_title"><?= $ELEMS['TIT_INTERACTIVO'] ?></h3>
          <p class="panel_language">
            <a href="main.php?lang=esp<?=( $central != "" ? "&central=".intval($central) : "")?>" class="<?= ($_SESSION["lang"] == 'esp') ? 'selected' : '' ?>">Esp</a>
            <span class="panel_stick">|</span>
            <a href="main.php?lang=eng<?=( $central != "" ? "&central=".intval($central) : "")?>" class="<?= ($_SESSION["lang"] == 'eng') ? 'selected' : '' ?>">Eng</a>
            <span class="panel_stick">|</span>
            <a href="main.php?lang=glg<?=( $central != "" ? "&central=".intval($central) : "")?>" class="<?= ($_SESSION["lang"] == 'glg') ? 'selected' : '' ?>">Gal</a>
          </p>
        </div>
      </div>
    </div>

    <style>
    [class="anakin"] .anakin_item {
      width:calc(100% / <?= count($categories) ?>);
    }
    </style>

    <?php
    foreach ($categories as $category) {
      $self_awake = ".$category[slug] .anakin_item.$category[slug]";
      ?>
      <style>
        <?= $self_awake ?> {
          width:100vw;
        }
        <?= $self_awake ?> .anakin_title{
          /* font-family: 'Lato Black'; */
          font-size: 56px;
          color: #fff;
          filter: drop-shadow( 0px 0px 1.5px #fff);
          letter-spacing: 12px;
          text-transform: uppercase;
        }
        <?= $self_awake ?> .anakin_icon{
          transform: rotateZ(30deg);
          opacity: 0;
          width:0;
        }
        <?= $self_awake ?> .anakin_caption{
          transform: translateY(-280px);
        }
      </style>
      <div class="anakin_item <?= $category['slug'] ?>" onclick="open_category('<?= $category['slug'] ?>')" tabindex="1">
        <img class="anakin_img rowcol1" src="<?= $DIR_IMG ?><?= $category['esp_fondo'] ?>" alt="">

        <div class="anakin_caption rowcol1">
          <p class="anakin_description">Especies de Cultivo</p>
          <div class="anakin_icon">
            <img src="<?= $DIR_IMG.$category['esp_icono'] ?>">
            <?php // include_once("<?= $DIR_IMG$category[esp_icono]") ?>
          </div>

          <h2 class="anakin_title"><?= $category['tra_nombre_esp'] ?></h2>
        </div>
      </div>
    <?php } ?>



    <div class="luke Obse" data-observe=".luke_item" data-root-width="100">
      <div class="luke_viw">
        <ul class="luke_scroll">
          <?php foreach ($alphabet as $letter) { ?>
            <style>
            <?= ".$letter .$letter.full .luke_letter" ?>{
              color: rgb(214, 0, 28);
              transform: scale(1.65);
            }
            </style>
            <li class="luke_item <?= $letter ?>" data-clase="<?= $letter ?>">
              <p class="luke_letter"><?= $letter ?></p>
            </li>
          <?php } ?>
        </ul>
      </div>
      <div class="luke_circle"></div>

      <ul class="luke_list">

        <?php
        foreach ($species as $specie) {
          $frst_letter = $specie["slug"][0];
          $self_awake = ".$specie[slug] .luke_specie.$specie[slug]";
          $self_filtered = ".$specie[category] .$frst_letter .luke_specie.$frst_letter.$specie[category]";
          ?>
          <style>
          <?= $self_filtered ?> {
            /* max-height: 0; */
            opacity: 1;
            max-height: 34px;
            transition:max-height .5s 0s, opacity .7s .2s;
          }
          <?= $self_awake ?> {
            font-weight: bold;
            font-family: 'Lato Black';
          }
          </style>
          <li class="luke_specie <?= $specie['slug'] ?> <?= $specie['category'] ?> <?= $specie['slug'][0] ?>" onclick="alt_ficha('<?= $specie['slug'] ?>'<?= ($is_center_screen) ? ", " . ($timer_ficha_in_seconds * 1000 + 500) : '' ?>);">
          <?php /* <!-- <li class="luke_specie <?= $specie['slug'] ?> <?= $specie['category'] ?> <?= $specie['slug'][0] ?>" onclick="altClassFromSelector('<?= $specie['slug'] ?>', '.general', ['general']); setTimeout(()=>{ set_obses() },1400)"> --> */ ?>
            <p><?= $specie['tra_nombre_ani'] ?></p>
          </li>

        <?php } ?>

      </ul>
    </div>


    <style media="screen">
      .leia_content {
        transform: translate<?= ($is_center_screen) ? 'Y' : 'X' ?>(100%);
        transition: <?= ($is_center_screen) ? '0' : '.5' ?>s;
      }
    </style>

    <?php
    foreach ($species as $specie) {
      $self_awake = ".$specie[slug] .leia.$specie[slug]";
      ?>
      <style>
      <?= $self_awake ?> {
        width:50%;
        z-index: 2;
      }
      <?= $self_awake ?> .leia_content {
        <?php if ($is_center_screen){ ?>
          transform: translateY(0);
          margin-top: -100vh;
          /* transition-delay: transform .5s, margin-top 1s; */
          transition: transform .5s .5s, margin-top .5s <?= $timer_ficha_in_seconds ?>s;
        <?php } else { ?>
          transform: translateX(0);
          transition-delay: .5s;
        <?php } ?>
      }
      </style>
       <div class="leia <?= $specie['slug'] ?>">
         <div class="leia_content">
           <div class="magnified_map">
             <svg class="close_magified_map" onclick="altClassFromSelector('active', '.magnified_map')" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             	 viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve">
             	 <style type="text/css">
             		 .st0{fill:#9BB4CA;}
             		 .st1{fill:#BE201A;}
             	 </style>
             	 <g id="cerrar-azul">
             		 <path class="st0" d="M30,60C13.5,60,0,46.5,0,30S13.5,0,30,0s30,13.5,30,30S46.5,60,30,60z M30,4.3C15.8,4.3,4.3,15.8,4.3,30
             			S15.8,55.7,30,55.7S55.7,44.2,55.7,30S44.2,4.3,30,4.3z"/>
             			<path class="st0" d="M33,30l6.1-6.1c0.8-0.8,0.8-2.2,0-3s-2.2-0.8-3,0L30,27l-6.1-6.1c-0.8-0.8-2.2-0.8-3,0s-0.8,2.2,0,3L27,30
             			l-6.1,6.1c-0.8,0.8-0.8,2.2,0,3s2.2,0.8,3,0L30,33l6.1,6.1c0.8,0.8,2.2,0.8,3,0s0.8-2.2,0-3L33,30z"/>
             		</g>
             </svg>
             <img class="magnified_map_img" data-url="<?= $DIR_IMG . $specie['ani_mapa'] ?>" src="" alt="Mapa de tamaño completo de las regiones de cultivo">
           </div>

           <div class="leia_hierarchy">
             <?php /* <!-- <img class="leia_hier_icon" src="<?= $DIR_IMG . $specie['esp_icono'] ?>"> --> */ ?>
             <object class="leia_hier_icon" data-url="<?= $DIR_IMG . $specie['esp_icono'] ?>" data="" type="image/svg+xml"></object>
             <?php
             ?>
             <p class="leia_hier_txt"><?= $specie['category'] ?></p>
           </div>
           <h3 class="leia_title"><?= $specie['tra_nombre_ani'] ?></h3>

           <img class="leia_image" data-url="<?= $DIR_IMG . $specie['ani_foto'] ?>" src="" alt="">

           <p class="leia_label">Nombre Científico</p>
           <p class="leia_info"><?= $specie['ani_cientifico'] ?></p>
           <div class="leia_separator"></div>
           <p class="leia_label">Tipo de agricultura</p>
           <p class="leia_info"><?=( $specie["ani_tipoacuicultura"] == "M" ? $ELEMS["TIPO_ACUMARINA"] : $ELEMS["TIPO_ACUCONTINENTAL"])?></p>
           <div class="leia_separator"></div>
           <p class="leia_info"><?= $specie['tra_curiosidades_ani'] ?></p>

           <div class="leia_map_container">
             <img class="leia_map" data-url="<?= $DIR_IMG . $specie['ani_mapa'] ?>" src="" alt="">

             <svg onclick="altClassFromSelector('active', '.leia.<?= $specie['slug'] ?> .magnified_map')" class="leia_map_magnify" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             	 viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve">
               <style type="text/css">
                 .st0{fill:#9BB4CA;}
             	  .st1{fill:#BE201A;}
              </style>
              <g id="lupa-rojo">
                <g>
                  <path class="st1" d="M59.2,55.3L40.6,36.7c3-3.9,4.9-8.7,4.9-14C45.5,10.2,35.3,0,22.7,0c0,0,0,0,0,0C16.7,0,10.9,2.4,6.7,6.7
             		  C2.4,10.9,0,16.7,0,22.7c0,12.5,10.2,22.7,22.7,22.7c5.3,0,10.2-1.8,14-4.9l18.6,18.6c0.5,0.5,1.2,0.8,1.9,0.8s1.4-0.3,1.9-0.8
             		  C60.3,58.1,60.3,56.4,59.2,55.3z M22.7,40c-9.5,0-17.3-7.7-17.3-17.3c0-4.6,1.8-9,5.1-12.2c3.3-3.3,7.6-5.1,12.2-5.1
             		  c9.5,0,17.3,7.7,17.3,17.3S32.3,40,22.7,40z"/>
                </g>
                <path class="st1" d="M15,20.4c0,5.7,6.3,12,7.4,12c1.1,0,7.4-6.4,7.4-12c0-4.1-3.3-7.6-7.4-7.6C18.3,12.9,15,16.4,15,20.4z
             	 M18,20.5c0-2.5,2-4.5,4.5-4.5c2.5,0,4.5,2,4.5,4.5s-2,4.5-4.5,4.5C20,25,18,23,18,20.5z"/>
             </g>
           </svg>
         </div>



           <?php if ($specie['tra_pais_ani'] == true) { ?>
           <div class="leia_location_grid">
            <svg class="leia_location_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 13.61 20.05"><defs><style>.cls-1{fill:#c40000;}</style></defs><title>3Recurso 6</title><g id="Capa_2" data-name="Capa 2"><g id="Layer_1" data-name="Layer 1"><path class="cls-1" d="M6.81,11A3.48,3.48,0,0,1,3.41,7.4a3.48,3.48,0,0,1,3.4-3.56A3.48,3.48,0,0,1,10.2,7.4,3.48,3.48,0,0,1,6.81,11m0-11A7,7,0,0,0,0,7.14a7.25,7.25,0,0,0,1.26,4.12l5.55,8.79,5.55-8.79a7.24,7.24,0,0,0,1.25-4.12A7,7,0,0,0,6.81,0"/></g></g></svg>
            <?php /* <!-- <p class="leia_location">Lugar lorem ipsum</p> --> */ ?>
             <p class="leia_location"><?= $specie['tra_pais_ani'] ?></p>
           </div>
           <?php } ?>
         </div>
       </div>

    <?php } ?>


  </section>


  <!-- Redirect timer -->
  <script> redirect_time = <?= $redirect_time ?>; </script>
  <script type="text/javascript" src="js/main.js"></script>
  <script>window.onload = () => { out_animate_screen(); }</script>


</body>
</html>
