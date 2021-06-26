<?php
  require_once ("inc.config.php");
  require_once("inc.checklogin.php");

  if ( !EsAdmin() ) {
    Header("Location: index.php");
    die();
  }

  $page_title = "Config interactivos > Timeouts de interactivos";
  $active_menutree = "config";
  $active_menu = "config-timeouts";

  if ( $_POST["action"] == "update" ) {

    if ( !EsAdmin() ) {
      $ERR = "No tienes permisos para editar este elemento";
    } else if (   strlen($_POST["timeout_int01"]) == 0 
               || strlen($_POST["timeout_int02"]) == 0 
               || strlen($_POST["timeout_int03"]) == 0 
               || strlen($_POST["timeout_int04"]) == 0 
               || strlen($_POST["timeout_int05"]) == 0 ) {
      $ERR = "Faltan campos requeridos";
    } else {

      $query = "UPDATE pesca_master SET ";
      $query .= "timeout_int01 = '".mysqli_real_escape_string($conn, $_POST["timeout_int01"])."', ";
      $query .= "timeout_int02 = '".mysqli_real_escape_string($conn, $_POST["timeout_int02"])."', ";
      $query .= "timeout_int03 = '".mysqli_real_escape_string($conn, $_POST["timeout_int03"])."', ";
      $query .= "timeout_int04 = '".mysqli_real_escape_string($conn, $_POST["timeout_int04"])."', ";
      $query .= "timeout_int05 = '".mysqli_real_escape_string($conn, $_POST["timeout_int05"])."' ";
      $query .= " WHERE Id ='1'";
      $res = @mysqli_query($conn, $query);
      if(!$res) {
        $ERR = "No se ha podido guardar la info en la base de datos actual. <br />".mysqli_error($conn);
      } else {
        $MSG = "Timeouts actualizados correctamente!<br />";

        $MSG .= "<br /><a href=\"index.php\">Volver al menú principal</a>";
      }
    }
  }

  // Modo de trabajo: por defecto, nueva ficha
  $MODO = "update";

  $query = "SELECT * ";
  $query .= " FROM pesca_master LIMIT 0,1";
  $res = @mysqli_query($conn, $query);
  if(!$res)	{
    $ERR = "No se ha podido conectar con la base de datos actual.";
  } else if ( @mysqli_num_rows($res) == 0 ) {
    $ERR = "Los datos solicitados no existen.<br /><a href=\"index.php\">Volver al menú principal</a>";
  } else {

    $fila = @mysqli_fetch_assoc($res);
    foreach ( $fila as $k => $v ) {
      $item[$k] = stripslashes($v);
    }
  }

  require_once ("inc.head.php");
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
        Timeouts de interactivos
        <small>Config interactivos</small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-cogs"></i> Config interactivos</li>
        <li class="active"><i class="fa fa-clock-o"></i> Editar timeouts</li>
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
        <div class="col-lg-8 col-md-10">
          <div class="box">

            <!-- / form -->
            <form action="<?=basename($_SERVER["PHP_SELF"])?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="update" />

              <!--<div class="box-header">
              </div>-->
              <!-- /.box-header -->

              <div class="box-body">

                <div class="form-group page-header">
                  <h3>¿Qué son los timeouts?</h3>
                  <div style="font-size: 14px;">
                    Los <i>timeouts</i> son contadores de tiempos máximos, para esperas o de inactividad, colocados en los interactivos.<br />
                    Por ejemplo, los tiempos de inactividad tras los que llevamos al visitante al salvapantallas de un interactivo.<br />
                    Se cuentan <u>por segundos</u>.
                  </div>
                </div>
                <!-- /.form-group -->
              
                <div class="row"></div>
              
                <div class="form-group page-header">
                  <h3>Timeouts de los Interactivos (pasar al salvapantallas)</h3>
                </div>

                <div class="form-group col-md-4">
                  <label for="field-timeout_int01" class="control-label">Flota y caladeros</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-md-10">
                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    <input type="text" class="form-control" id="field-timeout_int01" name="timeout_int01" maxlength="4" style="width: 70px" placeholder="###" value="<?=$item["timeout_int01"]?>">
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group col-md-4">
                  <label for="field-timeout_int02" class="control-label">Acuicultura</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-md-10">
                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    <input type="text" class="form-control" id="field-timeout_int02" name="timeout_int02" maxlength="4" style="width: 70px" placeholder="###" value="<?=$item["timeout_int02"]?>">
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group col-md-4">
                  <label for="field-timeout_int03" class="control-label">Hidrófonos</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-md-10">
                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    <input type="text" class="form-control" id="field-timeout_int03" name="timeout_int03" maxlength="4" style="width: 70px" placeholder="###" value="<?=$item["timeout_int03"]?>">
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group col-md-4">
                  <label for="field-timeout_int04" class="control-label">Barcos</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-md-10">
                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    <input type="text" class="form-control" id="field-timeout_int04" name="timeout_int04" maxlength="4" style="width: 70px" placeholder="###" value="<?=$item["timeout_int04"]?>">
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="form-group col-md-4">
                  <label for="field-timeout_int05" class="control-label">Líneas investigación</label> <small class="text-red">* obligatorio</small>
                  <div class="input-group col-md-10">
                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    <input type="text" class="form-control" id="field-timeout_int05" name="timeout_int05" maxlength="4" style="width: 70px" placeholder="###" value="<?=$item["timeout_int05"]?>">
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                <div class="row"></div>
              
                <div class="form-group">
                  <button type="submit" class="btn btn-primary" id="Enviar">Guardar cambios <i class="fa fa-arrow-circle-right"></i></button> <a href="index.php" class="btn btn-default pull-right"><i class="fa fa-arrow-circle-left"></i> Volver al menú principal</a>
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
<script>
  $(function () {
    
  })

</script>


</body>
</html>
