<?php

class InventarioModel extends CI_Model {
   
    public function __construct()
     {
        parent::__construct();
    }

    //verificar permisos
    public function verificarPermisos(  $id_user, $nombre )
    {
        $this->db->select(' p.id, p.permiso, d.id, d.id_usuario, d.id_permiso ');
        $this->db->from('permisos p');
        $this->db->join('detalle_permisos d', 'p.id = d.id_permiso');
        $this->db->where('d.id_usuario', $id_user);
        $this->db->where('p.permiso', $nombre);
        return $this->db->get()->result();
    }
    //productos bajos
    public function getProductosInventario() {

        $this->db->select('id, codigo, descripcion, precio_compra, precio_venta, cantidad, vencimiento, fecha_vencimiento ');
        $this->db->from('productos');
        $this->db->where('cantidad < 5');
        $this->db->where('estado', 1);
        return $this->db->get()->result();
    }
  
    //listar productos
    public function getInventarioProductos() {

        $this->db->select('*');
        $this->db->from('productos');
        $this->db->where('estado', 1);
        return $this->db->get()->result();
    }
    //listar movimientos entradas y salidas
    public function buscarEntradaSalida($EntradaSalida){
        
        if($EntradaSalida == "Entrada"){
            $this->db->select(' dco.id, c.total, c.fecha, c.entrada,p.descripcion, p.codigo, dco.cantidad, pro.nombre as 
            provCliente, u.usuario as usuario ');
            $this->db->from('compras c');
            $this->db->join('datella_compras dco', ' c.id = dco.id_compra');
            $this->db->join('productos p', 'dco.id_producto = p.id ');
            $this->db->join('proveedor pro ', 'c.id_proveedor = pro.id');
            $this->db->join('usuarios u', ' c.id_usuario = u.id ');
            $this->db->order_by('fecha', 'desc');
            $this->db->where('c.entrada ', $EntradaSalida);
               
        }else{
            $this->db->select('  dv.id, v.total, v.fecha, v.salida,p.descripcion, p.codigo, dv.cantidad, cli.nombre as 
            provCliente, u.usuario as usuario ');
            $this->db->from('ventas v');
            $this->db->join(' detalle_ventas dv ', ' v.id = dv.id_venta ');
            $this->db->join('productos p', 'dv.id_producto = p.id ');
            $this->db->join('clientes cli ', ' v.id_cliente = cli.id');
            $this->db->join('usuarios u', ' v.id_usuario = u.id');
            $this->db->order_by('fecha', 'desc');
            $this->db->where(' v.salida', $EntradaSalida);          
        }
        return $this->db->get()->result();

    }
    public function listarEntradaSalida(){        

            $subquery1 = $this->db->select('c.id, c.total, c.fecha, c.entrada, p.descripcion, p.codigo, dco.cantidad, pro.nombre as provCliente, u.usuario as usuario')
            ->from('compras c')
            ->join('datella_compras dco', 'c.id = dco.id_compra')
            ->join('productos p', 'dco.id_producto = p.id')
            ->join('proveedor pro', 'c.id_proveedor = pro.id')
            ->join('usuarios u', 'c.id_usuario = u.id')
            ->where('c.entrada', 'Entrada')
            ->get_compiled_select();

        $subquery2 = $this->db->select('v.id, v.total, v.fecha, v.salida, p.descripcion, p.codigo, dv.cantidad, cli.nombre as provCliente, u.usuario as usuario')
            ->from('ventas v')
            ->join('detalle_ventas dv', 'v.id = dv.id_venta')
            ->join('productos p', 'dv.id_producto = p.id')
            ->join('clientes cli', 'v.id_cliente = cli.id')
            ->join('usuarios u', 'v.id_usuario = u.id')
            ->where('v.salida', 'Salida')
            ->get_compiled_select();

        $this->db->select('*')
        ->from("($subquery1 UNION $subquery2) as combined_query")
        ->order_by('fecha', 'desc');

        $result = $this->db->get()->result();
        return $result;
    }

}

?>