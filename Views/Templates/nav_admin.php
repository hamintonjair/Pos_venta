 <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?php echo base_url; ?>Assets/Admin/images/admin.png" alt="User Image">
        <div>       
          <p class="app-sidebar__user-name"><?= $_SESSION['nombre']?></p>
          <p class="app-sidebar__user-designation"><?= $_SESSION['usuario'];?></p>
        </div>
  
      </div>
      <ul class="app-menu">     
         <li>
          <a class="app-menu__item" href="#">
            <i class="app-menu__icon fa fa-dashboard"></i>
            <span class="app-menu__label"> Configuración</span>
          </a>
        </li>    
        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">       
              <i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
              <span class="app-menu__label">Usuarios</span>
              <i class="treeview-indicator fa fa-angle-right"></i>
          </a>  
          <ul class="treeview-menu">
             <li><a class="treeview-item" href="<?php echo base_url; ?>Usuarios"><i class="icon fa fa-circle-o"></i>Usuarios</a></li>
            <li><a class="treeview-item" href="<?php echo base_url; ?>Cajas" > <i class="icon fa fa-circle-o"></i>Cajas</a></li>
          </ul>
        </li>    
        <li>
            <a class="app-menu__item"href="#/clientes"> 
            <i class="app-menu__icon fa fa-user" aria-hidden="true"></i>     
            <span class="app-menu__label"> Clientes</span></a>
        </li>      
          <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">       
              <i class="app-menu__icon fa fa-archive" aria-hidden="true"></i>
              <span class="app-menu__label">Tienda</span>
              <i class="treeview-indicator fa fa-angle-right"></i>
          </a>  
          <ul class="treeview-menu">  
            <li><a class="treeview-item" href="<?php echo base_url; ?>productos"><i class="icon fa fa-circle-o"></i> Productos</a></li> 
            <li><a class="treeview-item" href="#/categorias" > <i class="icon fa fa-circle-o"></i> Categorias</a></li> 
          </ul>
        </li>              
      </ul>
    </aside>