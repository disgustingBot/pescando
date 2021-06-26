<?php
  require_once("inc.config.php");

  if( is_array($_SESSION["PESCA_ADMIN"]) && $_SESSION["PESCA_ADMIN_ID"] > 0 ) {
    Header("Location: index.php");
    die;
  }

  $ERR = "";

  if($_POST["action"] == "login") {
    if(strlen($_POST["username"]) == 0 || strlen($_POST["password"]) == 0 )	{
      $ERR = "Falta usuario y/o contraseña";
    } else {

      $query = "SELECT * FROM pesca_adminusers WHERE
            adm_username='".mysqli_real_escape_string($conn, $_POST["username"])."'
        AND adm_passwd='".md5(mysqli_real_escape_string($conn, $_POST["password"]))."'
        AND adm_status='A'";
      $res = @mysqli_query($conn, $query);

      if(!$res) {
        print "Error! ".$query."<br />".@mysqli_error($conn);
        exit;
      }
      if(@mysqli_num_rows($res) <= 0) {
        $ERR = "Usuario y/o contraseña erróneos, o usuario no disponible";
      } else {

        $user = mysqli_fetch_assoc($res);
        $_SESSION["PESCA_ADMIN"] = $user;
        $_SESSION["PESCA_ADMIN_ID"] = $user["adm_id"];
        $_SESSION["PESCA_ADMIN_USER"] = $user["adm_username"];
        $_SESSION["PESCA_ADMIN_NAME"] = $user["adm_name"];
        $_SESSION["PESCA_ADMIN_TYPE"] = $user["adm_type"];
        $_SESSION["PESCA_ADMIN_AVATAR"] = ( $user["adm_avatar"] == "" ? "avatar-200x200.png":$user["adm_avatar"] );

        Log_Action($_SESSION["PESCA_ADMIN_ID"],"login");

        Header("Location: index.php");
        exit;
      }
    }
  }

  $page_title = "Log in";

  require_once("inc.head.php");
?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><img src="<?=$DIR_IMG?>pescanova-biomarine-center.png" width="300" height="111" alt="Pescanova Biomarine Center" title="Pescanova Biomarine Center"/></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Accede al panel de control</p>
    <?php
      if ( $ERR != "" ) {
        echo "<p class=\"login-box-msg text-red\">".$ERR."</p>";
      }
    ?>

    <form action="login.php" method="post">
      <input type="hidden" name="action" value="login" />
      <div class="form-group has-feedback">
        <input type="username" name="username" class="form-control" placeholder="Usuario">
        <span class="form-control-feedback fa fa-user"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Contraseña de acceso">
        <span class="form-control-feedback fa fa-lock"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Acceder</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <a href="lost-password.php">Olvidé mi contraseña <span class="fa fa-chevron-circle-right"></span></a><br>

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
