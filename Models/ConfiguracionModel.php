<?php

class ConfiguracionModel extends Query {

    private $caja, $id, $estado;

    public function __construct()
 {
        parent::__construct();
    }

    //listar caja

    public function getEmpresa() {

        $sql = 'SELECT * FROM configuracion';
        $data = $this->select( $sql );
        return $data;
    }

    //listar datos

    public function getDatos( string $table ) {

        $sql = "SELECT COUNT(*) as total FROM $table";
        $data = $this->select( $sql );
        return $data;
    }
    //actualizar

    public function actualizar( string $nit, string $regimen, int $resolucion, string $nombre, string $telefono, string $direccion, string $ciudad, string $mensaje, int $id ) {

        $sql = 'UPDATE configuracion SET nit = ?, regimen = ?,resolucion = ?, nombre = ?, telefono = ?, direccion = ?, ciudad = ?, mensaje = ? WHERE id = ?';
        $data = array( $nit, $regimen, $resolucion, $nombre,  $telefono,  $direccion,  $ciudad,  $mensaje,  $id );
        $datos = $this->save( $sql, $data );

        if ( $datos == 1 ) {

            $result = 'ok';
        } else {
            $result = 'error';
        }

        return $result;
    }
    //mostrar datos en la grafica

    public function getStockMinimo() {
        $sql = 'SELECT * FROM productos WHERE cantidad < 10 AND estado = 1 ORDER BY cantidad DESC LIMIT 10';
        $data = $this->selectAll( $sql );
        return $data;
    }
    //mostrar datos en la grafica

    public function getproductosMasVendidos() {
        $sql = 'SELECT d.id_producto, d.cantidad, p.id, p.descripcion, SUM(d.cantidad) as total FROM detalle_ventas d INNER JOIN productos p ON p.id = d.id_producto GROUP BY d.id_producto ORDER BY p.cantidad DESC LIMIT 10';
        $data = $this->selectAll( $sql );
        return $data;
    }
    //historial venatas ´para ña grafica

    public function getVentas() {

        $sql = 'SELECT COUNT(*) as total FROM ventas WHERE estado = 1';
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