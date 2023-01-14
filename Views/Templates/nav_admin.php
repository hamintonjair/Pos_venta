 <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?php echo base_url; ?>Assets/Admin/images/admin.png" alt="User Image">
        <div>       
          <?php if(!empty($_SESSION['nombre']) || !empty($_SESSION['usuario'])){ ?>
          <p class="app-sidebar__user-name"><?= $_SESSION['nombre']?></p>
          <p class="app-sidebar__user-designation"><?= $_SESSION['usuario'];?></p>
          <?php }; ?>
        </div>
  
      </div>
      <ul class="app-menu">     
         <li>
          <a class="app-menu__item" href="#">
          <i class="app-menu__icon fa fa-dashboard"></i>
            <span class="app-menu__label">Dashboard</span>
          </a>
        </li>    
        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">       
          <i class="app-menu__icon fa fa-tools" aria-hidden="true"></i>
            <span class="app-menu__label"> Configuración</span>
              <i class="treeview-indicator fa fa-angle-right"></i>
          </a>  
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?php echo base_url; ?>Usuarios">
            <i class="icon fa fa-users" aria-hidden="true"></i> Usuarios</a></li>
            <li><a class="treeview-item" href="<?php echo base_url; ?>Configuracion" >
            <i class="icon fa fa-cogs" aria-hidden="true"></i> Configuración</a></li>
            <li><a class="treeview-item" href="<?php echo base_url; ?>Cajas">
            <i class="icon fa fa-archive"></i>Cajas</a></li>
            <li><a class="treeview-item" href="<?php echo base_url; ?>Roles" >
            <i class="icon fa fa-user" aria-hidden="true"></i>Roles</a></li>
            <li><a class="treeview-item" href="<?php echo base_url; ?>Proveedores" >
            <i class="icon fa fa-user" aria-hidden="true"></i>Proveedores</a></li>
            <li><a class="treeview-item" href="<?php echo base_url; ?>Sesion">
            <i class="icon fa fa-arrow-circle-o-down"></i> Sesiones</a></li>
        
          </ul>
        </li>    
        <li>
            <a class="app-menu__item"href="<?php echo base_url; ?>Productos"> 
            <i class="app-menu__icon fa fa-product-hunt" aria-hidden="true"></i>   
            <span class="app-menu__label"> Productos</span></a>
        </li>    
        <li>
            <a class="app-menu__item"href="<?php echo base_url; ?>Categorias"> 
            <i class="app-menu__icon fa fa-arrow-circle-o-down" aria-hidden="true"></i>     
            <span class="app-menu__label"> Categorias</span></a>
        </li>    
        <li>
            <a class="app-menu__item"href="<?php echo base_url; ?>Medidas"> 
            <i class="app-menu__icon fa fa-balance-scale-left" aria-hidden="true"></i>     
            <span class="app-menu__label"> Medidas</span></a>
        </li>  
        <li>
            <a class="app-menu__item"href="<?php echo base_url; ?>Clientes"> 
            <i class="app-menu__icon fa fa-users" aria-hidden="true"></i>     
            <span class="app-menu__label"> Clientes</span></a>
        </li>  
         <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">       
              <i class="app-menu__icon fa fa-shopping-cart" aria-hidden="true"></i>
              <span class="app-menu__label">Ventas</span>
              <i class="treeview-indicator fa fa-angle-right"></i>
          </a>  
          <ul class="treeview-menu">  
            <li><a class="treeview-item" href="<?php echo base_url; ?>productos"><i class="icon fa fa-cart-plus"></i> Nueva Venta</a></li> 
            <li><a class="treeview-item" href="#/categorias" > <i class="icon fa fa-list-alt"></i> Ventas</a></li> 
          </ul>
        </li> 
        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">       
              <i class="app-menu__icon fa fa-bus" aria-hidden="true"></i>
              <span class="app-menu__label">Compras</span>
              <i class="treeview-indicator fa fa-angle-right"></i>
          </a>  
          <ul class="treeview-menu">  
            <li><a class="treeview-item" href="<?php echo base_url; ?>compras"><i class="icon fa fa-cart-arrow-down"></i> Nueva Compra</a></li> 
            <li><a class="treeview-item" href="#" > <i class="icon fa fa-list"></i> Compras</a></li> 
          </ul>
        </li>                       
      </ul>
    </aside>