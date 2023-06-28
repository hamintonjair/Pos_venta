<?php

class CategoriasModel extends CI_Model {


    public function __construct()
    {
        parent::__construct();
    }

    //listar categoria

    public function getCategorias() {

        $this->db->select('*');
        $this->db->from('categorias');
        $this->db->where('estado',1);
        return $this->db->get()->result();
    }
    //categorias eliminado
    public function getCategoriasEliminados() {
        
        $this->db->select('*');
        $this->db->from('categorias');
        $this->db->where('estado',0);
        return $this->db->get()->result();
    }
    //registrar categoria

    public function registrarCategoria(  $categoria ) {

        $data = array(
            'nombre' => $categoria,
        );
        $this->db->select('*');
        $this->db->from('categorias');
        $this->db->where('nombre', $categoria);
        $this->db->where('estado', 1);
        $existe = $this->db->get()->result();

        if (empty( $existe ) ) {
             $this->db->insert('categorias', $data);          
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
    //editar categoria

    public function editarCategoria( int $id ) {
        $this->db->where('id', $id);
        return $this->db->get('categorias')->result();
   
    }
    //update categoria

    public function updateCategoria( $categoria, $id ) {
 
        $this->db->where('id', $id);
        $this->db->SET('nombre',"");

        $data = array(
            'nombre' => $categoria,
        );
        $this->db->update('categorias',$data);
        $result = $this->db->affected_rows();

        if ( $result > 0 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }
        return $result;
    }
    //veridficar relacion
     public function verificarRelacion($id) {
    
        $this->db->where('id_categoria',$id);
        $result = $this->db->get('productos');
        $data = $this->db->affected_rows();
        return $data;
    }
    //eliminar categoria
    public function accionCategoria( $estado, $id ) {
        
        $this->db->where('id', $id);
        $this->db->set('estado', "");

        $data = array(
            'estado' => $estado,
        );
        $this->db->update('categorias', $data);    
        return $this->db->affected_rows();

    }
    //vaciar categorías
    public function vaciarCategorias(){

        $this->db->where('estado', 0);        
        $this->db->delete('categorias');
        $result = $this->db->affected_rows();
        return $result;
    }

}

?>