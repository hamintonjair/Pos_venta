
<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-flag'></i>Inventario <small>Sistema de ventas</small>               
            <button class="btn btn-warning" type="button" onclick="productosBajos();" data-toggle="modal_arqueo"
                    class="fa-solid fa-circle-plus">R. Stock bajos</button>  
             <button class="btn btn-primary" type="button" onclick="EntradasSalidas();"
                    class="fa-solid fa-circle-plus">Movimientos entradas & salidas </button></a>             

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url(); ?>reportes'>Ir a reportes
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table  table-light table-hover table-bordered' id='tableInventario'>
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>                              
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Ventas</th>
                                    <th>Stock</th>                                                         
                                    <th>vence</th>
                                    <th>vencimiento</th>
                                                          
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
