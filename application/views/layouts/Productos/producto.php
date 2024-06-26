
<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Productos <small>Sistema de ventas</small>
                <button class="btn btn-primary" type="button" onclick="openModalProductos();" data-toggle="modal"
                    class="fa-solid fa-circle-plus">Nuevo</button>
                    <button class="btn btn-warning" type="button" onclick="productosEliminados();" class="fa-solid fa-circle-plus">Eliminados</button>

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url(); ?>proveedores'>Ir a proveedores
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table table-light table-hover table-bordered' id='tableProductos'>
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Imagen</th>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Iva</th>
                                    <th>vence</th>
                                    <th>vencimiento</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
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
    <div class='modal fade' id='nuevo_producto' tabindex='-1' role='dialog' aria-labelledby='modelTitleId'
        aria-hidden='true'>
        <div class='modal-dialog modal-lg' role='document'>
            <div class='modal-content'>
                <div class='modal-header headerRegister'>
                    <h5 class='modal-title' id='titleModal'>Nuevo productos</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form method='post' id='frmProductos'>
                        <input type='hidden' id='idProducto' name='idProducto' value=''>
                        <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son
                            obligatorios.</p>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for='codigo'>Código de Barra(<font color="red">*</font>)</label>
                                    <input type='text' name='codigo' id='codigo' class='form-control valid validNumber'
                                        placeholder='Código de barra' aria-describedby='helpId'>
                                        <br>
                    <div id="divBarcode" class="notblock textcenter">
                        <div id="printCode">
                          <svg id="barcode"></svg>
                        </div>
                        <button class="btn btn-success btn-sm" type="button" onClick="printBarcode('#printCode')"><i class="fas fa-print"> Imprimir</i></button></button>
                    </div>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for='descripcion'>Producto(<font color="red">*</font>)</label>
                                    <input type='text' name='descripcion' id='descripcion'
                                        class='form-control' placeholder='Descripción'
                                        aria-describedby='helpId'>

                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label for='precio_venta'>Precio de venta(<font color="red">*</font>)</label>
                                    <input type='text' name='precio_venta' id='precio_venta'
                                        class='form-control valid validNumber' placeholder='Precio de venta'
                                        aria-describedby='helpId'>
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label for='precio_compra'>Precio de compra</label>
                                    <input type='text' name='precio_compra' id='precio_compra'
                                        class='form-control valid validNumber' placeholder='Precio compra'
                                        aria-describedby='helpId'>

                                </div>
                            </div>
                          
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label for='cantidad'>Cantidad(<font color="red">*</font>)</label>
                                    <input type='text' name='cantidad' id='cantidad'
                                        class='form-control valid validNumber' placeholder='Cantidad'
                                        aria-describedby='helpId'>

                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2'>
                                <div class='form-group'>
                                    <label for='iva'>IVA(<font color="red">*</font>)</label>
                                    <input type='text' name='iva' id='iva' class='form-control valid validNumber'
                                        placeholder='Valor IVA' aria-describedby='helpId'>

                                </div>
                            </div>
                            <div class='col-md-2'>
                                <div class='form-group'>
                                    <label for='medida'>Medidas(<font color="red">*</font>)</label>
                                    <select class="form-control selectpicker" id="id_medida" name="id_medida">
                                        <option selected="selected">Seleccionar..</option>
                                        <?php foreach ($medidas as $row){ ?>
                                        <option value="<?php echo $row->id; ?>"><?php echo $row->nombre; ?>
                                        </option>
                                        <?php }; ?>
                                    </select>

                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label for='categoria'>Categoría(<font color="red">*</font>)</label>
                                    <select class='form-control selectpicker' name='id_categoria' id='id_categoria'>
                                        <option selected="selected">Seleccionar..</option>
                                        <?php foreach ($categorias as $row){ ?>
                                        <option value="<?php echo $row->id; ?>"><?php echo $row->nombre; ?>
                                        </option>
                                        <?php }; ?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label for='proveedor'>Proveedor(<font color="red">*</font>)</label>
                                    <select class='form-control selectpicker' name='id_proveedor' id='id_proveedor'>
                                        <option selected="selected">Seleccionar..</option>
                                        <?php foreach ($proveedores as $row){ ?>
                                        <option value="<?php echo $row->id; ?>"><?php echo $row->nombre; ?>
                                        </option>
                                        <?php }; ?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>Agregar Foto</label>
                                    <div class="card border-primary">

                                        <div class="card-body">
                                            <label for="imagen" id="icon-image" class="btn btn-primary"><i
                                                    class="fas fa-image"></i></label>
                                            <span id="icon-cerrar"></span>
                                            <input id="imagen" class="d-none" type="file" name="imagen"
                                                onchange="preview(event)">
                                        </div>
                                        <input type="hidden" id="foto_actual" name="foto_actual">
                                        <img class="img-thumbnail" id="img-preview">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="min">¿Vence?(<font color="red">*</font>)</label>
                                    <select class='form-control selectpicker' name='vencimiento' id='vencimiento'>
                                        <option selected="selected">Seleccionar..</option>
                                         <option value="Si">Si</option>
                                         <option value="No">No</option>
                                    </select>
                                   
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="min">Fecha vencimiento</label>
                                    <input type="date" value="<?php echo date("Y-m-d"); ?>" name="fecha" id="fecha">
                                </div>
                            </div>
                        </div>
                        <div class='modal-footer'>
                            <button id='btnActionForm' type='button' class='btn btn-primary'
                                onclick="registrarProducto(event);"><span id='btnText'>
                                    Registrar</span></button>
                            <button type='button' class='btn btn-secondary' onclick="reloadPage()" data-dismiss='modal'>Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
