<?php 

class Usuarios extends CI_Controller{

    public function __construct()
    {

         session_start();
   
         if ( empty( $_SESSION[ 'activo' ] ) ) {
             echo '<script>window.location.href="http://localhost/Pos_venta/"</script>';	
 
         }
        parent::__construct();
        $this->load->model('UsuariosModel');
        $this->load->model('DashboardModel');

    }

    //VISTA DASHBOARD
    public function vista_usuario(){

        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->DashboardModel->verificarPermisos( $id_user, 'usuarios' );
      
        if ( !empty( $verificar ) || $id_user == 1 ) {
            if( empty($_SESSION['activo'])){
                header("location:".base_url);
            }
            $data['cajas'] =  $this->UsuariosModel->getCajas();

            $this->load->view('layouts/Templates/header_admin');
            $this->load->view('layouts/Templates/nav_admin');
            $this->load->view('layouts/Templates/body');
            $this->load->view('layouts/Usuarios/usuario', $data);
            $this->load->view('layouts/Templates/footer_admin');
        } else {
            echo '<script>window.location.href="http://localhost/Pos_venta/Errors/permisos"</script>';	
        }
    }

    //listar los usuarios
    public function listar(){

        $data = $this->UsuariosModel->getUsuarios();

        for($i=0; $i < count($data); $i++){          
                
               $data[$i]->estado = '<span class="badge badge-success">Activo</span>';
               if($data[$i]->id == 1){
                    $data[$i]->acciones = '<div>                     
                       <span class="badge bg-primary">Administrador</span>';
                    '<div>   
                </div>';
               }else{

                    if($_SESSION['rol'] == 'Administrador'){
                        $data[$i]->acciones = '<div>   
                        <a type="button" class="btn btn-dark" href="'.base_url().'usuarios/permisos/'.$data[$i]->id.'" title="Permisos"><i class="fas fa-key"></i></a>          
                        <button type="button" class="btn btn-primary" onclick="editarUsuario('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit"></i></button>   
                        <button type="button" class="btn btn-danger" onclick="eliminarUsuario('.$data[$i]->id.');" title="Eliminar"><i class="far   
                        fa-trash-alt"></i></button>    
                    </div>';
                    }else if( $_SESSION['rol'] == 'Supervisor'){
                        $data[$i]->acciones = '<div>   
                        <a type="button" class="btn btn-dark" href="'.base_url().'usuarios/permisos/'.$data[$i]->id.'" title="Permisos"><i class="fas fa-key"></i></a>          
                        <button type="button" class="btn btn-primary" onclick="editarUsuario('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit"></i></button>   
                        <button type="button" disabled="" class="btn btn-danger" onclick="eliminarUsuario('.$data[$i]->id.');" title="Eliminar"><i class="far   
                        fa-trash-alt"></i></button>    
                       </div>';
                    }else{

                        $data[$i]->acciones = '<div>   
                        <a type="button"id="miEnlace" class="btn btn-dark" href="'.base_url().'usuarios/permisos/'.$data[$i]->id.'" title="Permisos"><i class="fas fa-key"></i></a>          
                        <button type="button" disabled="" class="btn btn-primary" onclick="editarUsuario('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit"></i></button>   
                        <button type="button" disabled="" class="btn btn-danger" onclick="eliminarUsuario('.$data[$i]->id.');" title="Eliminar"><i class="far   
                        fa-trash-alt"></i></button>  
                        </div>';  
                    }
                
                }
              }
       
        
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //listar eliminados
    public function listarEliminados(){
        
        $data = $this->UsuariosModel->getUsuariosEliminados();
        for($i=0; $i < count($data); $i++){          
         
            $data[$i]->estado = ' <span class="badge bg-danger">Inactivo</span>';
            $data[$i]->acciones = '<div>                     
            <button type="button" class="btn btn-success" onclick="reingresarUsuario('.$data[$i]->id.');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
           </div>';    
           
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //vista usuarios eliminados
    public function usuarioEliminado(){ 
        
        $this->load->view('layouts/Templates/header_admin');
        $this->load->view('layouts/Templates/nav_admin');
        $this->load->view('layouts/Templates/body');
        $this->load->view('layouts/Usuarios/usuarioEliminado');
        $this->load->view('layouts/Templates/footer_admin');
    }
    //registrar y actualizar usuarios
    public function registrarUser(){

        $usuario = $this->input->post('usuario');
        $nombre = $this->input->post('nombre');
        $clave = $this->input->post('clave');
        $confirmar = $this->input->post('confirmar');
        $caja = $this->input->post('caja');
        $rol = $this->input->post('rol');
        $id = $this->input->post('idUsuario');
        $hash = hash("SHA256", $clave);

        if(empty($usuario) || empty($nombre ) || $caja == "Seleccionar.."){
            $msg = (array('ok'=>false, 'post' => 'Todos los campos son obligatorios.'));
        }else{
            
            if($id == ""){
                //registrar
                if($clave != $confirmar){
                    $msg = (array('ok'=>false, 'post' => 'La contraseñas no coinciden.'));	
                }else{
                    $data = $this->UsuariosModel->registrarUsuario($usuario,$nombre, $hash ,$caja, $rol);
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
                if($confirmar == ""){
                 
                   $data = $this->UsuariosModel->updateUsuario($usuario,$nombre,$caja, $rol, $clave,$id);
                }else{
                    $data = $this->UsuariosModel->updateUsuario($usuario,$nombre,$caja, $rol, $hash,$id);
                }
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

        $data = $this->UsuariosModel->editarUsuario($id);     
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();

    }
    //verificar relacion
    public function eliminar(int $id) {
        // Verificar la relación del usuario con otra tabla
        $tieneRelacion = $this->UsuariosModel->verificarRelacion($id);

        if ($tieneRelacion > 0) {
            $response['success'] = false;
            $response['message'] = 'El usuario tiene relaciones con otras tablas. ¿Desea eliminarlo de todas formas?, su estado cambiará a inactivo';

            echo json_encode($response);
            exit;
        } else {
            // Eliminar el usuario
            $eliminado = $this->UsuariosModel->accionUsuario(0,$id);

            if ($eliminado > 0) {
                $response['success'] = true;
                $response['message'] = 'Usuario eliminado correctamente';
            } else {
                $response['success'] = false;
                $response['message'] = 'Error al eliminar el usuario';
            }

            echo json_encode($response,JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    //eliminar usuario
    public function deleteUsuario(int $id){
       
        $data = $this->UsuariosModel->accionUsuario(0, $id);  

        if($data = true){
            $msg = (array('eliminado'=>true, 'post' => 'El usuario no se eliminará de forma permanente, solo cambiará el estado a inactivo.'));
        }else{
            $msg = (array('eliminado'=>false, 'msg' => 'Error al eliminar el Usuario.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    //reingresar usuario
    public function reingresarUsuario(int $id){

        $data = $this->UsuariosModel->accionUsuario(1, $id);  

        if($data > 0){
            $msg = (array('reingresado'=>true, 'post' => 'El Usuario fue reingresado con éxito.'));
        }else{
            $msg = (array('reingresado'=>false, 'msg' => 'Error al reingresar el Usuario.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    //vaciar usuarios
    public function vaciarUsuarios(){
        $data = $this->UsuariosModel->vaciarUsuarios();  

        if($data > 0){
            $msg = (array('eliminado'=>true, 'post' => 'Los Usuario fueron vaciados con éxito.'));
        }else{
            $msg = (array('eliminado'=>false, 'msg' => 'No es posible vaciar, hay usuarios asociados a ventas realizadas.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
 
    //cambiar password
    public function cambiarPass(){
        $clave_actual = $this->input->post('clave_actual');
        $clave_nueva = $this->input->post('clave_nueva');
        $confirmar_clave = $this->input->post('confirmar_clave');

        if( empty($clave_actual) || empty($clave_nueva) ||  empty($confirmar_clave)){
            $msg = (array('modificado'=>false, 'post' => 'Todos los campos son obligatorios.'));
        }else{
           if($clave_nueva != $confirmar_clave ){
                 $msg = (array('modificado'=>false, 'post' => 'Las contraseñas no coinciden.'));
           }else{
                $id =  $_SESSION['id_usuario'];
                $hash = hash("SHA256", $clave_actual);
              
                $data = $this->UsuariosModel->getPass($hash, $id);  
              
                if(!empty($data)){                        
                    $verificar = $this->UsuariosModel->modificarPass(hash("SHA256",$clave_nueva), $id); 
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
            echo '<script>window.location.href="http://localhost/Pos_venta/Errors/permisos"</script>';	
        } 
        $data['datos'] =  $this->UsuariosModel->getPermisos();
        $permisos =  $this->UsuariosModel->getDetallePermisos($id);
        $data['asignados'] = array();   
         
        foreach ($permisos as $permiso){           
            $data['asignados'][$permiso->id_permiso] = true;
        }      
        $data['id_usuario'] =  $id;
        $this->load->view('layouts/Templates/header_admin');
        $this->load->view('layouts/Templates/nav_admin');
        $this->load->view('layouts/Templates/body');
        $this->load->view('layouts/Usuarios/permisos',$data );
        $this->load->view('layouts/Templates/footer_admin');
    }
    //permisos usuarios
    public function RegistrarPermisos(){
        $msg = '';
        $id_user = $this->input->post('id_usuario');   
        $permisos = $this->input->post('permisos');
        $eliminar = $this->UsuariosModel->eliminarPermisos($id_user);

        if($eliminar == 'ok'){
            if(!empty($permisos)){
                foreach ($permisos as $id_permiso){  
       

                $msg = $this->UsuariosModel->registrarPermisos($id_user, $id_permiso);
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