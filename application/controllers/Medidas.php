<?php 

class Medidas extends CI_Controller{

    public function __construct()
    {
        session_start();    
        if( empty($_SESSION['activo'])){
            echo '<script>window.location.href="http://localhost/Pos_venta/"</script>';	

       }    
        parent::__construct();
        $this->load->model('MedidasModel');
        $this->load->model('DashboardModel');
    }
    //VISTA DASHBOARD
    public function vista_usuario(){  
       
        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->DashboardModel->verificarPermisos( $id_user, 'medidas' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
            $this->load->view('layouts/Templates/header_admin');
            $this->load->view('layouts/Templates/nav_admin');
            $this->load->view('layouts/Templates/body');
            $this->load->view('layouts/Medidas/medida');
            $this->load->view('layouts/Templates/footer_admin');
        } else {
            echo '<script>window.location.href="http://localhost/Pos_venta/Errors/permisos"</script>';	
        }
       
    }
    //registrar y actualizar caja
    public function registrarMedida(){

            $nombre = $this->input->post('nombre');     
            $nombre_corto = $this->input->post('nombre_corto');             
            $id = $this->input->post('idMedida');       
            if(empty($nombre) || empty($nombre_corto)){
                $msg = (array('ok'=>false, 'post' => 'Todos los campos son obligatorios.'));
            }else{                
                if($id == ""){
                    //registrar                   
                        $data = $this->MedidasModel->registrarMedida($nombre,  $nombre_corto );
                        if($data == 'ok'){
                            $msg = (array('ok'=>true, 'post' => 'Unidad de medida registrada con éxito.'));
    
                        }else if($data == "existe"){
                            $msg = (array('ok'=>false, 'post' => 'la unidad de medida ya existe.'));	
                        }else{
                            $msg = (array('ok'=>false, 'post' => 'Error al registrar la la unidad de medida.'));
                        }
                    
                }else{
                    //actualizar                  
                    $data = $this->MedidasModel->updateMedida($nombre,  $nombre_corto , $id);
                    if($data == 'modificado'){
                        $msg = (array('modificado'=>true, 'post' => 'La unidad de medida fue actualizada con éxito.'));
    
                    }else{
                        $msg = (array('modificado'=>false, 'post' => 'Error al actualizar la unidad de Medida.'));
                    }
                }
            
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
    }
    //listar las caja
    public function listar(){

        $data = $this->MedidasModel->getMedidas();

        for($i=0; $i < count($data); $i++){
                
                $data[$i]->estado = '<span class="badge badge-success">Activo</span>';
                if( $_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                    $data[$i]->acciones = '<div>            
                    <button type="button" class="btn btn-danger" onclick="eliminarMedida('.$data[$i]->id.');" title="Eliminar"><i class="far fa-trash-alt"></i></button>            
                   </div>';       
                }else{
                    $data[$i]->acciones = '<div>            
                    <button type="button" disabled="" class="btn btn-danger" onclick="eliminarMedida('.$data[$i]->id.');" title="Eliminar"><i class="far fa-trash-alt"></i></button>            
                   </div>';       
                }   
        }      
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function listarEliminado() {

        $data = $this->MedidasModel->getMedidasEliminados();
        for ( $i = 0; $i < count( $data );
        $i++ ) {
            $data[$i]->estado = ' <span class="badge badge-danger">Inactivo</span>';
            $data[$i]->acciones = '<div>               
               <button type="button" class="btn btn-success" onclick="reingresarMedida('.$data[$i]->id.');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
           </div>';
        }
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    public function medidasEliminado(){ 
        $this->load->view('layouts/Templates/header_admin');
        $this->load->view('layouts/Templates/nav_admin');
        $this->load->view('layouts/Templates/body');
        $this->load->view('layouts/Medidas/medidasEliminado');
        $this->load->view('layouts/Templates/footer_admin');   
    }
    //Editar caja
    public function editar(int $id){

        $data = $this->MedidasModel->editarMedida($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
     //eliminar caja
    public function eliminar(int $id) {
        // Verificar la relación de la unidad demedida con otra tabla
        $tieneRelacion = $this->MedidasModel->verificarRelacion($id);

        if ($tieneRelacion > 0) {
            $response['success'] = false;
            $response['message'] = 'La medida tiene relaciones con otras tablas. ¿Desea eliminarlo de todas formas?, su estado cambiará a inactivo';

            echo json_encode($response);
            exit;
        } else {
            // Eliminar el unidad de medida
            $eliminado = $this->MedidasModel->accionMedida(0,$id);

            if ($eliminado > 0) {
                $response['success'] = true;
                $response['message'] = 'Unidad de medida eliminado correctamente';
            } else {
                $response['success'] = false;
                $response['message'] = 'Error al eliminar la unidad de medida';
            }

            echo json_encode($response,JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    public function deleteMedida(int $id){
       
        $data = $this->MedidasModel->accionMedida(0, $id);  

        if($data = true){
            $msg = (array('eliminado'=>true, 'post' => 'La unidad de medida no se eliminará de forma permanente, solo cambiará el estado a inactivo..'));
        }else{
            $msg = (array('eliminado'=>false, 'msg' => 'Error al eliminar la unidad de medida.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    //vaciar medidas
    public function vaciarMedidas(){
        $data = $this->MedidasModel->vaciarMedidas();  

        if($data > 0){
            $msg = (array('eliminado'=>true, 'post' => 'Las  unidades de medidas fueron vaciados con éxito.'));
        }else{
            $msg = (array('eliminado'=>false, 'msg' => 'Error al vaciar las unidades de medidas.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    //reingresar caj
    public function reingresarMedida(int $id){

        $data = $this->MedidasModel->accionMedida(1, $id);  

        if($data > 0){
            $msg = (array('reingresado'=>true, 'post' => 'La Medida fue reingresada con éxito.'));
        }else{
            $msg = (array('reingresado'=>false, 'msg' => 'Error al reingresar la Medida.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

}
?>