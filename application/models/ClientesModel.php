<?php

class ClientesModel extends CI_Model {


    public function __construct()
    {
        parent::__construct();
    }
    //listar cliente
    public function getClientes() {

        $this->db->select('*');
        $this->db->from('clientes');
        $this->db->where('estado', 1);
        return $this->db->get()->result();
    }
    public function getClientesEliminados(){

        $this->db->select('*');
        $this->db->from('clientes');
        $this->db->where('estado', 0);
        return $this->db->get()->result();
    }    

    //registrar cliente
    public function registrarCliente( $dni, $nombre, $telefono, $direccion ) {
        $data = array(
            'dni' => $dni,
            'nombre' => $nombre,
            'telefono'  => $telefono,
            'direccion' => $direccion,
        );

        $this->db->select('*');
        $this->db->from('clientes');
        $this->db->where('dni', $dni);
        $this->db->where('estado', 1);


        $existe = $this->db->get()->result();

        if (empty( $existe ) ) {
             $this->db->insert('clientes', $data);          
             $result = $this->db->affected_rows();

            if ( $result > 0 ) {
                $result = 'ok';
            } else {
                $result = 'error';
            }
        } else {

            $result = 'existe';
        }
        return $result;
    }
    //editar cliente
    public function editarCliente( $id ) {
        
        $this->db->select('*');
        $this->db->from('clientes');
        $this->db->where('id',$id);
        return $this->db->get()->result();

    }
    //update cliente
    public function updateCliente( $dni, $nombre, $telefono, $direccion, $id ) {
       
        $this->db->where('id', $id);
        $this->db->SET('dni', "");
        $this->db->SET('nombre', "");
        $this->db->SET('telefono', "");
        $this->db->SET('direccion', "");
        
        $data = array(
            'dni' => $dni,
            'nombre' => $nombre,
            'telefono'  => $telefono,
            'direccion' => $direccion,
        );
        $this->db->update('clientes', $data);
        $result = $this->db->affected_rows();
      
        if ( $result > 0 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }
        return $result;
    }
    //eliminar cliente

    public function accionCliente( int $estado, int $id ) {

        $this->db->where('id', $id);
        $this->db->SET('estado', "");
        $data = array(
            'estado' => $estado,
        );
        $this->db->update('clientes',$data);
        $result = $this->db->affected_rows();
        return $result;

    }
        //vaciar productos eliminados
    public function vaciarCliente(){
        $this->db->where('estado', 0);      
        $this->db->update('clientes');
        $result = $this->db->affected_rows();
        return $result;
     }
}

?>