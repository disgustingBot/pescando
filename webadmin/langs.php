<?php
  require_once ("inc.config.php");
  require_once("inc.checklogin.php");

  if ( !EsAdmin() ) {
    Header("Location: index.php");
    die();
  }

  $title_menutree = "Administración";
  $title_menu = "Idiomas";
  $page_title = $title_menutree." > ".$title_menu;
  $active_menutree = "admin";
  $active_menu = "admin-idiomas";
  $icon_menutree = "fa fa-hashtag";
  $icon_menu = "fa fa-language";

  require_once ("inc.head.php");

  if( isset($_POST["action"]) && $_POST["action"] == "delete" ) {
    if ( EsAdmin() ) {
      $info = explode("@", stripslashes($_POST["delete"]));
      $info[0] = intval($info[0]);
      $info[1] = stripslashes($info[1]);
      $query = "DELETE FROM pesca_langs WHERE lng_code='".mysqli_real_escape_string($conn, $info[0])."'";
      $re = @mysqli_query($conn, $query);
      if(!$re) {
        $ERR = "No se ha podido borrar el idioma '".$info[1]."'.<br />".mysqli_error($conn);
      } else {
        $MSG = "Idioma '".$info[1]."' borrado correctamente.";
      }
    } else {
      $ERR = "No tienes permisos para borrar idiomas!";
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
        <div class="col-md-11">
          <div class="box">

            <!--<div class="box-header">
            </div>-->
            <!-- /.box-header -->

            <div class="box-body">

              <h3 class="page-header">Listado de idiomas</h3>

              <!-- / form -->
              <form id="lista" action="<?=basename($_SERVER["PHP_SELF"])?>" method="post">
              <input type="hidden" name="action" value="delete" />
              <input type="hidden" id="to-delete" name="delete" value="" />
              <div class="table">
                <table id="main-list" class="table table-hover">
                  <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Código</th>
                    <th>Content-Type</th>
                    <th>ISO</th>
                    <th>Icono</th>
                    <th class="text-center">Orden</th>
                    <th>Estado</th>
                    <th>&nbsp;</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $q1 = "SELECT * FROM pesca_langs ORDER BY lng_orden, lng_title";
                    $r1 = @mysqli_query($conn, $q1);
                    if ( !$r1 || mysqli_num_rows($r1) == 0 ) {
                  ?>
                  <tr>
                    <td colspan="8">No hay idiomas dados de alta en el panel de control.</td>
                  </tr>
                  <?php
                    } else {
                      while ( $r1 && $rw1 = mysqli_fetch_assoc($r1) ) {
                        $lab = ($rw1["lng_status"] == 'A' ? "success":"danger");
                        $stat = ($rw1["lng_status"] == 'A' ? "Activo":"Inactivo");
                  ?>
                  <tr>
                    <td><a href="langs_edit.php?code=<?=$rw1["lng_code"]?>"><?=$rw1["lng_title"]?></a></td>
                    <td><?=$rw1["lng_code"]?></td>
                    <td><?=$rw1["lng_contenttype"]?></td>
                    <td><?=$rw1["lng_iso"]?></td>
                    <td>
                    <?php if ( $rw1["lng_flag"] != "" && file_exists($DIR_IMG.$rw1["lng_flag"]) ) { ?>
                      <img src="<?=$DIR_IMG.$rw1["lng_flag"]?>" style="width: 30px;" />
                    <?php } else echo "&nbsp;"; ?>
                    </td>
                    <td class="text-center"><?=$rw1["lng_orden"]?></td>
                    <td>
                      <span class="label label-<?=$lab?>"><?=$stat?></span>
                    </td>
                    <td>
                      <span class="pull-right-container">
                        <div class="pull-right">
                          <a href="langs_edit.php?code=<?=$rw1["lng_code"]?>" class="success"><i class="fa fa-pencil-square-o"></i></a>
                        <?php if ( EsAdmin() && $_SESSION["PESCA_ADMIN_USER"] == "pepito" ) { ?>
                          <a href="javascript:Borrar('<?=$rw1["lng_code"]?>','<?=$rw1["lng_title"]?>','<?=$rw1["lng_flag"]?>')"><i class="fa fa-trash-o"></i></a>
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
                    <a href="langs_edit.php?code=0"><i class="fa fa-plus"></i> Añadir nuevo idioma</a>
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
  if ( confirm("¿Seguro que desea borrar el idioma '"+titol+"'?") ) {
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

    //Flat orange color scheme for iCheck
    $('input[type="checkbox"].flat-item, input[type="radio"].flat-item').iCheck({
      checkboxClass: 'icheckbox_flat-orange',
      radioClass   : 'iradio_flat-orange'
    });

});
</script>

</body>
</html>