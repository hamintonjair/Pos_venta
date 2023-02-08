<?php

class VentasModel extends Query {

    public function __construct()
 {
        parent::__construct();
    }

    //buscar producto por código

    public function getProCod( string $cod ) {

        $sql = "SELECT * FROM productos WHERE codigo = '$cod'";
        $data = $this->select( $sql );

        if ( !empty( $data ) ) {
            $result = array( 'ok' => true, 1 => $data ) ;
        } else {
            $result = false;
        }

        return $result;

    }
    //registrar detalles ventas

    public function getProductos( string $id ) {

        $sql = "SELECT * FROM productos WHERE id = $id";
        $data = $this->select( $sql );

        return $data;
    }
    //buscar cliente

    public function getCliente( string $cedula ) {
        $sql = "SELECT * FROM clientes WHERE dni = $cedula AND estado = 1";
        $data = $this->select( $sql );

        return $data;
    }
    //registrar datalles

    public function registrarDetalles( int $id_producto, int $id_usuario, string $precio, int $cantidad, int $iva, string $sub_total ) {

        $sql = 'INSERT INTO  detalle_temp(id_producto, id_usuario, precio, cantidad, iva, sub_total) VALUES(?,?,?,?,?,?)';
        $datos = array( $id_producto, $id_usuario, $precio, $cantidad, $iva, $sub_total );
        $data = $this->save( $sql, $datos );

        if ( $data == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;

    }
    //listar detalle de ventas

    public function getDetalle( int $id ) {

        $sql = "SELECT d.*, p.id as id_pro, p.descripcion FROM detalle_temp d INNER JOIN productos p ON d.id_producto = p.id WHERE d.id_usuario = $id ";
        $data = $this->selectAll( $sql );

        return $data;
    }
    //listar detalle de venta

    public function calcularVenta( int $id_usuario ) {

        $sql = "SELECT sub_total, SUM(sub_total) AS total FROM detalle_temp WHERE id_usuario = $id_usuario ";
        $data = $this->select( $sql );

        return $data;
    }
    //eliminar producto de detalles

    public function deleteDetalle( int $id ) {
        $sql = 'DELETE FROM detalle_temp WHERE id = ?';
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

    public function consultarDetalle( int $id_producto, int $id_usuario ) {

        $sql = "SELECT * FROM detalle_temp WHERE id_producto = $id_producto AND id_usuario = $id_usuario";
        $data = $this->select( $sql );

        return $data;
    }
    //actualizar detalles

    public function actualizarDetalles( string $precio, int $cantidad, int $iva, string $sub_total, int $id_producto, int $id_usuario ) {

        $sql = 'UPDATE detalle_temp SET precio = ?, cantidad = ?, iva = ?, sub_total = ? WHERE id_producto = ? AND id_usuario = ?';
        $datos = array( $precio, $cantidad, $iva, $sub_total, $id_producto, $id_usuario );
        $data = $this->save( $sql, $datos );

        if ( $data == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;
    }
    //registrar venta

    public function registrarVenta( int  $id_usuario, string $total, int $id_cliente ) {

        $sql = 'INSERT INTO ventas (id_usuario, total, id_cliente) VALUES(?,?,?)';

        $datos = array( $id_usuario, $total, $id_cliente );
        $data = $this->save( $sql, $datos );

        if ( $data == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;

    }
    //seleccionar id venta

    public function id_Venta() {
        $sql = 'SELECT MAX(id) AS id FROM ventas';
        $data = $this->select( $sql );
        return $data;
    }
    //tregistrar Detalle venta

    public function registrarDetalleVenta( int $id_venta,  int $id_prod, int $cantidad, int $iva, string $descuento, string $precio, string $sub_total ) {

        $sql = 'INSERT INTO  detalle_ventas (id_venta, id_producto, cantidad, iva, descuento, precio, sub_total) VALUES(?,?,?,?,?,?,?)';
        $datos = array( $id_venta, $id_prod, $cantidad, $iva, $descuento, $precio, $sub_total );
        $data = $this->save( $sql, $datos );

        if ( $data == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;

    }
    //datos d ela empresa

    public function getEmpresa() {
        $sql = 'SELECT * FROM configuracion';
        $data = $this->select( $sql );
        return $data;
    }
    //vaciar detalles

    public function vaciarDetalle( int $id_usuario ) {

        $sql = 'DELETE FROM  detalle_temp WHERE id_usuario = ?';
        $datos = array( $id_usuario );
        $data = $this->save( $sql, $datos );

        if ( $data == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;

    }
    //datos de la venta

    public function getVenta( int $id_venta ) {

        $sql = "SELECT v.*, d.*, p.id, p.descripcion, c.nombre FROM ventas v INNER JOIN detalle_ventas d ON v.id = d.id_venta INNER JOIN productos p ON
        p.id = d.id_producto INNER JOIN clientes c ON c.id = v.id_cliente WHERE v.id = $id_venta";

        $data = $this->selectAll( $sql );
        return $data;
    }
    //historial venta

    public function getHistorialVenta() {

        $sql = 'SELECT v.*, c.nombre FROM clientes c INNER JOIN ventas v WHERE c.id = v.id_cliente';

        $data = $this->selectAll( $sql );
        return $data;
    }
    //actualizar stock

    public function actualizarStock( int $cantidad, int $id_prod ) {

        $sql = 'UPDATE productos SET cantidad = ? WHERE id = ?';
        $datos = array( $cantidad, $id_prod );
        $data = $this->save( $sql, $datos );

        return $data;

    }
    //actualizar descuento

    public function actualizarDescuento( string $desc, string $sub_total,  int $id ) {

        $sql = 'UPDATE detalle_temp SET descuento = ?, sub_total = ? WHERE id = ?';
        $datos = array( $desc, $sub_total, $id );
        $data = $this->save( $sql, $datos );

        if ( $data == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;

    }
    //verificar descuento

    public function verificarDescuento( int $id ) {

        $sql = "SELECT * FROM detalle_temp  WHERE id = $id";

        $data = $this->select( $sql );
        return $data;

    }
    //seleccionar elñ descxuento aplicado

    public function getDescuento( int $id_venta ) {
        $sql = "SELECT descuento, SUM(descuento) AS total FROM detalle_ventas WHERE id_venta = $id_venta ";
        $data = $this->select( $sql );

        return $data;
    }
    //anulado

    public function getAnular( int $id_venta ) {

        $sql = 'UPDATE ventas SET estado = ? WHERE id = ?';
        $datos = array( 0, $id_venta );
        $data = $this->save( $sql, $datos );

        if ( $data == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;

    }
    //anular venta

    public function getAnularVenta( int $id_venta ) {

        $sql = "SELECT v.*, d.* FROM ventas v INNER JOIN detalle_ventas d ON v.id = d.id_venta WHERE v.id = $id_venta";
        $data = $this->selectAll( $sql );
        return $data;
    }
    //consultar usuario

    public function getUsuario( int $id_usuario ) {
        $sql = "SELECT * FROM usuarios WHERE id = $id_usuario";
        $data = $this->select( $sql );
        return $data;
    }
    //verificar caja abierta

    public function verificarCaja( $id_usuario ) {

        $sql = "SELECT * FROM cierre_caja WHERE id_usuario = $id_usuario AND estado = 1";
        $data = $this->select( $sql );
        return $data;
    }

}

?>