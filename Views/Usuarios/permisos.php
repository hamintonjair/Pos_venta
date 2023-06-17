<?php
include 'Views/Templates/header_admin.php';
include 'Views/Templates/nav_admin.php';
include 'Views/Templates/body.php';
?>
<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Permisos <small>Sistema de ventas</small>
                           </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url; ?>usuarios'>Ir a Usuarios
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
                        <?php foreach ($data['datos'] as $row){ ?>
                        <div class="col-md-4 text-center text-capitalize p-2">
                            <label for=""><?php echo $row['permiso'] ;?></label><br>
                            <input type="checkbox" name="permisos[]" value="<?php echo $row['id']; ?>"<?php echo isset($data['asignados'][ $row['id']]) ? 'checked' : '' ?>>
                        </div>
                        <?php } ?>
                        <input type="hidden" value="<?php echo  $data['id_usuario']; ?>" name="id_usuario">
                    </div>
                    <div class="d-grid gap-2">
                         <button class="btn btn-outline-primary" type="button" onclick="registrarPermisos(event);" ><i class="fa fa-registered" aria-hidden="true"></i>Asignar permisos</button>   
                    <a class="btn btn-outline-danger" href="<?php echo base_url; ?>Usuarios"></i>Volver atras</a>   
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
</main>

<?php include 'Views/Templates/footer_admin.php';
?>