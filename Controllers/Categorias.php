<?php 

class Categorias extends Controller{

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
        $this->views->getView($this, "categoria");
    }
    //registrar y actualizar categoria
    public function registrarCategoria(){

            $categoria = $_POST['categoria'];                
            $id = $_POST['idCategoria'];       
       
            if(empty($categoria)){
                $msg = (array('ok'=>false, 'post' => 'Todos los campos son obligatorios.'));
            }else{                
                if($id == ""){
                    //registrar                   
                        $data = $this->model->registrarCategoria($categoria );
                        if($data == 'ok'){
                            $msg = (array('ok'=>true, 'post' => 'Categoria registrado con éxito.'));
    
                        }else if($data == "existe"){
                            $msg = (array('ok'=>false, 'post' => 'la Categoria ya existe.'));	
                        }else{
                            $msg = (array('ok'=>false, 'post' => 'Error al registrar el Categoria.'));
                        }
                    
                }else{
                    //actualizar                  
                    $data = $this->model->updateCategoria($categoria, $id);
                    if($data == 'modificado'){
                        $msg = (array('modificado'=>true, 'post' => 'La Categoria fue actualizado con éxito.'));
    
                    }else{
                        $msg = (array('modificado'=>false, 'post' => 'Error al actualizar la Categoria.'));
                    }
                }
            
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die;
    }
    //listar las categoria
    public function listar(){

        $data = $this->model->getCategorias();

        for($i=0; $i < count($data); $i++){
          
            if($data[$i]['estado'] == 1){
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>            
                <button type="button" class="btn btn-primary" onclick="editarCategoria('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>   
                <button type="button" class="btn btn-danger" onclick="eliminarCategoria('.$data[$i]['id'].');" title="Eliminar"><i class="far fa-trash-alt"></i></button>            
               </div>';
                
            }else{
                $data[$i]['estado'] = ' <span class="badge badge-danger">Inactivo</span>';
                 $data[$i]['acciones'] = '<div>               
                    <button type="button" class="btn btn-success" onclick="reingresarCategoria('.$data[$i]['id'].');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
                </div>';
            }
           
        }      
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //Editar categoria
    public function editar(int $id){

        $data = $this->model->editarCategoria($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
     //eliminar categoria
    public function deleteCategoria(int $id){
       
        $data = $this->model->accionCategoria(0, $id);  

        if($data == 1){
            $msg = (array('eliminado'=>true, 'post' => 'El Categoria fue eliminado con éxito.'));
        }else{
            $msg = (array('eliminado'=>false, 'msg' => 'Error al eliminar el Categoria.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    //reingresar caj
    public function reingresarCategoria(int $id){

        $data = $this->model->accionCategoria(1, $id);  

        if($data == 1){
            $msg = (array('reingresado'=>true, 'post' => 'El Categoria fue reingresado con éxito.'));
        }else{
            $msg = (array('reingresado'=>false, 'msg' => 'Error al reingresar el Categoria.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

}
?>