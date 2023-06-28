
<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Categoria <small>Sistema de ventas</small>
                <button class="btn btn-primary" type="button" onclick="openModalCategoria();" data-toggle="modal"
                    class="fa-solid fa-circle-plus">Nuevo</button>
                    <?php if( $_SESSION['rol'] == 'Administrador' ){?>
                    <button class="btn btn-warning" type="button" onclick="categoriaEliminado();" class="fa-solid fa-circle-plus">Eliminados</button>
                    <?php }else if($_SESSION['rol'] == 'Supervisor'){ ?>
                        <button class="btn btn-warning" disabled="" type="button" onclick="categoriaEliminado();" class="fa-solid fa-circle-plus">Eliminados</button>

                     <?php }; ?>
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
                        <table class='table  table-light table-hover table-bordered' id='tableCategorias'>
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>                                
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
    <div class='modal fade' id='nueva_categoria' tabindex='-1' role='dialog' aria-labelledby='modelTitleId'
        aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header headerRegister'>
                    <h5 class='modal-title' id='titleModal'>Nueva Categoria</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form method='post' id='frmCategoria'>
                        <input type='hidden' id='idCategoria' name='idCategoria' value=''>                        
                        <div class='form-group'>
                            <label for='categoria'>Categoria(<font color="red">*</font>)</label>
                            <input type='text' name='categoria' id='categoria' class='form-control valid validText'
                                placeholder='Categoria' aria-describedby='helpId'>
                        </div>                                                                              
                        <div class='modal-footer'>
                            <button id='btnActionForm' type='button' class='btn btn-primary' onclick="registrarCategoria(event);"><span id='btnText'>
                                    Registrar</span></button>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>