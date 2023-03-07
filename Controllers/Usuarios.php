<?php 

class Usuarios extends Controller{

    public function __construct()
    {
        session_start();
               
        parent::__construct();
    }

    //VISTA DASHBOARD
    public function index(){

        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->model->verificarPermisos( $id_user, 'usuarios' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
            if( empty($_SESSION['activo'])){
                header("location:".base_url);
            }
            $data['cajas'] =  $this->model->getCajas();
            $this->views->getView($this, "usuario",  $data );
        } else {
            header( 'location:'.base_url.'Errors/permisos' );
        }
    }

    //listar los usuarios
    public function listar(){

        $data = $this->model->getUsuarios();

        for($i=0; $i < count($data); $i++){          
                
               $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
               if($data[$i]['id'] == 1){
                    $data[$i]['acciones'] = '<div>                     
                       <span class="badge bg-primary">Administrador</span>';
                    '<div>   
                </div>';
               }else{
              
                $data[$i]['acciones'] = '<div>   
                <a type="button" class="btn btn-dark" href="'.base_url.'usuarios/permisos/'.$data[$i]['id'].'" title="Permisos"><i class="fas fa-key"></i></a>          
                <button type="button" class="btn btn-primary" onclick="editarUsuario('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>   
                <button type="button" class="btn btn-danger" onclick="eliminarUsuario('.$data[$i]['id'].');" title="Eliminar"><i class="far   
                fa-trash-alt"></i></button>    
               </div>';
               }
       
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function listarEliminados(){
        
        $data = $this->model->getUsuariosEliminados();

        for($i=0; $i < count($data); $i++){          
         
            $data[$i]['estado'] = ' <span class="badge bg-danger">Inactivo</span>';
            $data[$i]['acciones'] = '<div>                     
            <button type="button" class="btn btn-success" onclick="reingresarUsuario('.$data[$i]['id'].');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
           </div>';    
           
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function usuarioEliminado(){ 
           
        $this->views->getView($this, "usuarioEliminado");
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


        if(empty($usuario) || empty($nombre ) || $caja == "Seleccionar.."){
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
                if($clave != $confirmar){
                    $msg = (array('ok'=>false, 'post' => 'La contraseñas no coinciden.'));	
                }
                $data = $this->model->updateUsuario($usuario,$nombre,$caja, $hash,$id);
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

    public function validar(){

        if(empty($_POST['usuario']) || empty($_POST['clave']) ){
            $msg = "Los campos estan vacios";           
         }else{
             $usuario = $_POST['usuario'];
             $clave = $_POST['clave'];
             $hash = hash("SHA256", $clave);  
             $data = $this->model->getUsuario($usuario, $hash);
        
             if(empty($data)){
                 $msg = 'El usuario o la contraseña es incorrecto.'; 
             }else{
                
                 if($data['estado'] == 1){
                     $_SESSION['id_usuario'] = $data['id'];
                     $_SESSION['usuario'] = $data['usuario'];
                     $_SESSION['nombre'] = $data['nombre'];
                     $_SESSION['activo'] = true;
      
                     $msg = (array('ok'=> true, 'post' => 'Iniciando sesión'));		
                 }else{                    
                     $msg = 'usuario inactivo';
                 }           
             }
         }           
         echo json_encode($msg, JSON_UNESCAPED_UNICODE);       
        die();     
    }
  //cerrar sesion
    public function logout(){
        
        session_destroy();
        header("location:".base_url);

    }
    //cambiar password
    public function cambiarPass(){
        $clave_actual = $_POST['clave_actual'];
        $clave_nueva = $_POST['clave_nueva'];
        $confirmar_clave = $_POST['confirmar_clave'];

        if( empty($clave_actual) || empty($clave_nueva) ||  empty($confirmar_clave)){
            $msg = (array('modificado'=>false, 'post' => 'Todos los campos son obligatorios.'));
        }else{
           if($clave_nueva != $confirmar_clave ){
                 $msg = (array('modificado'=>false, 'post' => 'Las contraseñas no coinciden.'));
           }else{
                $id =  $_SESSION['id_usuario'];
                $hash = hash("SHA256", $clave_actual);
              
                $data = $this->model->getPass($hash, $id);  
              
                if(!empty($data)){                        
                    $verificar = $this->model->modificarPass(hash("SHA256",$clave_nueva), $id); 
                    if($verificar == 1){
                        $msg = (array('modificado'=>true, 'post' => 'La contraseña se cambió con éxito.'));
                    }else{
                        $msg = (array('modificado'=>false, 'post' => 'Error al cambiar la contraseña.'));
                    }
                }else{
                    $msg = (array('modificado'=>false, 'post' => 'La contraseña actual es diferente.'));
                }
           }
           
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    //permisos
    public function permisos($id){

        if( empty($_SESSION['activo'])){
            header("location:".base_url);
        } 
        $data['datos'] =  $this->model->getPermisos();
        $permisos =  $this->model->getDetallePermisos($id);
        $data['asignados'] = array();   
         
        foreach ($permisos as $permiso){           
            $data['asignados'][$permiso['id_permiso']] = true;
        }      
        $data['id_usuario'] =  $id;
        $this->views->getView( $this, "permisos",  $data ); 
    }
    //permisos usuarios
    public function RegistrarPermisos(){
        $msg = '';
        $id_user = $_POST['id_usuario'];   
        $eliminar = $this->model->eliminarPermisos($id_user);
        if($eliminar == 'ok'){
            if(!empty($_POST['permisos'])){
                foreach ($_POST['permisos'] as $id_permiso){           
                $msg = $this->model->registrarPermisos($id_user, $id_permiso);
               }
            }else{
                $msg = (array('ok'=>false, 'post' => 'Error al asignar los permisos.'));   
            }
            
        }
        if($msg == 'ok'){
             $msg = (array('ok'=>true, 'post' => 'Permisos asignado correctamente.'));          
        }else{
             $msg = (array('ok'=>false, 'post' => 'Error al asignar los permisos.'));   
        }         
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>