<?php 

class Productos extends CI_Controller{

    public function __construct()
    {
        session_start();  
        if(empty($_SESSION['activo'])){
            echo '<script>window.location.href="http://localhost/Pos_venta/"</script>';	

       }     
        parent::__construct();
        $this->load->model('ProductosModel');
        $this->load->model('DashboardModel');
        $this->load->model('CategoriasModel');
        $this->load->model('ProveedoresModel');
        $this->load->model('MedidasModel');
    }

    //VISTA DASHBOARD
    public function vista_usuario(){

        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->DashboardModel->verificarPermisos( $id_user, 'productos' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
            $data = array(
                'proveedores' =>  $this->ProveedoresModel->getProveedores(),
                'categorias' =>  $this->CategoriasModel->getCategorias(),
                'medidas'   =>  $this->MedidasModel->getMedidas(),
           );  
           $this->load->view('layouts/Templates/header_admin');
           $this->load->view('layouts/Templates/nav_admin');
           $this->load->view('layouts/Templates/body');
           $this->load->view('layouts/Productos/producto',$data);
           $this->load->view('layouts/Templates/footer_admin');
        } else {
            echo '<script>window.location.href="http://localhost/Pos_venta/Errors/permisos"</script>';	
        }  

    }
    //listar loOS PRODUCTOS
    public function listar(){

        $data = $this->ProductosModel->getProductos();

        for($i=0; $i < count($data); $i++){          
           
            if($data[$i]->estado == 1){
                $data[$i]->imagen = '<img class="img-thumbnail" src ="'.base_url()."assets/img/".$data[$i]->foto.'"
                width = "50px"; height: 100px>';
                $data[$i]->estado = '<span class="badge badge-success">Activo</span>';
                if( $_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                    $data[$i]->acciones = '<div>            
                    <button type="button" class="btn btn-primary" onclick="editarProducto('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit"></i></button>   
                    <button type="button" class="btn btn-danger" onclick="eliminarProducto('.$data[$i]->id.');" title="Eliminar"><i class="far   
                    fa-trash-alt"></i></button>    
                   </div>';
                }else{
                    $data[$i]->acciones = '<div>            
                    <button type="button" class="btn btn-primary" disabled="" onclick="editarProducto('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit"></i></button>   
                    <button type="button" class="btn btn-danger" disabled="" onclick="eliminarProducto('.$data[$i]->id.');" title="Eliminar"><i class="far   
                    fa-trash-alt"></i></button>    
                   </div>';
                }
                
                
            }else{
                if($_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                      $data[$i]->estado = ' <span class="badge badge-danger">Inactivo</span>';
                $data[$i]->acciones = '<div>                     
                <button type="button" class="btn btn-success" onclick="reingresarProducto('.$data[$i]->id.');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
               </div>';
                }
              
            }
           
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //listar productos eliminados
    public function listarEliminados(){
        
        $data = $this->ProductosModel->getProductosEliminados();

        for($i=0; $i < count($data); $i++){
          
                $data[$i]->imagen = '<img class="img-thumbnail" src ="'.base_url()."Assets/img/".'default.png'.'"   width = "50px"; height: 100px>';
                $data[$i]->estado = ' <span class="badge badge-danger">Inactivo</span>';
                $data[$i]->acciones = '<div>                     
                <button type="button" class="btn btn-success" onclick="reingresarProducto('.$data[$i]->id.');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
               </div>';       
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //vista productos eliminados
    public function productosEliminados(){ 
        $this->load->view('layouts/Templates/header_admin');
        $this->load->view('layouts/Templates/nav_admin');
        $this->load->view('layouts/Templates/body');
        $this->load->view('layouts/Productos/productosEliminados');
        $this->load->view('layouts/Templates/footer_admin');
    }
    //registrar y actualizar usuarios
    public function registrarProductos(){

        $iva = $this->input->post('iva');
        $codigo = $this->input->post('codigo');
        $descripcion = $this->input->post('descripcion');
        $precio_compra = $this->input->post('precio_compra');
        $precio_venta = $this->input->Post('precio_venta');  
        $id_medida = $this->input->post('id_medida');
        $vencimiento = $this->input->post('vencimiento');  
        $id_categoria = $this->input->post('id_categoria');
        $id_proveedor = $this->input->post('id_proveedor');  
       
        $id = $this->input->post('idProducto');
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $tpmName = $img['tmp_name'];     
    
        if($vencimiento == "No"){                      
      
            $fecha_vencimiento = "0000-00-00"; 
        }if($vencimiento  == "Seleccionar.."){            
            $msg = (array('ok'=>false, 'post' => 'Todos los campos son obligatorios.'));
        }if($vencimiento == "Si"){ 
           
            $fecha_vencimiento = $this->input->post('fecha'); 
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
            }else if(!empty($this->input->post('foto_actual')) && empty($name)){
              $imgNombre = $this->input->post('foto_actual');
            }else{
                $imgNombre = "default.png";
            }
            if($id == ""){

                if(empty( $precio_compra)){
                    $precio_compra = "0";
                }              
                $cantidad = $this->input->post('cantidad'); 
                             
                //registrar               
                    $data = $this->ProductosModel->registrarProducto($codigo , $descripcion, $precio_compra , $precio_venta, $cantidad, $iva,
                    $id_medida,$id_categoria,$id_proveedor, $imgNombre, $vencimiento, $fecha_vencimiento  );

                    if($data == 'ok'){
                        $msg = (array('ok'=>true, 'post' => 'Producto registrado con éxito.'));
                     //eliminar la imagen
                      if(!empty($name)){
                        move_uploaded_file($tpmName, $destino);
                       }
                    }else if($data[0] == "e"){
                        $msg = (array('ok'=>false, 'post' => 'El producto ya existe y está asociado a otro proveedor.'));	
                        
                    }else{
                        $msg = (array('ok'=>false, 'post' => 'Error al registrar el Producto.'));
                    }           
            }else{
                //actualizar
                $imgDelete = $this->ProductosModel->editarProducto($id);       
                // var_dump(  $imgNombre, $imgDelete['foto']);exit;  
                if($imgDelete[0]->foto !=  $imgNombre ){            
                    if(file_exists("Assets/img/".$imgDelete[0]->foto)){
                        unlink("Assets/img/".$imgDelete[0]->foto);
                    }
                }        
                  
                $data = $this->ProductosModel->updateProducto($codigo , $descripcion, $precio_compra , $precio_venta, $iva ,
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

        $data = $this->ProductosModel->editarProducto($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();

    }
    //verificar
    public function eliminar($id) {
        // Verificar la relación del producto con otra tabla
        $tieneRelacion = $this->ProductosModel->verificarRelacion($id);

        if ($tieneRelacion > 0) {
            $response['success'] = false;
            $response['message'] = 'El producto tiene relaciones con otras tablas. ¿Desea eliminarlo de todas formas?, su estado cambiará a inactivo';

            echo json_encode($response);
            exit;
        } else {
            // Eliminar el producto
            $eliminado = $this->ProductosModel->accionProducto(0,$id);
          
            if ($eliminado > 0) {
                $response['success'] = true;
                $response['message'] = 'Producto eliminado correctamente';
            } else {
                $response['success'] = false;
                $response['message'] = 'Error al eliminar el producto';
            }

            echo json_encode($response,JSON_UNESCAPED_UNICODE);
            die();
        }
    }
    //eliminar usuario
    public function deleteProducto($id){
       
        $data = $this->ProductosModel->accionProducto(0, $id);  

        if($data = true){
            $msg = (array('eliminado'=>true, 'post' => 'El Producto no se eliminará de forma permanente, solo cambiará el estado a inactivo.'));
        }else{
            $msg = (array('eliminado'=>false, 'msg' => 'Error al eliminar el Producto.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    //vaciar productos eliminados
    public function vaciarProducto(){
        
        $data = $this->ProductosModel->vaciarProducto();  

        if($data > 0){
            $msg = (array('eliminado'=>true, 'post' => 'Los Producto fueron vaciados con éxito.'));
        }else{
            $msg = (array('eliminado'=>false, 'msg' => 'Error al vaciar los Productos.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    //reingresar usuario
    public function reingresarProducto($id){

        $data = $this->ProductosModel->accionProducto(1, $id);  

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
