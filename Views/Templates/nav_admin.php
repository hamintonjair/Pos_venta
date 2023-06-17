 <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?php echo base_url; ?>Assets/Admin/images/logo.jpg" alt="User Image">
        <div>       
          <?php if(!empty($_SESSION['nombre']) || !empty($_SESSION['rol'])){ ?>
          <p class="app-sidebar__user-name"><?= $_SESSION['nombre']?></p>
          <p class="app-sidebar__user-designation"><?= $_SESSION['rol'];?></p>
          <?php }; ?>
        </div>
  
      </div>
      <ul class="app-menu">     
         <li>
          <a class="app-menu__item" href="<?php echo base_url; ?>configuracion/dashboard">
          <i class="app-menu__icon fa fa-dashboard"></i>
            <span class="app-menu__label">Dashboard</span>
          </a>
        </li>    
        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">       
          <i class="app-menu__icon fa fa-tools" aria-hidden="true"></i>
            <span class="app-menu__label"> Administración</span>
              <i class="treeview-indicator fa fa-angle-right"></i>
          </a>  
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?php echo base_url; ?>configuracion" >
            <i class="icon fa fa-cogs" aria-hidden="true"></i> Configuración</a></li> 
            <li><a class="treeview-item" href="<?php echo base_url; ?>inventario" >
            <i class="icon fa fa-file-text" aria-hidden="true"></i> Inventario</a></li>    
            <li><a class="treeview-item" href="<?php echo base_url; ?>reportes" >
            <i class="icon fa fa-flag" aria-hidden="true"></i> Reportes</a></li>   
            <li><a class="treeview-item" href="<?php echo base_url; ?>usuarios">
            <i class="icon fa fa-users" aria-hidden="true"></i> Usuarios</a></li>                     
            <li><a class="treeview-item" href="<?php echo base_url; ?>proveedores" >
            <i class="icon fa fa-user" aria-hidden="true"></i>Proveedores</a></li>            
          </ul>
        </li>          
        <li>
            <a class="app-menu__item"href="<?php echo base_url; ?>cajas"> 
            <i class="app-menu__icon fa fa-archive" aria-hidden="true"></i>   
            <span class="app-menu__label">Cajas</span></a>
        </li>    
        <li>
            <a class="app-menu__item"href="<?php echo base_url; ?>categorias"> 
            <i class="app-menu__icon fa fa-arrow-circle-o-down" aria-hidden="true"></i>     
            <span class="app-menu__label">Categorias</span></a>
        </li>   
         <li>
            <a class="app-menu__item"href="<?php echo base_url; ?>clientes"> 
            <i class="app-menu__icon fa fa-users" aria-hidden="true"></i>     
            <span class="app-menu__label"> Clientes</span></a>
        </li>  
        <li>
            <a class="app-menu__item"href="<?php echo base_url; ?>medidas"> 
            <i class="app-menu__icon fa fa-balance-scale-left" aria-hidden="true"></i>     
            <span class="app-menu__label"> Medidas</span></a>
        </li>  
        <li>
            <a class="app-menu__item"href="<?php echo base_url; ?>productos"> 
            <i class="app-menu__icon fa fa-product-hunt" aria-hidden="true"></i>   
            <span class="app-menu__label">Productos</span></a>
        </li> 
         <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">       
              <i class="app-menu__icon fa fa-shopping-cart" aria-hidden="true"></i>
              <span class="app-menu__label">Ventas</span>
              <i class="treeview-indicator fa fa-angle-right"></i>
          </a>  
          <ul class="treeview-menu">  
            <li><a class="treeview-item" href="<?php echo base_url; ?>ventas"><i class="icon fa fa-cart-plus"></i>Nueva Venta</a></li> 
            <li><a class="treeview-item" href="<?php echo base_url; ?>ventas/historialVenta" > <i class="icon fa fa-list-alt"></i>Historial Ventas</a></li> 
          </ul>
        </li> 
        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">       
              <i class="app-menu__icon fa fa-bus" aria-hidden="true"></i>
              <span class="app-menu__label">Entradas</span>
              <i class="treeview-indicator fa fa-angle-right"></i>
          </a>  
          <ul class="treeview-menu">  
            <li><a class="treeview-item" href="<?php echo base_url; ?>compras"><i class="icon fa fa-cart-arrow-down"></i>Nueva Compra</a></li> 
            <li><a class="treeview-item" href="<?php echo base_url; ?>compras/historialCompra" > <i class="icon fa fa-list"></i> Historial Compras</a></li> 
          </ul>
        </li>                       
      </ul>
    </aside>