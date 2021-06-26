    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header"><?=Mayus($_SESSION["PESCA_ADMIN_TYPE"]." menu")?></li>
        <li class="<?=($active_menu == "principal"?"active":"")?>"><a href="index.php"><i class="fa fa-home"></i> <span>Principal</span></a></li>

        <?php if ( EsAdmin() || EsBasico() ) { ?>
        <li class="treeview <?=($active_menutree == "flota"?"active":"")?>">
          <a href="">
            <i class="fa fa-dot-circle-o"></i> <span>Flota y caladeros</span>
          </a>
          <ul class="treeview-menu">
            <li class="<?=($active_menu == "flota-caladeros"?"active":"")?>"><a href="caladeros.php"><span class="fa fa-globe"></span>Los caladeros</a></li>
            <li class="<?=($active_menu == "flota-tipos"?"active":"")?>"><a href="tipos_barcos.php"><span class="fa fa-th-large"></span>Tipos de barcos</a></li>
            <li class="<?=($active_menu == "flota-barcos"?"active":"")?>"><a href="barcos.php"><span class="fa fa-ship"></span>Los barcos</a></li>
            <li class="<?=($active_menu == "flota-textos"?"active":"")?>"><a href="translation.php?i=1"><span class="fa fa-file-text-o"></span>Traducción textos pantallas</a></li>
          </ul>
        </li>
        <li class="treeview <?=($active_menutree == "acuicultura"?"active":"")?>">
          <a href="">
            <i class="fa fa-align-center"></i> <span>Acuicultura</span>
          </a>
          <ul class="treeview-menu">
            <li class="<?=($active_menu == "acuicultura-especies"?"active":"")?>"><a href="especies.php"><span class="fa fa-object-group"></span>Las especies</a></li>
            <li class="<?=($active_menu == "acuicultura-animales"?"active":"")?>"><a href="animales.php"><span class="fa fa-picture-o"></span>Los animales</a></li>
            <li class="<?=($active_menu == "acuicultura-textos"?"active":"")?>"><a href="translation.php?i=2"><span class="fa fa-file-text-o"></span>Traducción textos pantallas</a></li>
          </ul>
        </li>
        <li class="treeview <?=($active_menutree == "hidro"?"active":"")?>">
          <a href="">
            <i class="fa fa-volume-up"></i> <span>Hidrófonos</span>
          </a>
          <ul class="treeview-menu">
            <li class="<?=($active_menu == "hidro-sonidos"?"active":"")?>"><a href="sonidos.php"><span class="fa fa-volume-down"></span>Los sonidos de las especies</a></li>
            <li class="<?=($active_menu == "hidro-textos"?"active":"")?>"><a href="translation.php?i=3"><span class="fa fa-file-text-o"></span>Traducción textos pantallas</a></li>
          </ul>
        </li>
        <li class="treeview <?=($active_menutree == "barcos"?"active":"")?>">
          <a href="">
            <i class="fa fa-ship"></i> <span>Barcos en detalle</span>
          </a>
          <ul class="treeview-menu">
            <li class="<?=($active_menu == "barcos-videos"?"active":"")?>"><a href="barcos_detalles.php"><span class="fa fa-film"></span>Los barcos</a></li>
            <li class="<?=($active_menu == "barcos-textos"?"active":"")?>"><a href="translation.php?i=4"><span class="fa fa-file-text-o"></span>Traducción textos pantallas</a></li>
          </ul>
        </li>
        <li class="treeview <?=($active_menutree == "futuro"?"active":"")?>">
          <a href="">
            <i class="fa fa-search-plus"></i> <span>Líneas Investigación</span>
          </a>
          <ul class="treeview-menu">
            <li class="<?=($active_menu == "futuro-areas"?"active":"")?>"><a href="areas.php"><span class="fa fa-search"></span>Áreas de investigación</a></li>
            <li class="<?=($active_menu == "futuro-textos"?"active":"")?>"><a href="translation.php?i=5"><span class="fa fa-file-text-o"></span>Traducción textos pantallas</a></li>
          </ul>
        </li>
        <?php } // Admin o Básico ?>

        <?php if ( EsAdmin() ) { ?> 
        <li class="treeview <?=($active_menutree == "config"?"active":"")?>">
          <a href="">
            <i class="fa fa-cogs"></i> <span>Config Interactivos</span>
          </a>
          <ul class="treeview-menu">
            <li class="<?=($active_menu == "config-screens"?"active":"")?>"><a href="screens.php"><span class="fa fa-desktop"></span>Interactivos en Pantallas</a></li>
            <li class="<?=($active_menu == "config-timeouts"?"active":"")?>"><a href="timeouts.php"><span class="fa fa-clock-o"></span>Timeouts en interactivos</a></li>
          </ul>
        </li>
        <li class="treeview <?=($active_menutree == "admin"?"active":"")?>">
          <a href="">
            <i class="fa fa-hashtag"></i> <span>Administración</span>
          </a>
          <ul class="treeview-menu">
            <li class="<?=($active_menu == "admin-usuarios"?"active":"")?>"><a href="adminusers.php"><span class="fa fa-id-badge"></span>Usuarios del panel</a></li>
            <li class="<?=($active_menu == "admin-idiomas"?"active":"")?>"><a href="langs.php"><span class="fa fa-language"></span>Idiomas</a></li>
            <li class="<?=($active_menu == "admin-datos"?"active":"")?>"><a href="_adminer_.php" target="_blank"><span class="fa fa-ban"></span>Adminer</a></li>
          </ul>
        </li>
        <?php } else { ?>
        <li class="treeview <?=($active_menutree == "admin"?"active":"")?>">
          <a href="">
            <i class="fa fa-hashtag"></i> <span>Administración</span>
          </a>
          <ul class="treeview-menu">
            <li class="<?=($active_menu == "admin-usuarios"?"active":"")?>"><a href="adminusers.php"><span class="fa fa-id-badge"></span>Perfil del usuario</a></li>
          </ul>
        <?php } ?>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->

