<?php
  require_once ("inc.config.php");
  require_once("inc.checklogin.php");

  if ( !EsAdmin() ) {
    Header("Location: index.php");
    die();
  }


  $title_menutree = "Administración";
  $title_menu = "Interactivos en pantalla";
  $page_title = $title_menutree." > ".$title_menu." > Edición";
  $active_menutree = "admin";
  $active_menu = "admin-screens";
  $icon_menutree = "fa fa-hashtag";
  $icon_menu = "fa fa-desktop";

  if ( $_POST ["action"] != "" ) {
    $id = $_POST["id"];
  } else {
    $id = $_GET["id"];
  }

  if ( !isset($id) ) {
    Header("Location: screens.php");
    die();
  }

  if ( $_POST["action"] == "update" ) {

    if ( !EsAdmin() ) {
      $ERR = "No tienes permisos para editar este elemento";
    } else if ( strlen($_POST["titulo"]) == 0 || strlen($_POST["ip"]) == 0 || strlen($_POST["url"]) == 0 ) {
      $ERR = "Faltan campos requeridos";
    } else {

      $query = "UPDATE pesca_screens set ";
      $query .= "scr_url = '".mysqli_real_escape_string($conn, $_POST["url"])."', ";
      $query .= "scr_ip = '".mysqli_real_escape_string($conn, $_POST["ip"])."', ";
      $query .= "scr_titulo = '".mysqli_real_escape_string($conn, $_POST["titulo"])."' ";
      $query .= " WHERE scr_id ='".mysqli_real_escape_string($conn, $_POST["id"])."'";
      $res = @mysqli_query($conn, $query);
      if(!$res) {
        $ERR = "No se ha podido guardar la info en la base de datos actual. <br />".mysqli_error($conn);
      } else {
        $MSG = "Pantalla actualizada correctamente!<br />";

        $MSG .= "<br /><a href=\"screens.php\">Volver al listado de interactivos en pantalla</a>";
        $MSG .= "<a style=\"float:right\" href=\"screens_edit.php?id=0\">Insertar nuevo registro</a>";
      }
    }

  } else if ( $_POST["action"] == "insert" ) {

    if ( !EsAdmin() ) {
      $ERR = "No tienes permisos para dar de alta nuevos elementos";
    } else if ( strlen($_POST["titulo"]) == 0 || strlen($_POST["ip"]) == 0 || strlen($_POST["url"]) == 0 ) {
      $ERR = "Faltan campos requeridos";
    } else {
      $query = "INSERT INTO pesca_screens VALUES ( '',
        '".mysqli_real_escape_string($conn, $_POST["titulo"])."',
        '".mysqli_real_escape_string($conn, $_POST["ip"])."',
        '".mysqli_real_escape_string($conn, $_POST["url"])."',
        '', '' )";
      $res = @mysqli_query($conn, $query);
      if(!$res) {
        $ERR = "No se ha podido guardar la info en la base de datos actual.<br />".mysqli_error($conn);
      } else {
        $MSG = "Pantalla creada correctamente!<br />";

        $id = mysqli_insert_id($conn);

        $MSG .= "<br /><a href=\"screens.php\">Volver al listado de interactivos en pantalla</a>";
        $MSG .= "<a style=\"float:right\" href=\"screens_edit.php?id=0\">Insertar nuevo registro</a>";
      }
    }
  }

  // Modo de trabajo: por defecto, nueva ficha
  $MODO = "add";

  if ( $id > 0 ) {
    $trads = "";

    $query = "SELECT * ".$trads." FROM pesca_screens WHERE scr_id = '".mysqli_real_escape_string($conn, $id)."'";
    $res = @mysqli_query($conn, $query);
    if(!$res)	{
      $ERR = "No se ha podido conectar con la base de datos actual.";
    } else if ( @mysqli_num_rows($res) == 0 ) {
      $ERR = "El interactivo indicado no existe.<br /><a href=\"screens.php\">Volver al listado de interactivos en pantalla</a>";
      $id = "0";
    } else {

      $fila = @mysqli_fetch_assoc($res);
      foreach ( $fila as $k => $v ) {
        $index = substr($k,4);
        $item[$index] = stripslashes($v);
      }
      $MODO = "update";
    }
  }

  // Cargamos ips de las pantallas
  $q0 = "SELECT scr_ip FROM pesca_screens ORDER BY scr_ip";
  $r0 = mysqli_query($conn, $q0);
  $IPS = array();
  while ( $r0 && $rw0 = mysqli_fetch_assoc($r0) ) {
    $IPS[] = stripslashes($rw0["esc_titulo"]);
  }

  require_once ("inc.head.php");
?>
</head>
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">
  <?php require_once("basic.header.php"); ?>
  </header>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
  <?php require_once("basic.main-sidebar.php"); ?>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">

      <h1>
        <?=$title_menu?>
        <small><?=$title_menutree?></small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="<?=$icon_menutree?>"></i> <?=$title_menutree?></li>
        <li><a href="screens.php"><i class="<?=$icon_menu?>"></i> <?=$title_menu?></a></li>
        <li class="active"><i class="fa fa-pencil"></i> <?=($MODO == "add" ? "Añadir":"Editar")?> pantalla</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

<?php if ( $ERR != "" || $MSG != "" ) { ?>
      <div class="row">
        <div class="col-md-6">

            <?php if ( $ERR != "" ) { ?>
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> ERROR!</h4>
                <?=$ERR?>
              </div>
            <?php } ?>
            <?php if ( $MSG != "" ) { ?>
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> TODO OK!</h4>
                <?=$MSG?>
              </div>
            <?php } ?>

        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->
<?php } ?>

      <div class="row">
        <div class="col-md-6">
          <div class="box">

            <!-- / form -->
            <form action="<?=basename($_SERVER["PHP_SELF"])?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?=( $MODO == "add" ? "insert":"update")?>" />
            <input type="hidden" name="id" value="<?=$id?>" />

              <!--<div class="box-header">
              </div>-->
              <!-- /.box-header -->

              <div class="box-body">

                <div class="form-group page-header">
                  <h3><?=($MODO == "add" ? "Añadir":"Editar")?> ficha de datos</h3>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-titulo" class="control-label">Título identificativo</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-md-10">
                    <span class="input-group-addon"><i class="fa fa-language"></i></span>
                    <input type="text" class="form-control" id="field-titulo" name="titulo" maxlength="50" placeholder="Titulo completo" value="<?=$item["titulo"]?>">
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-ip" class="control-label">IP</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-md-8">
                    <span class="input-group-addon"><i class="fa fa-podcast"></i></span>
                    <input type="text" class="form-control" id="field-ip" name="ip" maxlength="16" style="width: 140px" placeholder="xxx.xxx.xxx.xxx" value="<?=$item["ip"]?>">
                  </div>
                  <small>Nota: Las pantallas de los interactivos están en los rangos 10.10.100.x y 10.10.101.x</small>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-url" class="control-label">Redirige a...</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-sm-8">
                    <span class="input-group-addon"><i class="fa fa-desktop"></i></span>
                    <input type="text" class="form-control" id="field-url" name="url" maxlength="100" placeholder="???" value="<?=$item["url"]?>">
                    <?php /*
                    <select class="form-control" id="field-url" name="url">
                      <option value="">- Elige una opción -</option>
                      <?php

  $SCREENS = array (
    array( "url" => "/cerveza/cerveza.php?welcome=1", "descr" => "Tipos y Estilos ( Inicio )" ),
    array( "url" => "/envasado/envasado.php?welcome=1", "descr" => "Envasado ( Inicio )" ),
    array( "url" => "/envasado/botella.php?welcome=1", "descr" => "Envasado: Grupos 1, 2, 7 y 8( Botella )" ),
    array( "url" => "/envasado/lata.php?welcome=1", "descr" => "Envasado: Grupo 4 ( Lata )" ),
    array( "url" => "/envasado/barril.php?welcome=1", "descr" => "Envasado: Grupos 5 y 6 ( Barril )" ),
    array( "url" => "/envasado/logistica.php?welcome=1", "descr" => "Envasado: Logistica" ),
    array( "url" => "/mural/mural.php?pos=E&welcome=1", "descr" => "Mural: Sumerios (Este)" ),
    array( "url" => "/mural/mural.php?pos=O&welcome=1", "descr" => "Mural: Vikingos (Oeste)" ),
    array( "url" => "/publi/publi.php?welcome=1", "descr" => "Publicidad ( Inicio )" ),
    array( "url" => "/encuesta/encuesta.php?welcome=1", "descr" => "Encuesta ( Inicio )" ),
    array( "url" => "/moto1/pantalla2.php?welcome=1", "descr" => "Moto 1 ( Inicio )" ),
    array( "url" => "/moto2/pantalla2.php?welcome=1", "descr" => "Moto 2 ( Inicio )" ),
    array( "url" => "/moto1/moto1.php", "descr" => "Moto 1 ( Moto 1 PHP )" ),   
    array( "url" => "/moto2/moto2.php", "descr" => "Moto 2 ( Moto 2 PHP )" ),    
    array( "url" => "/newmoto1/moto1.php", "descr" => "Moto 1 ( Moto 1 PHP )" ),   
    array( "url" => "/newmoto2/moto2.php", "descr" => "Moto 2 ( Moto 2 PHP )" ),    
    array( "url" => "/reservas/operate.php", "descr" => "Recepción ( Operate )" ),   
    array( "url" => "/reservas/fastpass.php", "descr" => "Recepción ( Fastpass )" ),   
    array( "url" => "/reservas/validator.php", "descr" => "Cambio de datos ( Validador )" )   
  );
  
                        foreach ( $SCREENS as $a => $b ) {
                          echo "<option value=\"".$b["url"]."\"";
                          if ( $item["url"] == $b["url"] ) echo " selected";
                          echo ">".$b["descr"]."</option>\n";
                        }
                      ?>
                    </select>
                    */ ?>
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <?php if ( $id > 0 ) { ?>
                <div class="form-group">
                  <label for="field-last-active" class="control-label">Última actividad</label>
                  <div class="input-group col-md-6">
                    <span class="input-group-addon"><i class="fa fa-podcast"></i></span>
                    <input type="text" class="form-control" id="field-last-active" name="last-active" placeholder="- Nunca -" value="<?=( $item["last_active"] != "" ? GeneraData($item["last_active"],14):"- Nunca -")?>" disabled="disabled">
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->
                
                <?php } ?>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary" id="Enviar"><?=( $MODO == "add" ? "Guardar nueva pantalla con interactivo":"Guardar cambios")?> <i class="fa fa-arrow-circle-right"></i></button> <a href="screens.php" class="btn btn-default pull-right"><i class="fa fa-arrow-circle-left"></i> Volver al listado</a>
                </div>
                <!-- /.form-group -->

              </div>
              <!-- ./box-body -->

              <!--<div class="box-footer clearfix">
              </div>-->
              <!-- /.box-footer -->

            </form>
            <!-- / form -->

          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
  <?php require_once("basic.footer.php"); ?>
  </footer>

  <!-- Control Sidebar -->
  <?php require_once("basic.controlbar.php"); ?>

</div>
<!-- ./wrapper -->

<?php require_once("inc.foot.php"); ?>

</body>
</html>
