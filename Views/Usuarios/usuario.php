<?php
include 'Views/Templates/header_admin.php';
include 'Views/Templates/nav_admin.php';
include 'Views/Templates/body.php';
?>

<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Usuarios <small>Sistema de ventas</small>
                <button class="btn btn-primary" type="button" onclick="openModalUsuarios();" data-toggle="modal"
                    class="fa-solid fa-circle-plus">Nuevo</button>
                    <button class="btn btn-danger" type="button" onclick="usuarioEliminado();" class="fa-solid fa-circle-plus">Eliminados</button>

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url; ?>cajas'>Ir a cajas
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table table-hover table-bordered' id='tableUsuarios'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Usuario</th>
                                    <th>Nombre</th>
                                    <th>Caja</th>
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
    <div class='modal fade' id='nuevo_usuario' tabindex='-1' role='dialog' aria-labelledby='modelTitleId'
        aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header headerRegister'>
                    <h5 class='modal-title' id='titleModal'>Nuevo usuario</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form method='post' id='frmUsuarios'>
                        <input type='hidden' id='idUsuario' name='idUsuario' value=''>
                        <div class='form-group'>
                            <label for='usuario'>Usuario</label>
                            <input type='text' name='usuario' id='usuario' class='form-control valid validText'
                                placeholder='Usuario' aria-describedby='helpId'>
                        </div>
                        <div class='form-group'>
                            <label for='usuario'>Nombre</label>
                            <input type='text' name='nombre' id='nombre' class='form-control valid validText'
                                placeholder='Nombre del usuario' aria-describedby='helpId'>
                        </div>
                        <div class='row' id="claves">
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for='clave'>Contraseña</label>
                                    <input type='password' name='clave' id='clave' class='form-control'
                                        placeholder='Contraseña' aria-describedby='helpId'>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for='confirmar'>Confirmar contraseña</label>
                                    <input type='password' name='confirmar' id='confirmar' class='form-control'
                                        placeholder='Confirmar contraseña' aria-describedby='helpId'>
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <label for='caja'>Caja</label>
                            <select class='form-control selectpicker' name='caja' id='caja'>

                                <option selected="selected">Seleccionar..</option>
                                <?php foreach ($data['cajas'] as $row){ ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['caja']; ?>
                                </option>
                                <?php }; ?>
                            </select>
                        </div>
                        <div class='modal-footer'>
                            <button id='btnActionForm' type='button' class='btn btn-primary'
                                onclick="registrarUsuario(event);"><span id='btnText'>
                                    Registrar</span></button>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Closed</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'Views/Templates/footer_admin.php';
?>