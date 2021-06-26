<?php

  // Per a poder venir des del llistat d'ofertes...
  $_POST["action"] = "buscar";

  if ( $_GET["tipo"] != "" ) {
    $_POST["tipo"] = $_GET["tipo"];
  }

  if ( $_GET["fecha-desde"] != "" || $_GET["fecha-hasta"] != "" ) {
    $_POST["fecha-desde"] = $_GET["fecha-desde"];
    $_POST["fecha-hasta"] = $_GET["fecha-hasta"];
  }

  if ( $_POST["fecha-desde"] == "" ) {
    $_POST["fecha-desde"] = date("d/m/Y", mktime(0, 0, 0, date("m"), date("d")-7, date("Y")));
  }
  if ( $_POST["fecha-hasta"] == "" ) {
    $_POST["fecha-hasta"] = date("d/m/Y");
  }

  $cond = "";
  $cadena = "";
  $file_sector = "";
  if ( $_POST["action"] == "buscar" ) {

    // Fechas
    if ( $_POST["fecha-desde"] != "" && $_POST["fecha-hasta"] != "" ) {
      $desde = substr($_POST["fecha-desde"],6,4)."-".substr($_POST["fecha-desde"],3,2)."-".substr($_POST["fecha-desde"],0,2);
      $hasta = substr($_POST["fecha-hasta"],6,4)."-".substr($_POST["fecha-hasta"],3,2)."-".substr($_POST["fecha-hasta"],0,2);
      $_SESSION["desde"] = $desde;
      $_SESSION["hasta"] = $hasta;
      if ( $desde == $hasta ) {
        // Un único día
        $cond .= " AND pul_entrada LIKE '".$desde."%' ";
        $cadena .= "Día ".$_POST["fecha-desde"]." ";
        $file_sector = substr($desde,0,4).substr($desde,5,2).substr($desde,8,2);
      } else {
        $cond .= " AND pul_entrada BETWEEN '".$desde." 00:00:00' AND '".$hasta." 23:59:59' ";
        $cadena .= "Del ".$_POST["fecha-desde"]." al ".$_POST["fecha-hasta"]." ";
        $file_sector = substr($desde,0,4).substr($desde,5,2).substr($desde,8,2)."-".substr($hasta,0,4).substr($hasta,5,2).substr($hasta,8,2);
      }
    }       

    // Idioma
    if ( $_POST["idioma"] != "" ) {
      $cond .= " AND pul_idioma = '".$_POST["idioma"]."' ";
      $cadena .= "/ ".( $_POST["idioma"] == "esp" ? "Castellano": ( $_POST["idioma"] == "eng" ? "English" : ( $_POST["idioma"] == "glg" ? "Galego" : "- Desconocido -" )))." ";
      $file_sector .= "-".$_POST["idioma"];
    }
    
    $_SESSION["file_sector"] = $file_sector;
    
    $_SESSION["cadena"] = $cadena;
    $_SESSION["cond"] = $cond;
  }

  $pag = 0;
  $xpag = 5000;

  $limit = " LIMIT ".$pag.", ".$xpag;
  /* if ( basename($_SERVER["PHP_SELF"]) != "visitantes.php" ) */
  $limit = "";

  if ( basename($_SERVER["PHP_SELF"]) == "interactivos-toques.php" ) {
    $q1 = "
      SELECT
        SUBSTRING(vis_momento, 1, 13) as fecha, vis_interactivo, count(*) AS total 
      FROM
        pesca_visitas 
      LEFT JOIN
        pesca_pulseras ON pul_codigo = vis_pulsera AND SUBSTRING(pul_alta, 1,10 ) = SUBSTRING(vis_momento, 1, 10)
      WHERE 
        vis_momento BETWEEN '".$desde." 00:00:00' AND '".$hasta." 23:59:59'
        AND pul_tipo NOT IN ('Especial','Empleado')
    ".$cond."
      GROUP BY 
        SUBSTRING(vis_momento, 1, 13), vis_interactivo 
      ORDER BY
        fecha, vis_interactivo
    ".$limit;

  } else {

    $q1 = "
      SELECT *,
        ( SELECT vis_momento FROM pesca_visitas WHERE vis_pulsera = pul_codigo AND vis_momento >= pul_entrada AND vis_momento <= pul_salida ORDER BY vis_momento DESC LIMIT 0,1) as ultimo, 
        SEC_TO_TIME(TIMESTAMPDIFF(SECOND, pul_entrada, pul_salida)) as duracion
      FROM
        pesca_pulseras
      WHERE
        pul_tipo NOT IN ('Especial','Empleado')
    ".$cond."
      ORDER BY 
         pul_alta DESC
    ".$limit;
    
  }
  $r1 = @mysqli_query($conn, $q1);

  $_SESSION["last_query"] = $q1;
?>

        <div class="row">
          <div class="col-md-12">
            
            <div id="buscador" class="box collapsed-box">

              <div class="box-header">

                <div class="box-title"><a data-widget="collapse" style="color: black; cursor: pointer"><h4>Buscador avanzado</h4></a></div>
                <div class="box-tools pull-right" style="margin-top: 8px;">
                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>  
                </div>

              </div>
              <!-- /.box-header -->

              <div class="box-body">

                <div class="row">

                  <div class="col-md-4">

                    <div class="form-group">
                      <label for="fecha">Por fechas:</label>
                      <div class="input-group input-daterange">
                        <input type="text" class="form-control" name="fecha-desde" value="<?=( $_POST["fecha-desde"] != "" ? $_POST["fecha-desde"] : "19/06/2019" )?>">
                        <div class="input-group-addon">a</div>
                        <input type="text" class="form-control" name="fecha-hasta" value="<?=( $_POST["fecha-hasta"] != "" ? $_POST["fecha-hasta"] : date("d/m/Y") )?>">
                      </div>
                    </div>

                  </div>
                  <!-- /.col -->

                  <div class="col-md-4">

                    <div class="form-group">
                      <label for="idioma">Por idioma:</label>
                      <div class="input-group">
                        <select name="idioma" class="form-control">
                          <option value="">- Cualquier idioma -</option>
<?php
  $q0 = "SELECT lng_code, lng_title FROM pesca_langs ORDER BY lng_orden, lng_code";
  if ( $r0 = mysqli_query($conn,$q0) ) {
    while ( $rw0 = mysqli_fetch_assoc($r0) ) {
?>
                          <option value="<?=$rw0["lng_code"]?>" <?=( $_POST["idioma"] == $rw0["lng_code"] ? "selected":"")?>><?=$rw0["lng_title"]?></option>
<?php
    }

    mysqli_free_result($r0);
  }
?>
                        </select>

                      </div>
                    </div>

                  </div>
                  <!-- /.col -->

                  <div class="col-md-4">

                  </div>
                  <!-- /.col -->

                </div>
                <!-- /.row -->


              </div>
              <!-- /.box-body -->

              <div class="box-footer text-center">
                <button id="buscar" class="btn btn-default">Filtrar Datos</button>
              </div>
              <!-- /.box-footer -->

            </div>
            <!-- /.box -->

          </div>
        </div>
        <!-- /.row -->
