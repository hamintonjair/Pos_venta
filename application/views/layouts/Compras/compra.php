

<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> <small>Sistema de ventas</small>

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url(); ?>compras/historialCompra'>Ir a historial de
                    compras
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class='card'>
        <div class='card-header bg-primary text-white'>
            <h4>Nueva Compra</h4>
        </div>
        <img class='card-img-top' src='holder.js/100x180/' alt=''>
        <div class='card-body'>
            <form id='frmCompra' method='post'>
                <div class='row'>
                    <div class='col-md-2'>
                        <div class='form-group'>
                            <label for='codigo2'>Código de barra <i class='fas fa-barcode'></i></label>
                            <input type='hidden' id='id' name='id'>
                            <input type='text' name='codigo2' id='codigo2' class='form-control valid validNumber'
                                placeholder='Código de barra' onkeyup='buscarCodigo(event)' aria-describedby='helpId'>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="nombre">Buscar por Nombre</label>
                            <input type="text" id="buscador" class="form-control" placeholder="Buscar producto..."
                                oninput="filtrarProductosC()">
                            <select id="nombre" name="nombre" class="form-control" onchange="buscarNombreC()">
                                <option value="">Seleccionar..</option>
                                <?php foreach ($productos as $row) { ?>
                                <option value="<?php echo $row->descripcion; ?>"><?php echo $row->descripcion; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <label for='descripcion'>Descripción</label>
                            <input type='text' name='descripcion' id='descripcion' class='form-control valid validText'
                                placeholder='Descripcion del producto' aria-describedby='helpId' disabled>
                        </div>
                    </div>
                    <div class='col-md-2'>
                        <div class='form-group'>
                            <label for='cantidad'>Cantidad</label>
                            <input type='number' name='cantidad' id='cantidad' class='form-control valid validNumber'
                                placeholder='Cantidad' onkeyup='calcularPrecioC(event)' aria-describedby='helpId'>
                        </div>
                    </div>
                    <div class='col-md-2'>
                        <div class='form-group'>
                            <label for='precio'>Precio compra</label>
                            <input type='text' name='precio' id='precio' class='form-control valid validNumber'
                                placeholder='Precio compra' aria-describedby='helpId'>
                        </div>
                    </div>
                    <div class='col-md-2'>
                        <div class='form-group'>
                            <label for='sub_total'>Sub Total</label>
                            <input type='text' name='sub_total' id='sub_total' class='form-control valid validNumber'
                                placeholder='0.00' aria-describedby='helpId' disabled>
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
                        <table class='table table-light table-hover table-bordered' id='tableCompra'>
                            <thead class='thead-dark'>
                                <tr>
                                    <th>#</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Sub Total</th>
                                    <th>Acción </th>
                                </tr>
                            </thead>
                            <tbody id='tblDetalleC'>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id='frmCompras'>
        <div class='row'>
            <div class='form-group '>
                <a type='button' class='btn btn-primary mt-4' href='<?php echo base_url(); ?>proveedores'
                    target='_blank'>Registrar</a>
            </div>
            <div class='col-md-2 '>
                <div class='form-group'>
                    <label for='nit'><i class='fas fa-users'></i>Buscar proveedor </label>
                    <input type='text' name='nit' id='nit' class='form-control valid validNumber'
                        aria-describedby='helpId' placeholder="Nit empresa
                    " onkeyup='buscarProveedor(event)' required="">
                    <input type='hidden' name='id_proveedor' id='id_proveedor' aria-describedby='helpId'>
                </div>
            </div>
            <div class='col-md-3'>
                <div class='form-group'>
                    <label for='proveedor'><i class='fas fa-user'></i>Nombre </label>
                    <input type='text' name='proveedor' id='proveedor' class='form-control' aria-describedby='helpId'
                        disabled>
                </div>
            </div>
            <div class='col-md-3 ml-auto'>
                <div class='form-group'>
                    <label for='total' class='font-weight-bold'>Total a pagar</label>
                    <input type='text' name='total' id='total' class='form-control valid validNumber'
                        placeholder='Total' aria-describedby='helpId' disabled>
                    <button type='button' class='btn btn-primary mt-2 btn-block' onclick='cerrarCompra()'>Generar
                        Compra</button>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal -->
    <div class='modal fade' id='cerrarCompra' tabindex='-1' role='dialog' aria-labelledby='modelTitleId'
        aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header headerRegister'>
                    <h5 class='modal-title' id='titleModal'>Cerrar compra </h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form id='frmCerrarC'>
                        <div class='form-group'>
                            <label for='valor_pagar'>Valor a pagar</label>
                            <input type='text' name='valor_pagar' id='valor_pagar' class='form-control'
                                aria-describedby='helpId' disabled>
                        </div>
                        <div class='form-group'>
                            <label for='pago'>Tipo de pago</label>
                            <select class='custom-select' name='pago' id='pago' onchange="capturarValorSelect()">
                                <option selected>Selecionar..</option>
                                <option value='Debito'>Debito</option>
                                <option value='Credito'>Credito</option>
                            </select>
                        </div>
                        <div class='form-group'>
                            <label for='efectivos'>Pagar</label>
                            <input type='number' name='efectivo' id='efectivo' class='form-control valid validNumber'
                                placeholder='Pagar'aria-describedby='helpId'>
                        </div>
                        <div class='modal-footer'>
                            <button id='btnActionForm' type='button' class='btn btn-primary'
                                onclick='generarCompra()'><span id='btnText'>
                                    Cobrar</span></button>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        </div>
                    </form>
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
