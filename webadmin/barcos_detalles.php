<?php
  require_once ("inc.config.php");
  require_once("inc.checklogin.php");

  if ( !EsAdmin() && !EsBasico() ) {
    Header("Location: index.php");
    die();
  }

  $title_menutree = "Barcos en detalle";
  $title_menu = "Los Barcos";
  $page_title = $title_menutree." > ".$title_menu;
  $active_menutree = "barcos";
  $active_menu = "barcos-videos";
  $icon_menutree = "fa fa-ship";
  $icon_menu = "fa fa-film";

  require_once ("inc.head.php");

  if( isset($_POST["action"]) && $_POST["action"] == "delete" && $_POST["delete"] != "" ) {
    if ( EsAdmin() ) {
      $info = explode("@", stripslashes($_POST["delete"]));
      $info[0] = intval($info[0]);
      $info[1] = stripslashes($info[1]);
      $info[2] = trim($info[2]);

      $query = "DELETE FROM pesca_barcos_detalles WHERE bde_id='".mysqli_real_escape_string($conn, $info[0])."'";
      $re = @mysqli_query($conn, $query);
      if(!$re) {
        $ERR = "No se ha podido borrar el barco '".$info[1]."'.<br />".mysqli_error($conn);
      } else {
        $MSG = "Barco '".$info[1]."' borrado correctamente.";

        /* Borramos las imágenes relacionadas */
        $q1 = "SELECT field, lang, value FROM pesca_textos WHERE referred = 'barcos-detalles' AND referred_id = '".mysqli_real_escape_string($conn2, $info[0])."' AND field IN ('imagen') ";
        $r1 = @mysqli_query($conn2, $q1);
        while ( $r1 && $row1 = @mysqli_fetch_assoc($r1) ) {
          if ( $row1["value"] != "" ) {
            $MSG .= "<br />-> Borrando fichero ".ucfirst($row1["field"])." (".Mayus($row1["lang"]).") -> ".$row1["value"];
            if ( file_exists($DIR_IMG.$row1["value"]) ) @unlink( $DIR_IMG.$row1["value"] );
          }
        }
        
        // Los medias relacionados, los borramos o se dejan?
        
      }
    } else {
      $ERR = "No tienes permisos para borrar barcos interactivos!";
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

              <h3 class="page-header">Listado de barcos en detalle</h3>

              <!-- / form -->
              <form id="lista" action="<?=basename($_SERVER["PHP_SELF"])?>" method="post">
              <input type="hidden" name="action" value="delete" />
              <input type="hidden" id="to-delete" name="delete" value="" />
              <div class="table-responsive">
                <table id="main-list" class="table no-margin table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nombre del barco</th>
                    <th class="text-center"># Vídeos</th>
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
                    $q1 = "SELECT * 
                      , ( select count(*) FROM pesca_videos WHERE vid_barco = bde_id ) as total ";
                    foreach ( $LANGS AS $k => $v ) {
                      $q1 .= ", ( SELECT count(*) FROM pesca_textos WHERE referred = 'barcos-detalles' AND referred_id = bde_id AND field IN ('imagen') AND lang = '".$v."' AND value != '' ) as ".$v;
                      $q1 .= ", ( SELECT count(*) FROM pesca_textos WHERE referred = 'barcos-detalles' AND referred_id = bde_id AND field IN ('imagen') AND lang = '".$v."' AND value != '' ) as ".$v;
                    }
                    $q1 .= " FROM pesca_barcos_detalles ORDER BY bde_orden";
                    $r1 = @mysqli_query($conn, $q1);
                    if ( !$r1 || mysqli_num_rows($r1) == 0 ) {
                  ?>
                  <tr>
                    <td colspan="<?=$td?>">No existen datos de ningún barco en detalle en la base de datos.<br /><?=$q1?></td>
                  </tr>
                  <?php
                    } else {
                      while ( $r1 && $rw1 = mysqli_fetch_assoc($r1) ) {
                  ?>
                  <tr>
                    <td style="vertical-align: middle;"><a href="barcos_detalles_edit.php?id=<?=$rw1["bde_id"]?>"><?=$rw1["bde_nombre"]?></a></td>
                    <td style="vertical-align: middle;" class="text-center"><?=intval($rw1["total"])?></td>
                    <?php foreach ( $LANGS AS $k => $v ) { ?>
                    <td class="text-center" style="vertical-align: middle;">
                    <?php   if ( $rw1[$v] > 0 ) { ?>
                      <span class="fa fa-1g fa-check" style="color: darkgreen"></span>
                    <?php   } else { ?>
                      <span class="fa fa-1g fa-times" style="color: red"></span>
                    <?php   } ?>
                    </td>
                    <?php } ?>
                    <td style="vertical-align: middle;" class="text-center"><?=$rw1["bde_orden"]?></td>
                    <td style="vertical-align: middle;" class="text-center"><?=( $rw1["bde_status"] == "A" ? "Activo" : "Inactivo" )?></td>
                    <td style="vertical-align: middle;">
                      <span class="pull-right-container">
                        <div class="pull-right">
                          <a href="barcos_detalles_edit.php?id=<?=$rw1["bde_id"]?>" class="success"><i class="fa fa-pencil-square-o"></i></a>
                        <?php if ( $rw1["total"] > 0 ) { ?>
                          <span class="text-red" data-toggle="tooltip" title="Aún existen videos de este barco!"><i class="fa fa-trash-o"></i></span>
                        <?php } else if ( EsAdmin() ) { ?>
                          <a href="javascript:Borrar(<?=$rw1["bde_id"]?>,'<?=$rw1["bde_nombre"]?>','')"><i class="fa fa-trash-o"></i></a>
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
                    <a href="barcos_detalles_edit.php?id=0"><i class="fa fa-plus"></i> Añadir nuevo barco en detalle</a>
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
  if ( confirm("¿Seguro que desea borrar el barco '"+titol+"'?") ) {
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