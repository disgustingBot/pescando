<?php
  require_once ("inc.config.php");
  require_once("inc.checklogin.php");

  if ( !EsAdmin() ) {
    Header("Location: index.php");
    die();
  }

  $title_menutree = "Administración";
  $title_menu = "Idiomas";
  $page_title = $title_menutree." > ".$title_menu." > Edición";
  $active_menutree = "admin";
  $active_menu = "admin-idiomas";
  $icon_menutree = "fa fa-hashtag";
  $icon_menu = "fa fa-language";

  if ( $_POST ["action"] != "" ) {
    $code = $_POST["code"];
  } else {
    $code = $_GET["code"];
  }

  if ( !isset($code) ) {
    Header("Location: langs.php");
    die();
  }

  $ok1 = 0;
  $name1 = "";

  function upload($FVARS) {
    global $ok1, $name1, $code, $ERR, $DIR_IMG;

    $sufix = "lang-flag-";

    foreach( $FVARS as $a => $b ) {
      if ( $a == "flag" && $FVARS[$a]["size"] > 0  ) {

        $size1=$FVARS[$a]["size"];     // filesize
        $type1=$FVARS[$a]["type"];     // mime type
        $name1=Minus($sufix.$code."_".date("YmdHi").substr($FVARS[$a]["name"],strrpos($FVARS[$a]["name"],'.')));
        $temp1=$FVARS[$a]["tmp_name"]; // temporary name
        if($size1) {
          $DIRECT_foto = $DIR_IMG.$name1;

          $ok1 = move_uploaded_file( $temp1, $DIRECT_foto );
          chmod ( $DIRECT_foto, 0777 );
        }
      }
    }
  }

  if ( $_POST["action"] == "update" ) {

    if ( !EsAdmin() ) {
      $ERR .= "No tienes permisos para editar idiomas";
    } else if ( strlen($_POST["title"]) == 0 || strlen($_POST["code"]) == 0 || strlen($_POST["iso"]) == 0 || strlen($_POST["orden"]) == 0 || strlen($_POST["contenttype"]) == 0 || strlen($_POST["status"]) == 0 ) {
      $ERR .= "Faltan campos requeridos";
    } else {

      upload($_FILES);

      $query = "UPDATE pesca_langs SET ";
      if ( $ok1 ) {
        $query .= " lng_flag = '".$name1."',";
      }
      $query .= "lng_contenttype = '".mysqli_real_escape_string($conn, $_POST["contenttype"])."', ";
      $query .= "lng_iso = '".mysqli_real_escape_string($conn, $_POST["iso"])."', ";
      $query .= "lng_orden = '".mysqli_real_escape_string($conn, $_POST["orden"])."', ";
      $query .= "lng_status = '".mysqli_real_escape_string($conn, $_POST["status"])."', ";
      $query .= "lng_title = '".mysqli_real_escape_string($conn, $_POST["title"])."' ";
      $query .= " WHERE lng_code='".mysqli_real_escape_string($conn, $_POST["code"])."'";
      $res = @mysqli_query($conn, $query);
      if(!$res) {
        $ERR .= "No se ha podido guardar la info en la base de datos actual. <br />".mysqli_error($conn);
      } else {
        if ( $ok1 && $_POST["old_flag"] != "" && $_POST["old_flag"] != $name1 ) {
          @unlink($DIR_IMG.$_POST["old_flag"]);
        }

        $MSG .= "Idioma actualizado correctamente!<br />";

        $MSG .= "<br /><a href=\"langs.php\">Volver al listado de idiomas</a>";
        $MSG .= "<a style=\"float:right\" href=\"langs_edit.php?code=0\">Insertar nuevo idioma</a>";
      }
    }

  } else if ( $_POST["action"] == "insert" ) {

    if ( !EsAdmin() ) {
      $ERR = "No tienes permisos para dar de alta nuevos idiomas";
    } else if ( strlen($_POST["title"]) == 0 || strlen($_POST["code"]) == 0 || strlen($_POST["iso"]) == 0 || strlen($_POST["orden"]) == 0 || strlen($_POST["contenttype"]) == 0 || strlen($_POST["status"]) == 0 ) {
      $ERR = "Faltan campos requeridos";
    } else {
      $query = "SELECT lng_code FROM pesca_langs WHERE lng_code = '".mysqli_real_escape_string($conn, $code)."'";
      $re = @mysqli_query($conn, $query);
      if(!$re) {
        $ERR = "No se ha podido guardar la info en la base de datos actual. <br />".mysqli_error($conn);
      } else if(mysqli_num_rows($re) > 0) {
        $ERR = "El código de idioma '<strong>".$code."</strong>' ya existe.";
      } else {

        $code = stripslashes($_POST["code"]);

        $query = "INSERT INTO pesca_langs VALUES (
          '".mysqli_real_escape_string($conn, $code)."',
          '".mysqli_real_escape_string($conn, $_POST["title"])."',
          '".mysqli_real_escape_string($conn, $_POST["contenttype"])."',
          '".mysqli_real_escape_string($conn, $_POST["iso"])."',
          '',
          '".mysqli_real_escape_string($conn, $_POST["orden"])."',
          '".mysqli_real_escape_string($conn, $_POST["status"])."' )";
        $res = @mysqli_query($conn, $query);
        if(!$res) {
          $ERR = "No se ha podido conectar con la base de datos actual.<br />".mysqli_error($conn);
        } else {
          $MSG = "Idioma creado correctamente!<br />";

          upload($_FILES);

          if ( $ok1 ) {
            $query = "UPDATE pesca_langs SET lng_flag = '".mysqli_real_escape_string($conn, $name1)."' WHERE lng_code = '".mysqli_real_escape_string($conn, $code)."'";
            $result = mysqli_query($conn, $query);
            if ( !$result ) $ERR .= "Error subiendo la imagen!<br />".mysqli_error($conn);
            else $MSG .= "Imagen subida correctamente!<br />";
          }

          $MSG .= "<br /><a href=\"langs.php\">Volver al listado de idiomas</a>";
          $MSG .= "<a style=\"float:right\" href=\"langs_edit.php?code=0\">Insertar nuevo registro</a>";
        }
      }
    }
  }

  // Modo de trabajo: por defecto, nueva ficha
  $MODO = "add";

  if ( $code != "0" ) {
    $query = "SELECT * FROM pesca_langs WHERE lng_code='".mysqli_real_escape_string($conn, $code)."'";
    $res = @mysqli_query($conn, $query);
    if(!$res)	{
      $ERR = "No se ha podido conectar con la base de datos actual.";
    } else if ( @mysqli_num_rows($res) == 0 ) {
      $ERR = "El idioma indicado no existe.<br /><a href=\"langs.php\">Volver al listado de idiomas</a>";
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
        <li><a href="langs.php"><i class="<?=$icon_menu?>"></i> <?=$title_menu?></a></li>
        <li class="active"><i class="fa fa-pencil"></i> <?=($MODO == "add" ? "Añadir":"Editar")?> idioma</li>
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
              <input type="hidden" name="old_flag" value="<?=$item["flag"]?>" />

              <!--<div class="box-header">
              </div>-->
              <!-- /.box-header -->

              <div class="box-body">

                <div class="form-group page-header">
                  <h3><?=($MODO == "add" ? "Añadir":"Editar")?> ficha de datos</h3>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-title" class="control-label">Idioma</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-md-10">
                    <span class="input-group-addon"><i class="fa fa-language"></i></span>
                    <input type="text" class="form-control" id="field-title" name="title" maxlength="50" placeholder="Nombre completo del idioma" value="<?=$item["title"]?>">
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-code" class="control-label">Código</label> <?php if ( $MODO == "add" ) { ?><small class="text-red">* obligatorio</small><?php } ?>
                  <div class="input-group col-md-2">
                    <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                    <input type="text" class="form-control" id="field-code" name="code" maxlength="3" placeholder="???" value="<?=$item["code"]?>" <?=($MODO == "add" ? "":"disabled")?>>
                    <?php if ( $MODO != "add" ) { ?>
                    <input type="hidden" name="code" value="<?=$item["code"]?>">
                    <?php } ?>
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-contenttype" class="control-label">Content-Type</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-md-2">
                    <span class="input-group-addon"><i class="fa fa-code"></i></span>
                    <input type="text" class="form-control" id="field-contenttype" name="contenttype" maxlength="2" placeholder="??" value="<?=$item["contenttype"]?>">
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-iso" class="control-label">ISO</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-md-4">
                    <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                    <select class="form-control" id="field-iso" name="iso">
                      <option value="utf8" <?php if ( $item["iso"] == "utf8" ) echo " selected"; ?>>UTF-8</option>
                      <option value="iso-8859-1" <?php if ( $item["iso"] == "iso-8859-1" ) echo " selected"; ?>>iso-8859-1</option>
                    </select>
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-flag" class="control-label">Flag</label>

                  <?php if ( $item["flag"] != "" && file_exists($DIR_IMG.$item["flag"]) ) { ?>
                  <div style="margin-bottom: 10px;">
                    <img src="<?=$DIR_IMG.$item["flag"]?>" style="max-width: 100%" /> <a href="borra_imagen.php?id=<?=$item["code"]?>&sec=langs&foto=flag" title="Borra esta imagen!" style="color: red;"><span class="fa fa-2x fa-times"></span></a>
                  </div>
                  <?php } ?>

                  <div class="file-loading">
                    <input id="flag" name="flag" type="file" accept="image/*">
                  </div>Formato: JPG, PNG o GIF. Medidas recomendadas: 50 x 50 pixels

                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-orden" class="control-label">Orden</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group input-group-sm col-xs-6">
                    <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                    <input type="text" class="form-control" id="field-orden" name="orden" style="width: 50px;" maxlength="3" placeholder="???" value="<?=$item["orden"]?>">
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-status" class="control-label">Estado</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-md-4">
                    <span class="input-group-addon"><i class="fa fa-sort"></i></span>
                    <select class="form-control" id="field-status" name="status">
                      <option value="A" <?php if ( $item["status"] == "A" ) echo " selected"; ?>>Activo</option>
                      <option value="I" <?php if ( $item["status"] == "I" || $item["status"] == "" ) echo " selected"; ?>>Inactivo</option>
                    </select>
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <button type="submit" class="btn btn-primary" id="Enviar"><?=( $MODO == "add" ? "Guardar nuevo idioma":"Guardar cambios")?> <i class="fa fa-arrow-circle-right"></i></button> <a href="langs.php" class="btn btn-default pull-right"><i class="fa fa-arrow-circle-left"></i> Volver al listado</a>
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
<!-- File Uploader -->
<script src="../plugins/krajee-fileinput/js/fileinput.min.js"></script>
<script src="../plugins/krajee-fileinput/js/locales/es.js"></script>
<script>
  $(function () {

    $("#flag").fileinput({
      overwriteInitial: true,
      maxFileSize: 1500,
      showClose: false,
      showCaption: false,
      showUpload: false,
      browseLabel: '<?=($item["flag"] != "" ? "Cambiar":"Elegir")?> imagen',
      removeLabel: '',
      browseIcon: '<i class="fa fa-folder-open"></i>',
      removeIcon: '<i class="fa fa-times"></i>',
      removeTitle: 'Cancelar cambios',
      msgErrorClass: 'alert alert-block alert-danger',
      defaultPreviewContent: '',
      allowedFileExtensions: ["jpg", "png", "gif"],
      previewFileType: "image",
    });

     //Flat orange color scheme for iCheck
    $('input[type="checkbox"].flat-item, input[type="radio"].flat-item').iCheck({
      checkboxClass: 'icheckbox_flat-orange',
      radioClass   : 'iradio_flat-orange'
    })

  })
</script>


</body>
</html>
