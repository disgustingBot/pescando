<?php
  require_once ("inc.config.php");
  require_once("inc.checklogin.php");

  $title_menutree = "Administración";
  $title_menu = ( EsAdmin() ? "Usuarios del panel":"Perfil del usuario");
  $page_title = $title_menutree." > ".$title_menu." > Edición";
  $active_menutree = "admin";
  $active_menu = "admin-usuarios";
  $icon_menutree = "fa fa-hashtag";
  $icon_menu = "fa fa-id-badge";

  if ( $_POST ["action"] != "" ) {
    $id = $_POST["id"];
  } else {
    $id = $_GET["id"];
  }

  if ( !isset($id) ) {
    Header("Location: adminusers.php");
    die();
  }

  $ok1 = 0;
  $name1 = "";

  function upload($FVARS) {
    global $ok1, $name1, $id, $DIR_IMG;

    $sufix = "avatar";

    foreach( $FVARS as $a => $b ) {
      if ( $a == "avatar" && $FVARS[$a]["size"] > 0  ) {

        $size1=$FVARS[$a]["size"];     // filesize
        $type1=$FVARS[$a]["type"];     // mime type
        $name1=Minus($sufix.$id."_".date("YmdHi").substr($FVARS[$a]["name"],strrpos($FVARS[$a]["name"],'.')));
        $temp1=$FVARS[$a]["tmp_name"]; // temporary name
        if($size1) {
          $DIRECT_foto = $DIR_IMG.$name1;

          $ok1 = move_uploaded_file( $temp1, $DIRECT_foto );
          @chmod ( $DIRECT_foto, 0777 );
        }
      }
    }
  }

  if ( $_POST["action"] == "update" ) {

    if($_POST["password"] != $_POST["repeat-password"]) {
      $ERR .= "Las contraseñas indicadas son distintas";
    } else {
      upload($_FILES);

      $query = "UPDATE pesca_adminusers SET ";
      if ( $ok1 ) {
        $query .= " adm_avatar = '".$name1."',";
      }
      if(strlen($_POST["password"]) > 0) {
        $PASSWD = md5($_POST["password"]);
        $query .= "adm_passwd = '".mysqli_real_escape_string($conn, $PASSWD)."', ";
      }
      if ( $_POST["status"] != "" ) $query .= "adm_status = '".mysqli_real_escape_string($conn, $_POST["status"])."', ";
      if ( $_POST["type"] != "" ) $query .= "adm_type = '".mysqli_real_escape_string($conn, $_POST["type"])."', ";
      $query .= "adm_email = '".mysqli_real_escape_string($conn, $_POST["email"])."', ";
      $query .= "adm_name = '".mysqli_real_escape_string($conn, $_POST["name"])."' ";
      $query .= " WHERE adm_id='".mysqli_real_escape_string($conn, $_POST["id"])."'";
      $res = @mysqli_query($conn, $query);
      if(!$res) {
        $ERR .= "No se ha podido guardar la info en la base de datos actual. <br />".mysqli_error($conn);
      } else {
        if ( $ok1 && $_POST["old_avatar"] != "" && $_POST["old_avatar"] != $name1 ) {
          @unlink($DIR_IMG.$_POST["old_avatar"]);
          if ( $_SESSION["PESCA_ADMIN_ID"] == $id ) {
            $_SESSION["PESCA_ADMIN_AVATAR"] = $name1;
          }

        }

        $MSG .= "Usuario actualizado correctamente!<br />";

        if ( EsAdmin() ) {
          $MSG .= "<br /><a href=\"adminusers.php\">Volver al listado de usuarios</a>";
          $MSG .= "<a style=\"float:right\" href=\"adminusers_edit.php?id=0\">Insertar nuevo registro</a>";
        } else {
          $MSG .= "<br /><a href=\"adminusers.php\">Volver al listado del perfil</a>";
        }

      }
    }

  } else if ( $_POST["action"] == "insert" ) {

    if ( !EsAdmin() ) {
      $ERR .= "No tienes permisos para crear nuevos usuarios";
    } else if ( strlen($_POST["username"]) == 0 || strlen($_POST["password"]) == 0 || strlen($_POST["repeat-password"]) == 0 || strlen($_POST["type"]) == 0 ) {
      $ERR .= "Faltan campos requeridos";
    } else if($_POST["password"] != $_POST["repeat-password"]) {
      $ERR .= "Las contraseñas indicadas son distintas";
    } else {
      $query = "SELECT adm_username FROM pesca_adminusers WHERE adm_username='".mysqli_real_escape_string($conn, $_POST["username"])."'";
      $re = @mysqli_query($conn, $query);
      if(!$re) {
        $ERR .= "No se ha podido guardar la info en la base de datos actual. <br />".mysqli_error($conn);
      } else if(mysqli_num_rows($re) > 0) {
        $ERR .= "El usuario '<strong>".$_POST["username"]."</strong>' ya existe.";
      } else {

        $TODAY = date("Ymd");
        $PASSWD = md5($_POST[password]);

        $query = "INSERT INTO pesca_adminusers VALUES ('',
          '".mysqli_real_escape_string($conn, $_POST["name"])."',
          '".mysqli_real_escape_string($conn, $_POST["username"])."',
          '".mysqli_real_escape_string($conn, $PASSWD)."',
          '".mysqli_real_escape_string($conn, $_POST["type"])."',
          '".mysqli_real_escape_string($conn, $_POST["email"])."',
          '',
          '".$TODAY."',
          '".mysqli_real_escape_string($conn, $_POST["status"])."' )";
        $res = @mysqli_query($conn, $query);
        if(!$res) {
          $ERR .= "No se ha podido conectar con la base de datos actual. <br />".mysqli_error($conn);
        } else {
          $id = @mysqli_insert_id($conn);
          $MSG .= "Usuario creado correctamente!<br />";

          upload($_FILES);

          if ( $ok1 ) {
            $query = "UPDATE pesca_adminusers SET adm_avatar = '".$name1."' WHERE adm_id = '".$id."'";
            $result = mysqli_query($conn, $query);
            if ( !$result ) $ERR .= "Error subiendo la imagen!<br />".mysqli_error($conn);
            else $MSG .= "Imagen subida correctamente!";
          }

          $MSG .= "<br /><a href=\"adminusers.php\">Volver al listado de usuarios</a>";
          $MSG .= "<a style=\"float:right\" href=\"adminusers_edit.php?id=0\">Insertar nuevo registro</a>";
        }
      }
    }
  }

  // Modo de trabajo: por defecto, nueva ficha
  $MODO = "add";

  if ( $id > 0 ) {
    $query = "SELECT *, (SELECT MAX(log_moment) FROM pesca_adminusers_logs WHERE log_userid = adm_id AND log_action = 'login') as adm_last_login  FROM pesca_adminusers WHERE adm_id='".mysqli_real_escape_string($conn, $id)."'";
    $res = @mysqli_query($conn, $query);
    if(!$res)	{
      $ERR .= "No se ha podido conectar con la base de datos actual.<br />";
    } else if ( @mysqli_num_rows($res) == 0 ) {
      $ERR .= "El usuario indicado no existe.<br /><a href=\"adminusers.php\">Volver al listado de usuarios</a>";
      $id = 0;
    } else {

      $fila = @mysqli_fetch_assoc($res);
      foreach ( $fila as $k => $v ) {
        $index = substr($k,4);
        $user[$index] = stripslashes($v);
      }

      $CREATED = GeneraData($user["created"],8);
      if ( $user["last_login"] != '' ) {
        $LASTLOGIN = GeneraData($user["last_login"],12);
      } else {
        $LASTLOGIN = "Nunca ha accedido al panel de control";
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
        <li><a href="adminusers.php"><i class="<?=$icon_menu?>"></i> <?=$title_menu?></a></li>
        <li class="active"><i class="fa fa-pencil"></i> <?=($MODO == "add" ? "Añadir":"Editar")?> usuario</li>
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
              <input type="hidden" name="old_avatar" value="<?=$user["avatar"]?>" />

              <!--<div class="box-header">
              </div>-->
              <!-- /.box-header -->

              <div class="box-body">

                <div class="form-group page-header">
                  <h3><?=($MODO == "add" ? "Añadir":"Editar")?> ficha de datos</h3>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-name" class="control-label">Nombre de la persona</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-sm-10">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" id="field-name" name="name" maxlength="120" placeholder="Nombre completo" value="<?=$user["name"]?>">
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-username" class="control-label">Usuario</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-sm-8">
                    <span class="input-group-addon">@</span>
                    <input type="text" class="form-control" id="field-username" name="username" maxlength="32" placeholder="Usuario para acceder al panel" value="<?=$user["username"]?>" <?=($MODO == "add" ? "":"disabled")?>>
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-password" class="control-label">Contraseña</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-sm-8">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" id="field-password" name="password" maxlength="50" placeholder="">
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-repeat-password" class="control-label">Repetir contraseña</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-sm-8">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" id="field-repeat-password" name="repeat-password" maxlength="50" placeholder="">
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-email" class="control-label">Dirección email</label>
                  <div class="input-group col-sm-10">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" class="form-control" id="field-email" name="email" maxlength="75" placeholder="Dirección de correo electrónico" value="<?=$user["email"]?>">
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-type" class="control-label">Tipo de usuario</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-sm-5">
                    <span class="input-group-addon"><i class="fa fa-eye"></i></span>
                    <select class="form-control" id="field-type" name="type" <?=($MODO == "add" || EsAdmin() ? "":"disabled")?>>
                      <option value="basico" <?php if ( $user["type"] == "basico" ) echo " selected"; ?>>Usuario Básico</option>
                      <?php if ( EsAdmin() ) { ?><option value="admin" <?php if ( $user["type"] == "admin" ) echo " selected"; ?>>Administrador</option><?php } ?>
                    </select>
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-avatar" class="control-label">Avatar</label>

                  <?php if ( $user["avatar"] != "" && file_exists($DIR_IMG.$user["avatar"]) ) { ?>
                  <div style="margin-bottom: 10px;">
                    <img src="<?=$DIR_IMG.$user["avatar"]?>" style="max-width: 100%" /> <a href="borra_imagen.php?id=<?=$id?>&sec=admin&foto=avatar" title="Borra esta imagen!" style="color: red;"><span class="fa fa-2x fa-times"></span></a>
                  </div>
                  <?php } ?>

                  <div class="file-loading">
                    <input id="avatar" name="avatar" type="file" accept="image/*">
                  </div> Formato: JPG, PNG o GIF. Medidas recomendadas: 200 x 200 pixels

                </div>
                <!-- /.form-group -->
                
                <div class="form-group">
                  <label for="field-status" class="control-label">Estado</label> <small class="text-red">* obligatorio</small>
                  <?php if ( EsAdmin() ) { ?>
                  <div class="input-group col-sm-4">
                    <span class="input-group-addon"><i class="fa fa-universal-access"></i></span>
                    <select class="form-control" id="field-status" name="status">
                      <option value="A" <?php if ( $user["status"] == "A" ) echo " selected"; ?>>Activo</option>
                      <option value="I" <?php if ( $user["status"] == "I" || $user["status"] == "" ) echo " selected"; ?>>Inactivo</option>
                    </select>
                  </div>
                  <!-- /.input-group -->
                  <?php } else { ?>
                  <div><?=($user["status"] == "A" ? "Activo":"Inactivo")?></div>
                  <?php } ?>
                </div>
                <!-- /.form-group -->

                <?php if ( $MODO == "update" ) { ?>
                <div class="form-group">
                  <label class="control-label">Fecha de alta</label>
                  <div><?=$CREATED?></div>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label class="control-label">Último acceso</label>
                  <div><?=$LASTLOGIN?></div>
                </div>
                <!-- /.form-group -->
                <?php } ?>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary" id="Enviar"><?=( $MODO == "add" ? "Guardar nuevo usuario":"Guardar cambios")?> <i class="fa fa-arrow-circle-right"></i></button> <a href="adminusers.php" class="btn btn-default pull-right"><i class="fa fa-arrow-circle-left"></i> Volver al listado</a>
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

    $("#avatar").fileinput({
      overwriteInitial: true,
      maxFileSize: 1500,
      showClose: false,
      showCaption: false,
      showUpload: false,
      browseLabel: '<?=( $user["avatar"] != "" ? "Cambiar":"Elegir")?> imagen',
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