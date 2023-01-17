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
    //editar empresa
    public function ditar(){

        $nit = $_POST['nit'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $ciudad = $_POST['ciudad'];
        $mensaje = $_POST['mensaje'];
        $id = $_POST['id'];

        $data = $this->model->actualizar($nit,$nombre,$telefono,$direccion,$ciudad,$mensaje,$id);

        if($data == "ok"){        
            $msg = (array('ok'=> true, 'post' => 'Se actualizaron los datos.'));		          
         }else{
              $msg = (array('ok'=> false, 'post' => 'Error al actualizar.'));;
         }
         echo json_encode($msg, JSON_UNESCAPED_UNICODE);
         die();
    }
  
}
?>