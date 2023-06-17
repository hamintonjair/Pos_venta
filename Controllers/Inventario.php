<?php

class Inventario extends Controller {

   public function __construct()
  {
        session_start();

        if ( empty( $_SESSION[ 'activo' ] ) ) {
            header( 'location:'.base_url );
        }
        parent::__construct();
    }
    //VISTA DASHBOARD

    public function index() {

        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->model->verificarPermisos( $id_user, 'inventario' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
           
            $this->views->getView( $this, 'inventario' );
        } else {
            header( 'location:'.base_url.'Errors/permisos' );
        }

    }
    //stock bajos
    public function listarStockBajos(){

        $data = $this->model->getProductosInventario();
       
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //reporte cierre
    public function stockBajos(){

        $this->views->getView($this, 'stockBajos');
    }
    //movimientos entradas y salidas
    public function entradaSalida(){

        $this->views->getView($this, 'entrada_y_salida');
    }
    //listar movimientos esntradas y salidas
    public function listarEntradaSalida(){
        $data = $this->model->listarEntradaSalida();
    
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

   //buscar por entrada o salida
   
   public function buscarEntradaSalida() {

    $EntradaSalida = $_POST[ 'id_entrada' ];        
    $data = array(
        'entradaSalida' =>  $this->model->buscarEntradaSalida( $EntradaSalida )
    );
    echo json_encode( $data, JSON_UNESCAPED_UNICODE );
    die();
}
    //listar inventario de lios productos
    public function listarInventario(){

        $data = $this->model->getInventarioProductos();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>