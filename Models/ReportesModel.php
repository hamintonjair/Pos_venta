<?php

class ReportesModel extends Query {

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
    //reporte cierre de caja

    public function getreporteCierre()
 {
        $sql = "SELECT c.id, c.monto_inicial, c.monto_total, c.fecha_apertura, c.fecha_cierre, c.total_ventas, u.nombre, ca.caja FROM cierre_caja c 
          INNER JOIN usuarios u ON c.id_usuario = u.id INNER JOIN  caja ca ON c.id_caja = ca.id WHERE c.estado = 0";
        $data = $this->selectAll( $sql );
        return $data;
    }
    //buscar reporte cierre por empleado
    public function getreporteCierreEmpleado( int $id_empleado ) {

        $sql = "SELECT c.id, c.monto_inicial, c.monto_total, c.fecha_apertura, c.fecha_cierre, c.total_ventas, u.nombre, ca.caja FROM cierre_caja c 
        INNER JOIN usuarios u ON c.id_usuario = u.id INNER JOIN  caja ca ON c.id_caja = ca.id WHERE c.id_usuario = $id_empleado AND c.estado = 0";
        $data = $this->selectAll( $sql );
        return $data;
    }
    // listar las ventas por usuario
    public function getreporteEmpleados( ) {

        $sql = "SELECT c.id, c.monto_inicial, c.monto_total, c.fecha_apertura, c.fecha_cierre, c.total_ventas, u.nombre, ca.caja FROM cierre_caja c 
        INNER JOIN usuarios u ON c.id_usuario = u.id INNER JOIN  caja ca ON c.id_caja = ca.id WHERE c.estado = 0";
        $data = $this->selectAll( $sql );
        return $data;
    }
    //usaurios

    public function getUsuarios() {

        $sql = 'SELECT u.*, c.id as id_caja, c.caja FROM usuarios u INNER JOIN caja c WHERE u.id_caja = c.id AND u.estado = 1';
        $data = $this->selectAll( $sql );
        return $data;
    }
    //reportes de ventas por mes

    public function getreporteVentasMes() {

        $sql = 'SELECT c.id, c.fecha_cierre, c.total_ventas AS ventas, c.monto_total AS total, ca.caja  FROM cierre_caja c INNER JOIN caja ca ON c.id_caja = ca.id
         WHERE c.estado = 0';
        $data = $this->selectAll( $sql );
        return $data;
    }
    //reporte ventas por fecha

    public function getRangoFechas( string $desde, string $hasta ) {

        $sql = "SELECT c.id, c.fecha_cierre, SUM(c.total_ventas) AS ventas, SUM(c.monto_total) AS total, ca.caja  FROM cierre_caja c 
            INNER JOIN caja ca ON c.id_caja = ca.id  WHERE c.fecha_apertura BETWEEN '$desde' AND '$hasta' AND c.estado = 0";

        $data = $this->select( $sql );
        return $data;
    }
    //listar los proveedores

    public function getProveedor() {

        $sql = "SELECT id, nombre FROM proveedor ";

        $data = $this->selectAll( $sql );
        return $data;

    }
    //buscar compras a proveedores
    public function getreporteCompraProveedores( int $id_proveedor ) {

        $sql = "SELECT c.id, p.nit, p.razon_social, p.nombre, pro.descripcion, d.cantidad, d.precio, c.total,c.fecha,
        pa.pago
        FROM proveedor p INNER JOIN productos pro ON p.id = pro.id_proveedor  INNER JOIN datella_compras d 
        ON d.id_producto = pro.id INNER JOIN compras c  ON c.id = d.id_compra INNER JOIN pagos pa ON pa.id_pago = c.tipoPago WHERE c.id_proveedor = $id_proveedor AND c.estado = 1";

        $data = $this->selectAll( $sql );
        return $data;
    }
    //listar compras
    public function getreporteCompras( ) {

        $sql = "SELECT c.id, p.nit, p.razon_social, p.nombre, pro.descripcion, d.cantidad, d.precio, c.total,c.fecha,
        pa.pago
        FROM proveedor p INNER JOIN productos pro ON p.id = pro.id_proveedor  INNER JOIN datella_compras d 
        ON d.id_producto = pro.id INNER JOIN compras c  ON c.id = d.id_compra INNER JOIN pagos pa ON pa.id_pago = c.tipoPago WHERE c.estado = 1";

        $data = $this->selectAll( $sql );
        return $data;
    }
    // ganacias mes a mes
    public function gananciaMes($año){

        $sql = "SELECT m.mes_nombre AS mes, YEAR(v.fecha) AS año, SUM(p.precio_venta * dv.cantidad - p.precio_compra * dv.cantidad) AS total_mes
        FROM ventas v
        JOIN detalle_ventas dv ON v.id = dv.id_venta
        JOIN productos p ON dv.id_producto = p.id
        JOIN meses m ON MONTH(v.fecha) = m.mes_numero
        WHERE YEAR(v.fecha) = $año
        GROUP BY m.mes_nombre, YEAR(fecha)
        ORDER BY YEAR(v.fecha), MONTH(v.fecha)   
        ";
          $data = $this->selectAll( $sql );
        return $data;
    }
    //listar ganacias mes a mes
    public function listargananciaMes(){
        $sql = "SELECT m.mes_nombre AS mes, YEAR(v.fecha) AS año, SUM(p.precio_venta * dv.cantidad - p.precio_compra * dv.cantidad) AS total_mes
        FROM ventas v
        JOIN detalle_ventas dv ON v.id = dv.id_venta
        JOIN productos p ON dv.id_producto = p.id
        JOIN meses m ON MONTH(v.fecha) = m.mes_numero
        GROUP BY m.mes_nombre, YEAR(fecha)
        ORDER BY YEAR(v.fecha), MONTH(v.fecha)   
        ";
          $data = $this->selectAll( $sql );
        return $data;
    }
}
