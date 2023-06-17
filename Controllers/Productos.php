<?php 

class Productos extends Controller{

    public function __construct()
    {
        session_start();  
        if(empty($_SESSION['activo'])){
            header("location:".base_url);
       }     
        parent::__construct();
    }

    //VISTA DASHBOARD
    public function index(){

        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->model->verificarPermisos( $id_user, 'productos' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
            $data = array(
                'proveedores' =>  $this->model->getProveedores(),
                'categorias' =>  $this->model->getCategorias(),
                'medidas'   =>  $this->model->getMedidas(),
           );  
    
            $this->views->getView($this, "producto", $data );
        } else {
            header( 'location:'.base_url.'Errors/permisos' );
        }
      

    }
    //listar loOS PRODUCTOS
    public function listar(){

        $data = $this->model->getProductos();

        for($i=0; $i < count($data); $i++){
          
           
            if($data[$i]['estado'] == 1){
                $data[$i]['imagen'] = '<img class="img-thumbnail" src ="'.base_url."Assets/img/".$data[$i]['foto'].'"
                width = "50px"; height: 100px>';
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                if( $_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                    $data[$i]['acciones'] = '<div>            
                    <button type="button" class="btn btn-primary" onclick="editarProducto('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>   
                    <button type="button" class="btn btn-danger" onclick="eliminarProducto('.$data[$i]['id'].');" title="Eliminar"><i class="far   
                    fa-trash-alt"></i></button>    
                   </div>';
                }else{
                    $data[$i]['acciones'] = '<div>            
                    <button type="button" class="btn btn-primary" disabled="" onclick="editarProducto('.$data[$i]['id'].');" title="Editar"><i class="fas fa-edit"></i></button>   
                    <button type="button" class="btn btn-danger" disabled="" onclick="eliminarProducto('.$data[$i]['id'].');" title="Eliminar"><i class="far   
                    fa-trash-alt"></i></button>    
                   </div>';
                }
                
                
            }else{
                if($_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                      $data[$i]['estado'] = ' <span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>                     
                <button type="button" class="btn btn-success" onclick="reingresarProducto('.$data[$i]['id'].');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
               </div>';
                }
              
            }
           
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //listar productos eliminados
    public function listarEliminados(){
        
        $data = $this->model->getProductosEliminados();

        for($i=0; $i < count($data); $i++){
          
         
                $data[$i]['imagen'] = '<img class="img-thumbnail" src ="'.base_url."Assets/img/".'default.png'.'"   width = "50px"; height: 100px>';
                $data[$i]['estado'] = ' <span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>                     
                <button type="button" class="btn btn-success" onclick="reingresarProducto('.$data[$i]['id'].');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
               </div>';
        
           
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //vista productos eliminados
    public function productosEliminados(){ 
           
        $this->views->getView($this, "productosEliminados");
    }
    //registrar y actualizar usuarios
    public function registrarProductos(){

        $iva = $_POST['iva'];
        $codigo = $_POST['codigo'];
        $descripcion = $_POST['descripcion'];
        $precio_compra = $_POST['precio_compra'];
        $precio_venta = $_POST['precio_venta'];  
        $id_medida = $_POST['id_medida'];
        $vencimiento = $_POST['vencimiento'];  
        $id_categoria = $_POST['id_categoria'];
        $id_proveedor = $_POST['id_proveedor'];  
       
        $id = $_POST['idProducto'];
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $tpmName = $img['tmp_name'];       
   
       
        if($vencimiento == "No"){                      
      
            $fecha_vencimiento = "0000-00-00"; 
        }if($vencimiento  == "Seleccionar.."){            
            $msg = (array('ok'=>false, 'post' => 'Todos los campos son obligatorios.'));
        }if($vencimiento == "Si"){ 
           
            $fecha_vencimiento = $_POST['fecha']; 
        }       
        if($iva == ""){
            $iva = 0;
        }  

        $fecha = date("YmdHis");
     
         if($id_medida == "Seleccionar.." || $id_categoria == "Seleccionar.." ||  $id_proveedor == "Seleccionar.."){

            $msg = (array('ok'=>false, 'post' => 'Todos los campos son obligatorios.'));

         }else if(empty($codigo) || empty($descripcion ) || empty( $precio_venta )){

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

                if(empty( $precio_compra)){
                    $precio_compra = "0";
                }
              
                $cantidad = $_POST['cantidad'];                     
                //registrar               
                    $data = $this->model->registrarProducto($codigo , $descripcion, $precio_compra , $precio_venta, $cantidad, $iva,
                    $id_medida,$id_categoria,$id_proveedor, $imgNombre, $vencimiento, $fecha_vencimiento  );

                    if($data == 'ok'){
                        $msg = (array('ok'=>true, 'post' => 'Producto registrado con éxito.'));
                     //eliminar la imagen
                      if(!empty($name)){
                        move_uploaded_file($tpmName, $destino);
                       }
                    }else if($data['existe'] == "existe" && $data['id_proveedor']){
                        $msg = (array('ok'=>false, 'post' => 'El producto ya existe y está asociado a otro proveedor.'));	
                        
                    }else{
                        $msg = (array('ok'=>false, 'post' => 'Error al registrar el Producto.'));
                    }
                
            }else{
                //actualizar
             
     
                $imgDelete = $this->model->editarProducto($id);       
                // var_dump(  $imgNombre, $imgDelete['foto']);exit;                  
                if($imgDelete['foto'] !=  $imgNombre ){            
                    if(file_exists("Assets/img/".$imgDelete['foto'])){
                        unlink("Assets/img/".$imgDelete['foto']);
                    }
                }        
                  
                $data = $this->model->updateProducto($codigo , $descripcion, $precio_compra , $precio_venta, $iva ,
                $id_medida,$id_categoria,$id_proveedor, $imgNombre, $vencimiento, $fecha_vencimiento,$id);

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
    //vaciar productos eliminados
    public function vaciarProducto(){
        
        $data = $this->model->vaciarProducto();  

        if($data == 1){
            $msg = (array('eliminado'=>true, 'post' => 'Los Producto fueron vaciados con éxito.'));
        }else{
            $msg = (array('eliminado'=>false, 'msg' => 'Error al vaciar los Productos.'));
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