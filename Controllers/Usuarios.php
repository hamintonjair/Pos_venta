<?php 

class Usuarios extends Controller{

    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    //VISTA DASHBOARD
    public function index(){

     $this->views->getView($this, "index");

    }
  //VALIDAMOS EL INICIO DE SESION
    public function validar(){

        if(empty($_POST['usuario']) || empty($_POST['clave']) ){
            $msg = "Los campos estan vacios";
        }else{
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];
  
            $data = $this->model->getUsuario($usuario,$clave);

            if($data){
               $_SESSION['id_usuario'] = $data['id'];
               $_SESSION['usuario'] = $data['usuario'];
               $_SESSION['nombre'] = $data['nombre'];
               $msg = "ok";
            }else{
                 $msg = "usuario o contraseña incorrecta";
            }
        }
         echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    //listar los usuarios
    public function listar(){

        $data = $this->model->getUsuarios();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}

?>