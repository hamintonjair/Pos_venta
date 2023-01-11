<?php
include 'Views/Templates/header_admin.php';
include 'Views/Templates/nav_admin.php';
include 'Views/Templates/body.php';
?>

<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Productos <small>Sistema de ventas</small>
                <button class="btn btn-primary" type="button" onclick="openModalProductos();" data-toggle="modal"
                    class="fa-solid fa-circle-plus">Nuevo</button>

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url; ?>dashboard/categorias'>Ir a Rol
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table table-hover table-bordered' id='tableProductos'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Precio compra</th>
                                    <th>Precio venta</th>
                                    <th>Cantidad</th>
                                    <th>Medida</th>
                                    <th>Categoría</th>
                                    <th>Proveedor</th>
                                    <th>estado</th>
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

    <!-- Modal -->
    <div class='modal fade' id='nuevo_productos' tabindex='-1' role='dialog' aria-labelledby='modelTitleId'
        aria-hidden='true'>
        <div class='modal-dialog modal-xl' role='document'>
            <div class='modal-content'>
                <div class='modal-header headerRegister'>
                    <h5 class='modal-title' id='titleModal'>Nuevo productos</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form method='post' id='frmProductos'>
                        <input type='hidden' id='idProducto' name='idProducto' value=''>
                        <div class='row'>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label for='codigo'>Código</label>
                                    <input type='text' name='codigo' id='codigo' class='form-control valid validNumber'
                                        placeholder='Código' aria-describedby='helpId'>
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label for='descripcion'>Descripción</label>
                                    <input type='text' name='descripcion' id='descripcion'
                                        class='form-control valid validText' placeholder='Descripción'
                                        aria-describedby='helpId'>

                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label for='precioV'>Precio de venta</label>
                                    <input type='text' name='precioV' id='precioV'
                                        class='form-control valid validNumber' placeholder='Precio venta'
                                        aria-describedby='helpId'>

                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label for='precioC'>Precio de compra</label>
                                    <input type='text' name='precioC' id='precioC'
                                        class='form-control valid validNumber' placeholder='Precio de compra'
                                        aria-describedby='helpId'>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <label for='cantidad'>Cantidad</label>
                                <input type='text' name='cantidad' id='cantidad' class='form-control valid validNumber'
                                    placeholder='Cantidad' aria-describedby='helpId'>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <label for='medida'>Medida</label>
                                <select class='form-control' name='medida' id='medida'>

                                </select>
                            </div>
                        </div>
                </div>
                <div class='row'>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='categoria'>Categoría</label>
                            <select class='form-control' name='categoria' id='categoria'>

                            </select>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='proveedor'>Proveedor</label>
                            <select class='form-control' name='proveedor' id='proveedor'>

                            </select>
                        </div>
                    </div>

                </div>               
                <div class='modal-footer'>
                    <button id='btnActionForm' type='button' class='btn btn-primary'
                        onclick="registraProducto(event);"><span id='btnText'>
                            Registrar</span></button>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</main>

<?php include 'Views/Templates/footer_admin.php';
?>