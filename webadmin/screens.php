<?php
  require_once ("inc.config.php");
  require_once("inc.checklogin.php");

  if ( !EsAdmin() ) {
    Header("Location: index.php");
    die();
  }

  $title_menutree = "Administración";
  $title_menu = "Interactivos en pantallas";
  $page_title = $title_menutree." > ".$title_menu;
  $active_menutree = "admin";
  $active_menu = "admin-screens";
  $icon_menutree = "fa fa-hashtag";
  $icon_menu = "fa fa-desktop";

  require_once ("inc.head.php");

  if( isset($_POST["action"]) && $_POST["action"] == "delete" && $_POST["delete"] != "" ) {
    if ( EsAdmin() ) {
      $info = explode("@", stripslashes($_POST["delete"]));
      $info[0] = intval($info[0]);
      $info[1] = stripslashes($info[1]);
      $query = "DELETE FROM pesca_screens WHERE scr_id='".mysqli_real_escape_string($conn, $info[0])."'";
      $re = @mysqli_query($conn, $query);
      if(!$re) {
        $ERR = "No se ha podido borrar la pantalla de interactivos '".$info[1]."'.<br />".mysqli_error($conn);
      } else {
        $MSG = "Pantalla de interactivos '".$info[1]."' eliminada correctamente.";
      }
    } else {
      $ERR = "No tienes permisos para borrar pantallas de interactivos!";
    }
  }
?>
    <meta http-equiv="refresh" content="300" />
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
        <div class="col-md-10">
          <div class="box">

            <!--<div class="box-header">
            </div>-->
            <!-- /.box-header -->

            <div class="box-body">

              <h3 class="page-header">Listado de interactivos en pantalla</h3>

              <!-- / form -->
              <form id="lista" action="<?=basename($_SERVER["PHP_SELF"])?>" method="post">
              <input type="hidden" name="action" value="delete" />
              <input type="hidden" id="to-delete" name="delete" value="" />
              <div class="table-responsive">
                <table id="main-list" class="table no-margin table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Pantalla</th>
                    <th>IP</th>
                    <th>Redirige a</th>
                    <th>Última actividad</th>
                    <th>Pulsera activa</th>
                    <th>&nbsp;</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $q1 = "SELECT scr_id, scr_titulo, scr_url, scr_ip, scr_pulsera, scr_last_active ";
                    $q1 .= " FROM pesca_screens ORDER BY scr_last_active DESC, scr_titulo";
                    $r1 = @mysqli_query($conn, $q1);
                    if ( !$r1 || mysqli_num_rows($r1) == 0 ) {
                  ?>
                  <tr>
                    <td colspan="6">No existen datos de ningún interactivo en la base de datos.</td>
                  </tr>
                  <?php
                    } else {
                      while ( $r1 && $rw1 = mysqli_fetch_assoc($r1) ) {
                        if ( $rw1["scr_last_active"] != "" ) {
                          $last = GeneraData($rw1["scr_last_active"],14);
                          $col = "";
                        } else {
                          "- Nunca -";
                          $col = "red";
                        }
                  ?>
                  <tr>
                    <td><a href="screens_edit.php?id=<?=$rw1["scr_id"]?>"><?=$rw1["scr_titulo"]?></a></td>
                    <td><?=$rw1["scr_ip"]?></td>
                    <td><?=$rw1["scr_url"]?></td>
                    <td><?=$last?></td>
                    <td>
                      <?php if ( $rw1["scr_pulsera"] != "" ) { ?>
                      <a href="visitantes_info.php?id=<?=$rw1["scr_pulsera"]?>"><?=$rw1["scr_pulsera"]?></a>
                      <?php } else { ?>
                      Disponible
                      <?php } ?>
                    </td>
                    <td>
                      <span class="pull-right-container">
                        <div class="pull-right">
                        <?php if ( EsAdmin() ) { ?>
                          <a href="screens_edit.php?id=<?=$rw1["scr_id"]?>" class="success"><i class="fa fa-pencil-square-o"></i></a>
                          <a href="javascript:Borrar(<?=$rw1["scr_id"]?>,'<?=$rw1["scr_titulo"]?>','')"><i class="fa fa-trash-o"></i></a>
                        <?php } else { ?>
                          <span class="text-red"><i class="fa fa-pencil-square-o"></i></span>
                          <span class="text-red"><i class="fa fa-trash-o"></i></span>
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
                  <a href="screens_edit.php?id=0"><i class="fa fa-plus"></i> Añadir nuevo interactivo en pantalla</a>
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
  if ( confirm("¿Seguro que desea borrar la asignación de la pantalla '"+titol+"'?") ) {
    $('#to-delete').val(id+'@'+titol+'@'+imag);
    $('#lista').submit();
  }
}

$(document).ready(function() {

    $('#main-list').DataTable({
      "pageLength": 50,
      "ordering": false,
      "stateSave": true
    });

    //Flat orange color scheme for iCheck
    $('input[type="checkbox"].flat-item, input[type="radio"].flat-item').iCheck({
      checkboxClass: 'icheckbox_flat-orange',
      radioClass   : 'iradio_flat-orange'
    });

});
</script>

</body>
</html>