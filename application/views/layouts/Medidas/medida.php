
<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Medida <small>Sistema de ventas</small>
                <button class="btn btn-primary" type="button" onclick="openModalMedida();" data-toggle="modal"
                    class="fa-solid fa-circle-plus">Nuevo</button>
                    <button class="btn btn-warning" type="button" onclick="medidasEliminado();" class="fa-solid fa-circle-plus">Eliminados</button>


            </h1>
        </div>  
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url(); ?>productos'>Ir a productos
            <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table table-light table-hover table-bordered' id='tableMedidas'>
                            <thead class="thead-dark">
                                <tr class="thead-dark">
                                    <th>#</th>
                                    <th>Nombre</th>                                
                                    <th>Corto</th>
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
    <div class='modal fade' id='nueva_medida' tabindex='-1' role='dialog' aria-labelledby='modelTitleId'
        aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header headerRegister'>
                    <h5 class='modal-title' id='titleModal'>Nueva Medida</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form method='post' id='frmMedida'>
                        <input type='hidden' id='idMedida' name='idMedida' value=''>                        
                        <div class='form-group'>
                            <label for='nombre'>Nombre(<font color="red">*</font>)</label>
                            <input type='text' name='nombre' id='nombre' class='form-control valid validText'
                                placeholder='Nombre medida' aria-describedby='helpId'>
                        </div>       
                        <div class='form-group'>
                            <label for='nombre_corto'>Nombre corto(<font color="red">*</font>)</label>
                            <input type='text' name='nombre_corto' id='nombre_corto' class='form-control valid validText'
                                placeholder='Nombre corto medida' aria-describedby='helpId'>
                        </div>                                                                                                
                        <div class='modal-footer'>
                            <button id='btnActionForm' type='button' class='btn btn-primary' onclick="registrarMedida(event);"><span id='btnText'>
                                    Registrar</span></button>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
