<?php
  require_once("inc.config.php");
  require_once("inc.checklogin.php");

  if ( !EsAdmin() && !EsBasico() ) {
    Header("Location: index.php");
    die();
  }

  $title_menutree = "Líneas de Investigación";
  $title_menu = "Áreas de investigación";
  $page_title = $title_menutree." > ".$title_menu." > Edición";
  $active_menutree = "futuro";
  $active_menu = "futuro-areas";
  $icon_menutree = "fa fa-search-plus";
  $icon_menu = "fa fa-search";


  if ( $_POST ["action"] != "" ) {
    $id = $_POST["id"];
  } else {
    $id = $_GET["id"];
  }

  if ( !isset($id) ) {
    Header("Location: areas.php");
    die();
  }

  $ok2 = "";
  $name2="";
  function upload($FVARS) {
    global $ok2, $name2, $id, $DIR_IMG;
      
    $sufix = "area".$id;

    foreach( $FVARS as $a => $b  ) {
      if ( $a == "fondo" && $FVARS[$a]["size"] > 0  ) {

        $size2=$FVARS[$a]["size"];     // filesize
        $type2=$FVARS[$a]["type"];     // mime type
        $name2=Minus($sufix."_".$a."_".date("His").substr($FVARS[$a]["name"],strrpos($FVARS[$a]["name"],'.')));
        $temp2=$FVARS[$a]["tmp_name"]; // temporary name
        if($size2) {
          $DIRECT_foto = $DIR_IMG.$name2;

          $ok2 = move_uploaded_file( $temp2, $DIRECT_foto );
          @chmod ( $DIRECT_foto, 0777 );
        }
      }
    }
  }

  if ( $_POST["action"] == "update" ) {

    if ( !EsAdmin() ) {
      $ERR = "No tienes permisos para editar este elemento";
    } else if ( strlen($_POST["nombre"]) == 0 || strlen($_POST["orden"]) == 0 || strlen($_POST["status"]) == 0 ) {
      $ERR = "Faltan campos requeridos";
      $item = $_POST;
    } else {

      upload($_FILES);

      $query = "UPDATE pesca_areas SET ";
      if ( $ok2 ) {
        $query .= " are_fondo = '".$name2."',";
      }
      $query .= "are_nombre = '".mysqli_real_escape_string($conn, ucfirst($_POST["nombre"]))."', ";
      $query .= "are_orden = '".mysqli_real_escape_string($conn, $_POST["orden"])."', ";
      $query .= "are_status = '".mysqli_real_escape_string($conn, $_POST["status"])."' ";
      $query .= " WHERE are_id ='".mysqli_real_escape_string($conn, $id)."'";
      $res = @mysqli_query($conn, $query);
      if(!$res) {
        $ERR = "No se ha podido guardar la info en la base de datos actual. <br />".mysqli_error($conn);
      } else {
        $MSG = "Área de investigación actualizada correctamente!<br />";

        if ( $ok2 && $_POST["old_fondo"] != "" && $_POST["old_fondo"] != $name2 ) {
          @unlink($DIR_IMG.$_POST["old_fondo"]);
        }

        /* Traduccions */
        foreach ( $LANGS as $k => $v ) {
          // Nombre
          if ( ExisteTextoLang( 'areas', $id, 'nombre', $v) ) {
            $qry = "UPDATE pesca_textos SET value='".mysqli_real_escape_string($conn, strip_tags($_POST["nombre_".$v], "<b><i><strong><em>"))."' WHERE referred = 'areas' AND referred_id = ".$id." AND field='nombre' AND lang = '".mysqli_real_escape_string($conn, $v)."'";
            $res = mysqli_query($conn,  $qry );
            if ( $res ) $MSG .= "Nombre ".Mayus($v).": traducción actualizada correctamente<br />";
          } else {
            $qry = "INSERT INTO pesca_textos VALUES ( '', 'areas', $id, 'nombre','".mysqli_real_escape_string($conn, $v)."','".mysqli_real_escape_string($conn, strip_tags($_POST["nombre_".$v], "<b><i><strong><em>"))."' ) ";
            $res = mysqli_query($conn,  $qry );
            if ( $res ) $MSG .= "Nombre ".Mayus($v).": traducción creada correctamente<br />";
          }

        }

        $MSG .= "<br /><a href=\"areas.php\">Volver al listado de áreas de investigación</a>";
        $MSG .= "<a style=\"float:right\" href=\"areas_edit.php?id=0\">Insertar nuevo registro</a>";
      }
    }

  } else if ( $_POST["action"] == "insert" ) {

    if ( !EsAdmin() ) {
      $ERR = "No tienes permisos para dar de alta nuevos elementos";
    } else if ( strlen($_POST["nombre"]) == 0 || strlen($_POST["orden"]) == 0 || strlen($_POST["status"]) == 0 ) {
      $ERR = "Faltan campos requeridos";
      $item = $_POST;
    } else {

      $query = "INSERT INTO pesca_areas (are_nombre, are_orden, are_status)
        VALUES (
        '".mysqli_real_escape_string($conn, ucfirst($_POST["nombre"]))."',
        '".mysqli_real_escape_string($conn, $_POST["orden"])."',
        '".mysqli_real_escape_string($conn, $_POST["status"])."' )";
      $res = @mysqli_query($conn, $query);
      if(!$res) {
        $ERR = "No se ha podido guardar la info en la base de datos actual.<br />".mysqli_error($conn)."<br />".$query;
      } else {
        $MSG = "Área de investigación creada correctamente!<br />";

        $id = mysqli_insert_id($conn);

        /* Traduccions */
        foreach ( $LANGS as $k => $v ) {
          // Nombre
          $qry = "INSERT INTO pesca_textos VALUES ( '', 'areas', $id, 'nombre','".mysqli_real_escape_string($conn, $v)."','".mysqli_real_escape_string($conn, strip_tags($_POST["nombre_".$v], "<b><i><strong><em>"))."' ) ";
          $res = mysqli_query($conn,  $qry );
          if ( $res ) $MSG .= "Nombre ".Mayus($v).": traducción creada correctamente<br />";

        }

        upload($_FILES);

        if ( $ok2 ) {
          $query = "UPDATE pesca_areas SET are_fondo = '".mysqli_real_escape_string($conn, $name2)."' WHERE are_id = '".mysqli_real_escape_string($conn, $id)."'";
          $result = mysqli_query($conn, $query);
          if ( !$result ) $ERR .= "Error subiendo la imagen de fondo!<br />".mysqli_error($conn);
          else $MSG .= "Imagen de fondo subida correctamente!<br />";
        }

        $MSG .= "<br /><a href=\"areas.php\">Volver al listado de áreas de investigación</a>";
        $MSG .= "<a style=\"float:right\" href=\"areas_edit.php?id=0\">Insertar nuevo registro</a>";
      }
    }
  }

  // Modo de trabajo: por defecto, nueva ficha
  $MODO = "add";

  if ( $id > 0 ) {
    $trads = "";
    foreach( $LANGS AS $k => $v ) {
      $trads .= ", ( SELECT value FROM pesca_textos WHERE referred = 'areas' AND referred_id = are_id AND field = 'nombre' AND lang = '".$v."' ) AS tra_nombre_".$v." ";
    }

    $query = "SELECT * ".$trads." FROM pesca_areas WHERE are_id = '".mysqli_real_escape_string($conn, $id)."'";
    $res = @mysqli_query($conn, $query);
    if(!$res)	{
      $ERR .= "No se ha podido conectar con la base de datos actual.<br />".$query;
    } else if ( @mysqli_num_rows($res) == 0 ) {
      $ERR .= "La área de investigación indicada no existe.<br /><a href=\"areas.php\">Volver al listado de áreas de investigación</a>";
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
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
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
        <li><a href="areas.php"><i class="<?=$icon_menu?>"></i> <?=$title_menu?></a></li>
        <li class="active"><i class="fa fa-pencil"></i> <?=($MODO == "add" ? "Añadir":"Editar")?> especie</li>
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
            <input type="hidden" name="old_fondo" value="<?=$item["fondo"]?>" />

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
                  <label for="field-fondo" class="control-label">Fondo</label> <small class="text-red">* obligatorio</small>

                  <?php if ( $item["fondo"] != "" && file_exists($DIR_IMG.$item["fondo"]) ) { ?>
                  <div style="margin-bottom: 10px;">
                    <img src="<?=$DIR_IMG.$item["fondo"]?>" style="max-width: 100%" />
                  </div>
                  <?php } ?>

                  <div class="file-loading">
                    <input id="fondo" name="fondo" type="file" accept="image/*">
                  </div> Formato: JPG, PNG o GIF. Medidas: 1080 pixels (ancho máximo) por 1920 pixels (alto máximo)

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
                        <label for="field-nombre-<?=$v?>" class="control-label">Nombre (<?=Mayus($v)?>)</label> <small class="text-red">* obligatorio</small>
                        <div class="input-group col-xs-11">
                          <input type="text" class="form-control" id="field-nombre-<?=$v?>" name="nombre_<?=$v?>" placeholder="" value="<?=$item["nombre_".$v]?>" />
                        </div>
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

                <div class="form-group">
                  <button type="submit" class="btn btn-primary" id="Enviar"><?=( $MODO == "add" ? "Guardar nueva área":"Guardar cambios")?> <i class="fa fa-arrow-circle-right"></i></button> <a href="areas.php" class="btn btn-default pull-right"><i class="fa fa-arrow-circle-left"></i> Volver al listado</a>
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
<!-- Bootstrap WYSIHTML5 -->
<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- File Uploader -->
<script src="../plugins/krajee-fileinput/js/fileinput.min.js"></script>
<script src="../plugins/krajee-fileinput/js/locales/es.js"></script>
<script>
  $(function () {

    $("#fondo").fileinput({
      overwriteInitial: true,
      maxFileSize: 3500,
      showClose: false,
      showCaption: false,
      showUpload: false,
      browseLabel: '<?=( $item["fondo"] != "" ? "Cambiar":"Elegir")?> imagen de fondo',
      removeLabel: '',
      browseIcon: '<i class="fa fa-folder-open"></i>',
      removeIcon: '<i class="fa fa-times"></i>',
      removeTitle: 'Cancelar cambios',
      msgErrorClass: 'alert alert-block alert-danger',
      defaultPreviewContent: '',
      allowedFileExtensions: ["jpg", "png", "gif"],
      previewFileType: "image",
    });

    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5({useLineBreaks : true});
    
  });

</script>

</body>
</html>
