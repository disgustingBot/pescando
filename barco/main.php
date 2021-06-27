<?php
  require_once("inc.config.php");
  require_once("../inc.basic.php");
  require_once("../inc.registra_visita.php");
  require_once("../inc.salvapantallas.php");
  require_once("../inc.alive.php");


$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$current_url_no_params = "https://".$_SERVER["HTTP_HOST"]."$uri_parts[0]";


$ELEMS      = get_strings();

// TODO: cambiar el svg
// DE PEPUS PARA SOFIA acuérdate que los nombres de los clickables cambian a general / cocina / factoria / camarotes / cubierta / comedor / salamaquinas / salacontrol
// Lo ideal sería crear una funcion get_clickables, de momento créala aquí y yo ya la trasladaré al inc.funcs.php del webadmin
$clickables = array(
  array(
    'slug' => 'control',
    'image' => 'timothy.jpg'
  ),
  array(
    'slug' => 'deck',
    'image' => 'fondobarco-sin-flechas.jpg'
  ),
  array(
    'slug' => 'diner',
    'image' => 'gerson.jpg'
  ),

);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?=$ELEMS["TIT_INTERACTIVO"]?></title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="in_animate_screen in_animate_screen_display">
    <svg class="in_screen_icon in_screen_icon_animate" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 68.34 68">
      <defs><style>.cls-2{fill:none;}</style></defs>
      <title>Alga</title>
      <g id="Layer_2" data-name="Layer 2"><g id="Capa_1" data-name="Capa 1"><path d="M57.39,60.79A31.23,31.23,0,0,0,66.05,39a6,6,0,0,0-5.94-5.91h0a5.93,5.93,0,0,0-5.9,5.95,19.52,19.52,0,0,1-5.66,13.83,9.53,9.53,0,0,0-4.74.63c-.15-.2-.32-.37-.48-.56a9.47,9.47,0,0,0,0-1,18.58,18.58,0,0,1,5.44-13.26l.11-.11a29.9,29.9,0,0,0,8.75-21.32l0-6.32a5.7,5.7,0,0,0-5.68-5.67h0A5.68,5.68,0,0,0,46.19,11l0,6.32a18.6,18.6,0,0,1-1.9,8.25,19.46,19.46,0,0,1-3.9-11.62A5.94,5.94,0,0,0,34.48,8h0A5.94,5.94,0,0,0,28.54,14a31.27,31.27,0,0,0,8.39,21.28,29.29,29.29,0,0,0-3,5.69A30.06,30.06,0,0,0,27.22,30.7l-.12-.12a18.57,18.57,0,0,1-5.52-13.21l0-6.32a5.7,5.7,0,0,0-5.69-5.67h0a5.7,5.7,0,0,0-5.67,5.7l0,6.32a29.91,29.91,0,0,0,8.89,21.26l.12.12a18.53,18.53,0,0,1,5.51,13,11.33,11.33,0,0,0-2.66-.33h0a11.64,11.64,0,0,0-3.41.54,19.47,19.47,0,0,1-4.86-12.8,6,6,0,0,0-5.93-5.92h0a5.94,5.94,0,0,0-5.91,6,32.53,32.53,0,0,0,8.83,21.69L4.15,61v4l59.77-.19,0-4ZM32.5,13.94a2,2,0,0,1,2-2h0a2,2,0,0,1,2,2,23.33,23.33,0,0,0,5.6,15.17,17.47,17.47,0,0,1-1.29,1.44l-.11.11c-.45.45-.87.92-1.28,1.39A27.27,27.27,0,0,1,32.5,13.94Zm11,19.51.12-.12a22.61,22.61,0,0,0,6.59-16l0-6.33a1.72,1.72,0,0,1,1.72-1.73h0a1.73,1.73,0,0,1,1.73,1.72l0,6.32A26,26,0,0,1,46,35.77l-.12.12A22.56,22.56,0,0,0,39.4,50.1,11.14,11.14,0,0,0,36,49.17,25.91,25.91,0,0,1,43.46,33.45ZM22,36l-.12-.12a25.94,25.94,0,0,1-7.72-18.46l0-6.32a1.74,1.74,0,0,1,1.73-1.74h0a1.73,1.73,0,0,1,1.73,1.73l0,6.32a22.54,22.54,0,0,0,6.69,16l.12.12A25.89,25.89,0,0,1,32,49.45h0a11.54,11.54,0,0,0-3.38,1.46A22.48,22.48,0,0,0,22,36Zm-9.63,21a27.31,27.31,0,0,1-6.53-17.7,2,2,0,0,1,2-2h0a2,2,0,0,1,2,2A23.38,23.38,0,0,0,15,53.93,11.57,11.57,0,0,0,12.37,56.93ZM15,60.86A7.38,7.38,0,0,1,22,55.47h0a7.37,7.37,0,0,1,4,1.2l1.6,1,1.12-1.55a7.42,7.42,0,0,1,5.95-3.07h0a7.34,7.34,0,0,1,6.54,4l1,2,1.86-1.23a5.93,5.93,0,0,1,7.44.74A6,6,0,0,1,53,60.74Zm39.48-5.14a9.74,9.74,0,0,0-1.85-1.43,23.29,23.29,0,0,0,5.53-15.22,2,2,0,0,1,2-2h0a2,2,0,0,1,2,2A27.32,27.32,0,0,1,55.51,57,10.55,10.55,0,0,0,54.45,55.72Z"/><rect class="cls-2" width="68.34" height="68"/></g></g>
    </svg>

    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
  </div>

  <section class="shape_screen">
    <div class="top_panel">
      <div class="back_grid">
        <button class="back_btn" onclick="back_btn()">
          <img src="<?=$DIR_ICONS?>atras.svg">
        </button>
        <div class="title_lang_grid">
          <h3 class="top_panel_title">Ponta Timbue</h3>
          <p class="top_panel_language">
            <a href="main.php?lang=esp" class="<?= ($_SESSION["lang"] == 'esp') ? 'selected' : '' ?>">Esp</a>
            <span class="top_panel_stick">|</span>
            <a href="main.php?lang=eng" class="<?= ($_SESSION["lang"] == 'eng') ? 'selected' : '' ?>">Eng</a>
            <span class="top_panel_stick">|</span>
            <a href="main.php?lang=glg" class="<?= ($_SESSION["lang"] == 'glg') ? 'selected' : '' ?>">Gal</a>
          </p>
        </div>
      </div>

      <div class="turn">
        <div class="turn_caption">
          <h3 class="turn_txt">Cubierta</h3>
        </div>
        <div class="turn_icon">
          <img src="<?=$DIR_ICONS?>360-barco.svg">
        </div>
      </div>
    </div>


    <?php
    $barcos = array(
      array(
        'image' => 'tangonero.jpg',
        'nombre' => 'Tangonero',
        'slug' => 'tangonero',
        'svg' => 'barco-esp-sin-sombra-letras.svg',
      ),
      array(
        'image' => 'arrastrero.jpg',
        'nombre' => 'Arrastrero',
        'slug' => 'arrastrero',
        'svg' => 'barco-esp-sin-sombra-letras.svg',
      ),
    );
     ?>

    <div class="boats_screen rowcol1">
      <?php foreach ($barcos as $barco) { ?>

        <div class="boats_screen_boat <?= $barco['slug'] ?>" onclick="console.log('<?= $barco['slug'] ?>')">
          <img class="boats_screen_img rowcol1" src="<?= $DIR_IMG . $barco['image'] ?>">
          <button class="boats_screen_title rowcol1"><?= $barco['nombre'] ?></button>
          <div class="shape_screen_img ponta rowcol1">
            <?= file_get_contents($DIR_IMG.'barco-esp-sin-sombra-letras.svg') ?>
            <!-- <img src="<?=$DIR_IMG?>silueta-barco-con-bolas.svg"> -->
            <!-- <button class="control">Sala de mandos</button>
            <button class="deck">Cubierta</button>
            <button class="diner">Comedor</button>
            <button class="factory">Factoria</button>
            <button class="cabins">Camarotes</button>
            <button class="kitchen">Cocina</button>
            <button class="machines">Sala de máquinas</button>
            <button class="general">Vista general del barco</button> -->
          </div>
        </div>
      <?php } ?>
    </div>








        <div id="three_container" class="image360 rowcol1"></div>

        <div class="ship_screen_cross rowcol1">
          <button class="triangle_btn triangle_up"></button>
          <div class="ship_screen_cross_half">
            <button class="triangle_btn triangle_left"></button>
            <button class="triangle_btn triangle_right"></button>
          </div>
          <button class="triangle_btn triangle_down"></button>
        </div>
  </section>


  <script type="text/javascript" src="js/main.js"></script>
  <!-- Image 360 view -->
  <script type="text/javascript" src="js/three.min.js"></script>

  <script>
    // Scene
    let scene = new THREE.Scene();

    // Camera
    let camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.01, 1);
    camera.target = new THREE.Vector3(0, 0, 0);

    // Renderer
    let renderer = new THREE.WebGLRenderer();
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(window.innerWidth, window.innerHeight);

    // Add the renderer to three_container
    let three_container = document.getElementById('three_container');
    three_container.appendChild(renderer.domElement);

    // Variables
    let is_touching = false;
    let longitude = 0;
    let latitude = 0;
    let phi = 0; theta = 0;
    let touch_init_position_x = 0;
    let touch_init_position_y = 0;
    let touch_last_position_x = 0;
    let touch_last_position_y = 0;

    // start(ulr);
    update_frame();

    // Create a 360 image
    function create_image(image_url) {
      // Texture with image
      let image_loader = new THREE.TextureLoader();
      let image_texture = image_loader.load(image_url, () => {
        // Set the background to scene
        let cube_render = new THREE.WebGLCubeRenderTarget(image_texture.image.height);
        cube_render.fromEquirectangularTexture(renderer, image_texture);
        scene.background = cube_render.texture;
      });
    }

    // Create scene full screen events
    function create_full_screen_events() {
      three_container.addEventListener('touchstart', on_touch_down, { passive: false });
      three_container.addEventListener('touchmove', on_touch_move, { passive: false  });
      three_container.addEventListener('touchend', on_touch_up, { passive: false });
    }

    // Initial configuration
    function start(url) {
      // Add a 360 image to scene
      create_image(url);
      // create_image('<?=$DIR_IMG?>background/timothy.jpg');
      // create_image('<?=$DIR_IMG?>background/fondobarco-sin-flechas.jpg');

      // Add the events to full screen
      create_full_screen_events();
    }

    function on_touch_down(event) {
      event.preventDefault();
      is_touching = true;

      let touch = event.touches[0] || event.changedTouches[0];

      touch_init_position_x = touch.pageX;
      touch_init_position_y = touch.pageY;

      touch_last_position_x = longitude;
      touch_last_position_y = latitude;
    }

    function on_touch_move(event) {
      if (is_touching === true) {
        let touch = event.touches[0] || event.changedTouches[0];

        longitude = (touch_init_position_x - touch.pageX) * 0.1 + touch_last_position_x;
        latitude = (touch.pageY - touch_init_position_y) * 0.1 + touch_last_position_y;
      }
    }

    function on_touch_up(event) {
      is_touching = false;
    }

    function update_frame() {
      requestAnimationFrame(update_frame);
      update();
    }

    // Update the camera rotation
    function update_camera() {
      latitude = Math.max(-85, Math.min(85, latitude));
      phi = THREE.Math.degToRad(90 - latitude);
      theta = THREE.Math.degToRad(longitude);

      camera.target.x = 1 * Math.sin(phi) * Math.cos(theta);
      camera.target.y = 1 * Math.cos(phi);
      camera.target.z = 1 * Math.sin(phi) * Math.sin(theta);

      camera.lookAt(camera.target);
    }

    function update() {
      update_camera();

      // Render the scene
      renderer.render(scene, camera);
    }
  </script>


      <?php foreach ($clickables as $object) { ?>
        <script type="text/javascript">
          // document.querySelector('.<?= $object['slug'] ?>').onclick = ()=>{
          //   console.log('test');
          //   let url = '<?=$DIR_IMG?>background/<?= $object['image'] ?>'
          //   start(url);
          //   altClassFromSelector('image_active', '.shape_screen')
          // }
        </script>
      <?php } ?>

  <script>window.onload = () => { out_animate_screen(); }</script>
</body>
</html>
