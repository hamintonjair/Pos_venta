
<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Caja <small>Sistema de ventas</small>
            <?php if($_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){ ?>
                <button class="btn btn-primary" type="button" onclick="openModalCaja();" data-toggle="modal"
                    class="fa-solid fa-circle-plus">Nuevo</button>
                 <?php }else{; ?>
                    <button class="btn btn-primary" disabled="" type="button" onclick="openModalCaja();" data-toggle="modal"
                    class="fa-solid fa-circle-plus">Nuevo</button>
                    <?php }; ?>
                <button class="btn btn-success" type="button" onclick="openArqueo();"
                    class="fa-solid fa-circle-plus">Abrir caja</button>

            </h1>
        </div>  
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url(); ?>usuarios'>Ir a Usuarios
            <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table  table-light table-hover table-bordered' id='tableCajas'>
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Caja</th>                                
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
    <div class='modal fade' id='nueva_caja' tabindex='-1' role='dialog' aria-labelledby='modelTitleId'
        aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header headerRegister'>
                    <h5 class='modal-title' id='titleModal'>Nueva Caja</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form method='post' id='frmCaja'>
                        <input type='hidden' id='idCaja' name='idCaja' value=''>                        
                        <div class='form-group'>
                            <label for='caja'>Caja(<font color="red">*</font>)</label>
                            <input type='text' name='caja' id='caja' class='form-control valid validText'
                                placeholder='Caja' aria-describedby='helpId'>
                        </div>                                                                              
                        <div class='modal-footer'>
                            <button id='btnActionForm' type='button' class='btn btn-primary' onclick="registrarCaja(event);"><span id='btnText'>
                                    Registrar</span></button>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

 