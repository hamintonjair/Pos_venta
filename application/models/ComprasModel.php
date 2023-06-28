<?php

class ComprasModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    //buscar producto por código o nombre
    public function getProCodi( string $cod ) {

        if ( is_numeric( $cod ) == true ) {
            $this->db->select('p.*, pro.nombre, pro.nit');
            $this->db->from('productos p');
            $this->db->join('proveedor pro', 'p.id_proveedor = pro.id');
            $this->db->where('codigo', $cod);
            $data = $this->db->get()->result();

        } else {
            $this->db->select('p.*, pro.nombre, pro.nit');
            $this->db->from('productos p');
            $this->db->join('proveedor pro', 'p.id_proveedor = pro.id');
            $this->db->where('descripcion', $cod);

            $data = $this->db->get()->result();
        }
        if (!empty($data) ) {
            $result = $data ;
        } else {
            $result = false;
        }
        return $result;
   }
    //registrar datalles
    public function registrarDetallesC( $id_producto, $id_usuario, $precio, $cantidad, $sub_total ) {
        $data = array(
            'id_producto' => $id_producto,
            'id_usuario' => $id_usuario,
            'precio'  => $precio,
            'cantidad' => $cantidad,
            'sub_total' => $sub_total,
        );
        $this->db->insert('detalle', $data);          
        $result = $this->db->affected_rows();

       if( $result > 0 ) {
           $result = 'modificado';
        }else {
           $result = 'error';
        }
        return $result;  
    }
    //listar detalle de compra
    public function getDetalleC( $id ) {

        $this->db->select('d.*, p.id as id_pro, p.descripcion');
        $this->db->from(' detalle d');
        $this->db->join('productos p', ' d.id_producto = p.id');
        $this->db->where('d.id_usuario ',$id);
        return $this->db->get()->result();
    }
    //listar detalle de compra
    public function calcularCompra(  $id_usuario ) {
        $this->db->select('sub_total, SUM(sub_total) AS total ');
        $this->db->from(' detalle');
        $this->db->where('id_usuario', $id_usuario);
    
        $result = $this->db->get()->result();
        return $result;
    }
    //eliminar producto de detalles
    public function deleteDetalleC(  $id ) {
        $this->db->where('id', $id);
        $this->db->delete('detalle');       
        $result = $this->db->affected_rows();
        if ( $result == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;
    }
    //validar prosuctos para sumar las cantidades
    public function consultarDetalleC(  $id_producto, $id_usuario ) {

        $this->db->select('*');
        $this->db->from('detalle');
        $this->db->where('id_producto', $id_producto);
        $this->db->where('id_usuario', $id_usuario);
        return $this->db->get()->result();

    }
    //actualizar detalles

    public function actualizarDetallesC( $precio, $cantidad, $sub_total, $id_producto, $id_usuario ) {

        $this->db->where('id_producto', $id_producto);
        $this->db->where('id_usuario', $id_usuario);
        $this->db->SET('precio', "");
        $this->db->SET('cantidad', "");
        $this->db->SET('sub_total', "");

        $data = array(
            'precio' => $precio,
            'cantidad' => $cantidad,
            'sub_total' => $sub_total,
        );       

        $this->db->update('detalle', $data);
            
        $result = $this->db->affected_rows();
       if( $result > 0 ) {
           $result = 'modificado';
        }else {
           $result = 'error';
        }
        return $result;

    }
    //registrar compra

    public function registrarCompra( $total, $id_proveedor, $tipoPago, $id_usuario) {
        $data = array(
            'total' => $total,
            'id_proveedor' => $id_proveedor,
            'tipoPago' => $tipoPago,
            'id_usuario' => $id_usuario,
        
        );    
        $this->db->insert('compras', $data);            
        $result = $this->db->affected_rows();

       if( $result > 0 ) {
           $result = 'modificado';
        }else {
           $result = 'error';
        }
        return $result;
    }
    //id tipo de pago
    public function getidCompra(){
        $this->db->select('*');
        $this->db->from('pagos');
        return $this->db->get()->result();
     
    }
    //seleccionar id compra
    public function id_Compra() {
        $this->db->select_max('id');
        $this->db->from('compras');
        return $this->db->get()->result();

    }
    //tregistrar Detalle Compra
    public function registrarDetalleCompra( $id_compra,  $id_prod, $cantidad, $precio,  $sub_total ) {

        $data = array(
            'id_compra' => $id_compra,
            'id_producto' => $id_prod,
            'cantidad' => $cantidad,
            'precio' => $precio,
            'sub_total' => $sub_total,
        );      

        $this->db->insert('datella_compras', $data);            
        $result = $this->db->affected_rows();

       if( $result > 0 ) {
           $result = 'modificado';
        }else {
           $result = 'error';
        }
        return $result;

    }
    //vaciar detalles
    public function vaciarDetalleC( $id_usuario ) {

        
        $this->db->where('id_usuario', $id_usuario);
        $this->db->delete('detalle');
        $result = $this->db->affected_rows();

        if ( $result > 0 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }
        return $result;

           }
    //datos de la compra

    public function getCompra( $id_compra ) {

        $this->db->select('c.*, d.*, p.id, p.descripcion, pro.nombre, pago.id_pago, pago.pago');
        $this->db->from('compras c');
        $this->db->join('datella_compras d', 'c.id = d.id_compra');
        $this->db->join('productos p', 'p.id = d.id_producto');
        $this->db->join('proveedor pro', 'pro.id = c.id_proveedor');
        $this->db->join('pagos pago', 'pago.id_pago = c.tipoPago');
        $this->db->where('c.id', $id_compra);
        $result = $this->db->get()->result();
    
        $count = count($result);
        $data = array('registro' => $result, 'count' => $count);
    
        return $data;
    }
    //historial compras
    public function getHistorialCompra() {

        $this->db->select('c.*, p.nombre ');
        $this->db->from('proveedor p ');
        $this->db->join('compras c', ' p.id = c.id_proveedor');
        return $this->db->get()->result();

    }
    //actualizar stock
    public function actualizarStockC( $cantidad, $id_prod ) {

        $this->db->where('id',$id_prod);
        $this->db->SET('cantidad', "");
 
        $data = array(
            'cantidad' =>  $cantidad,
        );
        return  $this->db->update('productos', $data);  
    }
    //anular compra
    public function getAnularCompra($id_compra) {
        
        $this->db->select('c.*, d.*');
        $this->db->from('compras c');
        $this->db->join('datella_compras d ', ' c.id = d.id_compra');
        $this->db->where('c.id ', $id_compra);
        return $this->db->get()->result();

          }
    //anulado
    public function getAnular($id_compra ){

        $this->db->where('id',$id_compra);
        $this->db->SET('estado', "");
 
        $data = array(
            'estado' =>  0,
        );
        $this->db->update('compras', $data);            
        $result = $this->db->affected_rows();
       if( $result > 0 ) {
           $result = 'modificado';
        }else {
           $result = 'error';
        }
        return $result;
    }

    //buscar proveedor    
    public function getProveedor( $nit ) {
        $this->db->select('*');
        $this->db->from('proveedor');
        $this->db->where('nit',$nit);
        $this->db->where('estado',1);
        return $this->db->get()->result();
       
    }

}

?>
