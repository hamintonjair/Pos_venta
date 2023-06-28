<?php

class ProveedoresModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    //listar proveedor

    public function getProveedores() {

        $this->db->select('*');
        $this->db->from('proveedor');
        return $this->db->get()->result();

    }
    //registrar proveedor

    public function registrarProveedor( $nit, $razon_social, $nombre, $telefono,$direccion ) {
      
        $this->db->where('nit', $nit);
        $query = $this->db->get('proveedor');

        if ($query->num_rows() == 0) {
            $data = array(
                'nit' => $nit,
                'razon_social' => $razon_social,
                'nombre' => $nombre,
                'telefono' => $telefono,
                'direccion' => $direccion
            );

            $inserted = $this->db->insert('proveedor', $data);

            if ($inserted) {
                $result = 'ok';
            } else {
                $result = 'error';
            }
        } else {
            $result = 'existe';
        }

    return $result;
    }
    //editar usuario
    public function editarProveedor( int $id ) {

        $this->db->select('*');
        $this->db->from('proveedor');
        $this->db->where('id',$id);
        return $this->db->get()->result();

      }
    //update usuario

    public function updateProveedor( $nit, $razon_social,  $nombre, $telefono, $direccion, $id_proveedor ) {
       
        $this->db->where('id', $id_proveedor);
        $this->db->SET('nit', "");
        $this->db->SET('razon_social', "");
        $this->db->SET('nombre', "");
        $this->db->SET('telefono', "");
        $this->db->SET('direccion', "");

        $data = array(
            'nit' => $nit,
            'razon_social' => $razon_social,
            'nombre' => $nombre,
            'telefono' => $telefono,
            'direccion' => $direccion
        );   
       
        $updated = $this->db->update('proveedor', $data);
    
        if ($updated) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }
    
        return $result;
    }
    //eliminar proveedor
    public function accionProveedor( $estado, $id ) {

        $this->db->where('id', $id);
        $this->db->SET('estado', "");

        $data = array(
            'estado' => $estado
        );    
        $this->db->update('proveedor', $data);
        $result = $this->db->affected_rows();    
        return $result;

    }

}

?>