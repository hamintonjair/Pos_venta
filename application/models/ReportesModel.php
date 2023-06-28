<?php

class ReportesModel extends CI_Model {

    public function __construct()
 {
        parent::__construct();
    }

    //verificar permisos

    public function verificarPermisos( $id_user, $nombre ){
        $this->db->select('p.id, p.permiso, d.id, d.id_usuario, d.id_permiso  ');
        $this->db->from('permisos p');
        $this->db->join('detalle_permisos d', 'p.id = d.id_permiso ');
        $this->db->where('d.id_usuario', $id_user);
        $this->db->where('p.permiso', $nombre);
        return $this->db->get()->result();
    }
    //reporte cierre de caja
    public function getreporteCierre(){
        $this->db->select(' c.id, c.monto_inicial, c.monto_total, c.fecha_apertura, c.fecha_cierre, c.total_ventas, u.nombre, ca.caja ');
        $this->db->from('cierre_caja c ');
        $this->db->join(' usuarios u ', 'c.id_usuario = u.id');
        $this->db->join(' caja ca ', 'c.id_caja = ca.id');
        $this->db->where('c.estado', 0);
        return $this->db->get()->result();
    }
    //buscar reporte cierre por empleado
    public function getreporteCierreEmpleado( $id_empleado ) {
        $this->db->select(' c.id, c.monto_inicial, c.monto_total, c.fecha_apertura, c.fecha_cierre, c.total_ventas, u.nombre, ca.caja ');
        $this->db->from('cierre_caja c ');
        $this->db->join(' usuarios u ', 'c.id_usuario = u.id');
        $this->db->join(' caja ca ', 'c.id_caja = ca.id');
        $this->db->where('c.id_usuario', $id_empleado);
        $this->db->where('c.estado', 0);
        return $this->db->get()->result();
    }
    // listar las ventas por usuario
    public function getreporteEmpleados( ) {
        $this->db->select(' c.id, c.monto_inicial, c.monto_total, c.fecha_apertura, c.fecha_cierre, c.total_ventas, u.nombre, ca.caja ');
        $this->db->from('cierre_caja c ');
        $this->db->join(' usuarios u ', 'c.id_usuario = u.id');
        $this->db->join(' caja ca ', 'c.id_caja = ca.id');
        $this->db->where('c.estado', 0);
        return $this->db->get()->result();
    }
    //usaurios

    public function getUsuarios() {
        $this->db->select('u.*, c.id as id_caja, c.caja ');
        $this->db->from(' usuarios u');
        $this->db->join('caja c ', 'u.id_caja = c.id');
        $this->db->where('u.estado',1);
        return $this->db->get()->result();
    }
    //reportes de ventas por mes

    public function getreporteVentasMes() {
        $this->db->select('c.id, c.fecha_cierre, c.total_ventas AS ventas, c.monto_total AS total, ca.caja ');
        $this->db->from(' cierre_caja c');
        $this->db->join('caja ca', ' c.id_caja = ca.id');
        $this->db->where('c.estado', 0);
        return $this->db->get()->result();
    }
    //reporte ventas por fecha

    public function getRangoFechas( $desde, $hasta ) {
        $this->db->select('c.id, c.fecha_cierre, SUM(c.total_ventas) AS ventas, SUM(c.monto_total) AS total, ca.caja');
        $this->db->from('cierre_caja c');
        $this->db->join('caja ca', 'c.id_caja = ca.id');
        $this->db->where('c.fecha_apertura >=', $desde);
        $this->db->where('c.fecha_apertura <=', $hasta);
        $this->db->where('c.estado', 0);
        $this->db->group_by('c.id');

        return $this->db->get()->result();
    
    }
    //listar los proveedores

    public function getProveedor() {

        $this->db->select('id, nombre');
        $this->db->from('proveedor');
        return $this->db->get()->result();

    }
    //buscar compras a proveedores
    public function getreporteCompraProveedores( int $id_proveedor ) {

        $this->db->select('c.id, p.nit, p.razon_social, p.nombre, pro.descripcion, d.cantidad, d.precio, c.total, c.fecha, pa.pago');
        $this->db->from('proveedor p');
        $this->db->join('productos pro', 'p.id = pro.id_proveedor');
        $this->db->join('datella_compras d', 'd.id_producto = pro.id');
        $this->db->join('compras c', 'c.id = d.id_compra');
        $this->db->join('pagos pa', 'pa.id_pago = c.tipoPago');
        $this->db->where('c.id_proveedor', $id_proveedor);
        $this->db->where('c.estado', 1);
        return $this->db->get()->result();
    }
    //listar compras
    public function getreporteCompras( ) {

        $this->db->select('c.id, p.nit, p.razon_social, p.nombre, pro.descripcion, d.cantidad, d.precio, c.total, c.fecha, pa.pago');
        $this->db->from('proveedor p');
        $this->db->join('productos pro', 'p.id = pro.id_proveedor');
        $this->db->join('datella_compras d', 'd.id_producto = pro.id');
        $this->db->join('compras c', 'c.id = d.id_compra');
        $this->db->join('pagos pa', 'pa.id_pago = c.tipoPago');
        return $this->db->get()->result();

    }
    // ganacias mes a mes
    public function gananciaMes($año){

        $this->db->select('m.mes_nombre AS mes, YEAR(v.fecha) AS año, SUM(p.precio_venta * dv.cantidad - p.precio_compra * dv.cantidad) AS total_mes');
        $this->db->from('ventas v');
        $this->db->join('detalle_ventas dv', 'v.id = dv.id_venta');
        $this->db->join('productos p', 'dv.id_producto = p.id');
        $this->db->join('meses m', 'MONTH(v.fecha) = m.mes_numero');
        $this->db->where('YEAR(v.fecha)', $año);
        $this->db->group_by(' m.mes_nombre', 'YEAR(fecha)');
        $this->db->group_by(' YEAR(v.fecha)', 'MONTH(v.fecha) ');
        $this->db->order_by('MONTH(v.fecha)', 'asc');
        return $this->db->get()->result();


    }
    //listar ganacias mes a mes
    public function listargananciaMes(){

        $this->db->select('m.mes_nombre AS mes, YEAR(v.fecha) AS año, SUM(p.precio_venta * dv.cantidad - p.precio_compra * dv.cantidad) AS total_mes');
        $this->db->from('ventas v');
        $this->db->join('detalle_ventas dv', 'v.id = dv.id_venta');
        $this->db->join('productos p', 'dv.id_producto = p.id');
        $this->db->join('meses m', 'MONTH(v.fecha) = m.mes_numero');
        $this->db->group_by(' m.mes_nombre', 'YEAR(fecha)');
        $this->db->group_by(' YEAR(v.fecha)', 'MONTH(v.fecha) ');
        return $this->db->get()->result();
     
    }
}
