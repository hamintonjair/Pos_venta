<?php

class DashboardModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    //listar caja

    public function getEmpresa() {

        $this->db->select('*');
        $this->db->from('configuracion');
        return $this->db->get()->result();
    }

    //listar datos

    public function getDatos( $table ) {

        $this->db->select('COUNT(*) as total');
        $this->db->from($table);   
        return $this->db->get()->result();
    }
    //actualizar

    public function actualizar( $nit, $regimen,  $resolucion,  $nombre, $telefono, $direccion, $ciudad, $mensaje, $impresora, $id ) {

        $this->db->where('id', $id);
        $this->db->SET('nit', "");
        $this->db->SET('regimen', "");
        $this->db->SET('resolucion', "");
        $this->db->SET('nombre', "");
        $this->db->SET('telefono', "");
        $this->db->SET('direccion', "");
        $this->db->SET('ciudad', "");
        $this->db->SET('mensaje', "");
        $this->db->SET('tipo_Impresora', "");

        $data = array(
            'nit' => $nit,
            'regimen' => $regimen,
            'resolucion' => $resolucion,
            'nombre' => $nombre,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'ciudad' => $ciudad,
            'mensaje' => $mensaje,
            'tipo_Impresora' => $impresora,
        );
       
        $this->db->update('configuracion', $data);
        $result = $this->db->affected_rows();

        return $result;
    }
    //mostrar datos en la grafica

    public function getStockMinimo() {

        $this->db->select('*');
        $this->db->from('productos');
        $this->db->where('cantidad < 10');
        $this->db->where('estado ', 1);
        $this->db->order_by('cantidad', 'desc');
        $this->db->limit(10);
        return $this->db->get()->result();
    }
    //mostrar datos en la grafica

    public function getproductosMasVendidos() {

        $this->db->select(' d.id_producto, d.cantidad, p.id, p.descripcion, SUM(d.cantidad) as total');
        $this->db->from('detalle_ventas d');
        $this->db->join('productos p', 'p.id = d.id_producto');
        $this->db->group_by('d.id_producto');
        $this->db->order_by('p.cantidad', 'desc');
        $this->db->limit(10);
        return $this->db->get()->result();
    }
    //historial venatas ´para ña grafica

    public function getVentas() {

        $this->db->select('COUNT(*) as total');
        $this->db->from('ventas');   
        $this->db->where('estado', 1);   
        return $this->db->get()->result();
   
    }
   //verificar permisos

    public function verificarPermisos( $id_user, $nombre )
    {
         $this->db->select('p.id, p.permiso, d.id, d.id_usuario, d.id_permiso');
         $this->db->from('permisos p');
         $this->db->join('detalle_permisos d', 'p.id = d.id_permiso ');
         $this->db->where('d.id_usuario', $id_user);
         $this->db->where('p.permiso', $nombre);
         return $this->db->get()->result();
         
     }
  
}

?>