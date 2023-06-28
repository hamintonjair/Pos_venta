
<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-flag'></i>Movimientos <small>Entradas & Salidas</small>
                <button class="btn btn-primary" type="button" onclick="volverInventario();"
                    class="fa-solid fa-circle-plus">Volver</button></a></li>
                    

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url(); ?>inventario'>Ir a inventario
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>
    <form id='frmBuscar2'>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <!-- <label for='empleado'>Empleados(<font color="red">*</font>)</label> -->
                    <select class="form-control selectpicker" id="id_entrada" name="id_entrada">
                        <option selected="selected">Seleccionar..</option>                      
                        <option value="Entrada">Entrada</option>
                        <option value="Salida">Salida</option>

                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for='entradaSalida'>Buscar</label>
                    <button type="button" onclick="buscarEntradas();" class="btn btn-info">Buscar</button>
                </div>
            </div>
        </div>

    </form>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table  table-light table-hover table-bordered' id='tableEntradaSalida'>
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Usuario</th> 
                                    <th>Clte -Pdor</th>                            
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>                                                       
                                    <th>Fecha</th> 

                                </tr>
                            </thead>
                            <tbody  id="tableReporteEntradaSalida">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
