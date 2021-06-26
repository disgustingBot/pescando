<?php
  require_once ("inc.config.php");
  require_once("inc.checklogin.php");

  $title_menutree = "Administración";
  $title_menu = ( EsAdmin() ? "Usuarios del panel":"Perfil del usuario");
  $page_title = $title_menutree." > ".$title_menu;
  $active_menutree = "admin";
  $active_menu = "admin-usuarios";
  $icon_menutree = "fa fa-hashtag";
  $icon_menu = "fa fa-id-badge";

  require_once ("inc.head.php");

  if( isset($_POST["action"]) && $_POST["action"] == "delete" && $_POST["delete"] != "" ) {
    if ( EsAdmin() ) {
      $info = explode("@", stripslashes($_POST["delete"]));
      $info[0] = intval($info[0]);
      $info[1] = stripslashes($info[1]);
      $query = "DELETE FROM pesca_adminusers WHERE adm_id='".mysqli_real_escape_string($conn, $info[0])."'";
      $re = @mysqli_query($conn, $query);
      if(!$re) {
        $ERR = "No se ha podido borrar al usuario '".$info[1]."'.<br />".mysqli_error($conn);
      } else {
        $MSG = "Usuario '".$info[1]."' borrado correctamente.";
        // Borramos también todos los logs de acceso de ese usuario
        $re2 = @mysqli_query($conn, "DELETE FROM pesca_adminusers_logs WHERE log_userid = '".$info[0]."'");
        if ( !$re2 ) $ERR = "No se han podido borrar sus registros de actividad.<br />";
        else $MSG .= "<br />Los registros de actividad del usuario también han sido borrados.";
       // Si hay imagen, la borramos (avatar)
        if ( $info[2] != "" && file_exists($DIR_IMG.$info[2]) ) {
            $del = @unlink($DIR_IMG.$info[2]);
            if ( $del ) $MSG .= "<br />Imagen '".$info[2]."' borrada correctamente.";
            else $ERR .= "Fallo al intentar borrar la imagen '".$info[2]."' de la carpeta ".$DIR_IMG."<br />";
        }
      }
    } else {
      $ERR = "No tienes permisos para borrar usuarios!";
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

              <h3 class="page-header"><?=( EsAdmin() ? "Listado de usuarios del panel":"Perfil del usuario")?></h3>

              <!-- / form -->
              <form id="lista" action="<?=basename($_SERVER["PHP_SELF"])?>" method="post">
              <input type="hidden" name="action" value="delete" />
              <input type="hidden" id="to-delete" name="delete" value="" />
              <div class="table">
                <table id="main-list" class="table table-hover">
                  <thead>
                  <tr>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Avatar</th>
                    <th>Fecha alta</th>
                    <th>Último acceso</th>
                    <th>Estado</th>
                    <th>&nbsp;</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    if ( EsAdmin() ) {
                      $q1 = "SELECT *, (SELECT MAX(log_moment) FROM pesca_adminusers_logs WHERE log_userid = adm_id AND log_action = 'login') as last_login FROM pesca_adminusers ORDER BY adm_username";
                    } else {
                      $q1 = "SELECT *, (SELECT MAX(log_moment) FROM pesca_adminusers_logs WHERE log_userid = adm_id AND log_action = 'login') as last_login FROM pesca_adminusers WHERE adm_id = '".$_SESSION["PESCA_ADMIN_ID"]."' ORDER BY adm_username";
                    }
                    $r1 = @mysqli_query($conn, $q1);
                    if ( !$r1 || mysqli_num_rows($r1) == 0 ) {
                  ?>
                  <tr>
                    <td colspan="8">No hay usuarios dados de alta en el panel de control. ¡ESO ES IMPOSIBLE!</td>
                  </tr>
                  <?php
                    } else {
                      while ( $r1 && $rw1 = mysqli_fetch_assoc($r1) ) {
                        $lab = ($rw1["adm_status"] == 'A' ? "success":"danger");
                        $stat = ($rw1["adm_status"] == 'A' ? "Activo":"Inactivo");
                        $alta = GeneraData($rw1["adm_created"],8);
                        if ($rw1["last_login"] == NULL ) {
                          $last = "Nunca";
                        } else {
                          $last = GeneraData($rw1["last_login"],12);
                          $q9 = "SELECT log_moment FROM pesca_adminusers_logs WHERE log_userid = '".$rw1["adm_id"]."' AND log_action = 'login' ORDER BY log_moment DESC LIMIT 0,5";
                          $r9 = mysqli_query($conn, $q9);
                          $last_logins = "";
                          while ( $r9 && $rw9 = mysqli_fetch_assoc($r9) ) {
                            $last_logins .= "".GeneraData($rw9["log_moment"],12)."<br />";
                          }
                        }
                  ?>
                  <tr>
                    <td><a href="adminusers_edit.php?id=<?=$rw1["adm_id"]?>"><?=$rw1["adm_username"]?></a></td>
                    <td><?=stripslashes($rw1["adm_name"])?></td>
                    <td><?=ucwords($rw1["adm_type"])?></td>
                    <td>
                    <?php if ( $rw1["adm_avatar"] != "" && file_exists($DIR_IMG.$rw1["adm_avatar"]) ) { ?>
                    <img src="<?=$DIR_IMG.$rw1["adm_avatar"]?>" class="img-circle" alt="<?=$rw1["adm_name"]?>" title="<?=$rw1["adm_name"]?>" style="width: 30px;">
                    <?php } else { ?>
                    <img src="<?=$DIR_IMG?>avatar-200x200.png" class="img-circle" alt="<?=$rw1["adm_nameE"]?>" title="<?=$rw1["adm_name"]?>" style="width: 30px;">
                    <?php } ?>
                    </td>
                    <td><?=$alta?></td>
                    <td>
                      <?=$last?> 
                      <?php if ( $rw1["last_login"] != NULL ) { ?>
                        <span class="fa fa-question-circle-o" data-toggle="popover" data-content="<span style=font-size:13px;><?=$last_logins?></span>"></span>
                      <?php } ?>
                    </td>
                    <td>
                      <span class="label label-<?=$lab?>"><?=$stat?></span>
                    </td>
                    <td>
                      <span class="pull-right-container">
                        <div class="pull-right">
                        <?php if ( EsAdmin() || $_SESSION["PESCA_ADMIN_ID"] == $rw1["adm_id"] ) { ?>
                          <a href="adminusers_edit.php?id=<?=$rw1["adm_id"]?>" class="success"><i class="fa fa-pencil-square-o"></i></a>
                        <?php } else { ?>
                          <span class="text-red" data-toggle="tooltip" title="No tienes permisos para editar!"><i class="fa fa-pencil-square-o"></i></span>
                        <?php } ?>
                        <?php if ( EsAdmin() && $_SESSION["PESCA_ADMIN_ID"] != $rw1["adm_id"] ) { ?>
                          <a href="javascript:Borrar(<?=$rw1["adm_id"]?>,'<?=$rw1["adm_username"]?>','<?=$rw1["adm_avatar"]?>')"><i class="fa fa-trash-o"></i></a>
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
                    <a href="adminusers_edit.php?id=0"><i class="fa fa-user-plus"></i> Añadir nuevo usuario</a>
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
  if ( confirm("¿Seguro que desea borrar al usuario '"+titol+"'?") ) {
    $('#to-delete').val(id+'@'+titol+'@'+imag);
    $('#lista').submit();
  } else {
    alert('¡Uuuuf! ¡Lo dejo como está!');
  }
}

$(document).ready(function() {

    $(".delete_class").click(function(){
      var del_id = $(this).attr('data-id');
      var del_name = $(this).attr('data-name');
      if ( confirm("¿Seguro que desea borrar al usuario '"+del_name+"'?") ) {
        $('#to-delete').val(del_id+'@'+del_name);
        $('#lista').submit();
      } else {
        alert('¡Uuuuf! ¡Lo dejo como está!');
      }
    });

    $('#main-list').DataTable({
      "pageLength": 10,
      "ordering": false,
      "stateSave": true
    });
  
    $('[data-toggle="popover"]').popover({ 
      'html': true,
      'placement': 'top',
      'trigger': 'hover',
      'title': 'Últimos 5 accesos'          
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