<?php
  require_once ("inc.config.php");
  require_once("inc.checklogin.php");

  $page_title = "Panel de control";
  $active_menu = "principal";

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
        Estado actual
        <small>Resumen</small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-home"></i> Principal</li>
      </ol>
    </section>

<?php

  // General Data
  $val = @mysqli_fetch_assoc(@mysqli_query($conn, "SELECT count(*) AS total FROM pesca_barcos WHERE bar_status = 'A'"));
  $GENERAL["total_barcos"] = intval($val["total"]);
  //$GENERAL["total_barcos"] = $val["total"];

  $val = @mysqli_fetch_assoc(@mysqli_query($conn, "SELECT count(*) AS total FROM pesca_sonidos WHERE son_status = 'A'"));
  $GENERAL["total_sonidos"] = $val["total"];

  $val = @mysqli_fetch_assoc(@mysqli_query($conn, "SELECT count(*) AS total FROM pesca_animales WHERE ani_status = 'A'"));
  $GENERAL["total_animales"] = $val["total"];

  $val = @mysqli_fetch_assoc(@mysqli_query($conn, "SELECT count(*) AS total FROM pesca_pulseras WHERE pul_tipo NOT IN ('Especial','Empleado') AND pul_productName != '' "));
  $GENERAL["total_visitantes"] = 0;
  //$GENERAL["total_visitantes"] = $val["total"];
    
  $_SESSION["GENERAL"] = $GENERAL;
?>

    <!-- Main content -->
    <section class="content container-fluid">

      <!-- Small boxes (Stat box) -->
      <div class="row">

        <div class="col-lg-12 col-md-12">
          
          <div class="row">
            <div class="col-lg-3 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-libres">
                <div class="inner">
                  <h3><?=$GENERAL["total_barcos"]?></h3>

                  <h4>Barcos</h4>
                </div>
                <div class="icon">
                  <i class="fa fa-ship"></i>
                </div>
                <a href="barcos.php" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-guiadas">
                <div class="inner">
                  <h3><?=$GENERAL["total_animales"]?></h3>

                  <h4>Animales</h4>
                </div>
                <div class="icon">
                  <i class="fa fa-picture-o"></i>
                </div>
                <a href="animales.php" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-visitantes">
                <div class="inner">
                  <h3><?=$GENERAL["total_sonidos"]?></h3>

                  <h4>Sonidos</h4>
                </div>
                <div class="icon">
                  <i class="fa fa-volume-up"></i>
                </div>
                <a href="sonidos.php" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          
            <div class="col-lg-3 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-visitantes">
                <div class="inner">
                  <h3><?=$GENERAL["total_visitantes"]?></h3>

                  <h4>Visitantes (acumulado)</h4>
                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>
                <a href="" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            
          </div>

        </div>

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
$(document).ready(function() {

});
</script>

</body>
</html>