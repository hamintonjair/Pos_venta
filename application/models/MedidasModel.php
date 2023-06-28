<?php

class MedidasModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    //listar medidas
    public function getMedidas() {
        $this->db->select('*');
        $this->db->from('medidas');
        $this->db->where('estado', 1);
        return $this->db->get()->result();

    }
    public function getMedidasEliminados() {
        $this->db->select('*');
        $this->db->from('medidas');
        $this->db->where('estado', 0);
        return $this->db->get()->result();

    }
    //registrar medidas
    public function registrarMedida( $nombre, $nombre_corto ) {
       
        $data = array(
            'nombre' => $nombre,
            'nombre_corto'  => $nombre_corto,
        );

        $this->db->select('*');
        $this->db->from('medidas');
        $this->db->where('nombre', $nombre);
        $existe = $this->db->get()->result();

        if (empty( $existe ) ) {
             $this->db->insert('medidas', $data);          
             $result = $this->db->affected_rows();

            if ( $result > 0 ) {
                $result = 'ok';
            } else {
                $result = 'error';
            }
        } else {

            $result = 'existe';
        }
    }
    //editar medidas
    public function editarMedida( $id ) {
        $this->db->select('*');
        $this->db->from('medidas');
        $this->db->where('id',$id);
        return $this->db->get()->result();

    }
    //update medidas
    public function updateMedida($nombre, $nombre_corto, $id ){
     
        $this->db->where('id', $id);
        $this->db->SET('nombre', "");
        $this->db->SET('nombre_corto', "");
        
        $data = array(
            'nombre' => $nombre,
            'nombre_corto'  => $nombre_corto,
        );
        $this->db->update('medidas', $data);
        $result = $this->db->affected_rows();
        if ( $result > 0 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }
        return $result;
    }
    //verificar relacion
    public function verificarRelacion($id) {
    
        $this->db->where('id_medida',$id);
        $result = $this->db->get('productos');
        $data = $this->db->affected_rows();
        return $data;
    }
    //eliminar medidas
    public function accionMedida( $estado, $id ) {

        $this->db->where('id', $id);
        $this->db->SET('estado', "");
        $data = array(
            'estado' => $estado,
        );
        $this->db->update('medidas',$data);
        $result = $this->db->affected_rows();
        return $result;

    }
    //vaciar medidas
    public function vaciarMedidas(){
        $this->db->where('estado', 0);   
        $this->db->update('medidas');
        $result = $this->db->affected_rows();
        return $result;
    }

}

?>