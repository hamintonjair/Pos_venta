<?php

class Inventario extends CI_Controller {

   public function __construct()
  {
        session_start();

        if ( empty( $_SESSION[ 'activo' ] ) ) {
            echo '<script>window.location.href="http://localhost/Pos_venta/"</script>';	

        }
        parent::__construct();
        $this->load->model('InventarioModel');
    }
    //VISTA DASHBOARD

    public function vista_usuario() {

        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->InventarioModel->verificarPermisos( $id_user, 'inventario' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
           
            $this->load->view('layouts/Templates/header_admin');
            $this->load->view('layouts/Templates/nav_admin');
            $this->load->view('layouts/Templates/body');
            $this->load->view('layouts/Inventario/inventario');
            $this->load->view('layouts/Templates/footer_admin');
        } else {
            echo '<script>window.location.href="http://localhost/Pos_venta/Errors/permisos"</script>';	

        }

    }
    //stock bajos
    public function listarStockBajos(){

        $data = $this->InventarioModel->getProductosInventario();
       
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //reporte cierre
    public function stockBajos(){

        $this->load->view('layouts/Templates/header_admin');
        $this->load->view('layouts/Templates/nav_admin');
        $this->load->view('layouts/Templates/body');
        $this->load->view('layouts/Inventario/stockBajos');
        $this->load->view('layouts/Templates/footer_admin');
    }
    //movimientos entradas y salidas
    public function entradaSalida(){
      
        $this->load->view('layouts/Templates/header_admin');
        $this->load->view('layouts/Templates/nav_admin');
        $this->load->view('layouts/Templates/body');
        $this->load->view('layouts/Inventario/entrada_y_salida');
        $this->load->view('layouts/Templates/footer_admin');
    }
    //listar movimientos esntradas y salidas
    public function listarEntradaSalida(){
        $data = $this->InventarioModel->listarEntradaSalida();
    
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

   //buscar por entrada o salida 
   public function buscarEntradaSalida() {

       $EntradaSalida = $_POST[ 'id_entrada' ];        
       $data = array(
        'entradaSalida' =>  $this->InventarioModel->buscarEntradaSalida( $EntradaSalida )
      );
      echo json_encode( $data, JSON_UNESCAPED_UNICODE );
      die();
    }
    //listar inventario de lios productos
    public function listarInventario(){

        $data = $this->InventarioModel->getInventarioProductos();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>