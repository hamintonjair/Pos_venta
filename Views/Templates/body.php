   <body class="app sidebar-mini">
   <div id="divLoading" >
          <div>
            <img src="<?php echo base_url; ?>Assets/Admin/images/loading.svg" alt="Loading">
          </div>
        </div>
    <!-- Navbar-->   
    <header class="app-header"><a class="app-header__logo" href="<?php echo base_url; ?>dashboard">Efi-conta</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="" data-toggle="sidebar" aria-label="Hide Sidebar"><i class="fad fa-bars"></i></a>

      <!-- Navbar Right Menu-->
      <ul class="app-nav">
          
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">          
            <li><a class="dropdown-item"  href="#"data-toggle="modal" data-target="#pass"><i class="fa fa-key fa-lg"></i>Contraseña</a></li>     
           
            <li><a class="dropdown-item"  href="https://drive.google.com/file/d/1rWD1ZMnmXgOTWyrI2Iz3gsxw1fqyG4TT/view?usp=sharing" target="_blank" rel="noopener"><i class="fa fa-address-book" aria-hidden="true"></i>
Manual de usuario</a></li>
<li><a class="dropdown-item"  href="https://fb.watch/ld_qLC6KIl/" target="_blank" rel="noopener"><i class="fa fa-info-circle" aria-hidden="true"></i>
Ayuda</a></li>
          
            <li><a class="dropdown-item"  href="<?php echo base_url; ?>Usuarios/logout"><i class="fa fa-sign-out fa-lg"></i>Cerrear sesión</a></li>
          </ul>
        </li>
      </ul>
    </header>
