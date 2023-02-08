<?php
include 'Views/Templates/header_admin.php';
include 'Views/Templates/nav_admin.php';
include 'Views/Templates/body.php';
?>
<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Permisos <small>Sistema de ventas</small>
                <button class="btn btn-primary" type="button" onclick="openModalMedida();" data-toggle="modal"
                    class="fa-solid fa-circle-plus">Nuevo</button>
            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url; ?>productos'>Ir a Usuarios
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Asignar permisos</h4>
            </div>
            <div class="card-body">
                <form id="formulario">
                    <div class="row">
                        <?php foreach ($data as $row){ ?>
                        <div class="col-md-4 text-center text-capitalize p-2">
                            <label for=""><?php echo $row['permiso'] ;?></label><br>
                            <input type="checkbox">
                        </div>
                        <?php } ?>
                    </div>

                </form>
            </div>
        </div>
    </div>
</main>

<?php include 'Views/Templates/footer_admin.php';
?>