<?php 

class Medidas extends Controller{

    public function __construct()
    {
        session_start();        
        parent::__construct();
    }
    //VISTA DASHBOARD
    public function index(){  
        if( empty($_SESSION['activo'])){
             header("location:".base_url);
        }
        $this->views->getView($this, "medida");
    }
    //registrar y actualizar caja
    public function registrarMedida(){

            $nombre = $_POST['nombre'];     
            $nombre_corto = $_POST['nombre_corto'];             
            $id = $_POST['idMedida'];       
       
            if(empty($nombre) || empty($nombre_corto)){
                $msg = (array('ok'=>false, 'post' => 'Todos los campos son obligatorios.'));
            }else{                
                if($id == ""){
                    //registrar                   
                        $data = $this->model->registrarMedida($nombre,  $nombre_corto );
                        if($data == 'ok'){
                            $msg = (array('ok'=>true, 'post' => 'Medida registrada con éxito.'));
    
                        }else if($data == "existe"){
                            $msg = (array('ok'=>false, 'post' => 'la Medida ya existe.'));	
                        }else{
                            $msg = (array('ok'=>false, 'post' => 'Error al registrar la Medida.'));
                        }
                    
                }else{
                    //actualizar                  
                    $data = $this->model->updateMedida($nombre,  $nombre_corto , $id);
                    if($data == 'modificado'){
                        $msg = (array('modificado'=>true, 'post' => 'La Medida fue actualizada con éxito.'));
    
                    }else{
                        $msg = (array('modificado'=>false, 'post' => 'Error al actualizar la Medida.'));
                    }
                }
            
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die;
    }
    //listar las caja
    public function listar(){

        $data = $this->model->getMedidas();

        for($i=0; $i < count($data); $i++){
          
            if($data[$i]['estado'] == 1){
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>            
                <button type="button" class="btn btn-primary" onclick="editarMedida('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>   
                <button type="button" class="btn btn-danger" onclick="eliminarMedida('.$data[$i]['id'].');" title="Eliminar"><i class="far fa-trash-alt"></i></button>            
               </div>';
                
            }else{
                $data[$i]['estado'] = ' <span class="badge badge-danger">Inactivo</span>';
                 $data[$i]['acciones'] = '<div>               
                    <button type="button" class="btn btn-success" onclick="reingresarMedida('.$data[$i]['id'].');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
                </div>';
            }
           
        }      
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //Editar caja
    public function editar(int $id){

        $data = $this->model->editarMedida($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
     //eliminar caja
    public function deleteMedida(int $id){
       
        $data = $this->model->accionMedida(0, $id);  

        if($data == 1){
            $msg = (array('eliminado'=>true, 'post' => 'El Medida fue eliminada con éxito.'));
        }else{
            $msg = (array('eliminado'=>false, 'msg' => 'Error al eliminar la Medida.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    //reingresar caj
    public function reingresarMedida(int $id){

        $data = $this->model->accionMedida(1, $id);  

        if($data == 1){
            $msg = (array('reingresado'=>true, 'post' => 'La Medida fue reingresada con éxito.'));
        }else{
            $msg = (array('reingresado'=>false, 'msg' => 'Error al reingresar la Medida.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

}
?>