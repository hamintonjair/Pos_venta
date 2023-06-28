

<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-flag'></i>Reportes <small>Compras a proveedores</small>
                <button class="btn btn-primary" type="button" onclick="volverProveedor();"
                    class="fa-solid fa-circle-plus">Volver</button></a></li>

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url(); ?>reportes'>Ir a reportes
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>
    <form id='frmBuscarC'>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">                   
                    <select class="form-control selectpicker" id="id_proveedor" name="id_proveedor">
                        <option selected="selected">Seleccionar..</option>
                        <?php foreach ($proveedor as $row){ ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->nombre; ?>
                        </option>
                        <?php }; ?>

                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for='proveedor'>Buscar Proveedor</label>
                    <button type="button" onclick="frmBuscarCompras();" class="btn btn-info">Buscar</button>
                </div>
            </div>
        </div>

    </form>
    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table table-light table-hover table-bordered '  id="tableReporteCompras">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nit</th>
                                    <th>Razón social</th>                                
                                    <th>Nombre</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio U.</th>     
                                    <th>Precio Total</th>                                                        
                                    <th>Método pago</th>
                                    <th>Fecha</th>                                
                                </tr>
                            </thead>
                            <tbody id = "tableCompras" >
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

