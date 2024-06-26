
<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-box'></i> Historial de compras <small>Sistema de ventas</small>              

            </h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url(); ?>compras'>Ir a compras
                    <small>Sistema de ventas</small></a></li>
        </ul>
    </div>

    <div class='row'>
        <div class='col-md-12'>
            <div class='tile'>
                <div class='tile-body'>
                    <div class='table-responsive'>
                        <table class='table table-light table-hover table-bordered' id='tableHistorial'>
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>    
                                    <th>Proveedor</th>                                
                                    <th>Total</th>
                                    <th>Fecha Compra</th>                                  
                                    <th>Estado </th> 
                                    <th>Acción </th>                                  
                                </tr>
                            </thead>
                            <tbody id="tblDetalle">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </main>

