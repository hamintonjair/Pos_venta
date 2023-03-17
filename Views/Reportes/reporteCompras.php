<?php
include 'Views/Templates/header_admin.php';
include 'Views/Templates/nav_admin.php';
include 'Views/Templates/body.php';
?>

<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-flag'></i>Reportes <small>Sistema de ventas</small>
                <button class="btn btn-primary" type="button" onclick="volverReportes();"
                    class="fa-solid fa-circle-plus">Volver</button> <small>Compras por mes</small></a></li>

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url; ?>reportes'>Ir a reportes
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>
    <form id='frmBuscarCompras'>
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
                    <label for='empleado'>Buscar Mes</label>
                    <button type="button" onclick="buscarCompraMes()" class="btn btn-info">Buscar</button>
                </div>
           
                <div class="form-group">                   
                    <button type="button" onclick="Todoss()" class="btn btn-warning">Todos.</button>
                </div>
            </div>
        </div>

    </form>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table  table-light table-hover table-bordered '  id="tableReporteComprasMes">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Caja</th>                                
                                    <th>Total ventas</th>
                                    <th>Monto total</th>                                
                                </tr>
                            </thead>
                            <tbody  id="tableReporteCompras">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<?php include 'Views/Templates/footer_admin.php';
?>