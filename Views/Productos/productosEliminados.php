<?php
include 'Views/Templates/header_admin.php';
include 'Views/Templates/nav_admin.php';
include 'Views/Templates/body.php';
?>

<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Productos <small>Sistema de ventas</small>
                <button class="btn btn-primary" type="button" onclick="volver();" data-toggle="modal"
                    class="fa-solid fa fa-product-hunt">Volver</button><small> Productos eliminados</small></a></li>
               
            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url; ?>productos'>Ir a productos
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table table-light table-hover table-bordered' id='tableProductosEliminados'>
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Imagen</th>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Iva</th>
                                    <th>Descuento</th>
                                    <th>vence</th>
                                    <th>vencimiento</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>

<?php include 'Views/Templates/footer_admin.php';
?>