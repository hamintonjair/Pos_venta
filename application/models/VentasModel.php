<?php

class VentasModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    //buscar producto por código
    public function getProCod( $cod ) {

        if ( is_numeric( $cod ) == true ) {
            $this->db->select('*');
            $this->db->from('productos');
            $this->db->where('codigo', $cod);
            $data = $this->db->get()->result();

        } else {
            $this->db->select('*');
            $this->db->from('productos');
            $this->db->where('descripcion', $cod);
            $data = $this->db->get()->result();
        }
        if (!empty($data) ) {
            $result = $data ;
            // array( 'ok' => true, 1 => $data ) ;
        } else {
            $result = false;
        }
        return $result;
    }
        
    //listar productos
    public function getProducto(){

        $this->db->select('descripcion');
        $this->db->from('productos');
        $this->db->where('estado',1);

        return $this->db->get()->result();
    }
    //registrar detalles ventas
    public function getProductos( $id ) {

        $this->db->select('*');
        $this->db->from('productos');
        $this->db->where('id',$id);
        $this->db->where('estado',1);

        return $this->db->get()->result();
    }
    //buscar cliente
    public function getCliente( $cedula ) {

        $this->db->select('*');
        $this->db->from('clientes');
        $this->db->where('dni',$cedula);
        $this->db->where('estado',1);
        return $this->db->get()->result();
    }
    //registrar datalles
    public function registrarDetalles( $id_producto, $id_usuario, $precio, $cantidad, $iva, $sub_total ) {

        $data = array(
            'id_producto' => $id_producto,
            'id_usuario' => $id_usuario,
            'precio'  => $precio,
            'cantidad' => $cantidad,
            'iva' => $iva,
            'sub_total' => $sub_total,
        );
        $this->db->insert('detalle_temp', $data);          
        $result = $this->db->affected_rows();

       if( $result > 0 ) {
           $result = 'modificado';
        }else {
           $result = 'error';
        }
        return $result;
    }
    //listar detalle de ventas
    public function getDetalle( $id ) {

        $this->db->select('d.*, p.id as id_pro, p.descripcion');
        $this->db->from(' detalle_temp d');
        $this->db->join('productos p', ' d.id_producto = p.id');
        $this->db->where('d.id_usuario ',$id);
        return $this->db->get()->result();
    }
    //seleccionar el total
    public function getDetalles() {

        $this->db->select('SUM(sub_total) as total ');
        $this->db->from(' detalle_temp');
        return $this->db->get()->result();

    }
    //listar detalle de venta
    public function calcularVenta( $id_usuario ) {
       
        $this->db->select('sub_total, SUM(sub_total) AS total ');
        $this->db->from(' detalle_temp');
        $this->db->where('id_usuario', $id_usuario);
    
        $result = $this->db->get()->result();
        return $result;
    }
    //eliminar producto de detalles

    public function deleteDetalle( $id ) {

        $this->db->where('id', $id);
        $this->db->delete('detalle_temp');       
        $result = $this->db->affected_rows();
        if ( $result == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;

    }
    //validar prosuctos para sumar las cantidades

    public function consultarDetalle( $id_producto, $id_usuario ) {

        $this->db->select('*');
        $this->db->from('detalle_temp');
        $this->db->where('id_producto',$id_producto);
        $this->db->where('id_usuario',$id_usuario);
        return $this->db->get()->result();
    }
    //actualizar detalles

    public function actualizarDetalles( $precio, $cantidad, $iva, $sub_total, $id_producto, $id_usuario ) {

        $this->db->where('id_producto', $id_producto);
        $this->db->where('id_usuario', $id_usuario);
        $this->db->SET('precio', "");
        $this->db->SET('cantidad', "");
        $this->db->SET('iva', "");
        $this->db->SET('sub_total', "");

        $data = array(
            'precio' => $precio,
            'cantidad' => $cantidad,
            'iva' => $iva,
            'sub_total' => $sub_total,
        );       

        $this->db->update('detalle_temp', $data);
            
        $result = $this->db->affected_rows();

       if( $result > 0 ) {
           $result = 'modificado';
        }else {
           $result = 'error';
        }
        return $result;
    }
    //registrar venta
    public function registrarVenta(  $id_usuario, $total, $id_cliente, $pago, $cambio ) {

         $data = array(
            'id_usuario' => $id_usuario,
            'total' => $total,
            'id_cliente' => $id_cliente,
            'pagado' => $pago,
            'cambio' => $cambio,
        
        );    
        $this->db->insert('ventas', $data);            
        $result = $this->db->affected_rows();

       if( $result > 0 ) {
           $result = 'modificado';
        }else {
           $result = 'error';
        }
        return $result;
    }
    //seleccionar id venta
    public function id_Venta() {

        $this->db->select_max('id');
        $this->db->from('ventas');
        return $this->db->get()->result();
    }
    //tregistrar Detalle venta
    public function registrarDetalleVenta( $id_venta,  $id_prod, $cantidad, $iva, $descuento, $precio, $sub_total ) {

        $data = array(
            'id_venta' => $id_venta,
            'id_producto' => $id_prod,
            'cantidad' => $cantidad,
            'iva' => $iva,
            'descuento' => $descuento,
            'precio' => $precio,
            'sub_total' => $sub_total,
        );      

        $this->db->insert('detalle_ventas', $data);            
        $result = $this->db->affected_rows();

       if( $result > 0 ) {
           $result = 'modificado';
        }else {
           $result = 'error';
        }
        return $result;
    }
    //datos d ela empresa
    public function getEmpresa() {
        $this->db->select('*');
        $this->db->from('configuracion');
        return $this->db->get()->result();

    }
    //vaciar detalles
    public function vaciarDetalle( $id_usuario ) {

        $this->db->where('id_usuario', $id_usuario);
        $this->db->delete('detalle_temp');
        $result = $this->db->affected_rows();

        if ( $result > 0 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }
        return $result;
    }

//seleccionar las ventas para la factura
    public function getVenta($id_venta) {
        $this->db->select('v.*, d.*, p.id, p.descripcion, c.nombre ');
        $this->db->from('ventas v');
        $this->db->join('detalle_ventas d', 'v.id = d.id_venta');
        $this->db->join('productos p', 'p.id = d.id_producto');
        $this->db->join('clientes c', 'c.id = v.id_cliente');
        $this->db->where('v.id', $id_venta);
        $result = $this->db->get()->result();
    
        $count = count($result);
        $data = array('registro' => $result, 'count' => $count);
    
        return $data;
    }
    
    //historial venta
    public function getHistorialVenta() {

        $this->db->select('v.*, c.nombre ');
        $this->db->from('clientes c ');
        $this->db->join('ventas v', ' c.id = v.id_cliente');
        return $this->db->get()->result();
    }
    //actualizar stock
    public function actualizarStock( $cantidad, $id_prod ) {
    
        $this->db->where('id',$id_prod);
        $this->db->SET('cantidad', "");
 
        $data = array(
            'cantidad' =>  $cantidad,
        );
        return  $this->db->update('productos', $data);   
    }
    //actualizar descuento
    public function actualizarDescuento( $desc, $sub_total, $id ) {

        $this->db->where('id',$id);
        $this->db->SET('descuento', "");
        $this->db->SET('sub_total', "");
        $data = array(
            'descuento' => $desc,
            'sub_total' => $sub_total,
    
        );
        $this->db->update('detalle_temp', $data);            
        $result = $this->db->affected_rows();

       if( $result > 0 ) {
           $result = 'modificado';
        }else {
           $result = 'error';
        }
        return $result;
    }
    //verificar descuento

    public function verificarDescuento($id ) {

        $this->db->select('*');
        $this->db->from('detalle_temp');
        $this->db->where('id', $id);
        return $this->db->get()->result();

    }
    //seleccionar elñ descxuento aplicado

    public function getDescuento( $id_venta ) {
        $this->db->select(' descuento, SUM(descuento) AS total');
        $this->db->from('detalle_ventas');
        $this->db->where('id_venta', $id_venta);
        return $this->db->get()->result();
    }
    //anulado
    public function getAnular(  $id_venta ) {

        $this->db->where('id',$id_venta);
        $this->db->SET('estado', "");
 
        $data = array(
            'estado' =>  0,
        );
        $this->db->update('ventas', $data);            
        $result = $this->db->affected_rows();

       if( $result > 0 ) {
           $result = 'modificado';
        }else {
           $result = 'error';
        }
        return $result;

    }
    //anular venta
    public function getAnularVenta(  $id_venta ) {

        $this->db->select('v.*, d.*');
        $this->db->from('ventas v ');
        $this->db->join('detalle_ventas d ', ' v.id = d.id_venta');
        $this->db->where('v.id ', $id_venta);
        return $this->db->get()->result();
    }
    //consultar usuarioid_usuario
    public function getUsuario( $id_usuario ) {
   
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('id', $id_usuario);
        return $this->db->get()->result();
    }
    //verificar caja abierta
    public function verificarCaja( $id_usuario ) {

        $this->db->select('*');
        $this->db->from('cierre_caja');
        $this->db->where('id_usuario', $id_usuario);
        $this->db->where('estado', 1);
        return $this->db->get()->result();
    }
    //verificar permisos
    public function verificarPermisos( $id_user, $nombre ){
        
        $this->db->select(' p.id, p.permiso, d.id, d.id_usuario, d.id_permiso');
        $this->db->from('permisos p');
        $this->db->join(' detalle_permisos d', 'p.id = d.id_permiso');
        $this->db->where(' d.id_usuario', $id_user);
        $this->db->where(' dp.permiso ', $nombre);
        return $this->db->get()->result();
    }
    //reporte fecha

    public function getRangoFechas( $desde, $hasta ) {

        $this->db->select('c.id, c.nombre, v.*, c.nombre ');
        $this->db->from('clientes c');
        $this->db->join(' ventas v', ' c.id = v.id_cliente');
        $this->db->where(' v.fecha >=', $desde);
        $this->db->where('v.fecha >=', $hasta);
        return $this->db->get()->result();
       
    }
}

?>
