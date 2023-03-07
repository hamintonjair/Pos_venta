<?php

class ProductosModel extends Query {
    private $fecha_vencimiento, $vencimiento, $iva, $codigo, $cantidad, $descripcion, $precio_compra, $precio_venta, $id_medida, $id_categoria, $id_proveedor, $foto;

    public function __construct()
 {
        parent::__construct();
    }
    //listar categoria

    public function getCategorias() {

        $sql = 'SELECT * FROM categorias WHERE estado = 1';
        $data = $this->selectAll( $sql );
        return $data;
    }

    public function getMedidas() {

        $sql = 'SELECT * FROM medidas WHERE estado = 1';
        $data = $this->selectAll( $sql );
        return $data;
    }

    public function getProveedores() {

        $sql = 'SELECT * FROM proveedor WHERE estado = 1';
        $data = $this->selectAll( $sql );
        return $data;
    }
    //listar productos

    public function getProductos() {

        $sql = 'SELECT p.*, m.id as id_medida, m.nombre as medida, c.id as id_categoria, c.nombre as categoria FROM productos as p INNER JOIN medidas m ON p.id_medida = m.id INNER JOIN categorias c ON p.id_categoria = c.id 
         WHERE p.estado = 1';
        $data = $this->selectAll( $sql );
        return $data;
    }
    //eliminados
    public function getProductosEliminados() {

        $sql = 'SELECT p.*, m.id as id_medida, m.nombre as medida, c.id as id_categoria, c.nombre as categoria FROM productos as p INNER JOIN medidas m ON p.id_medida = m.id INNER JOIN categorias c ON p.id_categoria = c.id  
        WHERE p.estado = 0';
        $data = $this->selectAll( $sql );
        return $data;
    }
    //registrar productos

    public function registrarProducto( string $codigo, string $descripcion, string $precio_compra, string $precio_venta, int $cantidad, 
    int $iva, int $descuento, int $id_medida, int $id_categoria, int $id_proveedor, string $foto, string $vencimiento, string $fecha_vencimiento ) {
        $this->iva = $iva;
        $this->descuento = $descuento;
        $this->codigo = $codigo;
        $this->descripcion = $descripcion;
        $this->precio_compra = $precio_compra;
        $this->precio_venta = $precio_venta;
        $this->vencimiento = $vencimiento;
        $this->fecha_vencimiento = $fecha_vencimiento;
        $this->cantidad = $cantidad;

        $this->id_medida = $id_medida;
        $this->id_categoria = $id_categoria;
        $this->id_proveedor = $id_proveedor;
        $this->foto = $foto;
        $verificar = "SELECT * FROM productos WHERE codigo = '$this->codigo'";
        $existe = $this->select( $verificar );
        if ( empty( $existe ) ) {
            $sql = "INSERT INTO productos(codigo, descripcion, precio_compra, precio_venta, cantidad, iva, descuento,
             id_medida, id_categoria, id_proveedor, foto, vencimiento, fecha_vencimiento) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $data = array( $this->codigo, $this->descripcion, $this->precio_compra, $this->precio_venta, $this->cantidad, $this->iva, 
            $this->descuento, $this->id_medida, $this->id_categoria, $this->id_proveedor, $this->foto, $this->vencimiento, $this->fecha_vencimiento);
            $datos = $this->save( $sql, $data );

            if ( $datos == 1 ) {
                $result = 'ok';
            } else {
                $result = 'error';
            }
        } else {

            $result = 'existe';
        }

        return $result;
    }
    //editar usuario

    public function editarProducto( int $id ) {

        $sql = "SELECT * FROM productos WHERE id = $id";
        $data = $this->select( $sql );
        return $data;

    }
    //update usuario

    public function updateProducto( string $codigo, string $descripcion, string $precio_compra, string $precio_venta, 
    int $iva, int $descuento, int $id_medida, int $id_categoria, int $id_proveedor, string $foto, string $vencimiento, string $fecha_vencimiento, int $id) {
        $this->iva = $iva;
        $this->descuento = $descuento;
        $this->codigo = $codigo;
        $this->descripcion = $descripcion;
        $this->precio_compra = $precio_compra;
        $this->precio_venta = $precio_venta;
        $this->vencimiento = $vencimiento;
        $this->fecha_vencimiento = $fecha_vencimiento;

        $this->id_medida = $id_medida;
        $this->id_categoria = $id_categoria;
        $this->id_proveedor = $id_proveedor;
        $this->foto = $foto;
        $this->id = $id;

        $sql = "UPDATE productos SET codigo = ?, descripcion = ?, precio_compra = ?, precio_venta = ?,iva = ?,  descuento = ?, id_medida = ?
        , id_categoria = ?, id_proveedor = ? , foto = ?, vencimiento = ?, fecha_vencimiento = ? WHERE id = ? ";
        $data = array( $this->codigo, $this->descripcion, $this->precio_compra, $this->precio_venta,$this->iva, 
        $this ->descuento, $this->id_medida, $this->id_categoria, $this->id_proveedor, $this->foto, $this->vencimiento, $this->fecha_vencimiento , $this->id);
        $datos = $this->save( $sql, $data );

        if ( $datos == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;
    }
    //eliminar usuario

    public function accionProducto( int $estado, int $id ) {

        $this->id = $id;
        $this->estado = $estado;
        $sql = 'UPDATE productos SET estado = ? WHERE id = ?';
        $datos = array( $this->estado, $this->id );
        $data = $this->save( $sql, $datos );

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