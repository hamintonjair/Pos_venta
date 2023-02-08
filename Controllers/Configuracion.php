<?php 

class Configuracion extends Controller{

    public function __construct()
    {
        session_start(); 
        if( empty($_SESSION['activo'])){
            header("location:".base_url);
       }       
        parent::__construct();
    }
    //VISTA DASHBOARD
    public function index(){  
      
        $data = $this->model->getEmpresa();
        $this->views->getView($this, "configuracion", $data );
    }
    public function dashboard(){  
      
        $data['usuarios'] = $this->model->getDatos("usuarios");
        $data['clientes'] = $this->model->getDatos("clientes");
        $data['productos'] = $this->model->getDatos("productos");
        $data['ventas'] = $this->model->getVentas();

        $this->views->getView($this, "dashboard", $data );
    }
    //editar empresa
    public function editar(){

        $nit = $_POST['nit'];
        $regimen = $_POST['regimen'];
        $resolucion = $_POST['resolucion'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $ciudad = $_POST['ciudad'];
        $mensaje = $_POST['mensaje'];
        $id = $_POST['id'];

        $data = $this->model->actualizar($nit,$regimen, $resolucion ,$nombre,$telefono,$direccion,$ciudad,$mensaje,$id);

        if($data == "ok"){        
            $msg = (array('ok'=> true, 'post' => 'Se actualizaron los datos.'));		          
         }else{
              $msg = (array('ok'=> false, 'post' => 'Error al actualizar.'));;
         }
         echo json_encode($msg, JSON_UNESCAPED_UNICODE);
         die();
    }
     //stock muinimo
    public function reportStock(){
        $data = $this->model->getStockMinimo();
        echo json_encode($data);
        die();
    }
     //productos mas vendidos
    public function productosVendidos(){
        $data = $this->model->getproductosMasVendidos();
        echo json_encode($data);
        die();
    }
  
}
?>