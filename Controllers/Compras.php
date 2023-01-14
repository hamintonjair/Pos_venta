<?php 

class Compras extends Controller{

    public function __construct()
    {
        session_start();        
        parent::__construct();
    }
    //VISTA DASHBOARD
    public function index(){  
        if( empty($_SESSION['activo'])){
             header("location:".base_url);
        }
        $this->views->getView($this, "compra");
    }
    //buscar código
    public function buscarCodigo($cod){

      $data = $this->model->getProCod($cod);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }
    //ingresar dellates
    public function ingresar(){

        $id = $_POST['id'];
        $datos = $this->model->getProductos($id);
        $id_producto = $datos['id'];
        $id_usuario = $_SESSION['id_usuario'];
        $precio = $datos['precio_compra'];
        $cantidad = $_POST['cantidad'];
        $sub_total =$precio * $cantidad;
        $data = $this->model->registrarDetalles($id_producto, $id_usuario, $precio, $cantidad, $sub_total);    

        if($data == 'modificado'){
            $msg = (array('modificado'=> true, 'post' => 'Producto agregado.'));

        }else{
            $msg = (array('modificado'=>false, 'post' => 'Error al ingresar el producto.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    //ñistar los productos al detalle
    public function listar(){

        $id_usuario = $_SESSION['id_usuario'];
        $data['detalle'] = $this->model->getDetalle( $id_usuario);   
        $data['total_pagar'] = $this->model->calcularCompra( $id_usuario);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //eliminar productos del detalle
    public function delete(int $id){

        $data = $this->model->deleteDetalle( $id);  

        if($data == 'modificado'){
            $msg = (array('modificado'=> true, 'post' => 'Producto eliminado.'));

        }else{
            $msg = (array('modificado'=>false, 'post' => 'Error al eliminar el producto.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die(); 
    }
}
?>