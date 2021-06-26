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
    <svg class="in_animate_screen_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 51.26 52">
      <title>Pescanova</title>
      <g id="Capa_2" data-name="Capa 2"><g id="Layer_1" data-name="Layer 1"><path d="M35.7,30.68,32.47,37.6H18.79l-3.23-6.92a3.27,3.27,0,0,1-.06-2.62l3.05-7.42a46.68,46.68,0,0,1,14.16,0l3,7.42a3.23,3.23,0,0,1-.06,2.62M8.87,21.19l0-.14h3.79a4.23,4.23,0,0,1,1.86,1.47l-.78,1.9-2.92-1.13a3.18,3.18,0,0,1-1.91-2.1M8,18a14.13,14.13,0,0,1,0-4.94h3.64a13.67,13.67,0,0,1,0,4.94ZM11.54,3.87a4.33,4.33,0,0,1,3-.81,8.1,8.1,0,0,1-.44,1.3L12.92,6.64l2.54-.08a4.45,4.45,0,0,1,1.26.17c-.71,1.2-2.08,3-3.93,3.28H8.52c.35-2,1.2-4.8,3-6.14M38.66,21.05h3.79l0,.14a3.18,3.18,0,0,1-1.91,2.1l-2.92,1.17-.8-1.94a4.26,4.26,0,0,1,1.88-1.47M34.55,6.73a4.57,4.57,0,0,1,1.27-.17l2.54.08L37.23,4.36a8.1,8.1,0,0,1-.44-1.3,4.33,4.33,0,0,1,3,.81c1.82,1.34,2.67,4.16,3,6.14H38.49c-1.76-.24-3.16-2-3.94-3.28m8.7,6.33a14.13,14.13,0,0,1,0,4.94H39.61a13.67,13.67,0,0,1,0-4.94ZM47.18,27.9H38.9c0-.21-.11-.41-.17-.61l2.89-1.16A6.28,6.28,0,0,0,45.35,22l.59-2.11A17,17,0,0,0,46,11.31c-.08-1.1-.65-7.1-4.43-9.89a7.92,7.92,0,0,0-7-1.07L33.22.7l.24,1.39c0,.14.15.86.37,1.68a4.16,4.16,0,0,0-2.51,1.71l-.42.67.3.72c.09.2,1.85,4.38,5.39,5.77a16.91,16.91,0,0,0,0,6,6.83,6.83,0,0,0-1.12.77L34.9,18l-.79-.17c-.46-.09-.94-.18-1.43-.25v-2.9H29.63V17.2a50.87,50.87,0,0,0-8,0V14.65H18.58v2.9c-.49.07-1,.16-1.43.25l-.79.17-.6,1.46a7.46,7.46,0,0,0-1.11-.77,17.15,17.15,0,0,0,0-6c3.53-1.39,5.29-5.57,5.38-5.77l.3-.72L20,5.48a4.21,4.21,0,0,0-2.52-1.71c.22-.82.35-1.54.37-1.68L18.06.7,16.7.35a7.92,7.92,0,0,0-7,1.07c-3.78,2.79-4.35,8.79-4.43,9.89a17,17,0,0,0,0,8.61L5.93,22a6.27,6.27,0,0,0,3.74,4.1l2.88,1.12a4.84,4.84,0,0,0-.19.65H4.08L0,33.78v5.77H3.05V34.74L5.68,31h6.74a7.3,7.3,0,0,0,.37,1l2.64,5.63h-7L3.35,44.23V52H6.4V45.26l3.54-4.61H41.37l3.53,4.61V52H48V44.23L42.88,37.6h-7L38.47,32a7.3,7.3,0,0,0,.37-1h6.74l2.63,3.79v4.81h3V33.78Z"/></g></g>
    </svg>
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
          document.querySelector('.<?= $object['slug'] ?>').onclick = ()=>{
            console.log('test');
            let url = '<?=$DIR_IMG?>background/<?= $object['image'] ?>'
            start(url);
            altClassFromSelector('image_active', '.shape_screen')
          }
        </script>
      <?php } ?>
</body>
</html>
