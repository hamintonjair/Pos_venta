<?php 

class Productos extends Controller{

    public function __construct()
    {
        session_start();       
        parent::__construct();
    }

    //VISTA DASHBOARD
    public function index(){

        if(empty($_SESSION['activo'])){
             header("location:".base_url);
        }
       $data = array(
            'proveedores' =>  $this->model->getProveedores(),
            'categorias' =>  $this->model->getCategorias(),
            'medidas'   =>  $this->model->getMedidas(),
       );  
        $this->views->getView($this, "producto", $data );

    }
    //listar los usuarios
    public function listar(){

        $data = $this->model->getProductos();
        for($i=0; $i < count($data); $i++){
          
            if($data[$i]['estado'] == 1){
                $data[$i]['imagen'] = '<img class="img-thumbnail" src ="'.base_url."Assets/img/".$data[$i]['foto'].'"
                width = "50px"; height: 100px>';
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>            
                <button type="button" class="btn btn-primary" onclick="editarProducto('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>   
                <button type="button" class="btn btn-danger" onclick="eliminarProducto('.$data[$i]['id'].');" title="Eliminar"><i class="far   
                fa-trash-alt"></i></button>    
               </div>';
                
            }else{
                $data[$i]['estado'] = ' <span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>                     
                <button type="button" class="btn btn-success" onclick="reingresarProducto('.$data[$i]['id'].');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
               </div>';
            }
           
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //registrar y actualizar usuarios
    public function registrarProductos(){

        $codigo = $_POST['codigo'];
        $descripcion = $_POST['descripcion'];
        $precio_compra = $_POST['precio_compra'];
        $precio_venta = $_POST['precio_venta'];    
        $id_medida = $_POST['id_medida'];
        $id_categoria = $_POST['id_categoria'];
        $id_proveedor = $_POST['id_proveedor'];      
        $id = $_POST['idProducto'];
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $tpmName = $img['tmp_name'];           
        $fecha = date("YmdHis");
          
        if(empty($codigo) || empty($descripcion ) || empty( $precio_compra) || empty($id_medida ) || empty( $precio_venta
        || empty($id_proveedor ) || empty( $id_categoria))){
            $msg = (array('ok'=>false, 'post' => 'Todos los campos son obligatorios.'));
        }else{        
            //validamos la imagen para removerla   
            if(!empty($name)){
                $imgNombre = $fecha.".jpg";
                $destino = "Assets/img/".$imgNombre;
            }else if(!empty($_POST['foto_actual']) && empty($name)){
              $imgNombre = $_POST['foto_actual'];
            }else{
                $imgNombre = "default.png";
            }
            if($id == ""){
                //registrar               
                    $data = $this->model->registrarProducto($codigo , $descripcion, $precio_compra , $precio_venta ,$id_medida,$id_categoria,$id_proveedor, $imgNombre  );

                    if($data == 'ok'){
                        $msg = (array('ok'=>true, 'post' => 'Producto registrado con éxito.'));
                     //eliminar la imagen
                      if(!empty($name)){
                        move_uploaded_file($tpmName, $destino);
                      }
                    }else if($data == "existe"){
                        $msg = (array('ok'=>false, 'post' => 'El Producto ya existe.'));	
                    }else{
                        $msg = (array('ok'=>false, 'post' => 'Error al registrar el Producto.'));
                    }
                
            }else{
                //actualizar
              
                $imgDelete = $this->model->editarProducto($id);                              
                if($imgDelete['foto'] != "default.png" ){            
                    if(file_exists("Assets/img/".$imgDelete['foto'])){
                        unlink("Assets/img/".$imgDelete['foto']);
                    }
                }              
                $data = $this->model->updateProducto($codigo , $descripcion, $precio_compra , $precio_venta ,$id_medida,$id_categoria,$id_proveedor, $imgNombre,$id);

                    if($data == 'modificado'){
                            //eliminar la imagen
                        if(!empty($name)){
                            move_uploaded_file($tpmName, $destino);
                        }
                        $msg = (array('modificado'=>true, 'post' => 'El Producto fue actualizado con éxito.'));

                    }else{
                        $msg = (array('modificado'=>false, 'post' => 'Error al actualizar el Producto.'));
                    }
               
            }
        
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die;
    }
    //Editar usuario
    public function editar(int $id){

        $data = $this->model->editarProducto($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();

    }
    //eliminar usuario
    public function deleteProducto(int $id){
       
        $data = $this->model->accionProducto(0, $id);  

        if($data == 1){
            $msg = (array('eliminado'=>true, 'post' => 'El Producto fue eliminado con éxito.'));
        }else{
            $msg = (array('eliminado'=>false, 'msg' => 'Error al eliminar el Producto.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    //reingresar usuario
    public function reingresarProducto(int $id){

        $data = $this->model->accionProducto(1, $id);  

        if($data == 1){
            $msg = (array('reingresado'=>true, 'post' => 'El Producto fue reingresado con éxito.'));
        }else{
            $msg = (array('reingresado'=>false, 'msg' => 'Error al reingresar el Producto.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

}
?>