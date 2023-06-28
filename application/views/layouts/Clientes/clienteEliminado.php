
<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Clientes <small>Clientes eliminados</small>
                <button class="btn btn-primary" type="button"  onclick="volverCliente();" data-toggle="modal"
                    class="fa-solid fa-circle-plus">Volver</button></a></li>
                    <?php if( $_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){?>
                    <button class="btn btn-danger" type="button" onclick="clienteVaciar();" class="fa-solid fa-circle-plus">Vaciar</button>
            <?php }else{; ?>
                <button class="btn btn-danger" disabled="" type="button" onclick="clienteVaciar();" class="fa-solid fa-circle-plus">Vaciar</button>

            <?php }; ?>
                   

            </h1>
        </div>  
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url(); ?>clientes'>Ir a Clientes
            <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table table-light table-hover table-bordered' id='tableClientesEliminados'>
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
</main>

