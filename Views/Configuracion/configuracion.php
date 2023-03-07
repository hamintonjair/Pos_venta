<?php
include 'Views/Templates/header_admin.php';
include 'Views/Templates/nav_admin.php';
include 'Views/Templates/body.php';
?>

<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Configuración <small>Sistema de ventas</small>

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url; ?>usuarios'>Ir a usuarios
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Datos de la empresa</h4>
        </div>
        <img class="card-img-top" src="holder.js/100x180/" alt="">
        <div class="card-body">
            <form id="frmEmpresa" method="post">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nit">Nit</label>
                            <input type="hidden" id="id" name="id" class="form-control "
                                value="<?php echo $data['id'] ?>">
                            <input type="text" name="nit" id="nit" class="form-control" placeholder="Nit empresa"
                                aria-describedby="helpId" value="<?php echo $data['nit'] ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="regimen">Regimen</label>
                            <input type="hidden" id="id" name="id" class="form-control "
                                value="<?php echo $data['id'] ?>">
                            <input type="text" name="regimen" id="regimen" class="form-control valid validText" placeholder="Regimen de la empresa"
                                aria-describedby="helpId" value="<?php echo $data['regimen'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre empresa</label>
                            <input type="text" name="nombre" id="nombre" class="form-control valid validText"
                                placeholder="Nombre empresa" aria-describedby="helpId"
                                value="<?php echo $data['nombre'] ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="resolucion">Resolución DIAN</label>
                            <input type="text" name="resolucion" id="resolucion" class="form-control valid validNumber"
                                placeholder="Resolución DIAN" aria-describedby="helpId"
                                value="<?php echo $data['resolucion'] ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control valid validNumber"
                                placeholder="Teléfono empresa" aria-describedby="helpId"
                                value="<?php echo $data['telefono'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" name="direccion" id="direccion" class="form-control "
                                placeholder="Dirección de empresa" aria-describedby="helpId"
                                value="<?php echo $data['direccion'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ciudad">Ciudad</label>
                            <input type="text" name="ciudad" id="ciudad" class="form-control"
                                placeholder="Ciudad empresa" aria-describedby="helpId"
                                value="<?php echo $data['ciudad'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mensaje">Mensaje</label>
                            <textarea name="mensaje" id="mensaje" class="form-control"
                                placeholder="Mensaje a mostrar en factura" 0
                                aria-describedby="helpId"><?php echo $data['mensaje'] ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type='button' class='btn btn-primary' onclick="actualizarEmpresa(event)">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'Views/Templates/footer_admin.php';
?>