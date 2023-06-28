
<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-flag'></i>Inventario <small>Ganancias mes a mes</small>
                <button class="btn btn-primary" type="button" onclick="volverEmpleados();" data-toggle="modal_arqueo"
                    class="fa-solid fa-circle-plus">Volver</button></a></li>
              

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url(); ?>reportes'>Ir a Reportes
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table  table-light table-hover table-bordered' id='tableGanancias'>
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>                              
                                    <th>Mes</th>
                                    <th>Año</th>
                                    <th>Total</th>                                                          
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

