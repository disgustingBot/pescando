<?php
  require_once ("inc.config.php");
  require_once("inc.checklogin.php");

  if ( !EsAdmin() && !EsBasico() ) {
    Header("Location: index.php");
    die();
  }

  if ( $_POST ["action"] != ""  ) {
    $interactiu = intval($_POST["i"]);
    $id = $_POST["id"];
  } else {
    $interactiu = intval($_GET["i"]);
    $id = $_GET["id"];
  }

  if ( !isset($id) ) {
//    Header("Location: index.php");
    echo "NO ID";
    die();
  }


  if ( $interactiu == 1 ) {
    $tit = "Flotas y Caladeros";
    $icon = "dot-circle-o";
    $active_menutree = "flotas";
    $active_menu = "flotas-textos";
  } else if ( $interactiu == 2 ) {
    $tit = "Acuicultura";
    $icon = "map-o";
    $active_menutree = "acuicultura";
    $active_menu = "acuicultura-textos";
  } else if ( $interactiu == 3 ) {
    $tit = "Hidrófonos";
    $icon = "volume-up";
    $active_menutree = "hidrofonos";
    $active_menu = "hidrofonos-textos";
  } else if ( $interactiu == 4 ) {
    $tit = "Barcos";
    $icon = "ship";
    $active_menutree = "barcos";
    $active_menu = "barcos-textos";
  } else if ( $interactiu == 5 ) {
    $tit = "Líneas de investigación";
    $icon = "search-plus";
    $active_menutree = "futuro";
    $active_menu = "futuro-textos";
  } else {
    
echo "Interactiu: ".$i." - ".$_GET["i"];
    //Header("Location: index.php");
    die;
  }
  $page_title = $tit." > Configuración > Edición";

  if ( $_POST["action"] == "update" ) {
    $item = $_POST;

/*
 * CAMBIAR
 */

    if ( strlen($_POST["pantalla"]) == 0 || strlen($_POST["field"]) == 0 ) {
      $ERR = "Faltan campos requeridos";
    } else {

      foreach ( $LANGS AS $k => $v ) {

        if ( ExisteTraduccionLang( $interactiu, $_POST["pantalla"], $_POST["field"], $v ) ) {
          $qry = "
            UPDATE pesca_translates
            SET
              value='".mysqli_real_escape_string($conn, $_POST[$v])."'
            WHERE
              interactiu = '".mysqli_real_escape_string($conn, $interactiu)."'
              AND pantalla = '".mysqli_real_escape_string($conn, $_POST["pantalla"])."'
              AND field = '".mysqli_real_escape_string($conn, $_POST["field"])."'
              AND lang = '".mysqli_real_escape_string($conn, $v)."'";
          $res = mysqli_query($conn,  $qry );
          if ( $res ) $MSG .= Mayus($v).": traducción actualizada correctamente<br />";
        } else {
          $qry = "INSERT INTO pesca_translates VALUES ( '',
            '".mysqli_real_escape_string($conn, $interactiu)."',
            '".mysqli_real_escape_string($conn, $_POST["pantalla"])."',
            '".mysqli_real_escape_string($conn, $v)."',
            '".mysqli_real_escape_string($conn, $_POST["field"])."',
            '".mysqli_real_escape_string($conn, $_POST[$v])."' ) ";
          $res = mysqli_query($conn,  $qry );
          if ( $res ) $MSG .= Mayus($v).": traducción creada correctamente<br />";
        }
      }

      $MSG .= "<br /><a href=\"translation.php?i=".$interactiu."\">Volver al listado de elementos</a>";
      $MSG .= "<a style=\"float:right\" href=\"translation_edit.php?i=".$interactiu."&id=0\">Insertar nuevo registro</a>";
    }

  } else if ( $_POST["action"] == "insert" ) {

    if ( strlen($_POST["pantalla"]) == 0 || strlen($_POST["field"]) == 0 ) {
      $ERR = "Faltan campos requeridos";
    } else {

      foreach ( $LANGS AS $k => $v ) {

        if ( ExisteTraduccionLang( $interactiu, $_POST["pantalla"], $_POST["field"], $v ) ) {
          $qry = "UPDATE pesca_translates SET value='".mysqli_real_escape_string($conn, $_POST[$v])."' WHERE interactiu = '".mysqli_real_escape_string($conn, $interactiu)."' AND pantalla = '".mysqli_real_escape_string($conn, $_POST["pantalla"])."' AND field='".mysqli_real_escape_string($conn, $_POST["field"])."' AND lang = '".mysqli_real_escape_string($conn, $v)."'";
          $res = mysqli_query($conn,  $qry );
          if ( $res ) $MSG .= Mayus($v).": traducción actualizada correctamente<br />";
        } else {
          $qry = "INSERT INTO pesca_translates VALUES ( '', '".mysqli_real_escape_string($conn, $interactiu)."', '".mysqli_real_escape_string($conn, $_POST["pantalla"])."', '".mysqli_real_escape_string($conn, $v)."', '".mysqli_real_escape_string($conn, $_POST["field"])."', '".mysqli_real_escape_string($conn, $_POST[$v])."' ) ";
          $res = mysqli_query($conn,  $qry );
          $id = mysqli_insert_id($conn);
          if ( $res ) $MSG .= Mayus($v).": traducción creada correctamente<br />";
        }
      }

      $MSG .= "<br /><a href=\"translation.php?i=".$interactiu."\">Volver al listado de elementos</a>";
      $MSG .= "<a style=\"float:right\" href=\"translation_edit.php?i=".$interactiu."&id=0\">Insertar nuevo registro</a>";
    }
  }

  // Modo de trabajo: por defecto, nueva ficha
  $MODO = "add";

  if ( $id > 0 ) {
    $query = "SELECT interactiu, pantalla, field FROM pesca_translates WHERE id='".mysqli_real_escape_string($conn, $id)."'";
    $res = @mysqli_query($conn, $query);
    if(!$res)	{
      $ERR = "No se ha podido conectar con la base de datos actual.";
    } else if ( @mysqli_num_rows($res) == 0 ) {
      $ERR = "El elemento indicado no existe.<br /><a href=\"translation.php?i=".$interactiu."\">Volver al listado de elementos</a>";
      $id = 0;
    } else {

      $fila = @mysqli_fetch_assoc($res);
      foreach ( $fila as $k => $v ) {
        $item[$k] = stripslashes($v);
      }
      $MODO = "update";

      /* Traducciones */
      foreach ( $LANGS AS $k => $v ) {
        $val = mysqli_fetch_assoc(mysqli_query($conn, "SELECT value FROM pesca_translates WHERE interactiu = '".$item["interactiu"]."' AND pantalla = '".$item["pantalla"]."' AND field = '".$item["field"]."' AND lang='".$v."'"));
        $item[$v] = stripslashes($val["value"]);
      }
    }
  }

  require_once ("inc.head.php");
?>
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
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
        Traducciones
        <small><?=$tit?></small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-<?=$icon?>"></i> <?=$tit?></li>
        <li><a href="translation.php?i=<?=$interactiu?>"><i class="fa fa-file-text-o"></i> Traducciones</a></li>
        <li class="active"><i class="fa fa-pencil"></i> <?=($MODO == "add" ? "Añadir":"Editar")?> traducción</li>
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
            <input type="hidden" name="i" value="<?=$interactiu?>" />

              <!--<div class="box-header">
              </div>-->
              <!-- /.box-header -->

              <div class="box-body">

                <div class="form-group page-header">
                  <h3><?=($MODO == "add" ? "Añadir":"Editar")?> ficha de datos</h3>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-pantalla" class="control-label">Pantalla</label> <?php if ( $MODO == "add" ) { ?><small class="text-red">* obligatorio</small><?php } ?>
                  <div class="input-group col-md-3">
                    <span class="input-group-addon"><i class="fa fa-desktop"></i></span>
                    <input type="text" class="form-control" id="field-pantalla" name="pantalla" maxlength="20" placeholder="???" value="<?=$item["pantalla"]?>" <?=($MODO == "add" ? "":"disabled")?>>
                    <?php if ( $MODO != "add" ) { ?>
                    <input type="hidden" name="pantalla" value="<?=$item["pantalla"]?>" />
                    <?php } ?>
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label for="field-field" class="control-label">Campo</label> <?php if ( $MODO == "add" ) { ?><small class="text-red">* obligatorio</small><?php } ?>
                  <div class="input-group col-md-6">
                    <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                    <input type="text" class="form-control" id="field-field" name="field" maxlength="50" placeholder="???" value="<?=$item["field"]?>" <?=($MODO == "add" ? "":"disabled")?>>
                    <?php if ( $MODO != "add" ) { ?>
                    <input type="hidden" name="field" value="<?=$item["field"]?>" />
                    <?php } ?>
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
                        <label for="field-<?=$v?>" class="control-label">Contenido (<?=Mayus($v)?>)</label> <small class="text-red">* obligatorio</small>
                        <div class="input-group col-xs-11">
                          <textarea class="form-control textarea" id="field-<?=$v?>" name="<?=$v?>" rows="4" placeholder=""><?=$item[$v]?></textarea>
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
                  <button type="submit" class="btn btn-primary" id="Enviar"><?=( $MODO == "add" ? "Guardar elemento":"Guardar cambios")?> <i class="fa fa-arrow-circle-right"></i></button> <a href="translation.php?i=<?=$interactiu?>" class="btn btn-default pull-right"><i class="fa fa-arrow-circle-left"></i> Volver al listado</a>
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
<!-- Bootstrap WYSIHTML5 -->
<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {

    //bootstrap WYSIHTML5 - text editor
<?php if ( $interactiu != 10 ) { ?>
      $('.textarea').wysihtml5({useLineBreaks : true});
<?php } ?>

  })
</script>


</body>
</html>
