<?php

class InventarioModel extends Query {
   
    public function __construct()
     {
        parent::__construct();
    }

    //verificar permisos
    public function verificarPermisos( int $id_user, string $nombre )
    {
        $sql = "SELECT p.id, p.permiso, d.id, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.permiso = '$nombre' ";
        $data = $this->selectAll( $sql );
        return $data;
    }
    //productos bajos
    public function getProductosInventario() {

        $sql = 'SELECT id, codigo, descripcion, precio_compra, precio_venta, cantidad, vencimiento, fecha_vencimiento FROM productos WHERE cantidad < 5 AND estado = 1';
        $data = $this->selectAll( $sql );
        return $data;
    }
  
    //listar productos
    public function getInventarioProductos() {

        $sql = 'SELECT * FROM productos WHERE estado = 1';
        $data = $this->selectAll( $sql );
        return $data;
    }

}

?>