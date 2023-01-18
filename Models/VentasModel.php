<?php 

class VentasModel extends Query{

    public function __construct()
    {
        parent::__construct();
    }
  
   //buscar producto por código
   public function getProCod(string $cod){

    $sql = "SELECT * FROM productos WHERE codigo = '$cod'";
    $data = $this->select($sql);
    return $data;
    }
    //registrar detalles
    public function getProductos(string $id){
       
        $sql = "SELECT * FROM productos WHERE id = $id";
        $data = $this->select($sql);       
        return $data;
    }
    //registrar datalles
    public function registrarDetalles(int $id_producto, int $id_usuario, string $precio, int $cantidad,string $sub_total){

        $sql = "INSERT INTO  detalle(id_producto, id_usuario, precio, cantidad, sub_total) VALUES(?,?,?,?,?)";
        $datos = array( $id_producto,$id_usuario, $precio, $cantidad, $sub_total);
        $data = $this->save($sql, $datos);

        if($data == 1){
            $result = 'modificado';
        }else{
            $result = 'error';
        }     
        return $result;

    }
    //listar detalle de compra
    public function getDetalle(int $id){       
       
        $sql ="SELECT d.*, p.id as id_pro, p.descripcion FROM detalle d INNER JOIN productos p ON d.id_producto = p.id WHERE d.id_usuario = $id ";
        $data = $this->selectAll($sql);        
        return $data;
    }
      //listar detalle de compra
      public function calcularCompra(int $id_usuario){       
       
        $sql ="SELECT sub_total, SUM(sub_total) AS total FROM detalle WHERE id_usuario = $id_usuario ";
        $data = $this->select($sql);        
        return $data;
    }
    //eliminar producto de detalles
    public function deleteDetalle(int $id){
        $sql ="DELETE FROM detalle WHERE id = ?";
        $datos = array($id);
        $data = $this->save($sql, $datos); 
               
        if($data == 1){
            $result = 'modificado';
        }else{
            $result = 'error';
        }     
        return $result;

    }
    //validar prosuctos para sumar las cantidades
    public function consultarDetalle(  int $id_producto, int $id_usuario){

        $sql ="SELECT * FROM detalle WHERE id_producto = $id_producto AND id_usuario = $id_usuario";
        $data = $this->select($sql);   
        return $data;
    }
    //actualizar detalles
    public function actualizarDetalles(string $precio, int $cantidad, string $sub_total, int $id_producto, int $id_usuario){

        $sql = "UPDATE detalle SET precio = ?, cantidad = ?, sub_total = ? WHERE id_producto = ? AND id_usuario = ?";
        $datos = array($precio, $cantidad, $sub_total, $id_producto, $id_usuario );
        $data = $this->save($sql, $datos);

        if($data == 1){
            $result = 'modificado';
        }else{
            $result = 'error';
        }     
        return $result;
    }
     //registrar compra
    public function registrarCompra(string $total, int $id_proveedor){

        $sql = "INSERT INTO  compras (total, id_proveedor) VALUES(?,?)";
        $datos = array( $total, $id_proveedor);
        $data = $this->save($sql, $datos);

        if($data == 1){
            $result = 'modificado';
        }else{
            $result = 'error';
        }     
        return $result;  
    }
    //seleccionar id copmpra
    public function id_Compra(){
        $sql = "SELECT MAX(id) AS id FROM compras";
        $data = $this->select($sql);
        return $data;
    }
    //tregistrar Detalle Compra
    public function registrarDetalleCompra(int $id_compra,  int $id_prod, int $cantidad, string $precio, string $sub_total){

        $sql = "INSERT INTO  datella_compras (id_compra, id_producto, cantidad, precio, sub_total) VALUES(?,?,?,?,?)";
        $datos = array( $id_compra, $id_prod, $cantidad, $precio, $sub_total);
        $data = $this->save($sql, $datos);

        if($data == 1){
            $result = 'modificado';
        }else{
            $result = 'error';
        }     
        return $result;  
    }
   //datos d ela empresa
   public function getEmpresa(){
        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql);
        return $data;
   }
   //vaciar detalles
   public function vaciarDetalle(int $id_usuario){

        $sql = "DELETE FROM  detalle WHERE id_usuario = ?";
        $datos = array( $id_usuario);
        $data = $this->save($sql, $datos);

        if($data == 1){
            $result = 'modificado';
        }else{
            $result = 'error';
        }     
        return $result;  
   }
   //datos de la compra
   public function getCompra(int $id_compra){

        $sql = "SELECT c.*, d.*, p.id, p.descripcion FROM compras c INNER JOIN datella_compras d ON C.id = d.id_compra INNER JOIN productos p ON
        p.id = d.id_producto WHERE c.id = $id_compra";    
        $data = $this->selectAll($sql);
        return $data;
   }
   //historial compras
   public function getHiistoriaCompra(){

        $sql = "SELECT * FROM compras";
        $data = $this->selectAll($sql);
        return $data;
   }
   //actualizar stock
   public function actualizarStock(int $cantidad, int $id_prod){

    $sql = "UPDATE productos SET cantidad = ? WHERE id = ?";
    $datos = array( $cantidad, $id_prod );
    $data = $this->save($sql, $datos);   
    return $data;  
}
   
}

?>