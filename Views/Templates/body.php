   <body class="app sidebar-mini">
   <div id="divLoading" >
          <div>
            <img src="<?php echo base_url; ?>Assets/Admin/images/loading.svg" alt="Loading">
          </div>
        </div>
    <!-- Navbar-->   
    <header class="app-header"><a class="app-header__logo" href="<?php echo base_url; ?>dashboard"></a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="" data-toggle="sidebar" aria-label="Hide Sidebar"><i class="fad fa-bars"></i></a>

      <!-- Navbar Right Menu-->
      <ul class="app-nav">
          
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">          
            <li><a class="dropdown-item"  href="<?php echo base_url; ?>Usuarios/perfil "><i class="fa fa-user fa-lg"></i>Perfil</a></li>        
            <li><a class="dropdown-item"  href="<?php echo base_url; ?>configuracion "><i class="fa fa-cog fa-lg"></i>Configuración</a></li>         
            <li><a class="dropdown-item"  href="https://drive.google.com/drive/folders/1kMgOQgKu0LnKs39kJ2Eu117QrNCWQ2A4?usp=sharing" target="_blank" rel="noopener"><i class="fa fa-info-circle" aria-hidden="true"></i>
Ayuda</a></li>
          
            <li><a class="dropdown-item"  href="<?php echo base_url; ?>login/logout"><i class="fa fa-sign-out fa-lg"></i>Cerrear sesión</a></li>
          </ul>
        </li>
      </ul>
    </header>
