<?php
include 'Views/Templates/header_admin.php';
include 'Views/Templates/nav_admin.php';
include 'Views/Templates/body.php';
?>

<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Proveedor <small>Sistema de ventas</small>
                <button class="btn btn-primary" type="button" onclick="openModalProveedor();" data-toggle="modal"
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
                        <table class='table table-light table-hover table-bordered' id='tableProveedores'>
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nit</th>
                                    <th>Razón social</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
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

    <!-- Modal -->
    <div class='modal fade' id='nuevo_proveedor' tabindex='-1' role='dialog' aria-labelledby='modelTitleId'
        aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header headerRegister'>
                    <h5 class='modal-title' id='titleModal'>Nuevo proveedor</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form method='post' id='frmProveedores'>
                        <input type='hidden' id='idProveedor' name='idProveedor' value=''>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for='nit'>Nit</label>
                                    <input type='text' name='nit' id='nit' class='form-control valid validNumber'
                                        placeholder='Usuario' aria-describedby='helpId'>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for='razon_social'>Razón social</label>
                                    <input type='text' name='razon_social' id='razon_social'
                                        class='form-control valid validText' placeholder='Razón social'
                                        aria-describedby='helpId'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for='nombre'>Nombre</label>
                                    <input type='text' name='nombre' id='nombre' class='form-control valid validText'
                                        placeholder='Nombre' aria-describedby='helpId'>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for='telefono'>Teléfono</label>
                                    <input type='text' name='telefono' id='telefono'
                                        class='form-control valid validNumber' placeholder='Teléfono'
                                        aria-describedby='helpId'>
                                </div>
                            </div>
                        </div>
                        <div class='row' id="claves">
                            <div class='col-md-12'>
                                <div class='form-group'>
                                    <label for='direccion'>Dirección</label>
                                    <input type='text' name='direccion' id='direccion' class='form-control'
                                        placeholder='Contraseña' aria-describedby='helpId'>
                                </div>
                            </div>                          
                        </div>                        
                        <div class='modal-footer'>
                            <button id='btnActionForm' type='button' class='btn btn-primary'
                                onclick="registrarProveedor(event);"><span id='btnText'>
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