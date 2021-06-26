<?php
  require_once ("inc.config.php");

  $ERR = "";

  if($_POST ["action"] == "lost") {
    if( strlen($_POST["username"]) == 0 || strlen($_POST["email"]) == 0 )	{
      $ERR = "Falta usuario y/o correo electrónico";
    } else {
      $passwd = GeneraClauAleatoria(8);

      require("class.phpmailer.php");

      $query = "SELECT * FROM pesca_adminusers WHERE
            adm_username='".mysqli_real_escape_string($conn, $_POST["username"])."'
        AND adm_email='".mysqli_real_escape_string($conn, $_POST["email"])."'
        AND adm_status='A'";
      $res = @mysqli_query($conn, $query);

      if(!$res) {
        print "Error! ".$query."<br />".@mysqli_error($conn);
        exit;
      }

      if(@mysqli_num_rows($res) <= 0) {
        $ERR = "Usuario y/o correo erróneos, o usuario no disponible";
      } else {

        // We send an email with new auto password
        $user = mysqli_fetch_assoc($res);

        $r2 = mysqli_query($conn, "UPDATE pesca_adminusers SET adm_passwd = '".mysqli_real_escape_string($conn, md5($passwd))."' WHERE adm_id = '".$user["adm_id"]."'");

        if ( !$r2 ) {
          $ERR = "No puedo crear una nueva clave para el usuario";
        } else {

          $from = "noreply@pescanova.com";
          $from_name = "Pescanova";
          $dest = $user["adm_email"];
          $dest_name = $user["adm_name"];

          $subj = "[PESCANOVA] Nueva contraseña";

          $body = "Buenos días!\n\nSiguiendo tu petición, te hemos cambiado la contraseña por otra nueva.\n\n";
          $body .= "Tu nueva contraseña es: ".$passwd."\n\n";
          $body .= "Ya puedes acceder con esta nueva contraseña en <a href=\"".$MAIN_URL."webadmin/login.php\">".$MAIN_URL."webadmin/login.php</a>,\n\Pescanova Panel de Control\n";

          $envio = EnviaEmail($from,$from_name,$dest,$dest_name,$subj,$body,nl2br($body));

          $MSG = "Nueva contraseña enviada. Comprueba tu buzón de correo, por favor.";
        }

      }

    }
  }

  $page_title = "Cambio de contraseña";

  require_once("inc.head.php");
?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>Pescanova Backend</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">¿Olvidaste la contraseña de acceso?<br />No te preocupes, te mandamos una nueva.</p>
    <?php
      if ( $ERR != "" ) {
        echo "<p class=\"login-box-msg text-red\">".$ERR."</p>";
      }
      if ( $MSG != "" ) {
        echo "<p class=\"login-box-msg text-green\">".$MSG."</p>";
      } else {
    ?>

    <form action="lost-password.php" method="post">
      <input type="hidden" name="action" value="lost" />
      <div class="form-group has-feedback">
        <input type="username" name="username" class="form-control" placeholder="Usuario">
        <span class="form-control-feedback fa fa-user"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Correo email">
        <span class="form-control-feedback fa fa-envelope"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Recordar</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <?php
      }
    ?>

    <a href="login.php"><span class="fa fa-chevron-circle-left"></span> Volver a la página de acceso</a><br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
