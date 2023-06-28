<?php 

class Proveedores extends CI_Controller{

    public function __construct()
    {
        session_start(); 
        if( empty($_SESSION['activo'])){
            echo '<script>window.location.href="http://localhost/Pos_venta/"</script>';	
       }      
        parent::__construct();
        $this->load->model('ProveedoresModel');
        $this->load->model('DashboardModel');

    }

    //VISTA DASHBOARD
    public function vista_usuario(){
        
        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->DashboardModel->verificarPermisos( $id_user, 'proveedor' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
            $this->load->view('layouts/Templates/header_admin');
            $this->load->view('layouts/Templates/nav_admin');
            $this->load->view('layouts/Templates/body');
            $this->load->view('layouts/Proveedores/proveedor');
            $this->load->view('layouts/Templates/footer_admin');
        } else {
            echo '<script>window.location.href="http://localhost/Pos_venta/Errors/permisos"</script>';	

       }
      
    }
    //listar los proveedores
    public function listar(){

        $data = $this->ProveedoresModel->getProveedores();
        for($i=0; $i < count($data); $i++){
          
            if($data[$i]->estado == 1){
                $data[$i]->estado = '<span class="badge badge-success">Activo</span>';
                if($data[$i]->id == 1){
                    $data[$i]->acciones = '<div>                     
                       <span class="badge bg-primary">Genérico</span>';
                    '<div>   
                </div>';
                }else if(  $_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                    $data[$i]->acciones = '<div>            
                    <button type="button" class="btn btn-primary" onclick="editarProveedor('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit"></i></button>   
                    <button type="button" class="btn btn-danger" onclick="eliminarProveedor('.$data[$i]->id.');" title="Eliminar"><i class="far   
                    fa-trash-alt"></i></button>    
                    </div>';
                }else{
                    $data[$i]->acciones = '<div>            
                    <button type="button" disabled="" class="btn btn-primary" onclick="editarProveedor('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit"></i></button>   
                    <button type="button" disabled="" class="btn btn-danger" onclick="eliminarProveedor('.$data[$i]->id.');" title="Eliminar"><i class="far   
                    fa-trash-alt"></i></button>    
                   </div>';
                }
              
                
            }else{
                if($_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                       $data[$i]->estado = ' <span class="badge badge-danger">Inactivo</span>';
                $data[$i]->acciones = '<div>                     
                <button type="button" class="btn btn-success" onclick="reingresarProveedor('.$data[$i]->id.');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
               </div>';
                }
             
            }
           
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //registrar y actualizar proveedores
    public function registrarProveedor(){

        $nit = $this->input->post('nit');
        $razon_social = $this->input->post('razon_social');
        $nombre = $this->input->post('nombre');
        $telefono = $this->input->post('telefono');
        $direccion = $this->input->post('direccion');
        $id = $this->input->post('idProveedor');

        if(empty($nit) || empty($razon_social ) || empty( $nombre) || empty($telefono ) || empty( $direccion)){
            $msg = (array('ok'=>false, 'post' => 'Todos los campos son obligatorios.'));
        }else{
            
            if($id == ""){
                //registrar                  
                    $data = $this->ProveedoresModel->registrarProveedor($nit, $razon_social, $nombre ,$telefono, $direccion );
                    if($data == 'ok'){
                        $msg = (array('ok'=>true, 'post' => 'Proveedor registrado con éxito.'));

                    }else if($data == "existe"){
                        $msg = (array('ok'=>false, 'post' => 'El Proveedor ya existe.'));	
                    }else{
                        $msg = (array('ok'=>false, 'post' => 'Error al registrar el Proveedor.'));
                    }              
            }else{
                //actualizar
                $data = $this->ProveedoresModel->updateProveedor($nit,$razon_social, $nombre ,$telefono, $direccion, $id);
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

        $data = $this->ProveedoresModel->editarProveedor($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();

    }
    //eliminar usuario
    public function deleteProveedor(int $id){
       
        $data = $this->ProveedoresModel->accionProveedor(0, $id);  

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

        $data = $this->ProveedoresModel->accionProveedor(1, $id);  

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