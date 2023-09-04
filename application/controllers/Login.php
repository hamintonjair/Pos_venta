<?php
class Login extends CI_Controller{

    public function __construct()
    {
        session_start(); 
        if(isset($_SESSION['activo'])){
            echo '<script>window.location.href="http://localhost/Pos_venta/dashboard"</script>';				
       }      
        parent::__construct();
        $this->load->model('UsuariosModel');
        $this->load->model('DashboardModel');
    }

    public function index(){
        $this->load->view('layouts/login');
    }
       //validar 
    public function Validar(){

        if(empty($this->input->post('usuario')) || empty($this->input->post('clave') )){
            $msg = "Los campos estan vacios";           
         }else{

             $usuario = $this->input->post('usuario');
             $clave = $this->input->post('clave');
             $hash = hash("SHA256", $clave);  
             $data = $this->UsuariosModel->getUsuario($usuario, $hash);        

             if(empty($data)){
                $msg = (array('ok'=> false, 'post' => 'El usuario o la contraseña es incorrecto.'));		
             }else{  

                 if($data[0]->estado == 1){
                    
                     $dato =  $this->DashboardModel->getEmpresa();   
                     $_SESSION['impresora'] = $dato[0]->tipo_Impresora;   
                     $_SESSION['id_usuario'] = $data[0]->id;
                     $_SESSION['usuario'] = $data[0]->usuario;
                     $_SESSION['nombre'] = $data[0]->nombre;
                     $_SESSION['rol'] = $data[0]->rol;
                     $_SESSION['activo'] = true;
      
                     $msg = (array('ok'=> true, 'post' => 'Iniciando sesión'));		
                 }else{  
                    $msg = (array('ok'=> false, 'post' => 'usuario inactivo.'));		
       
                 }           
             }
         }           
         echo json_encode($msg, JSON_UNESCAPED_UNICODE);       
        die();     
    }
  //cerrar sesion
    public function logout(){
        
    
        session_destroy();
        echo '<script>window.location.href="http://localhost/Pos_venta/"</script>';				

    }
}

?>