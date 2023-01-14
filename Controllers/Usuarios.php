<?php 

class Usuarios extends Controller{

    public function __construct()
    {
        session_start();
        if( empty($_SESSION['activo'] == true)){
             header("location:".base_url);
        }
        parent::__construct();
    }

    //VISTA DASHBOARD
    public function index(){

        $data['cajas'] =  $this->model->getCajas();
        $this->views->getView($this, "usuario",  $data );

    }
  //VALIDAMOS EL INICIO DE SESION
    public function validar(){

        if(empty($_POST['usuario']) || empty($_POST['clave']) ){
            $msg = "Los campos estan vacios";
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

               $msg = (array('ok'=> true, 'post' => 'Logueado'));		
              
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
        for($i=0; $i < count($data); $i++){
          
            if($data[$i]['estado'] == 1){
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>            
                <button type="button" class="btn btn-primary" onclick="editarUsuario('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>   
                <button type="button" class="btn btn-danger" onclick="eliminarUsuario('.$data[$i]['id'].');" title="Eliminar"><i class="far   
                fa-trash-alt"></i></button>    
               </div>';
                
            }else{
                $data[$i]['estado'] = ' <span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>                     
                <button type="button" class="btn btn-success" onclick="reingresarUsuario('.$data[$i]['id'].');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
               </div>';
            }
           
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //registrar y actualizar usuarios
    public function registrarUser(){

        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $clave = $_POST['clave'];
        $confirmar = $_POST['confirmar'];
        $caja = $_POST['caja'];
        $id = $_POST['idUsuario'];
        $hash = hash("SHA256", $clave);

        if(empty($usuario) || empty($nombre ) || empty( $caja)){
            $msg = (array('ok'=>false, 'post' => 'Todos los campos son obligatorios.'));
        }else{
            
            if($id == ""){
                //registrar
                if($clave != $confirmar){
                    $msg = (array('ok'=>false, 'post' => 'La contraseñas no coinciden.'));	
                }else{
                    $data = $this->model->registrarUsuario($usuario,$nombre, $hash ,$caja);
                    if($data == 'ok'){
                        $msg = (array('ok'=>true, 'post' => 'Usuario registrado con éxito.'));

                    }else if($data == "existe"){
                        $msg = (array('ok'=>false, 'post' => 'El Usuario ya existe.'));	
                    }else{
                        $msg = (array('ok'=>false, 'post' => 'Error al registrar el Usuario.'));
                    }
                }
            }else{
                //actualizar
                $data = $this->model->updateUsuario($usuario,$nombre,$caja, $id);
                if($data == 'modificado'){
                    $msg = (array('modificado'=>true, 'post' => 'El Usuario fue actualizado con éxito.'));

                }else{
                    $msg = (array('modificado'=>false, 'post' => 'Error al actualizar el Usuario.'));
                }
            }
        
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die;
    }
    //Editar usuario
    public function editar(int $id){

        $data = $this->model->editarUsuario($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();

    }
    //eliminar usuario
    public function deleteUsuario(int $id){
       
        $data = $this->model->accionUsuario(0, $id);  

        if($data == 1){
            $msg = (array('eliminado'=>true, 'post' => 'El Usuario fue eliminado con éxito.'));
        }else{
            $msg = (array('eliminado'=>false, 'msg' => 'Error al eliminar el Usuario.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    //reingresar usuario
    public function reingresarUsuario(int $id){

        $data = $this->model->accionUsuario(1, $id);  

        if($data == 1){
            $msg = (array('reingresado'=>true, 'post' => 'El Usuario fue reingresado con éxito.'));
        }else{
            $msg = (array('reingresado'=>false, 'msg' => 'Error al reingresar el Usuario.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
  //cerrar sesion
    public function logout(){
        
        session_destroy();
        header("location:".base_url);

    }
}
?>