<?php

class ProductosModel extends CI_Model {


    public function __construct()
    {
        parent::__construct();
    }

    //listar productos
    public function getProductos() {
        $this->db->select('p.*, m.id as id_medida, m.nombre as medida, c.id as id_categoria, c.nombre as categoria');
        $this->db->from('productos p');
        $this->db->join('medidas m ', 'p.id_medida = m.id');
        $this->db->join('categorias c', 'p.id_categoria = c.id ');
        $this->db->where('p.estado', 1);
        return $this->db->get()->result();
     
    }
    //eliminados
    public function getProductosEliminados() {
        $this->db->select('p.*, m.id as id_medida, m.nombre as medida, c.id as id_categoria, c.nombre as categoria');
        $this->db->from('productos p');
        $this->db->join('medidas m ', 'p.id_medida = m.id');
        $this->db->join('categorias c', 'p.id_categoria = c.id ');
        $this->db->where('p.estado', 0);
        return $this->db->get()->result();

    }
    //registrar productos

    public function registrarProducto( $codigo, $descripcion, $precio_compra, $precio_venta, $cantidad, 
    $iva, $id_medida, $id_categoria, $id_proveedor, $foto, $vencimiento, $fecha_vencimiento ) {
        
        $data = array(
            'codigo' => $codigo,
            'descripcion' => $descripcion,
            'precio_compra'  => $precio_compra,
            'precio_venta' => $precio_venta,
            'cantidad' => $cantidad,
            'iva' => $iva,
            'id_medida' => $id_medida,
            'id_categoria'  => $id_categoria,
            'id_proveedor' => $id_proveedor,
            'foto' => $foto,
            'vencimiento' => $vencimiento,
            'fecha_vencimiento' => $fecha_vencimiento,
        );

        $this->db->select('*');
        $this->db->from('productos');
        $this->db->where('codigo', $codigo);
        $this->db->or_where('descripcion', $descripcion);
        $existe = $this->db->get()->result();

        if (empty( $existe ) ) {
             $this->db->insert('productos', $data);          
             $result = $this->db->affected_rows();

            if ( $result > 0 ) {
                $result = 'ok';
            } else {
                $result = 'error';
            }
        } else {

            $result = array(
                'existe' => 'existe',

            );
        }

        return $result;
    }
    //editar usuario
    public function editarProducto( int $id ) {
        $this->db->select('*');
        $this->db->from('productos');
        $this->db->where('id',$id);
        return $this->db->get()->result();   

    }
    //update usuario
    public function updateProducto( $codigo, $descripcion, $precio_compra, $precio_venta, 
    $iva, $id_medida, $id_categoria, $id_proveedor, $foto, $vencimiento, $fecha_vencimiento, $id) {

        $this->db->where('id', $id);
        $this->db->SET('codigo', "");
        $this->db->SET('descripcion', "");
        $this->db->SET('precio_compra', "");
        $this->db->SET('precio_venta', "");
        $this->db->SET('iva', "");
        $this->db->SET('id_medida', "");
        $this->db->SET('id_categoria', "");
        $this->db->SET('id_proveedor', "");
        $this->db->SET('foto', "");
        $this->db->SET('vencimiento', "");
        $this->db->SET('fecha_vencimiento', "");
        
        $data = array(
            'codigo' => $codigo,
            'descripcion' => $descripcion,
            'precio_compra'  => $precio_compra,
            'precio_venta' => $precio_venta,
            'iva' => $iva,
            'id_medida' => $id_medida,
            'id_categoria'  => $id_categoria,
            'id_proveedor' => $id_proveedor,
            'foto' => $foto,
            'vencimiento' => $vencimiento,
            'fecha_vencimiento' => $fecha_vencimiento,
        );
        $this->db->update('productos', $data);
        $result = $this->db->affected_rows();
      
        if ( $result > 0 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }
        return $result;
    }
     //validar relacion antes de eliminar
     public function verificarRelacion($id) {
    
        $this->db->where('id_producto',$id);
        $result = $this->db->get('detalle_ventas');
        $data = $this->db->affected_rows();

        return $data;
    }
    //eliminar usuario
    public function accionProducto( $estado, $id ) {
        $this->db->where('id', $id);
        $this->db->SET('estado', "");
        $data = array(
            'estado' => $estado,
        );
        $this->db->update('productos',$data);
        $result = $this->db->affected_rows();
        return $result;
    
    }
    //vaciar productos eliminados
    public function vaciarProducto(){

        $this->db->where('estado', 0);
        $this->db->update('productos');
        $result = $this->db->affected_rows();

        return $result;
    }

}

?>