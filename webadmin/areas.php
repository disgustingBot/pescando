<?php
  require_once ("inc.config.php");
  require_once("inc.checklogin.php");

  if ( !EsAdmin() && !EsBasico() ) {
    Header("Location: index.php");
    die();
  }

  $title_menutree = "Líneas de Investigación";
  $title_menu = "Áreas de investigación";
  $page_title = $title_menutree." > ".$title_menu;
  $active_menutree = "futuro";
  $active_menu = "futuro-areas";
  $icon_menutree = "fa fa-search-plus";
  $icon_menu = "fa fa-search";

  require_once ("inc.head.php");

  if( isset($_POST["action"]) && $_POST["action"] == "delete" && $_POST["delete"] != "" ) {
    if ( EsAdmin() ) {
      $info = explode("@", stripslashes($_POST["delete"]));
      $info[0] = intval($info[0]);
      $info[1] = stripslashes($info[1]);
      $info[2] = trim($info[2]);
      $info[3] = trim($info[3]);

      $query = "DELETE FROM pesca_areas WHERE are_id='".mysqli_real_escape_string($conn, $info[0])."'";
      $re = @mysqli_query($conn, $query);
      if(!$re) {
        $ERR = "No se ha podido borrar la área de investigación '".$info[1]."'.<br />".mysqli_error($conn);
      } else {
        $MSG = "Área de investigación '".$info[1]."' borrada correctamente.";

        // Si hay ficheros, los borramos 
        if ( $info[2] != "" && file_exists($DIR_IMG.$info[2]) ) {
          $del = @unlink($DIR_IMG.$info[2]);
          if ( $del ) $MSG .= "<br />Imagen de fondo '".$info[2]."' borrada correctamente.";
          else $ERR .= "Fallo al intentar borrar la imagen de fondo '".$info[2]."' de la carpeta ".$DIR_IMG."<br />";
        }
        
        // Borramos las traducciones relacionadas
        $q2 = "DELETE FROM pesca_textos WHERE referred = 'areas' AND referred_id = '".mysqli_real_escape_string($conn, $info[0])."'";
        $r2 = @mysqli_query($conn, $q2);
        if ( !$r2 ) {
          $ERR .= "<br />No se han podido borrar las traducciones relacionadas con '".$info[1]."'.<br />";
        } else {
          $MSG .= "<br />Traducciones borradas correctamente.";
        }
      }
    } else {
      $ERR = "No tienes permisos para borrar áreas!";
    }
  }

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
        <li class="active"><i class="<?=$icon_menu?>"></i> <?=$title_menu?></li>
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
        <div class="col-md-12">
          <div class="box">

            <!--<div class="box-header">
            </div>-->
            <!-- /.box-header -->

            <div class="box-body">

              <h3 class="page-header">Listado de áreas de investigación</h3>

              <!-- / form -->
              <form id="lista" action="<?=basename($_SERVER["PHP_SELF"])?>" method="post">
              <input type="hidden" name="action" value="delete" />
              <input type="hidden" id="to-delete" name="delete" value="" />
              <div class="table-responsive">
                <table id="main-list" class="table no-margin table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nombre</th>
                    <th class="text-center">Imagen Fondo</th>
                    <th class="text-center">Video</th>
                    <?php
                      $td = 5;
                      foreach ( $LANGS as $k => $v ) {
                        $td++;
                    ?>
                    <th class="text-center"><?=Mayus($v)?></th>
                    <?php
                      }
                    ?>
                    <th class="text-center">Orden</th>
                    <th class="text-center">Estado</th>
                    <th>&nbsp;</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $q1 = "SELECT * ";
                    foreach ( $LANGS AS $k => $v ) {
                      $q1 .= ", ( SELECT count(*) FROM pesca_textos WHERE referred = 'areas' AND referred_id = are_id AND field IN ('nombre') AND lang = '".$v."' AND value != '' ) as ".$v;
                    }
                    $q1 .= " FROM pesca_areas ORDER BY are_orden";
                    $r1 = @mysqli_query($conn, $q1);
                    if ( !$r1 || mysqli_num_rows($r1) == 0 ) {
                  ?>
                  <tr>
                    <td colspan="<?=$td?>">No existen datos de ninguna área de investigación en la base de datos.<br /><?=$q1?></td>
                  </tr>
                  <?php
                    } else {
                      while ( $r1 && $rw1 = mysqli_fetch_assoc($r1) ) {
                  ?>
                  <tr>
                    <td style="vertical-align: middle;"><a href="areas_edit.php?id=<?=$rw1["are_id"]?>"><?=$rw1["are_nombre"]?></a></td>
                    <td style="vertical-align: middle;" class="text-center">
                    <?php
                      if ( $rw1["are_fondo"] != "" && file_exists($DIR_IMG.$rw1["are_fondo"]) ) {
                        echo "<img src='".$DIR_IMG.$rw1["are_fondo"]."' style='max-height: 200px; ' alt='Fondo ".$rw1["are_nombre"]."' title='Fondo ".$rw1["are_nombre"]."' border=0 />";
                      } else {
                        echo "- No disponible -";
                      }
                    ?>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                    <?php
                      if ( $rw1["are_video"] != "" ) {
                        echo $rw1["are_video"]." &nbsp; ";
                        if ( file_exists($DIR_VIDEOS.$rw1["are_video"]) ) {
                          echo " <a href=\"".$DIR_VIDEOS.$rw1["are_video"]."\" target=\"_blank\"><span class=\"fa fa-video-camera\" style=\"color: darkgreen;\"></span></a>";
                        } else {
                          echo " <span class=\"fa fa-video-camera\" style=\"color: darkred;\"></span>";
                        }                          
                      }
                    ?>
                    </td>
                    <?php foreach ( $LANGS AS $k => $v ) { ?>
                    <td class="text-center" style="vertical-align: middle;">
                    <?php   if ( $rw1[$v] > 0 ) { ?>
                      <span class="fa fa-1g fa-check" style="color: darkgreen"></span>
                    <?php   } else { ?>
                      <span class="fa fa-1g fa-times" style="color: red"></span>
                    <?php   } ?>
                    </td>
                    <?php } ?>
                    <td style="vertical-align: middle;" class="text-center"><?=$rw1["are_orden"]?></td>
                    <td style="vertical-align: middle;" class="text-center"><?=( $rw1["are_status"] == "A" ? "Activo" : "Inactivo" )?></td>
                    <td style="vertical-align: middle;">
                      <span class="pull-right-container">
                        <div class="pull-right">
                          <a href="areas_edit.php?id=<?=$rw1["are_id"]?>" class="success"><i class="fa fa-pencil-square-o"></i></a>
                        <?php if ( EsAdmin() ) { ?>
                          <a href="javascript:Borrar(<?=$rw1["are_id"]?>,'<?=$rw1["are_nombre"]?>','<?=$rw1["are_fondo"]."@".$rw1["are_video"]?>')"><i class="fa fa-trash-o"></i></a>
                        <?php } else { ?>
                          <span class="text-red" data-toggle="tooltip" title="No tienes permisos para borrar!"><i class="fa fa-trash-o"></i></span>
                        <?php } ?>
                        </div>
                      </span>
                    </td>
                  </tr>
                  <?php
                      }
                    }
                  ?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
              </form>
              <!-- / form -->

            </div>
            <!-- ./box-body -->

            <?php if ( EsAdmin() ) { ?>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-6 col-xs-6">
                    <a href="areas_edit.php?id=0"><i class="fa fa-plus"></i> Añadir nueva área de investigación</a>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 col-xs-6">
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
            <?php } ?>

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
function Borrar(id,titol,imag) {
  if ( confirm("¿Seguro que desea borrar la área de investigación '"+titol+"'?") ) {
    $('#to-delete').val(id+'@'+titol+'@'+imag);
    $('#lista').submit();
  }
}

$(document).ready(function() {

    $('#main-list').DataTable({
      "pageLength": 10,
      "ordering": false,
      "stateSave": true
    });

});
</script>

</body>
</html>