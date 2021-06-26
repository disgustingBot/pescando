<?php
  require_once ("inc.config.php");
  require_once("inc.checklogin.php");

  if ( !EsAdmin() && !EsBasico() ) {
    Header("Location: index.php");
    die();
  }

  if ( $_POST ["action"] != ""  ) {
    $interactiu = intval($_POST["i"]);
  } else {
    $interactiu = intval($_GET["i"]);
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
    Header("Location: index.php");
    die;
  }
  $page_title = $tit." - Configuración";

  require_once ("inc.head.php");

  if( isset($_POST["action"]) && $_POST["action"] == "delete" ) {
    if ( EsAdmin() ) {
      $info = explode("@", stripslashes($_POST["delete"]));
      $info[0] = stripslashes($info[0]);
      $info[1] = stripslashes($info[1]);
      $query = "DELETE FROM pesca_translates WHERE interactiu = '".mysqli_real_escape_string($conn,$interactiu)."' AND pantalla = '".mysqli_real_escape_string($conn, $info[0])."' AND field = '".mysqli_real_escape_string($conn, $info[1])."'";
      $re = @mysqli_query($conn, $query);
      if(!$re) {
        $ERR = "No se ha podido borrar el elemento 'Pantalla ".$info[0]." > ".$info[1]."' de este interactivo.<br />".mysqli_error($conn);
      } else {
        $MSG = "Elemento 'Pantalla ".$info[0]." > ".$info[1]."' borrado correctamente.";
      }
    } else {
      $ERR = "No tienes permisos para borrar elementos!!";
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
        Traducciones básicas
        <small><?=$tit?></small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-<?=$icon?>"></i> <?=$tit?></li>
        <li class="active"><i class="fa fa-file-text-o"></i> Traducciones</li>
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

              <h3 class="page-header">Listado de traducciones</h3>

              <!-- / form -->
              <form id="lista" action="<?=basename($_SERVER["PHP_SELF"])?>" method="post">
              <input type="hidden" name="action" value="delete" />
              <input type="hidden" id="to-delete" name="delete" value="" />
              <input type="hidden" name="i" value="<?=$interactiu?>" />
              <div class="table-responsive">
                <table id="main-list" class="table no-margin table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Pantalla</th>
                    <th>Elemento</th>
                    <?php
                      $td = 3;
                      foreach ( $LANGS as $k => $v ) {
                        $td++;
                    ?>
                    <th class="text-center"><?=Mayus($v)?></th>
                    <?php
                      }
                    ?>
                    <th>&nbsp;</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $q1 = "SELECT t.id, t.interactiu, t.pantalla, t.field ";
                    $i = 0;
                    foreach ( $LANGS AS $k => $v ) {
                      $i++;
                      $q1 .= ", ( SELECT t$i.value FROM pesca_translates t$i WHERE t.interactiu = t$i.interactiu AND t.pantalla = t$i.pantalla AND t.field = t$i.field AND t$i.lang = '".$v."') as ".$v;
                    }
                    $q1 .= " FROM pesca_translates t WHERE t.interactiu = '".$interactiu."' GROUP BY t.pantalla, t.field ORDER BY t.pantalla, t.field";
                    $r1 = @mysqli_query($conn, $q1);
                    if ( !$r1 || mysqli_num_rows($r1) == 0 ) {
                  ?>
                  <tr>
                    <td colspan="<?=$td?>">No hay elementos a traducir de ese interactivo en el panel de control.</td>
                  </tr>
                  <?php
                    } else {
                      while ( $r1 && $rw1 = mysqli_fetch_assoc($r1) ) {
                  ?>
                  <tr>
                    <td><a href="translation_edit.php?i=<?=$interactiu?>&id=<?=$rw1["id"]?>"><?=$rw1["pantalla"]?></a></td>
                    <td><?=$rw1["field"]?></td>
                    <?php foreach ( $LANGS AS $k => $v ) { ?>
                    <td class="text-center">
                    <?php   if ( strlen($rw1[$v]) > 0 ) { ?>
                      <span class="fa fa-1g fa-check" style="color: darkgreen"></span>
                    <?php   } else { ?>
                      <span class="fa fa-1g fa-times" style="color: red"></span>
                    <?php   } ?>
                    </td>
                    <?php } ?>
                    <td>
                      <span class="pull-right-container">
                        <div class="pull-right">
                          <a href="translation_edit.php?i=<?=$interactiu?>&id=<?=$rw1["id"]?>" class="success"><i class="fa fa-pencil-square-o"></i></a>
                        <?php if ( EsAdmin() ) { ?>
                          <a href="javascript:BorrarTrans('<?=$rw1["pantalla"]?>','<?=$rw1["field"]?>')"><i class="fa fa-trash-o"></i></a>
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
                    <a href="translation_edit.php?i=<?=$interactiu?>&id=0"><i class="fa fa-plus"></i> Añadir nuevo elemento</a>
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
function BorrarTrans(pantalla,titol) {
  if ( confirm("¿Seguro que desea borrar el elemento 'Pantalla "+pantalla+" > "+titol+"'?") ) {
    $('#to-delete').val(pantalla+'@'+titol);
    $('#lista').submit();
  }
}

$(document).ready(function() {

    $('#main-list').DataTable({
      "pageLength": 25,
      "ordering": false,
      "stateSave": true
    });

});
</script>


</body>
</html>