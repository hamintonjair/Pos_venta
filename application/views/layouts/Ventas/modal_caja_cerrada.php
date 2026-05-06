<main class='app-content'>
    <div class='app-title'>
        <div>
            <h1><i class='fas fa-cash-register'></i> <small>Sistema de ventas</small></h1>
        </div>
        <ul class='app-breadcrumb breadcrumb'>
            <li class='breadcrumb-item'><i class='fa fa-home fa-lg'></i></li>
            <li class='breadcrumb-item'><a href='<?php echo base_url(); ?>dashboard'>Dashboard</a></li>
        </ul>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white text-center">
                    <h4><i class="fas fa-lock"></i> Caja Cerrada</h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-cash-register fa-4x text-danger mb-3"></i>
                        <h5 class="card-title">No puede realizar ventas</h5>
                        <p class="card-text text-muted">
                            Para poder realizar ventas, primero debe abrir la caja. 
                            La caja se encuentra cerrada en este momento.
                        </p>
                    </div>
                    
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Importante:</strong> Debe abrir la caja antes de iniciar cualquier operación de venta.
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="<?php echo base_url(); ?>cajas" class="btn btn-success btn-lg">
                            <i class="fas fa-cash-register"></i> Ir a Caja
                        </a>
                        <a href="<?php echo base_url(); ?>dashboard" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver al Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 15px;
        }
        .card-header {
            border-radius: 15px 15px 0 0 !important;
        }
        .fa-4x {
            font-size: 4em;
        }
        .app-content {
            min-height: 60vh;
            display: flex;
            flex-direction: column;
        }
        .row.justify-content-center {
            flex: 1;
            align-items: center;
        }
    </style>
</main>
