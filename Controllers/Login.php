<?php 

class Login extends Controller{

    public function __construct()
    {
        session_start();
        if( empty($_SESSION['activo'] == true)){
             header("location:".base_url);
        }
        parent::__construct();
    }
    //VALIDAMOS EL INICIO DE SESION
    public function validar(){

        if(empty($_POST['usuario']) || empty($_POST['clave']) ){
            // $msg = "Los campos estan vacios";
            $msg = (array('ok'=> false, 'msg' => 'Los campos estan vacios'));	
        }else{
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];
            $hash = hash("SHA256", $clave);
  
            $data = $this->model->getUsuario($usuario, $hash);
      
            if($data){
               $_SESSION['id_usuario'] = $data['id'];
               $_SESSION['usuario'] = $data['usuario'];
               $_SESSION['nombre'] = $data['nombre'];
               $_SESSION['activo'] = true;

               $msg = (array('ok'=> true, 'post' => 'Iniciando sesión'));		
              
            }else{

                $msg = (array('ok'=> false, 'msg' => 'usuario o contraseña incorrecta'));		
                //  $msg = "usuario o contraseña incorrecta";
            }
        }           
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>