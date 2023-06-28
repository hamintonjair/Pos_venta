<?php 

class Categorias extends CI_Controller{

    public function __construct()
    {
        session_start();   
        if( empty($_SESSION['activo'])){
            echo '<script>window.location.href="http://localhost/Pos_venta/"</script>';	
       }     
        parent::__construct();
        $this->load->model('CategoriasModel');
        $this->load->model('DashboardModel');
    }
    //VISTA DASHBOARD
    public function vista_usuario(){  
        
        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->DashboardModel->verificarPermisos($id_user, 'categorias');
        if(!empty($verificar) || $id_user == 1){
            $this->load->view('layouts/Templates/header_admin');
            $this->load->view('layouts/Templates/nav_admin');
            $this->load->view('layouts/Templates/body');
            $this->load->view('layouts/Categorias/categoria');
            $this->load->view('layouts/Templates/footer_admin');
        }else{
            echo '<script>window.location.href="http://localhost/Pos_venta/Errors/permisos"</script>';	
        }
       
    }
    //registrar y actualizar categoria
    public function registrarCategoria(){

            $categoria = $this->input->post('categoria');                
            $id = $this->input->post('idCategoria');       
       
            if(empty($categoria)){
                $msg = (array('ok'=>false, 'post' => 'Todos los campos son obligatorios.'));
            }else{                
                if($id == ""){
                    //registrar                   
                        $data = $this->CategoriasModel->registrarCategoria($categoria );
                        if($data == 'ok'){
                            $msg = (array('ok'=>true, 'post' => 'Categoria registrado con éxito.'));
    
                        }else if($data == "existe"){
                            $msg = (array('ok'=>false, 'post' => 'la Categoria ya existe.'));	
                        }else{
                            $msg = (array('ok'=>false, 'post' => 'Error al registrar el Categoria.'));
                        }
                    
                }else{
                    //actualizar                  
                    $data = $this->CategoriasModel->updateCategoria($categoria, $id);
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

        $data = $this->CategoriasModel->getCategorias();

        for($i=0; $i < count($data); $i++){
          
                $data[$i]->estado = '<span class="badge badge-success">Activo</span>';
                if($_SESSION['rol'] == 'Administrador'){
                    $data[$i]->acciones = '<div>            
                    <button type="button" class="btn btn-primary" onclick="editarCategoria('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit"></i></button>   
                    <button type="button" class="btn btn-danger" onclick="eliminarCategoria('.$data[$i]->id.');" title="Eliminar"><i class="far fa-trash-alt"></i></button>            
                </div>';
                                
                }else if( $_SESSION['rol'] == 'Supervisor'){
                    $data[$i]->acciones = '<div>            
                    <button type="button" class="btn btn-primary" onclick="editarCategoria('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit"></i></button>   
                    <button type="button"  disabled="" class="btn btn-danger" onclick="eliminarCategoria('.$data[$i]->id.');" title="Eliminar"><i class="far fa-trash-alt"></i></button>            
                </div>';
                }else{
   
                         $data[$i]->acciones = '<div>            
                    <button type="button" disabled="" class="btn btn-primary" onclick="editarCategoria('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit"></i></button>   
                    <button type="button" disabled="" class="btn btn-danger" onclick="eliminarCategoria('.$data[$i]->id.');" title="Eliminar"><i class="far fa-trash-alt"></i></button>            
                   </div>';
           
                   
                                    
                }
     
        }      
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function listarEliminado() {

        $data = $this->CategoriasModel->getCategoriasEliminados();
        for ( $i = 0; $i < count( $data );
        $i++ ) {
        
            $data[$i]->estado = '<span class="badge badge-danger">Inactivo</span>';
            $data[$i]->acciones = '<div>               
               <button type="button" class="btn btn-success" onclick="reingresarCategoria('.$data[$i]->id.');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
           </div>';
        }
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    public function categoriaEliminado(){ 
        $this->load->view('layouts/Templates/header_admin');
        $this->load->view('layouts/Templates/nav_admin');
        $this->load->view('layouts/Templates/body');
        $this->load->view('layouts/Categorias/categoriaEliminado');
        $this->load->view('layouts/Templates/footer_admin');
    }
    //Editar categoria
    public function editar(int $id){

        $data = $this->CategoriasModel->editarCategoria($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //verificar relacion
    public function eliminar(int $id) {
        // Verificar la relación de la categoria con otra tabla
        $tieneRelacion = $this->CategoriasModel->verificarRelacion($id);

        if ($tieneRelacion > 0) {
            $response['success'] = false;
            $response['message'] = 'La categoría tiene relaciones con otras tablas. ¿Desea eliminarlo de todas formas?, su estado cambiará a inactivo';

            echo json_encode($response);
            exit;
        } else {
            // Eliminar la categoiria
            $eliminado = $this->CategoriasModel->accionCategoria(0,$id);

            if ($eliminado > 0) {
                $response['success'] = true;
                $response['message'] = 'Categoría eliminado correctamente';
            } else {
                $response['success'] = false;
                $response['message'] = 'Error al eliminar la categoría';
            }

            echo json_encode($response,JSON_UNESCAPED_UNICODE);
            die();
        }
    }
     //eliminar categoria
    public function deleteCategoria(int $id){

        $data = $this->CategoriasModel->accionCategoria(0, $id);  

        if($data = true){
            $msg = (array('eliminado'=>true, 'post' => 'La Categoria no se eliminará de forma permanente, solo cambiará el estado a inactivo..'));
        }else{
            $msg = (array('eliminado'=>false, 'msg' => 'Error al eliminar el Categoria.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function vaciarCategorias(){
        $data = $this->CategoriasModel->vaciarCategorias();  

        if($data > 0){
            $msg = (array('eliminado'=>true, 'post' => 'Las Categorias fueron vaciados con éxito.'));
        }else{
            $msg = (array('eliminado'=>false, 'msg' => 'Error al vaciar las Categoria.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    //reingresar caj
    public function reingresarCategoria(int $id){

        $data = $this->CategoriasModel->accionCategoria(1, $id);  

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