<?php
include 'Views/Templates/header_admin.php';
include 'Views/Templates/nav_admin.php';
include 'Views/Templates/body.php';
?>
<main class='app-content'>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary">
                <div class="card-body d-flex text-white">
                    Usuario
                    <p class="fas fa-user fa-2x ml-auto"></p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="<?php echo base_url; ?>usuarios" class="text-white">Ver Detalle</a>
                    <span class="text-white"><?php echo $data['usuarios']['total'] ?></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success">
                <div class="card-body d-flex text-white">
                    Clientes
                    <p class="fas fa-users fa-2x ml-auto"></p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="<?php echo base_url; ?>clientes" class="text-white">Ver Detalle</a>
                    <span class="text-white"><?php echo $data['clientes']['total'] ?></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger">
                <div class="card-body d-flex text-white">
                    Productos
                    <p class="fa fa-product-hunt fa-2x ml-auto"></p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="<?php echo base_url; ?>productos" class="text-white">Ver Detalle</a>
                    <span class="text-white"><?php echo $data['productos']['total'] ?></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning">
                <div class="card-body d-flex text-white">
                    Ventas por días
                    <p class="fas fa-cash-register fa-2x ml-auto"></p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="<?php echo base_url; ?>Ventas/historialVenta" class="text-white">Ver Detalle</a>
                    <span class="text-white"><?php echo $data['ventas']['total'] ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Productos con Stock mínimo
                </div>
                <div class="card-body">
                <canvas id="stockMinimo"></canvas>  
                </div>                
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Productos más vendidos
                </div>
                <div class="card-body">
                <canvas id="productosVendidos"></canvas>    
                </div>                
            </div>
        </div>
        
    </div>
</main>
<?php include 'Views/Templates/footer_admin.php';
?>