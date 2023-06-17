<?php 

class Proveedores extends Controller{

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
        
        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->model->verificarPermisos( $id_user, 'proveedor' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
            $this->views->getView($this, "proveedor");
        } else {
            header( 'location:'.base_url.'Errors/permisos' );
        }
      
    }
    //listar los proveedores
    public function listar(){

        $data = $this->model->getProveedores();
        for($i=0; $i < count($data); $i++){
          
            if($data[$i]['estado'] == 1){
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                if($data[$i]['id'] == 1){
                    $data[$i]['acciones'] = '<div>                     
                       <span class="badge bg-primary">Genérico</span>';
                    '<div>   
                </div>';
                }else if(  $_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                    $data[$i]['acciones'] = '<div>            
                    <button type="button" class="btn btn-primary" onclick="editarProveedor('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>   
                    <button type="button" class="btn btn-danger" onclick="eliminarProveedor('.$data[$i]['id'].');" title="Eliminar"><i class="far   
                    fa-trash-alt"></i></button>    
                    </div>';
                }else{
                    $data[$i]['acciones'] = '<div>            
                    <button type="button" disabled="" class="btn btn-primary" onclick="editarProveedor('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>   
                    <button type="button" disabled="" class="btn btn-danger" onclick="eliminarProveedor('.$data[$i]['id'].');" title="Eliminar"><i class="far   
                    fa-trash-alt"></i></button>    
                   </div>';
                }
              
                
            }else{
                if($_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                       $data[$i]['estado'] = ' <span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>                     
                <button type="button" class="btn btn-success" onclick="reingresarProveedor('.$data[$i]['id'].');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
               </div>';
                }
             
            }
           
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //registrar y actualizar proveedores
    public function registrarProveedor(){

        $nit = $_POST['nit'];
        $razon_social = $_POST['razon_social'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $id = $_POST['idProveedor'];

        if(empty($nit) || empty($razon_social ) || empty( $nombre) || empty($telefono ) || empty( $direccion)){
            $msg = (array('ok'=>false, 'post' => 'Todos los campos son obligatorios.'));
        }else{
            
            if($id == ""){
                //registrar                  
                    $data = $this->model->registrarProveedor($nit, $razon_social, $nombre ,$telefono, $direccion );
                    if($data == 'ok'){
                        $msg = (array('ok'=>true, 'post' => 'Proveedor registrado con éxito.'));

                    }else if($data == "existe"){
                        $msg = (array('ok'=>false, 'post' => 'El Proveedor ya existe.'));	
                    }else{
                        $msg = (array('ok'=>false, 'post' => 'Error al registrar el Proveedor.'));
                    }              
            }else{
                //actualizar
                $data = $this->model->updateProveedor($nit,$razon_social, $nombre ,$telefono, $direccion, $id);
                if($data == 'modificado'){
                    $msg = (array('modificado'=>true, 'post' => 'El Proveedor fue actualizado con éxito.'));

                }else{
                    $msg = (array('modificado'=>false, 'post' => 'Error al actualizar el Proveedor.'));
                }
            }
        
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die;
    }
    //Editar usuario
    public function editar(int $id){

        $data = $this->model->editarProveedor($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();

    }
    //eliminar usuario
    public function deleteProveedor(int $id){
       
        $data = $this->model->accionProveedor(0, $id);  

        if($data == 1){
            $msg = (array('eliminado'=>true, 'post' => 'El Proveedor fue eliminado con éxito.'));
        }else{
            $msg = (array('eliminado'=>false, 'msg' => 'Error al eliminar el Proveedor.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    //reingresar usuario
    public function reingresarProveedor(int $id){

        $data = $this->model->accionProveedor(1, $id);  

        if($data == 1){
            $msg = (array('reingresado'=>true, 'post' => 'El Proveedor fue reingresado con éxito.'));
        }else{
            $msg = (array('reingresado'=>false, 'msg' => 'Error al reingresar el Proveedor.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

}
?>