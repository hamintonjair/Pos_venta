<main class='app-content'>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="base-url" content="<?php echo base_url(); ?>">
        <title>Sistema de Ventas</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/Admin/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/Admin/css/main.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/Admin/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/Admin/css/style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/Admin/css/stylereal.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/Admin/css/toastr.css">
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/libreria/sweetalert2/dist/sweetalert2.min.css">
        <script src="<?php echo base_url(); ?>assets/Admin/js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/Admin/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/Admin/js/plugins/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/Admin/js/plugins/dataTables.bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/libreria/sweetalert2/dist/sweetalert2.min.js"></script>
    </head>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> <small>Sistema de ventas</small>

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url(); ?>ventas/historialVenta'>Ir a historial de ventas
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Nueva Venta</h4>
        </div>
        <div class="card-body">
            <form id="frmVenta" method="post">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="codigo">Buscar por Código<i class="fas fa-barcode"></i></label>
                            <input type="hidden" id="id" name="id">
                            <input type="text" name="codigo2" id="codigo2" class="form-control valid validNumber"
                                placeholder="Código de barra" onkeyup="buscarCodigoVenta(event);"
                                aria-describedby="helpId">
                        </div>
                    </div>
                      <div class="col-md-2">
                        <div class="form-group">
                            <label for="nombre">Buscar por Nombre</label>
                            <input type="text" id="buscador" class="form-control" placeholder="Buscar producto..."
                                oninput="filtrarProductos()">
                            <select id="nombre" name="nombre" class="form-control" onchange="buscarNombre()">
                                <option value="">Seleccionar..</option>
                                <?php foreach ($productos as $row) { ?>
                                <option value="<?php echo $row->descripcion; ?>"><?php echo $row->descripcion; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control "
                                placeholder="Descripcion del producto" aria-describedby="helpId" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <div class="input-group">
                                <input type="number" name="cantidad" id="cantidad" class="form-control "
                                    placeholder="Cantidad" onkeyup="calcularPrecioVenta(event)" aria-describedby="helpId"
                                    disabled>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-success" onclick="agregarProducto()" id="btnAgregar" disabled>
                                        <i class="fas fa-plus"></i> Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="precio">Precio</label>
                            <input type="text" name="precio" id="precio" class="form-control" placeholder="Precio venta"
                                aria-describedby="helpId" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="iva">Valor IVA</label>
                            <input type="text" name="iva" id="iva" class="form-control " placeholder="0.00"
                                aria-describedby="helpId" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="sub_total">Sub Total</label>
                            <input type="text" name="sub_total" id="sub_total" class="form-control " placeholder="0.00"
                                aria-describedby="helpId" disabled>
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
                                    <th>IVA</th>
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
            <div class="form-group ">
                <a type="button" class="btn btn-primary mt-4" href="<?php echo base_url(); ?>clientes"
                    target="_blank">Registrar</a>
            </div>
            <div class="col-md-2 ">
                <div class="form-group">
                    <label for="cedula"><i class="fas fa-users"></i>Buscar Cliente </label>
                    <div class="input-group">
                        <input type="text" name="cedula" id="cedula" class="form-control valid validNumber"
                            aria-describedby="helpId" placeholder="Cédula" onkeyup="buscarCliente(event)">
                        <div class="input-group-append">
                            <button class="btn btn-info" type="button" onclick="buscarClienteBtn()" title="Buscar Cliente">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="ID" id="ID" aria-describedby="helpId">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="cliente"><i class="fas fa-user"></i>Nombre </label>
                    <input type="text" name="cliente" id="cliente" class="form-control" aria-describedby="helpId"
                        disabled>
                </div>
            </div>
            <div class="col-md-3 ml-auto">
                <div class="form-group">
                    <label for="total" class="font-weight-bold">Total a pagar</label>
                    <input type="text" name="total" id="total" class="form-control valid validNumber"
                        placeholder="Total" aria-describedby="helpId" disabled>
                    <button type="button" class="btn btn-primary mt-2 btn-block" onclick="cerrarVenta()">Generar
                        Venta</button>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal -->
    <div class='modal fade' id='cerrarVenta' tabindex='-1' role='dialog' aria-labelledby='modelTitleId'
        aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header bg-success text-white'>
                    <h5 class='modal-title' id='titleModal'>
                        <i class='fas fa-cash-register'></i> Cerrar Venta
                    </h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form id='frmCerrar'>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for='valor_pagar' class='font-weight-bold'>
                                        <i class='fas fa-shopping-cart'></i> Total a Pagar
                                    </label>
                                    <div class='input-group'>
                                        <div class='input-group-prepend'>
                                            <span class='input-group-text'>$</span>
                                        </div>
                                        <input type='text' name='valor_pagar' id='valor_pagar' class='form-control bg-light'
                                            aria-describedby='helpId' disabled>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for='efectivos' class='font-weight-bold'>
                                        <i class='fas fa-money-bill-wave'></i> Efectivo Recibido
                                    </label>
                                    <div class='input-group'>
                                        <div class='input-group-prepend'>
                                            <span class='input-group-text'>$</span>
                                        </div>
                                        <input type='text' name='efectivos' id='efectivos' class='form-control valid validNumber'
                                            placeholder='0.00' onkeyup="efectivo(event)" aria-describedby='helpId' 
                                            style='font-size: 1.2em; font-weight: bold;'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='form-group'>
                                    <label for='devolver' class='font-weight-bold'>
                                        <i class='fas fa-exchange-alt'></i> Cambio a Devolver
                                    </label>
                                    <div class='input-group'>
                                        <div class='input-group-prepend'>
                                            <span class='input-group-text'>$</span>
                                        </div>
                                        <input type='text' name='devolver' id='devolver' class='form-control' 
                                            placeholder='0.00' aria-describedby='helpId' disabled
                                            style='font-size: 1.3em; font-weight: bold;'>
                                    </div>
                                    <small class='form-text text-muted'>
                                        <i class='fas fa-info-circle'></i> El cambio se calcula automáticamente
                                    </small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>
                        <i class='fas fa-times'></i> Cancelar
                    </button>
                    <button id='btnActionForm' type='button' class='btn btn-success btn-lg'
                        onclick="generarVenta();">
                        <i class='fas fa-check-circle'></i> 
                        <span id='btnText'>Completar Venta</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
        <style>
        select {
    display: none; /* Oculta el elemento select por defecto */
}

    </style>
</main>
