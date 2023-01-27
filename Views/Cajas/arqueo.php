<?php
include 'Views/Templates/header_admin.php';
include 'Views/Templates/nav_admin.php';
include 'Views/Templates/body.php';
?>

<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i>Arqueo de Caja <small>Sistema de ventas</small>
                <button class="btn btn-primary" type="button" onclick="arqueoCaja();" data-toggle="modal_arqueo"
                    class="fa-solid fa-circle-plus">Nuevo</button>
                <button class="btn btn-danger" type="button" onclick="cerrarArqueo();"
                    class="fa-solid fa-circle-plus"><i class="fa fa-window-close" aria-hidden="true"></i>Cerrar
                    caja</button>

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url; ?>cajas'>Ir a cajas
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
                                    <th>Usuario</th>
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
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header headerRegister'>
                    <h5 class='modal-title' id='titleModal'>Arqueo Caja</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form method='post' id='frmAbrirCaja' onsubmit="abrirArqueo(event);">
                        <input type='hidden' id='idCaja' name='idCaja' value=''>
                        <div class='form-group'>
                            <label for='caja'>Monto inicial</label>
                            <input type='text' name='monto_inicial' id='monto_inicial'
                                class='form-control valid validNumber' placeholder='Monto inicial'
                                aria-describedby='helpId'>
                        </div>
                        <div class='form-group'>
                            <label for='caja'>Fecha apertura</label>
                            <input type='date' value="<?php echo date('Y-m-d');?>" name='fecha_apertura'
                                id='fecha_apertura' class='form-control valid validText' aria-describedby='helpId'
                                required>
                        </div>
                        <div class="form-group">
                            <label for="monto_final">Monto final</label>
                            <input type="text" id="monto_final" class="form-control" aria-describedby="helpId"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="total_ventas">Total ventas</label>
                            <input type="text" id="total_ventas" class="form-control" aria-describedby="helpId"
                                disabled>
                        </div>
                        <div class='modal-footer'>

                            <button id='btnActionForm' type='submit' class='btn btn-primary'><span id='btnText'>
                                    Abrir</span></button>
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