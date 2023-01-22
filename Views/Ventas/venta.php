<?php
include 'Views/Templates/header_admin.php';
include 'Views/Templates/nav_admin.php';
include 'Views/Templates/body.php';
?>

<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> <small>Sistema de ventas</small>

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url; ?>ventas/historialVenta'>Ir a historial de ventas
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Nueva Venta</h4>
        </div>
        <img class="card-img-top" src="holder.js/100x180/" alt="">
        <div class="card-body">
            <form id="frmVenta" method="post">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="codigo">Código de barra <i class="fas fa-barcode"></i></label>
                            <input type="hidden" id="id" name="id">
                            <input type="text" name="codigo" id="codigo" class="form-control valid validNumber"
                                placeholder="Código de barra" onkeyup="buscarCodigoVenta(event)"                             aria-describedby="helpId">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control valid validText"
                                placeholder="Descripcion del producto" aria-describedby="helpId" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control valid validNumber"
                                placeholder="Cantidad" onkeyup="calcularPrecioVenta(event)" aria-describedby="helpId"
                                disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="precio">Precio</label>
                            <input type="text" name="precio" id="precio" class="form-control valid validNumber"
                                placeholder="Precio venta" aria-describedby="helpId" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="sub_total">Sub Total</label>
                            <input type="text" name="sub_total" id="sub_total" class="form-control valid validNumber"
                                placeholder="0.00" aria-describedby="helpId" disabled>
                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
    <br>
    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table table-light table-hover table-bordered' id='tableVenta'>
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Aplicar</th>
                                    <th>Descuento</th>
                                    <th>Precio</th>
                                    <th>Sub Total</th>
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
    <form id="frmVentas">
        <div class="row">
            <div class="col-md-3 ">
                <div class="form-group">
                    <label for="cliente"><i class="fas fa-users"></i>Buscar Cliente </label>
                    <input type="text" name="cliente" id="cliente" class="form-control valid validNumber"
                        aria-describedby="helpId" placeholder="Cédula
                    " onkeyup="buscarCliente(event)">
                    <input type="hidden" name="ID" id="ID" aria-describedby="helpId">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="nombre"><i class="fas fa-user"></i>Nombre </label>
                    <input type="text" name="nombre" id="nombre" class="form-control"
                        aria-describedby="helpId"  disabled>
                </div>
            </div>            
            <div class="col-md-3 ml-auto">
                <div class="form-group">
                    <label for="total" class="font-weight-bold">Total a pagar</label>
                    <input type="text" name="total" id="total" class="form-control valid validNumber"
                        placeholder="Total" aria-describedby="helpId" disabled>
                    <button type="button" class="btn btn-primary mt-2 btn-block" onclick="generarVenta()">Generar
                        Venta</button>
                </div>
            </div>
        </div>
    </form>
</main>

<?php include 'Views/Templates/footer_admin.php';
?>