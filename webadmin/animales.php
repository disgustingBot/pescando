<?php
  require_once ("inc.config.php");
  require_once("inc.checklogin.php");

  if ( !EsAdmin() && !EsBasico() ) {
    Header("Location: index.php");
    die();
  }

  $title_menutree = "Acuicultura";
  $title_menu = "Los animales";
  $page_title = $title_menutree." > ".$title_menu;
  $active_menutree = "acuicultura";
  $active_menu = "acuicultura-animales";
  $icon_menutree = "fa fa-align-center";
  $icon_menu = "fa fa-picture-o";

  require_once ("inc.head.php");

  if( isset($_POST["action"]) && $_POST["action"] == "delete" && $_POST["delete"] != "" ) {
    if ( EsAdmin() ) {
      $info = explode("@", stripslashes($_POST["delete"]));
      $info[0] = intval($info[0]);
      $info[1] = stripslashes($info[1]);
      $info[2] = trim($info[2]);
      $info[3] = trim($info[3]);

      $query = "DELETE FROM pesca_animales WHERE ani_id='".mysqli_real_escape_string($conn, $info[0])."'";
      $re = @mysqli_query($conn, $query);
      if(!$re) {
        $ERR = "No se ha podido borrar el animal '".$info[1]."'.<br />".mysqli_error($conn);
      } else {
        $MSG = "Animal '".$info[1]."' borrado correctamente.";

        // Si hay ficheros, los borramos 
        if ( $info[2] != "" && file_exists($DIR_IMG.$info[2]) ) {
          $del = @unlink($DIR_IMG.$info[2]);
          if ( $del ) $MSG .= "<br />Foto '".$info[2]."' borrada correctamente.";
          else $ERR .= "Fallo al intentar borrar la foto '".$info[2]."' de la carpeta ".$DIR_IMG."<br />";
        }
        if ( $info[3] != "" && file_exists($DIR_IMG.$info[3]) ) {
          $del = @unlink($DIR_IMG.$info[3]);
          if ( $del ) $MSG .= "<br />Mapa '".$info[3]."' borrado correctamente.";
          else $ERR .= "Fallo al intentar borrar el mapa '".$info[3]."' de la carpeta ".$DIR_IMG."<br />";
        }
        
        // Borramos las traducciones relacionadas
        $q2 = "DELETE FROM pesca_textos WHERE referred = 'animales' AND referred_id = '".mysqli_real_escape_string($conn, $info[0])."'";
        $r2 = @mysqli_query($conn, $q2);
        if ( !$r2 ) {
          $ERR .= "<br />No se han podido borrar las traducciones relacionadas con '".$info[1]."'.<br />".mysqli_error($conn);
        } else {
          $MSG .= "<br />Traducciones borradas correctamente.";
        }
      }
    } else {
      $ERR = "No tienes permisos para borrar animales!";
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

              <h3 class="page-header">Listado de animales</h3>

              <!-- / form -->
              <form id="lista" action="<?=basename($_SERVER["PHP_SELF"])?>" method="post">
              <input type="hidden" name="action" value="delete" />
              <input type="hidden" id="to-delete" name="delete" value="" />
              <div class="table-responsive">
                <table id="main-list" class="table no-margin table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nombre</th>
                    <th class="text-center">Especie</th>
                    <th class="text-center">Tipo Acuicultura</th>
                    <th class="text-center">Foto</th>
                    <th class="text-center">Mapa</th>
                    <?php
                      $td = 7;
                      foreach ( $LANGS as $k => $v ) {
                        $td++;
                    ?>
                    <th class="text-center"><?=Mayus($v)?></th>
                    <?php
                      }
                    ?>
                    <th class="text-center">Estado</th>
                    <th>&nbsp;</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $q1 = "SELECT * ";
                    foreach ( $LANGS AS $k => $v ) {
                      $q1 .= ", ( SELECT count(*) FROM pesca_textos WHERE referred = 'animales' AND referred_id = ani_id AND field IN ('nombre','curiosidades','paises') AND lang = '".$v."' AND value != '' ) as ".$v;
                    }
                    $q1 .= " FROM pesca_animales LEFT JOIN pesca_especies ON esp_id = ani_especie ORDER BY esp_orden, ani_nombre";
                    $r1 = @mysqli_query($conn, $q1);
                    if ( !$r1 || mysqli_num_rows($r1) == 0 ) {
                  ?>
                  <tr>
                    <td colspan="<?=$td?>">No existen datos de ningún animal en la base de datos.<br /><?=$q1?></td>
                  </tr>
                  <?php
                    } else {
                      while ( $r1 && $rw1 = mysqli_fetch_assoc($r1) ) {
                  ?>
                  <tr>
                    <td style="vertical-align: middle;"><a href="animales_edit.php?id=<?=$rw1["ani_id"]?>"><?=$rw1["ani_nombre"]?></a></td>
                    <td style="vertical-align: middle;" class="text-center"><?=$rw1["esp_nombre"]?></td>
                    <td style="vertical-align: middle;" class="text-center"><?=( $rw1["ani_tipoacuicultura"] == "M" ? "Acuicultura marina" : "Acuicultura continental" )?></td>
                    <td style="vertical-align: middle;" class="text-center">
                    <?php
                      if ( $rw1["ani_foto"] != "" && file_exists($DIR_IMG.$rw1["ani_foto"]) ) {
                        echo "<img src='".$DIR_IMG.$rw1["ani_foto"]."' style='max-height: 100px; ' alt='Foto ".$rw1["ani_nombre"]."' title='Foto ".$rw1["ani_nombre"]."' border=0 />";
                      } else {
                        echo "- No disponible -";
                      }
                    ?>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                    <?php
                      if ( $rw1["ani_mapa"] != "" && file_exists($DIR_IMG.$rw1["ani_mapa"]) ) {
                        echo "<img src='".$DIR_IMG.$rw1["ani_mapa"]."' style='max-height: 100px; ' alt='Mapa ".$rw1["ani_nombre"]."' title='Mapa ".$rw1["ani_nombre"]."' border=0 />";
                      } else {
                        echo "- No disponible -";
                      }
                    ?>
                    </td>
                    <?php foreach ( $LANGS AS $k => $v ) { ?>
                    <td class="text-center" style="vertical-align: middle;">
                    <?php   if ( $rw1[$v] > 2 ) { ?>
                      <span class="fa fa-1g fa-check" style="color: darkgreen"></span>
                    <?php   } else { ?>
                      <span class="fa fa-1g fa-times" style="color: red"></span>
                    <?php   } ?>
                    </td>
                    <?php } ?>
                    <td style="vertical-align: middle;" class="text-center"><?=( $rw1["ani_status"] == "A" ? "Activo" : "Inactivo" )?></td>
                    <td style="vertical-align: middle;">
                      <span class="pull-right-container">
                        <div class="pull-right">
                          <a href="animales_edit.php?id=<?=$rw1["ani_id"]?>" class="success"><i class="fa fa-pencil-square-o"></i></a>
                        <?php if ( EsAdmin() ) { ?>
                          <a href="javascript:Borrar(<?=$rw1["ani_id"]?>,'<?=$rw1["ani_nombre"]?>','<?=$rw1["ani_foto"]."@".$rw1["ani_mapa"]?>')"><i class="fa fa-trash-o"></i></a>
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
                    <a href="animales_edit.php?id=0"><i class="fa fa-plus"></i> Añadir nuevo animal</a>
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
  if ( confirm("¿Seguro que desea borrar el animal '"+titol+"'?") ) {
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