<?php
include 'Views/Templates/header_admin.php';
include 'Views/Templates/nav_admin.php';
include 'Views/Templates/body.php';
?>

<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Productos <small>Sistema de ventas</small>
                <button class="btn btn-primary" type="button" onclick="openModalProductos();" data-toggle="modal"
                    class="fa-solid fa-circle-plus">Nuevo</button>

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url; ?>proveedores'>Ir a proveedores
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
                                    <th>Descripción</th>
                                    <th>Precio</th>                                                                     
                                    <th>Stock</th>
                                    <th>Iva</th>
                                    <th>Descuento</th>
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
                        <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for='codigo'>Código de Barra(<font color="red">*</font>)</label>
                                    <input type='text' name='codigo' id='codigo' class='form-control valid validNumber'
                                        placeholder='Código de barra' aria-describedby='helpId'>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for='descripcion'>Descripción(<font color="red">*</font>)</label>
                                    <input type='text' name='descripcion' id='descripcion'
                                        class='form-control valid validText' placeholder='Descripción'
                                        aria-describedby='helpId'>

                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-3'>
                                <div class='form-group'>
                                    <label for='precio_compra'>Precio de venta(<font color="red">*</font>)</label>
                                    <input type='text' name='precio_compra' id='precio_compra'
                                        class='form-control valid validNumber' placeholder='Precio de venta'
                                        aria-describedby='helpId'>
                                </div>
                            </div>
                            <div class='col-md-3'>
                                <div class='form-group'>
                                    <label for='precio_venta'>Precio de compra</label>
                                    <input type='text' name='precio_venta' id='precio_venta'
                                        class='form-control valid validNumber' placeholder='Precio compra'
                                        aria-describedby='helpId'>

                                </div>
                            </div>
                            <div class='col-md-3'>
                                <div class='form-group'>
                                    <label for='descuento'>Descuentos(<font color="red">*</font>)</label>
                                    <select class='form-control selectpicker' name='descuento' id='descuento'>
                                        <option selected="selected">Seleccionar..</option> 
                                           <option value="noAplica"><?php echo "no Aplica" ?> 
                                           <option value="5"><?php echo 5 ?>
                                           <option value="10"><?php echo 10 ?>
                                           <option value="15"><?php echo 15 ?>
                                           <option value="20"><?php echo 20 ?>
                                           <option value="25"><?php echo 25 ?>
                                           <option value="30"><?php echo 30 ?>
                                           <option value="35"><?php echo 35 ?>
                                           <option value="40"><?php echo 40 ?>                                      
                                           <option value="45"><?php echo 45 ?>                                  
                                           <option value="50"><?php echo 50 ?>
                                           <option value="55"><?php echo 55 ?>
                                           <option value="60"><?php echo 60 ?>
                                           <option value="65"><?php echo 65 ?>
                                           <option value="70"><?php echo 70 ?>
                                           <option value="75"><?php echo 75 ?>
                                           <option value="80"><?php echo 80 ?>
                                           <option value="85"><?php echo 85 ?>                                                                                   
                                        </option>
                                       
                                    </select>
                                </div>
                            </div>
                            <div class='col-md-3'>
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
                                    <label for='iva'>IVA</label>
                                    <input type='text' name='iva' id='iva'
                                        class='form-control valid validNumber' placeholder='Valor IVA'
                                        aria-describedby='helpId'>

                                </div>
                            </div>
                            <div class='col-md-2'>
                                <div class='form-group'>
                                    <label for='medida'>Medidas(<font color="red">*</font>)</label>
                                    <select class="form-control selectpicker" id="id_medida" name="id_medida">
                                        <option selected="selected">Seleccionar..</option>
                                        <?php foreach ($data['medidas'] as $row){ ?>
                                           <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?>
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
                                        <?php foreach ($data['categorias'] as $row){ ?>
                                           <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?>
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
                                        <?php foreach ($data['proveedores'] as $row){ ?>
                                           <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?>
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
                        </div>
                        <div class='modal-footer'>
                            <button id='btnActionForm' type='button' class='btn btn-primary'
                                onclick="registrarProducto(event);"><span id='btnText'>
                                    Registrar</span></button>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'Views/Templates/footer_admin.php';
?>