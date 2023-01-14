<?php 

class ComprasModel extends Query{

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
}

?>