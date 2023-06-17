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
    //listar movimientos entradas y salidas
    public function buscarEntradaSalida($EntradaSalida){
        
        if($EntradaSalida == "Entrada"){
                $sql = "SELECT c.id, c.total, c.fecha, c.entrada,p.descripcion, p.codigo, dco.cantidad, pro.nombre as 
                provCliente, u.usuario as usuario FROM compras c INNER JOIN datella_compras dco ON c.id = dco.id_compra INNER JOIN productos p 
                ON dco.id_producto = p.id INNER JOIN proveedor pro ON c.id_proveedor = pro.id INNER JOIN usuarios u 
                ON c.id_usuario = u.id WHERE c.entrada = $EntradaSalida";
        }else{
            $sql = "SELECT v.id, v.total, v.fecha, v.salida,p.descripcion, p.codigo, dv.cantidad, cli.nombre as provCliente, u.usuario as usuario
             FROM ventas v INNER JOIN detalle_ventas dv ON v.id = dv.id_venta INNER JOIN productos p ON dv.id_producto = p.id
              INNER JOIN clientes cli ON v.id_cliente = cli.id INNER JOIN usuarios u 
                ON v.id_usuario = u.id  WHERE v.salida =  $EntradaSalida
            ";
        }
        $data = $this->selectAll( $sql );
        return $data;
    }
    public function listarEntradaSalida(){
        
        $sql1 = "SELECT  c.total as total, c.fecha, c.entrada, p.descripcion, p.codigo, dco.cantidad, pro.nombre as provCliente, u.usuario as usuario
        FROM compras c
        INNER JOIN datella_compras dco ON c.id = dco.id_compra
        INNER JOIN productos p ON dco.id_producto = p.id
        INNER JOIN proveedor pro ON c.id_proveedor = pro.id
        INNER JOIN usuarios u ON c.id_usuario = u.id
        WHERE c.entrada = 'Entrada'";

        $sql2 = "SELECT v.total as total, v.fecha, v.salida, p.descripcion, p.codigo, dv.cantidad, cli.nombre as provCliente, u.usuario as usuario
        FROM ventas v
        INNER JOIN detalle_ventas dv ON v.id = dv.id_venta
        INNER JOIN productos p ON dv.id_producto = p.id
        INNER JOIN clientes cli ON v.id_cliente = cli.id
        INNER JOIN usuarios u ON v.id_usuario = u.id
        WHERE v.salida = 'Salida'";

        $sql = $sql1 . " UNION ALL " . $sql2;
        $data = $this->selectAll($sql);
       return $data;
    }

}

?>