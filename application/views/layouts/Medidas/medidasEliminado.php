
<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Medida <small> Medidas eliminadas</small>
                <button class="btn btn-primary" type="button" onclick="volverMedidas();" data-toggle="modal"
                    class="fa-solid fa-circle-plus">Volver </button></a></li>
                    <button class="btn btn-danger" type="button" onclick="medidasVaciar();" class="fa-solid fa-circle-plus">Vaciar</button>


            </h1>
        </div>  
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url(); ?>medidas'>Ir a medidas
            <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table table-light table-hover table-bordered' id='tableMedidasEliminado'>
                            <thead class="thead-dark">
                                <tr class="thead-dark">
                                    <th>#</th>
                                    <th>Nombre</th>                                
                                    <th>Corto</th>
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
