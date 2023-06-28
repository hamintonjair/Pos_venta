
<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-flag'></i>Reportes <small>Por empleado cierre de
                    caja</small>
                <button class="btn btn-primary" type="button" onclick="volverEmpleados();"
                    class="fa-solid fa-circle-plus">Volver</button></a></li>

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url(); ?>reportes'>Ir a reportes
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>
    <form id='frmBuscar'>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <!-- <label for='empleado'>Empleados(<font color="red">*</font>)</label> -->
                    <select class="form-control selectpicker" id="id_empleado" name="id_empleado">
                        <option selected="selected">Seleccionar..</option>
                        <?php foreach ($empleado as $row){ ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->nombre; ?>
                        </option>
                        <?php }; ?>

                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for='empleado'>Buscar Empleado</label>
                    <button type="button" onclick="buscarEmpleados();" class="btn btn-info">Buscar</button>
                </div>
            </div>
        </div>

    </form>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table  table-light table-hover table-bordered' id='tableReporteVentaEmpleado'>
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Fecha apertura</th>
                                    <th>Caja</th>
                                    <th>Usuario</th>
                                    <th>Monto inicial</th>
                                    <th>Total ventas</th>
                                    <th>Monto total</th>
                                    <th>Fecha de cierre</th>

                                </tr>
                            </thead>
                            <tbody  id="tableReporteEmpleado">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
