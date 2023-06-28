<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Historial de ventas <small>Sistema de ventas</small>

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url(); ?>ventas'>Ir a ventas
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>
    <form action="<?php echo base_url(); ?>Ventas/pdf" method="post" target="_blank">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="min">Desde</label>
                    <input type="date" value="<?php echo date("Y-m-d"); ?>" name="desde" id="min">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="hasta">Hasta</label>
                    <input type="date" value="<?php echo date("Y-m-d"); ?>" name="hasta" id="hasta">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button type="submit" class="btn btn-danger">Generar PDF</button>
                </div>
            </div>
        </div>
    </form>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table table-light table-hover table-bordered' id='tableHistorialVentas'>
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>Total</th>
                                    <th>Fecha Venta</th>
                                    <th>Estado </th>
                                    <th>Acción </th>
                                </tr>
                            </thead>
                            <tbody id="tblDetalle">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
