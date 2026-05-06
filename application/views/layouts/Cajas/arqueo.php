<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i>Arqueo de Caja <small>Sistema de ventas</small>
            <button class="btn btn-primary" type="button" onclick="volverCaja();"
                    class="fa-solid fa-circle-plus">Volver</button>
                <button class="btn btn-info" type="button" onclick="arqueoCaja();" data-toggle="modal_arqueo"
                    class="fa-solid fa-circle-plus">Iniciar caja</button>
                <button class="btn btn-danger" type="button" onclick="cerrarArqueo();"
                    class="fa-solid fa-circle-plus"><i class="fa fa-window-close" aria-hidden="true"></i>Cerrar
                    caja</button>

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url(); ?>ventas'>Ir a ventas
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table  table-light table-hover table-bordered' id='tableArqueoCajas'>
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>  
                                    <th>Caja</th>                             
                                    <th>Monto inicial</th>
                                    <th>Monto final</th>
                                    <th>Fecha apertura</th>
                                    <th>Fecha cierre</th>
                                    <th>Total ventas </th>
                                    <th>Monto total </th>
                                    <th>Estado</th>
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
    <div class='modal fade' id='abrir_caja' tabindex='-1' role='dialog' aria-labelledby='modelTitleId'
        aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
            <div class='modal-content'>
                <div class='modal-header bg-info text-white'>
                    <h5 class='modal-title' id='titleModal'>
                        <i class='fas fa-cash-register'></i> Arqueo de Caja
                    </h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form method='post' id='frmAbrirCaja' onsubmit="abrirArqueo(event);">
                        <input type='hidden' id='id' name='id' value=''>
                        
                        <!-- Sección de Apertura de Caja -->
                        <div id="ocultar_campos2">
                            <div class='card mb-3'>
                                <div class='card-header bg-light'>
                                    <h6 class='mb-0'><i class='fas fa-unlock'></i> Apertura de Caja</h6>
                                </div>
                                <div class='card-body'>
                                    <div class='form-group'>
                                        <label for='caja' class='font-weight-bold'>
                                            <i class='fas fa-box'></i> Seleccionar Caja
                                        </label>
                                        <select class="form-control selectpicker" id="id_caja" name="id_caja">
                                            <option selected="selected">Seleccionar..</option>
                                            <?php foreach ($cajas as $row){ ?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->caja; ?></option>
                                            <?php }; ?>
                                        </select>
                                    </div>
                                    <div class='form-group'>
                                        <label for='monto_inicial' class='font-weight-bold'>
                                            <i class='fas fa-dollar-sign'></i> Monto Inicial
                                        </label>
                                        <div class='input-group'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>$</span>
                                            </div>
                                            <input type='text' name='monto_inicial' id='monto_inicial'
                                                class='form-control valid validNumber' placeholder='0.00'
                                                aria-describedby='helpId' style='font-weight: bold;'>
                                        </div>
                                        <small class='form-text text-muted'>
                                            Ingrese el monto inicial con el que abrirá la caja
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sección de Cierre de Caja -->
                        <div id="ocultar_campos">
                            <div class='card mb-3'>
                                <div class='card-header bg-warning text-dark'>
                                    <h6 class='mb-0'><i class='fas fa-lock'></i> Cierre de Caja</h6>
                                </div>
                                <div class='card-body'>
                                    <div class='row'>
                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <label for="monto_final" class='font-weight-bold'>
                                                    <i class='fas fa-coins'></i> Monto Final en Caja
                                                </label>
                                                <div class='input-group'>
                                                    <div class='input-group-prepend'>
                                                        <span class='input-group-text'>$</span>
                                                    </div>
                                                    <input type="text" id="monto_final" class="form-control" 
                                                        placeholder='0.00' aria-describedby='helpId' style='font-weight: bold;'>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <label for="total_ventas" class='font-weight-bold'>
                                                    <i class='fas fa-shopping-cart'></i> Total Ventas
                                                </label>
                                                <div class='input-group'>
                                                    <div class='input-group-prepend'>
                                                        <span class='input-group-text'>$</span>
                                                    </div>
                                                    <input type="text" id="total_ventas" class="form-control bg-light" 
                                                        placeholder='0.00' aria-describedby='helpId' disabled style='font-weight: bold;'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="monto_general" class='font-weight-bold'>
                                            <i class='fas fa-calculator'></i> Monto Total Calculado
                                        </label>
                                        <div class='input-group input-group-lg'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>$</span>
                                            </div>
                                            <input type="text" id="monto_general" class="form-control bg-success text-white" 
                                                placeholder='0.00' aria-describedby='helpId' disabled 
                                                style='font-weight: bold; font-size: 1.2em;'>
                                        </div>
                                        <small class='form-text text-muted'>
                                            Monto final + total ventas = monto total esperado
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>
                                <i class='fas fa-times'></i> Cancelar
                            </button>
                            <button id='btnActionForm' type='submit' class='btn btn-info btn-lg'>
                                <i class='fas fa-save'></i> 
                                <span id='btnText'>Abrir Caja</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>