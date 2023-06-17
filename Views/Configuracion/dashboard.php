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
                    Usuarios
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
                    Proveedores
                    <p class="fa fa-product-hunt fa-2x ml-auto"></p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="<?php echo base_url; ?>proveedores" class="text-white">Ver Detalle</a>
                    <span class="text-white"><?php echo $data['proveedores']['total'] ?></span>
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
    <br>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div style="background-color: #888888;">
                <div class="card-body d-flex text-white">
                    Entradas
                    <p class="fas fa-user fa-2x ml-auto"></p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="<?php echo base_url; ?>Reportes/reporteProveedor" class="text-white">Ver Detalle</a>
                    <span class="text-white"><?php echo $data['entrada']['total'] ?></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div style="background-color: #FF69B4;">
                <div class="card-body d-flex text-white">
                    Salidas
                    <p class="fas fa-users fa-2x ml-auto"></p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="<?php echo base_url; ?>Reportes/reporteEmpleado" class="text-white">Ver Detalle</a>
                    <span class="text-white"><?php echo $data['salidas']['total'] ?></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div style="background-color: #800080;">
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
            <div style="background-color: #87CEEB;">
                <div class="card-body d-flex text-white">
                    Categorías
                    <p class="fas fa-cash-register fa-2x ml-auto"></p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="<?php echo base_url; ?>Ventas/historialVenta" class="text-white">Ver Detalle</a>
                    <span class="text-white"><?php echo $data['categorias']['total'] ?></span>
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


    <br><br>
    <div class="row mt-2">
        <div>
            <label for="id">Año:</label>
            <input type="text" id="id" placeholder="Seleccione un año" class="year-input">
            <button onclick="ganancias()">Obtener Ganancias</button>
        </div>
        <br>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Ganacias por mes
                </div>
                <div class="card-body">
                    <canvas id="gananciasMes"></canvas>
                </div>
            </div>
        </div>

    </div>
</main>
<style>
.year-input {
    border: 1px solid #ccc;
    padding: 8px;
    font-size: 16px;
    border-radius: 4px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.year-input:focus {
    outline: none;
    border-color: #5b9bd5;
    box-shadow: 0 0 5px rgba(91, 155, 213, 0.5);
}
</style>
<?php include 'Views/Templates/footer_admin.php';
?>