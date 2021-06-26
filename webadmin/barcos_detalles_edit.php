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

  foreach ( $LANGS as $k => $v ) {
    $oks[$v] = 0;
    $names[$v] = "";
  }

  function upload($FVARS) {
    global $oks, $names, $id, $DIR_IMG;

    $sufix = "barco-detalle";

    while ( list($a,$b) = each($FVARS) ) {
      if ( $FVARS[$a]["size"] > 0 ) {

        $size=$FVARS[$a]["size"];     // filesize
        $type=$FVARS[$a]["type"];     // mime type
        $names[$a] = Minus($sufix.$id."-".$a."-".date("YmdHi").substr($FVARS[$a]["name"],strrpos($FVARS[$a]["name"],'.')));
        $temp=$FVARS[$a]["tmp_name"]; // temporary name
        if($size) {
          $DIRECT = $DIR_IMG.$names[$a];

          $oks[$a] = move_uploaded_file( $temp, $DIRECT );
          @chmod ( $DIRECT, 0777 );
        }
        
      }
    }
  }


  if ( $_POST["action"] == "update" ) {
    
    $_POST["nombre"] = trim($_POST["nombre"]);
    $_POST["order"] = trim($_POST["order"]);
    $_POST["status"] = trim($_POST["status"]);

    if ( !EsAdmin() ) {
      $ERR = "No tienes permisos para editar este elemento";
    } else if ( strlen($_POST["nombre"]) == 0 || strlen($_POST["orden"]) == 0 || strlen($_POST["status"]) == 0 ) {
      $ERR = "Faltan campos requeridos";
      $item = $_POST;
    } else {

      upload($_FILES);

      $query = "UPDATE pesca_barcos_detalles SET ";
      $query .= "bde_nombre = '".mysqli_real_escape_string($conn, ucfirst($_POST["nombre"]))."', ";
      $query .= "bde_orden = '".mysqli_real_escape_string($conn, $_POST["orden"])."', ";
      $query .= "bde_status = '".mysqli_real_escape_string($conn, $_POST["status"])."' ";
      $query .= " WHERE bde_id ='".mysqli_real_escape_string($conn, $id)."'";
      $res = @mysqli_query($conn, $query);
      if(!$res) {
        $ERR = "No se ha podido guardar la info en la base de datos actual. <br />".mysqli_error($conn);
      } else {
        $MSG = "Barco en detalle actualizado correctamente!<br />";

        /* Traduccions */
        foreach ( $LANGS as $k => $v ) {
          
          // Imagen
          if ( $oks["imagen_".$v] == 1 && ExisteTextoLang( 'barcos-detalles', $id, 'imagen', $v) ) {
            $qry = "UPDATE pesca_textos SET value='".mysqli_real_escape_string($conn, $names["imagen_".$v])."' WHERE referred = 'barcos-detalles' AND referred_id = ".$id." AND field='audio' AND lang = '".mysqli_real_escape_string($conn, $v)."'";
            $res = mysqli_query($conn,  $qry );
            if ( $res ) $MSG .= "Imagen ".Mayus($v).": fichero actualizado correctamente<br />";
          } else if ( $oks["imagen_".$v] == 1 ) {
            $qry = "INSERT INTO pesca_textos VALUES ( '', 'barcos-detalles', $id, 'imagen','".mysqli_real_escape_string($conn, $v)."','".mysqli_real_escape_string($conn, $names["imagen_".$v])."' ) ";
            $res = mysqli_query($conn,  $qry );
            if ( $res ) $MSG .= "Imagen ".Mayus($v).": fichero creado correctamente<br />";
          }

          if ( $oks["imagen_".$v] == 1 && $_POST["old_imagen_".$v] != "" && $_POST["old_imagen_".$v] != $names["imagen_".$v] ) {
            @unlink ( $DIR_IMG.$_POST["old_imagen_".$v] );
          }
        }

        $MSG .= "<br /><a href=\"barcos_detalles.php\">Volver al listado de barcos en detalle</a>";
        $MSG .= "<a style=\"float:right\" href=\"barcos_detalles_edit.php?id=0\">Insertar nuevo registro</a>";
      }
    }

  } else if ( $_POST["action"] == "insert" ) {
    
    $_POST["nombre"] = trim($_POST["nombre"]);
    $_POST["order"] = trim($_POST["order"]);
    $_POST["status"] = trim($_POST["status"]);

    if ( !EsAdmin() ) {
      $ERR = "No tienes permisos para dar de alta nuevos elementos";
    } else if ( strlen($_POST["nombre"]) == 0 || strlen($_POST["orden"]) == 0 || strlen($_POST["status"]) == 0 ) {
      $ERR = "Faltan campos requeridos";
      $item = $_POST;
    } else {

      $query = "INSERT INTO pesca_barcos_detalles (bde_nombre, bde_orden, bde_status)
        VALUES (
        '".mysqli_real_escape_string($conn, ucfirst($_POST["nombre"]))."',
        '".mysqli_real_escape_string($conn, $_POST["orden"])."',
        '".mysqli_real_escape_string($conn, $_POST["status"])."' )";
      $res = @mysqli_query($conn, $query);
      if(!$res) {
        $ERR = "No se ha podido guardar la info en la base de datos actual.<br />".mysqli_error($conn)."<br />".$query;
      } else {
        $MSG = "Barco en detalle creado correctamente!<br />";

        $id = mysqli_insert_id($conn);

        upload($_FILES);

        /* Traduccions */
        foreach ( $LANGS as $k => $v ) {
          // Imagen
          $qry = "INSERT INTO pesca_textos VALUES ( '', 'barcos-detalles', $id, 'imagen','".mysqli_real_escape_string($conn, $v)."','".mysqli_real_escape_string($conn, $names["imagen_".$v])."' ) ";
          $res = mysqli_query($conn,  $qry );
          if ( $res ) $MSG .= "Imagen ".Mayus($v).": fichero guardado correctamente<br />";
        }

        $MSG .= "<br /><a href=\"barcos_detalles.php\">Volver al listado de barcos en detalle</a>";
        $MSG .= "<a style=\"float:right\" href=\"barcos_detalles_edit.php?id=0\">Insertar nuevo registro</a>";
      }
    }
  }

  // Modo de trabajo: por defecto, nueva ficha
  $MODO = "add";

  if ( $id > 0 ) {
    $trads = "";
    foreach( $LANGS AS $k => $v ) {
      $trads .= ", ( SELECT value FROM pesca_textos WHERE referred = 'barcos-detalles' AND referred_id = bde_id AND field = 'imagen' AND lang = '".$v."' ) AS itm_imagen_".$v." ";
    }

    $query = "SELECT * ".$trads." FROM pesca_barcos_detalles WHERE bde_id = '".mysqli_real_escape_string($conn, $id)."'";
    $res = @mysqli_query($conn, $query);
    if(!$res)	{
      $ERR .= "No se ha podido conectar con la base de datos actual.<br />".$query;
    } else if ( @mysqli_num_rows($res) == 0 ) {
      $ERR .= "El barco en detalle indicado no existe.<br /><a href=\"barcos_detalles.php\">Volver al listado de barcos en detalle</a>";
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
  <!-- File Uploader -->
  <link href="../plugins/krajee-fileinput/css/fileinput.min.css?ver=201711192353" rel="stylesheet">
  <style>
  .kv-avatar .krajee-default.file-preview-frame,.kv-avatar .krajee-default.file-preview-frame:hover {
    margin: 0;
    padding: 0;
    border: none;
    box-shadow: none;
    text-align: center;
  }
  .kv-avatar {
    display: inline-block;
  }
  .kv-avatar .file-input {
    display: table-cell;
    width: 213px;
  }
  .kv-reqd {
    color: red;
    font-family: monospace;
    font-weight: normal;
  }
  </style>
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
        <li class="active"><i class="fa fa-pencil"></i> <?=($MODO == "add" ? "Añadir":"Editar")?> barco en detalle</li>
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
            <form id="ficha" action="<?=basename($_SERVER["PHP_SELF"])?>" method="post" enctype="multipart/form-data">
            <input type="hidden" id="action" name="action" value="<?=( $MODO == "add" ? "insert":"update")?>" />
            <input type="hidden" name="id" value="<?=$id?>" />
            <?php foreach ( $LANGS AS $k => $v ) { ?>
            <input type="hidden" name="old_imagen_<?=$v?>" value="<?=( $item["imagen_".$v] != "" ? $item["imagen_".$v]:"")?>" />
            <?php } ?>

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
                  <label for="field-orden" class="control-label">Orden</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-md-2">
                    <span class="input-group-addon"><i class="fa fa-sort"></i></span>
                    <input type="text" class="form-control" id="field-orden" name="orden" maxlength="4" placeholder="##" value="<?=$item["orden"]?>">
                  </div>
                  <!-- /.input-group -->
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

                <!-- Traducciones -->
                <?php
                  if ( is_array($LANGS) && count($LANGS) > 0 ) {
                    echo "<h3 class=\"page-header\">Traducciones</h3>";
                ?>

                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                  <?php $act = 0;foreach( $LANGS AS $k => $v ) { ?>
                    <li class="<?=($act++ == 0 ? "active":"")?>"><a href="#tab_<?=$v?>" data-toggle="tab"><?=Mayus($v)?></a></li>
                  <?php } ?>
								  </ul><!-- /.nav-tabs -->
                  
                  <div class="tab-content">
                  <?php $act = 0; foreach( $LANGS AS $k => $v ) { ?>
                    
                    <div class="tab-pane <?=( $act++ == 0 ?"active":"")?>" id="tab_<?=$v?>">

                      <div class="form-group">
                        <label for="field-imagen-<?=$v?>" class="control-label">Imagen del barco (<?=Mayus($v)?>)</label> <small class="text-red">* obligatorio</small>

                        <?php if ( $item["imagen_".$v] != "" ) { ?>
                        <div style="margin-bottom: 10px;">
                          <img src="<?=$DIR_IMG.$item["imagen_".$v]?>" style="max-width: 100%" />
                        </div>
                        <?php } ?>

                        <div class="file-loading">
                          <input id="imagen_<?=$v?>" name="imagen_<?=$v?>" type="file" accept="image/*">
                        </div> Formato: SVG (preferentemente)

                        <!-- /.input-group -->
                      </div>
                      <!-- /.form-group -->

                    </div><!-- /.tab-pane -->
                    
                  <?php } ?>
                  </div><!-- /.tab-content -->
                  
                </div>
                <!-- nav-tabs-custom -->
                <?php
                  }
                ?>

                <?php if ( $id > 0 ) { ?>
                <!-- Medias ...  -->
                <h3 class="page-header">Vídeos e imágenes</h3>
                
                <!-- /.Medias -->
                <?php } ?>
                
                <div class="form-group">
                  <button type="submit" class="btn btn-primary" id="Enviar"><?=( $MODO == "add" ? "Guardar nuevo barco":"Guardar cambios")?> <i class="fa fa-arrow-circle-right"></i></button> <a href="barcos_detalles.php" class="btn btn-default pull-right"><i class="fa fa-arrow-circle-left"></i> Volver al listado</a>
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
<!-- File Uploader -->
<script src="../plugins/krajee-fileinput/js/fileinput.min.js"></script>
<script src="../plugins/krajee-fileinput/js/locales/es.js"></script>
<script>
  $(function () {

<?php foreach ( $LANGS AS $k => $v ) { ?>
    $("#imagen_<?=$v?>").fileinput({
      overwriteInitial: true,
      maxFileSize: 15000,
      showClose: false,
      showCaption: false,
      showUpload: false,
      browseLabel: '<?=( $item["audio_".$v] != "" ? "Cambiar":"Elegir")?> imagen',
      removeLabel: '',
      browseIcon: '<i class="fa fa-folder-open"></i>',
      removeIcon: '<i class="fa fa-times"></i>',
      removeTitle: 'Cancelar cambios',
      msgErrorClass: 'alert alert-block alert-danger',
      defaultPreviewContent: '',
      allowedFileExtensions: ["svg","png"],
      previewFileType: "audio",
    });
    
<?php } ?>


  })
</script>

</body>
</html>
