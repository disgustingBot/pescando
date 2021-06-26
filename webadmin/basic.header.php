
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?=$DIR_IMG?>pescanova-bc.png" width="36" height="40" alt="Pescanova Biomarine Center" title="Pescanova Biomarine Center" /></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?=$DIR_IMG?>pescanova-biomarine-center.png" width="108" height="40" alt="Pescanova Biomarine Center" title="Pescanova Biomarine Center" /></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="<?=$DIR_IMG.$_SESSION["PESCA_ADMIN_AVATAR"]?>" class="user-image" alt="<?=$_SESSION["PESCA_ADMIN_NAME"]?>">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?=$_SESSION["PESCA_ADMIN_NAME"]?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="<?=$DIR_IMG.$_SESSION["PESCA_ADMIN_AVATAR"]?>" class="img-circle" alt="<?=$_SESSION["PESCA_ADMIN_NAME"]?>">

                <p>
                  <?=$_SESSION["PESCA_ADMIN_NAME"]?>
                  <small><?=ucfirst($_SESSION["PESCA_ADMIN_TYPE"])?></small>
                  <small>Miembro desde <?=GeneraData($_SESSION["PESCA_ADMIN"]["adm_created"],8)?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="adminusers_edit.php?id=<?=$_SESSION["PESCA_ADMIN_ID"]?>" class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>
