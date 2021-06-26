<?php
  require_once("inc.config.php");
  require_once("inc.checklogin.php");

  if ( !EsAdmin() && !EsBasico() ) {
    Header("Location: index.php");
    die();
  }

  $title_menutree = "Acuicultura";
  $title_menu = "Los animales";
  $page_title = $title_menutree." > ".$title_menu." > Edición";
  $active_menutree = "acuicultura";
  $active_menu = "acuicultura-animales";
  $icon_menutree = "fa fa-align-center";
  $icon_menu = "fa fa-picture-o";

  if ( $_POST ["action"] != "" ) {
    $id = $_POST["id"];
  } else {
    $id = $_GET["id"];
  }

  if ( !isset($id) ) {
    Header("Location: animales.php");
    die();
  }

  $ok1 = "";
  $name1="";
  $ok2 = "";
  $name2="";
  function upload($FVARS) {
    global $ok1, $name1, $ok2, $name2, $id, $DIR_IMG;
      
    $sufix = "animal".$id;

    foreach( $FVARS as $a => $b  ) {
      if ( $a == "foto" && $FVARS[$a]["size"] > 0  ) {

        $size1=$FVARS[$a]["size"];     // filesize
        $type1=$FVARS[$a]["type"];     // mime type
        $name1=Minus($sufix."_".$a."_".date("His").substr($FVARS[$a]["name"],strrpos($FVARS[$a]["name"],'.')));
        $temp1=$FVARS[$a]["tmp_name"]; // temporary name
        if($size1) {
          $DIRECT_foto = $DIR_IMG.$name1;

          $ok1 = move_uploaded_file( $temp1, $DIRECT_foto );
          @chmod ( $DIRECT_foto, 0777 );
        }
      } else if ( $a == "mapa" && $FVARS[$a]["size"] > 0  ) {

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
    } else if ( strlen($_POST["nombre"]) == 0 || strlen($_POST["especie"]) == 0 || strlen($_POST["cientifico"]) == 0 || strlen($_POST["tipoacuicultura"]) == 0 || strlen($_POST["status"]) == 0 ) {
      $ERR = "Faltan campos requeridos";
      $item = $_POST;
    } else {

      upload($_FILES);

      $query = "UPDATE pesca_animales SET ";
      if ( $ok1 ) {
        $query .= " ani_foto = '".$name1."',";
      }
      if ( $ok2 ) {
        $query .= " ani_mapa = '".$name2."',";
      }
      $query .= "ani_nombre = '".mysqli_real_escape_string($conn, ucfirst($_POST["nombre"]))."', ";
      $query .= "ani_cientifico = '".mysqli_real_escape_string($conn, ucfirst($_POST["cientifico"]))."', ";
      $query .= "ani_tipoacuicultura = '".mysqli_real_escape_string($conn, $_POST["tipoacuicultura"])."', ";
      $query .= "ani_especie = '".mysqli_real_escape_string($conn, $_POST["especie"])."', ";
      $query .= "ani_status = '".mysqli_real_escape_string($conn, $_POST["status"])."' ";
      $query .= " WHERE ani_id ='".mysqli_real_escape_string($conn, $id)."'";
      $res = @mysqli_query($conn, $query);
      if(!$res) {
        $ERR = "No se ha podido guardar la info en la base de datos actual. <br />".mysqli_error($conn);
      } else {
        $MSG = "Animal actualizado correctamente!<br />";

        if ( $ok1 && $_POST["old_foto"] != "" && $_POST["old_foto"] != $name1 ) {
          @unlink($DIR_IMG.$_POST["old_foto"]);
        }
        if ( $ok2 && $_POST["old_mapa"] != "" && $_POST["old_mapa"] != $name2 ) {
          @unlink($DIR_IMG.$_POST["old_mapa"]);
        }

        /* Traduccions */
        foreach ( $LANGS as $k => $v ) {
          // Nombre
          if ( ExisteTextoLang( 'animales', $id, 'nombre', $v) ) {
            $qry = "UPDATE pesca_textos SET value='".mysqli_real_escape_string($conn, strip_tags($_POST["nombre_".$v], "<b><i><strong><em>"))."' WHERE referred = 'animales' AND referred_id = ".$id." AND field='nombre' AND lang = '".mysqli_real_escape_string($conn, $v)."'";
            $res = mysqli_query($conn,  $qry );
            if ( $res ) $MSG .= "Nombre ".Mayus($v).": traducción actualizada correctamente<br />";
          } else {
            $qry = "INSERT INTO pesca_textos VALUES ( '', 'animales', $id, 'nombre','".mysqli_real_escape_string($conn, $v)."','".mysqli_real_escape_string($conn, strip_tags($_POST["nombre_".$v], "<b><i><strong><em>"))."' ) ";
            $res = mysqli_query($conn,  $qry );
            if ( $res ) $MSG .= "Nombre ".Mayus($v).": traducción creada correctamente<br />";
          }

          // Curiosidades
          if ( ExisteTextoLang( 'animales', $id, 'curiosidades', $v) ) {
            $qry = "UPDATE pesca_textos SET value='".mysqli_real_escape_string($conn, strip_tags($_POST["curiosidades_".$v], "<b><i><strong><em>"))."' WHERE referred = 'animales' AND referred_id = ".$id." AND field='curiosidades' AND lang = '".mysqli_real_escape_string($conn, $v)."'";
            $res = mysqli_query($conn,  $qry );
            if ( $res ) $MSG .= "Curiosidades ".Mayus($v).": traducción actualizada correctamente<br />";
          } else {
            $qry = "INSERT INTO pesca_textos VALUES ( '', 'animales', $id, 'curiosidades','".mysqli_real_escape_string($conn, $v)."','".mysqli_real_escape_string($conn, strip_tags($_POST["curiosidades_".$v], "<b><i><strong><em>"))."' ) ";
            $res = mysqli_query($conn,  $qry );
            if ( $res ) $MSG .= "Curiosidades ".Mayus($v).": traducción creada correctamente<br />";
          }

          // Paises
          if ( ExisteTextoLang( 'animales', $id, 'paises', $v) ) {
            $qry = "UPDATE pesca_textos SET value='".mysqli_real_escape_string($conn, strip_tags($_POST["paises_".$v], "<b><i><strong><em>"))."' WHERE referred = 'animales' AND referred_id = ".$id." AND field='paises' AND lang = '".mysqli_real_escape_string($conn, $v)."'";
            $res = mysqli_query($conn,  $qry );
            if ( $res ) $MSG .= "Paises ".Mayus($v).": traducción actualizada correctamente<br />";
          } else {
            $qry = "INSERT INTO pesca_textos VALUES ( '', 'animales', $id, 'paises','".mysqli_real_escape_string($conn, $v)."','".mysqli_real_escape_string($conn, strip_tags($_POST["paises_".$v], "<b><i><strong><em>"))."' ) ";
            $res = mysqli_query($conn,  $qry );
            if ( $res ) $MSG .= "Paises ".Mayus($v).": traducción creada correctamente<br />";
          }

        }

        $MSG .= "<br /><a href=\"animales.php\">Volver al listado de animales</a>";
        $MSG .= "<a style=\"float:right\" href=\"animales_edit.php?id=0\">Insertar nuevo registro</a>";
      }
    }

  } else if ( $_POST["action"] == "insert" ) {

    if ( !EsAdmin() ) {
      $ERR = "No tienes permisos para dar de alta nuevos elementos";
    } else if ( strlen($_POST["nombre"]) == 0 || strlen($_POST["especie"]) == 0 || strlen($_POST["cientifico"]) == 0 || strlen($_POST["tipoacuicultura"]) == 0 || strlen($_POST["status"]) == 0 ) {
      $ERR = "Faltan campos requeridos";
      $item = $_POST;
    } else {

      $query = "INSERT INTO pesca_animales (ani_nombre, ani_especie, ani_cientifico, ani_tipoacuicultura, ani_status)
        VALUES (
        '".mysqli_real_escape_string($conn, ucfirst($_POST["nombre"]))."',
        '".mysqli_real_escape_string($conn, $_POST["especie"])."',
        '".mysqli_real_escape_string($conn, ucfirst($_POST["cientifico"]))."',
        '".mysqli_real_escape_string($conn, $_POST["tipoacuicultura"])."',
        '".mysqli_real_escape_string($conn, $_POST["status"])."' )";
      $res = @mysqli_query($conn, $query);
      if(!$res) {
        $ERR = "No se ha podido guardar la info en la base de datos actual.<br />".mysqli_error($conn)."<br />".$query;
      } else {
        $MSG = "Animal creado correctamente!<br />";

        $id = mysqli_insert_id($conn);

        /* Traduccions */
        foreach ( $LANGS as $k => $v ) {
          // Nombre
          $qry = "INSERT INTO pesca_textos VALUES ( '', 'animales', $id, 'nombre','".mysqli_real_escape_string($conn, $v)."','".mysqli_real_escape_string($conn, strip_tags($_POST["nombre_".$v], "<b><i><strong><em>"))."' ) ";
          $res = mysqli_query($conn,  $qry );
          if ( $res ) $MSG .= "Nombre ".Mayus($v).": traducción creada correctamente<br />";

          // Curiosidades
          $qry = "INSERT INTO pesca_textos VALUES ( '', 'animales', $id, 'curiosidades','".mysqli_real_escape_string($conn, $v)."','".mysqli_real_escape_string($conn, strip_tags($_POST["curiosidades_".$v], "<b><i><strong><em>"))."' ) ";
          $res = mysqli_query($conn,  $qry );
          if ( $res ) $MSG .= "Curiosidades ".Mayus($v).": traducción creada correctamente<br />";

          // Paises
          $qry = "INSERT INTO pesca_textos VALUES ( '', 'animales', $id, 'paises','".mysqli_real_escape_string($conn, $v)."','".mysqli_real_escape_string($conn, strip_tags($_POST["paises_".$v], "<b><i><strong><em>"))."' ) ";
          $res = mysqli_query($conn,  $qry );
          if ( $res ) $MSG .= "Paises ".Mayus($v).": traducción creada correctamente<br />";

        }

        upload($_FILES);

        if ( $ok1 ) {
          $query = "UPDATE pesca_animales SET ani_foto = '".mysqli_real_escape_string($conn, $name1)."' WHERE ani_id = '".mysqli_real_escape_string($conn, $id)."'";
          $result = mysqli_query($conn, $query);
          if ( !$result ) $ERR .= "Error subiendo la foto!<br />".mysqli_error($conn);
          else $MSG .= "Foto subida correctamente!<br />";
        }
        if ( $ok2 ) {
          $query = "UPDATE pesca_animales SET ani_mapa = '".mysqli_real_escape_string($conn, $name2)."' WHERE ani_id = '".mysqli_real_escape_string($conn, $id)."'";
          $result = mysqli_query($conn, $query);
          if ( !$result ) $ERR .= "Error subiendo la imagen de mapa!<br />".mysqli_error($conn);
          else $MSG .= "Imagen de mapa subida correctamente!<br />";
        }

        $MSG .= "<br /><a href=\"animales.php\">Volver al listado de animales</a>";
        $MSG .= "<a style=\"float:right\" href=\"animales_edit.php?id=0\">Insertar nuevo registro</a>";
      }
    }
  }

  // Modo de trabajo: por defecto, nueva ficha
  $MODO = "add";

  if ( $id > 0 ) {
    $trads = "";
    foreach( $LANGS AS $k => $v ) {
      $trads .= ", ( SELECT value FROM pesca_textos WHERE referred = 'animales' AND referred_id = ani_id AND field = 'nombre' AND lang = '".$v."' ) AS tra_nombre_".$v." ";
      $trads .= ", ( SELECT value FROM pesca_textos WHERE referred = 'animales' AND referred_id = ani_id AND field = 'curiosidades' AND lang = '".$v."' ) AS tra_curiosidades_".$v." ";
      $trads .= ", ( SELECT value FROM pesca_textos WHERE referred = 'animales' AND referred_id = ani_id AND field = 'paises' AND lang = '".$v."' ) AS tra_paises_".$v." ";
    }

    $query = "SELECT * ".$trads." FROM pesca_animales WHERE ani_id = '".mysqli_real_escape_string($conn, $id)."'";
    $res = @mysqli_query($conn, $query);
    if(!$res)	{
      $ERR .= "No se ha podido conectar con la base de datos actual.<br />".$query;
    } else if ( @mysqli_num_rows($res) == 0 ) {
      $ERR .= "El animal indicado no existe.<br /><a href=\"animales.php\">Volver al listado de animales</a>";
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
        <li><a href="animales.php"><i class="<?=$icon_menu?>"></i> <?=$title_menu?></a></li>
        <li class="active"><i class="fa fa-pencil"></i> <?=($MODO == "add" ? "Añadir":"Editar")?> animal</li>
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
            <input type="hidden" name="old_foto" value="<?=$item["foto"]?>" />
            <input type="hidden" name="old_mapa" value="<?=$item["mapa"]?>" />

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
                  <label for="field-especie" class="control-label">Especie</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-sm-4">
                    <span class="input-group-addon"><i class="fa fa-object-group"></i></span>
                    <select class="form-control" id="field-especie" name="especie">
                    <?php
                      $q1 = "SELECT esp_id, esp_nombre FROM pesca_especies ORDER BY esp_orden";
                      $r1 = @mysqli_query($conn, $q1);
                      while ( $r1 && $rw1 = mysqli_fetch_assoc($r1) ) {
                    ?>
                      <option value="<?=$rw1["esp_id"]?>" <?php if ( $item["especie"] == $rw1["esp_id"] ) echo " selected"; ?>><?=$rw1["esp_nombre"]?></option>
                    <?php
                      }
                    ?>
                    </select>
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->
                

                <div class="form-group">
                  <label for="field-cientifico" class="control-label">Nombre cientfico</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-md-6">
                    <span class="input-group-addon"><i class="fa fa-language"></i></span>
                    <input type="text" class="form-control" id="field-cientifico" name="cientifico" maxlength="60" placeholder="##" value="<?=$item["cientifico"]?>">
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-tipoacuicultura" class="control-label">Tipo de acuicultura</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-sm-4">
                    <span class="input-group-addon"><i class="fa fa-universal-access"></i></span>
                    <select class="form-control" id="field-tipoacuicultura" name="tipoacuicultura">
                      <option value="M" <?php if ( $item["tipoacuicultura"] == "M" || $item["tipoacuicultura"] == "" ) echo " selected"; ?>>Acuicultura Marina</option>
                      <option value="C" <?php if ( $item["tipoacuicultura"] == "C" ) echo " selected"; ?>>Acuicultura Continental</option>
                    </select>
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->
                
                <div class="form-group">
                  <label for="field-foto" class="control-label">Foto</label> <small class="text-red">* obligatorio</small>

                  <?php if ( $item["foto"] != "" && file_exists($DIR_IMG.$item["foto"]) ) { ?>
                  <div style="margin-bottom: 10px;">
                    <img src="<?=$DIR_IMG.$item["foto"]?>" style="max-width: 100%" />
                  </div>
                  <?php } ?>

                  <div class="file-loading">
                    <input id="foto" name="foto" type="file" accept="image/*">
                  </div> Formato: JPG, PNG o SVG. Medidas: xxx pixels (ancho máximo) por xxx pixels (alto máximo)

                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-mapa" class="control-label">Imagen de mapa</label> <small class="text-red">* obligatorio</small>

                  <?php if ( $item["mapa"] != "" && file_exists($DIR_IMG.$item["mapa"]) ) { ?>
                  <div style="margin-bottom: 10px;">
                    <img src="<?=$DIR_IMG.$item["mapa"]?>" style="max-width: 100%" />
                  </div>
                  <?php } ?>

                  <div class="file-loading">
                    <input id="mapa" name="mapa" type="file" accept="image/*">
                  </div> Formato: JPG, PNG o GIF. Medidas: 240 pixels (ancho máximo) por 240 pixels (alto máximo)

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

                      <div class="form-group">
                        <label for="field-curiosidades-<?=$v?>" class="control-label">Curiosidades (<?=Mayus($v)?>)</label> <small class="text-red">* obligatorio</small>
                        <div class="input-group col-xs-11">
                          <textarea class="form-control textarea" id="field-curiosidades-<?=$v?>" name="curiosidades_<?=$v?>" rows="6" placeholder=""><?=$item["curiosidades_".$v]?></textarea>
                        </div>
                        <!-- /.input-group -->
                      </div>
                      <!-- /.form-group -->

                      <div class="form-group">
                        <label for="field-curiosidades-<?=$v?>" class="control-label">Países (<?=Mayus($v)?>)</label> <small class="text-red">* obligatorio</small>
                        <div class="input-group col-xs-11">
                          <textarea class="form-control textarea" id="field-paises-<?=$v?>" name="paises_<?=$v?>" rows="4" placeholder=""><?=$item["paises_".$v]?></textarea>
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
                  <button type="submit" class="btn btn-primary" id="Enviar"><?=( $MODO == "add" ? "Guardar nuevo animal":"Guardar cambios")?> <i class="fa fa-arrow-circle-right"></i></button> <a href="animales.php" class="btn btn-default pull-right"><i class="fa fa-arrow-circle-left"></i> Volver al listado</a>
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

    $("#foto").fileinput({
      overwriteInitial: true,
      maxFileSize: 3500,
      showClose: false,
      showCaption: false,
      showUpload: false,
      browseLabel: '<?=( $item["foto"] != "" ? "Cambiar":"Elegir")?> foto',
      removeLabel: '',
      browseIcon: '<i class="fa fa-folder-open"></i>',
      removeIcon: '<i class="fa fa-times"></i>',
      removeTitle: 'Cancelar cambios',
      msgErrorClass: 'alert alert-block alert-danger',
      defaultPreviewContent: '',
      allowedFileExtensions: ["jpg", "png", "svg"],
      previewFileType: "image",
    });

    $("#mapa").fileinput({
      overwriteInitial: true,
      maxFileSize: 3500,
      showClose: false,
      showCaption: false,
      showUpload: false,
      browseLabel: '<?=( $item["mapa"] != "" ? "Cambiar":"Elegir")?> imagen de mapa',
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
