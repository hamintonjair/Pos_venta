
<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-flag'></i>Reportes <small>ventas diario</small>                         
                <button class="btn btn-primary" type="button" onclick="ventasEmpleados();"
                    class="fa-solid fa-circle-plus">R. Ventas por empleados</button></a>
                    <button class="btn btn-info" type="button" onclick="reporteVentas();"
                    class="fa-solid fa-circle-plus">R. Ventas por mes</button></a></li>
                    <button class="btn btn-warning" type="button" onclick="comprasProveedor();"
                    class="fa-solid fa-circle-plus">R. Compras</button></a></li>
                    <button class="btn btn-danger" type="button" onclick="irGanancias();"
                    class="fa-solid fa-circle-plus">R. Ganancias</button></a></li>
            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url(); ?>inventario'>Ir a inventario
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    
    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table  table-light table-hover table-bordered' id='tableReporteCierre'>
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
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

