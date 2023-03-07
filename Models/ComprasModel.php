<?php

class ComprasModel extends Query {

    public function __construct()
 {
        parent::__construct();
    }

    //buscar producto por código

    public function getProCodi( string $cod ) {
      
        if(is_numeric($cod) == true){

            $sql = "SELECT * FROM productos WHERE codigo = '$cod'";
            
        }else{
            $sql = "SELECT * FROM productos WHERE descripcion = '$cod'";
        }
       
        $data = $this->select( $sql );
      
        return $data;
    }
    //registrar detalles

    public function getProductos( string $id ) {

        $sql = "SELECT * FROM productos WHERE id = $id";
        $data = $this->select( $sql );

        return $data;
    }
    //registrar datalles

    public function registrarDetallesC( int $id_producto, int $id_usuario, string $precio, int $cantidad, string $sub_total ) {

        $sql = 'INSERT INTO  detalle(id_producto, id_usuario, precio, cantidad, sub_total) VALUES(?,?,?,?,?)';
        $datos = array( $id_producto, $id_usuario, $precio, $cantidad, $sub_total );
        $data = $this->save( $sql, $datos );

        if ( $data == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;

    }
    //listar detalle de compra

    public function getDetalleC( int $id ) {

        $sql = "SELECT d.*, p.id as id_pro, p.descripcion FROM detalle d INNER JOIN productos p ON d.id_producto = p.id WHERE d.id_usuario = $id ";
        $data = $this->selectAll( $sql );

        return $data;
    }
    //listar detalle de compra

    public function calcularCompra( int $id_usuario ) {

        $sql = "SELECT sub_total, SUM(sub_total) AS total FROM detalle WHERE id_usuario = $id_usuario ";
        $data = $this->select( $sql );

        return $data;
    }
    //eliminar producto de detalles

    public function deleteDetalleC( int $id ) {
        $sql = 'DELETE FROM detalle WHERE id = ?';
        $datos = array( $id );
        $data = $this->save( $sql, $datos );

        if ( $data == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;

    }
    //validar prosuctos para sumar las cantidades

    public function consultarDetalleC( int $id_producto, int $id_usuario ) {

        $sql = "SELECT * FROM detalle WHERE id_producto = $id_producto AND id_usuario = $id_usuario";
        $data = $this->select( $sql );

        return $data;
    }
    //actualizar detalles

    public function actualizarDetallesC( string $precio, int $cantidad, string $sub_total, int $id_producto, int $id_usuario ) {

        $sql = 'UPDATE detalle SET precio = ?, cantidad = ?, sub_total = ? WHERE id_producto = ? AND id_usuario = ?';
        $datos = array( $precio, $cantidad, $sub_total, $id_producto, $id_usuario );
        $data = $this->save( $sql, $datos );

        if ( $data == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;
    }
    //registrar compra

    public function registrarCompra( string $total, int $id_proveedor ) {

        $sql = 'INSERT INTO  compras (total, id_proveedor) VALUES(?,?)';
        $datos = array( $total, $id_proveedor );
        $data = $this->save( $sql, $datos );

        if ( $data == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;

    }
    //seleccionar id compra

    public function id_Compra() {
        $sql = 'SELECT MAX(id) AS id FROM compras';
        $data = $this->select( $sql );
        return $data;
    }
    //tregistrar Detalle Compra

    public function registrarDetalleCompra( int $id_compra,  int $id_prod, int $cantidad, string $precio, string $sub_total ) {

        $sql = 'INSERT INTO  datella_compras (id_compra, id_producto, cantidad, precio, sub_total) VALUES(?,?,?,?,?)';
        $datos = array( $id_compra, $id_prod, $cantidad, $precio, $sub_total );
        $data = $this->save( $sql, $datos );

        if ( $data == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;

    }
    //datos de la empresa

    public function getEmpresa() {
        $sql = 'SELECT * FROM configuracion';
        $data = $this->select( $sql );
        return $data;
    }
    //vaciar detalles

    public function vaciarDetalleC( int $id_usuario ) {

        $sql = 'DELETE FROM  detalle WHERE id_usuario = ?';
        $datos = array( $id_usuario );
        $data = $this->save( $sql, $datos );

        if ( $data == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;

    }
    //datos de la compra

    public function getCompra( int $id_compra ) {

        $sql = "SELECT c.*, d.*, p.id, p.descripcion, pro.nombre FROM compras c INNER JOIN datella_compras d ON c.id = d.id_compra INNER JOIN productos p ON
        p.id = d.id_producto  INNER JOIN proveedor pro ON pro.id = c.id_proveedor WHERE c.id = $id_compra";

        $data = $this->selectAll( $sql );
        return $data;
    }
    //historial compras

    public function getHistorialCompra() {

        $sql = 'SELECT c.*, p.nombre FROM proveedor p INNER JOIN compras c WHERE p.id = c.id_proveedor';
        $data = $this->selectAll( $sql );
        return $data;
    }
    //actualizar stock
    public function actualizarStockC( int $cantidad, int $id_prod ) {

        $sql = 'UPDATE productos SET cantidad = ? WHERE id = ?';
        $datos = array( $cantidad, $id_prod );
        $data = $this->save( $sql, $datos );

        return $data;

    }
    //anular compra
    public function getAnularCompra(int $id_compra) {

        $sql = "SELECT c.*, d.* FROM compras c INNER JOIN datella_compras d ON c.id = d.id_compra WHERE c.id = $id_compra";
        $data = $this->selectAll( $sql );
        return $data;
    }
    //anulado
    public function getAnular(int $id_compra){

        $sql = "UPDATE compras SET estado = ? WHERE id = ?";
        $datos = array( 0, $id_compra);
        $data = $this->save($sql, $datos);
    
        if($data == 1){
            $result = 'modificado';
        }else{
            $result = 'error';
        }     
        return $result;  
    }
    //consultar usuario
    public function getUsuario(int $id_usuario){
        $sql = "SELECT * FROM usuarios WHERE id = $id_usuario";
        $data = $this->select( $sql );
        return $data;
    }
    //verificar permisos

    public function verificarPermisos( int $id_user, string $nombre )
   {
        $sql = "SELECT p.id, p.permiso, d.id, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.permiso = '$nombre' ";
        $data = $this->selectAll( $sql );
        return $data;
    }

}

?>