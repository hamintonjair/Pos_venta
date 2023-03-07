<?php
include 'Views/Templates/header_admin.php';
include 'Views/Templates/nav_admin.php';
include 'Views/Templates/body.php';
?>

<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Categoria <small>Sistema de ventas</small>
                <button class="btn btn-primary" type="button" onclick="volverCategoria();" data-toggle="modal"
                    class="fa-solid fa-circle-plus">Volver</button><small> Categorías eliminadas</small></a></li>

            </h1>
        </div>  
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url; ?>categorias'>Ir a categorías
            <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table  table-light table-hover table-bordered' id='tableCategoriasEliminado'>
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>                                
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
</main>

<?php include 'Views/Templates/footer_admin.php';
?>