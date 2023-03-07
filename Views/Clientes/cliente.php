<?php
include 'Views/Templates/header_admin.php';
include 'Views/Templates/nav_admin.php';
include 'Views/Templates/body.php';
?>

<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Clientes <small>Sistema de ventas</small>
                <button class="btn btn-primary" type="button" onclick="openModalCliente();" data-toggle="modal"
                    class="fa-solid fa-circle-plus">Nuevo</button>
                    <button class="btn btn-danger" type="button" onclick="clienteEliminado();" class="fa-solid fa-circle-plus">Eliminados</button>
                  

            </h1>
        </div>  
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url; ?>ventas'>Ir a Ventas
            <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table table-light table-hover table-bordered' id='tableClientes'>
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Cédula</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Direccion</th>
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
    <div class='modal fade' id='nuevo_cliente' tabindex='-1' role='dialog' aria-labelledby='modelTitleId'
        aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header headerRegister'>
                    <h5 class='modal-title' id='titleModal'>Nuevo cliente</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form method='post' id='frmCliente'>
                        <input type='hidden' id='idCliente' name='idCliente' value=''>
                        <div class='form-group'>
                            <label for='cliente'>DNI</label>
                            <input type='text' name='dni' id='dni' class='form-control valid validNumber' placeholder='Identificación'
                                aria-describedby='helpId'>
                        </div>
                        <div class='form-group'>
                            <label for='nombre'>Nombre</label>
                            <input type='text' name='nombre' id='nombre' class='form-control valid validText'
                                placeholder='Nombre del cliente' aria-describedby='helpId'>
                        </div>                    
                        <div class='form-group'>
                                <label for='telefono'>Teléfono</label>
                             <input type='number' name='telefono' id='telefono' class='form-control valid validNumber'
                                       placeholder='Teléfono' aria-describedby='helpId'>
                        </div>                         
                         <div class='form-group'>
                             <label for='confirmar'>Dirección</label>
                                <input type='direccion' name='direccion' id='direccion' class='form-control'
                                   placeholder='Dirección' aria-describedby='helpId'>
                            </div>
                        </div>                                             
                        <div class='modal-footer'>
                            <button id='btnActionForm' type='button' class='btn btn-primary' onclick="registrarCliente(event);"><span id='btnText'>
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