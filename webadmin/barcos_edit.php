<?php
  require_once("inc.config.php");
  require_once("inc.checklogin.php");

  if ( !EsAdmin() && !EsBasico() ) {
    Header("Location: index.php");
    die();
  }

  $title_menutree = "Flota y caladeros";
  $title_menu = "Los barcos";
  $page_title = $title_menutree." > ".$title_menu;
  $active_menutree = "flota";
  $active_menu = "flota-barcos";
  $icon_menutree = "fa fa-dot-circle-o";
  $icon_menu = "fa fa-ship";

  if ( $_POST ["action"] != "" ) {
    $id = $_POST["id"];
  } else {
    $id = $_GET["id"];
  }

  if ( !isset($id) ) {
    Header("Location: barcos.php");
    die();
  }

  if ( $_POST["action"] == "update" ) {
    
    $_POST["nombre"] = trim($_POST["nombre"]);
    $_POST["tipo"] = trim($_POST["tipo"]);
    $_POST["caladero"] = trim($_POST["caladero"]);
    $_POST["status"] = trim($_POST["status"]);
    $_POST["video"] = trim($_POST["video"]);

    if ( !EsAdmin() ) {
      $ERR = "No tienes permisos para editar este elemento";
    } else if ( strlen($_POST["nombre"]) == 0 || strlen($_POST["tipo"]) == 0 || strlen($_POST["caladero"]) == 0 || strlen($_POST["video"]) == 0 || strlen($_POST["status"]) == 0 ) {
      $ERR = "Faltan campos requeridos";
      $item = $_POST;
    } else {

      $query = "UPDATE pesca_barcos SET ";
      $query .= "bar_nombre = '".mysqli_real_escape_string($conn, ucfirst($_POST["nombre"]))."', ";
      $query .= "bar_tipo = '".mysqli_real_escape_string($conn, $_POST["tipo"])."', ";
      $query .= "bar_caladero = '".mysqli_real_escape_string($conn, $_POST["caladero"])."', ";
      $query .= "bar_video = '".mysqli_real_escape_string($conn, $_POST["video"])."', ";
      $query .= "bar_status = '".mysqli_real_escape_string($conn, $_POST["status"])."' ";
      $query .= " WHERE bar_id ='".mysqli_real_escape_string($conn, $id)."'";
      $res = @mysqli_query($conn, $query);
      if(!$res) {
        $ERR = "No se ha podido guardar la info en la base de datos actual. <br />".mysqli_error($conn);
      } else {
        $MSG = "Barco actualizado correctamente!<br />";

        $MSG .= "<br /><a href=\"barcos.php\">Volver al listado de barcos</a>";
        $MSG .= "<a style=\"float:right\" href=\"barcos_edit.php?id=0\">Insertar nuevo registro</a>";
      }
    }

  } else if ( $_POST["action"] == "insert" ) {
    
    $_POST["nombre"] = trim($_POST["nombre"]);
    $_POST["tipo"] = trim($_POST["tipo"]);
    $_POST["caladero"] = trim($_POST["caladero"]);
    $_POST["status"] = trim($_POST["status"]);
    $_POST["video"] = trim($_POST["video"]);

    if ( !EsAdmin() ) {
      $ERR = "No tienes permisos para dar de alta nuevos elementos";
    } else if ( strlen($_POST["nombre"]) == 0 || strlen($_POST["tipo"]) == 0 || strlen($_POST["caladero"]) == 0 || strlen($_POST["video"]) == 0 || strlen($_POST["status"]) == 0 ) {
      $ERR = "Faltan campos requeridos";
      $item = $_POST;
    } else {

      $query = "INSERT INTO pesca_barcos (bar_nombre, bar_tipo, bar_caladero, bar_video, bar_status)
        VALUES (
        '".mysqli_real_escape_string($conn, ucfirst($_POST["nombre"]))."',
        '".mysqli_real_escape_string($conn, $_POST["tipo"])."',
        '".mysqli_real_escape_string($conn, $_POST["caladero"])."',
        '".mysqli_real_escape_string($conn, $_POST["video"])."',
        '".mysqli_real_escape_string($conn, $_POST["status"])."' )";
      $res = @mysqli_query($conn, $query);
      if(!$res) {
        $ERR = "No se ha podido guardar la info en la base de datos actual.<br />".mysqli_error($conn)."<br />".$query;
      } else {
        $MSG = "Barco creado correctamente!<br />";

        $id = mysqli_insert_id($conn);

        $MSG .= "<br /><a href=\"barcos.php\">Volver al listado de barcos</a>";
        $MSG .= "<a style=\"float:right\" href=\"barcos_edit.php?id=0\">Insertar nuevo registro</a>";
      }
    }
  }

  // Modo de trabajo: por defecto, nueva ficha
  $MODO = "add";

  if ( $id > 0 ) {
    $trads = "";

    $query = "SELECT * ".$trads." FROM pesca_barcos WHERE bar_id = '".mysqli_real_escape_string($conn, $id)."'";
    $res = @mysqli_query($conn, $query);
    if(!$res)	{
      $ERR .= "No se ha podido conectar con la base de datos actual.<br />".$query;
    } else if ( @mysqli_num_rows($res) == 0 ) {
      $ERR .= "El barco indicado no existe.<br /><a href=\"barcos.php\">Volver al listado de barcos</a>";
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
        <li><a href="barcos.php"><i class="<?=$icon_menu?>"></i> <?=$title_menu?></a></li>
        <li class="active"><i class="fa fa-pencil"></i> <?=($MODO == "add" ? "Añadir":"Editar")?> barco</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

<?php if ( $ERR != "" || $MSG != "" ) { ?>
      <div class="row">
        <div class="col-md-8">

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
        <div class="col-md-8">
          <div class="box">

            <!-- / form -->
            <form id="ficha" action="<?=basename($_SERVER["PHP_SELF"])?>" method="post">
            <input type="hidden" id="action" name="action" value="<?=( $MODO == "add" ? "insert":"update")?>" />
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
                  <label for="field-nombre" class="control-label">Nombre</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-md-6">
                    <span class="input-group-addon"><i class="fa fa-language"></i></span>
                    <input type="text" class="form-control" id="field-nombre" name="nombre" maxlength="60" placeholder="Nombre" value="<?=$item["nombre"]?>">
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-tipo" class="control-label">Tipo de barco</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-sm-4">
                    <span class="input-group-addon"><i class="fa fa-th-large"></i></span>
                    <select class="form-control" id="field-tipo" name="tipo">
                    <?php
                      $q1 = "SELECT tba_id, tba_nombre FROM pesca_tipos_barcos ORDER BY tba_orden";
                      $r1 = @mysqli_query($conn, $q1);
                      while ( $r1 && $rw1 = mysqli_fetch_assoc($r1) ) {
                    ?>
                      <option value="<?=$rw1["tba_id"]?>" <?php if ( $item["tipo"] == $rw1["tba_id"] ) echo " selected"; ?>><?=$rw1["tba_nombre"]?></option>
                    <?php
                      }
                    ?>
                    </select>
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->
                
                <div class="form-group">
                  <label for="field-caladero" class="control-label">Caladero</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-sm-4">
                    <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                    <select class="form-control" id="field-caladero" name="caladero">
                    <?php
                      $q1 = "SELECT cal_id, cal_nombre FROM pesca_caladeros ORDER BY cal_nombre";
                      $r1 = @mysqli_query($conn, $q1);
                      while ( $r1 && $rw1 = mysqli_fetch_assoc($r1) ) {
                    ?>
                      <option value="<?=$rw1["cal_id"]?>" <?php if ( $item["caladero"] == $rw1["cal_id"] ) echo " selected"; ?>><?=$rw1["cal_nombre"]?></option>
                    <?php
                      }
                    ?>
                    </select>
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->
                
                <div class="form-group">
                  <label for="field-video" class="control-label">Nombre de ficheros para vídeo (vídeo y portada)</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group input-group-sm col-xs-6">
                    <span class="input-group-addon"><i class="fa fa-camera"></i></span>
                    <input type="text" class="form-control" id="field-video" name="video" maxlength="50" placeholder="NOMBRE DEL VIDEO" value="<?=$item["video"]?>">
                    <input type="hidden" name="old_video" value="<?=$item["video"]?>" />
                  </div>
                  <!-- /.input-group -->
                  <small>NOTA: Indique el nombre sin espacios, sin acentos y sin extensión.<br />El programa automáticamente buscará un vídeo NOMBRE.mp4 y una imagen NOMBRE.jpg en la carpeta <?=$LOCAL_VIDEOS?></small>
                </div>
                <!-- /.form-group -->
                
                <div class="form-group">
                  <label for="field-status" class="control-label">Estado</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-sm-4">
                    <span class="input-group-addon"><i class="fa fa-universal-access"></i></span>
                    <select class="form-control" id="field-status" name="status">
                      <option value="A" <?php if ( $item["status"] == "A" || $item["status"] == "" ) echo " selected"; ?>>Activo</option>
                      <option value="I" <?php if ( $item["status"] == "I" ) echo " selected"; ?>>Inactivo</option>
                    </select>
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <button type="submit" class="btn btn-primary" id="Enviar"><?=( $MODO == "add" ? "Guardar nuevo barco":"Guardar cambios")?> <i class="fa fa-arrow-circle-right"></i></button> <a href="barcos.php" class="btn btn-default pull-right"><i class="fa fa-arrow-circle-left"></i> Volver al listado</a>
                </div>
                <!-- /.form-group -->

              </div>
              <!-- /.box-body -->

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
<script>
  $(function () {

  });

</script>

</body>
</html>
