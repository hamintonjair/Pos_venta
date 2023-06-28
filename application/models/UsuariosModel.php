<?php

class UsuariosModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    //listar caja

    public function getCajas() {

        $this->db->select('*');
        $this->db->from('caja');
        $this->db->where('estado', 1);
        return $this->db->get()->result();
    }
    //listar usuarios
    public function getUsuarios() {

        $this->db->select('u.*, c.id as id_caja, c.caja');
        $this->db->from('usuarios u');
        $this->db->join('caja c', 'u.id_caja = c.id');
        $this->db->where('u.estado', 1);
        return $this->db->get()->result();

    }
    //listar usuarios eliminados
    public function getUsuariosEliminados() {

        $this->db->select('u.*, c.id as id_caja, c.caja');
        $this->db->from('usuarios u');
        $this->db->join('caja c', 'u.id_caja = c.id');
        $this->db->where('u.estado', 0);
        return $this->db->get()->result();

    }

    //vaciar usuarios
    public function vaciarUsuarios(){

        $this->db->where('estado', 0);
          $this->db->update('usuarios');
        $result = $this->db->affected_rows();
        return $result;
    }
    //registrar usuarios

    public function registrarUsuario( $usuario, $nombre, $clave, $id_caja, $rol ) {
       
        $data = array(
            'usuario' => $usuario,
            'nombre' => $nombre,
            'clave'  => $clave,
            'id_caja' => $id_caja,
            'rol' => $rol,
        );

        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('usuario', $usuario);
        $existe = $this->db->get()->result();

        if (empty( $existe ) ) {
             $this->db->insert('usuarios', $data);          
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
    //editar usuario

    public function editarUsuario( $id ) {

        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('id',$id);
        return $this->db->get()->result();

    }
    //update usuario

    public function updateUsuario( $usuario,$nombre, $id_caja, $rol, $clave, $id ) {
        
        $this->db->where('id', $id);
        $this->db->SET('usuario', "");
        $this->db->SET('nombre', "");
        $this->db->SET('clave', "");
        $this->db->SET('id_caja', "");
        $this->db->SET('rol', "");
        
        $data = array(
            'usuario' => $usuario,
            'nombre' => $nombre,
            'clave'  => $clave,
            'id_caja' => $id_caja,
            'rol' => $rol,
        );
        $this->db->update('usuarios', $data);
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
    
        $this->db->where('id_usuario',$id);
        $result = $this->db->get('ventas');
        $data = $this->db->affected_rows();

        return $data;
    }
    //eliminar usuario
     public function accionUsuario( $estado, $id ) {
 
        $this->db->where('id', $id);
        $this->db->SET('estado', "");
        $data = array(
            'estado' => $estado,
        );
        $this->db->update('usuarios',$data);
        $result = $this->db->affected_rows();
        return $result;

    }
    //cambiar password
    public function modificarPass(  $claveN, $id ) {

        $this->db->where('id', $id);
        $this->db->SET('clave', "");
        $data = array(
            'clave' => $claveN,
        );
        $this->db->update('usuarios',$data);
        $result = $this->db->affected_rows();
        return $result;
   }

    //validar claves
    public function getPass( $clave, $id ) {

        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('clave', $clave);
        $this->db->where('id', $id);
        return $this->db->get()->result();

    }
    //permisos
    public function getPermisos() {

        $this->db->select('*');
        $this->db->from('permisos');
        return $this->db->get()->result();
    }
    //añadir permisos
    public function registrarPermisos( $id_user, $id_permiso ) {
        
        $data = array(
            'id_usuario' => $id_user,
            'id_permiso' => $id_permiso,
        );

        // Insertar el nuevo usuario en la base de datos
        $this->db->insert('detalle_permisos', $data); 
      // Devolver el ID del nuevo usuario insertado
      $data = $this->db->affected_rows();

        if ( $data > 0 ){
            $res = 'ok';
        } else {
            $res = 'error';
        }
        return $res;
    }
    //eliminar permisos
    public function eliminarPermisos( $id_user ) {

        $this->db->where('id_usuario', $id_user);
        $this->db->delete('detalle_permisos');     
        $data = $this->db->affected_rows();

        if ( $data > 0 ) {
            $res = 'ok';
        } else {
            $res = 'error';
        }
        return $res;
    }
    //detalle permisos
    public function getDetallePermisos( $id_user ) {

        $this->db->select('*');
        $this->db->from('detalle_permisos');
        $this->db->where('id_usuario', $id_user);
        return $this->db->get()->result();
    }

   // validar login
    public function getUsuario( $usuario, $clave ){

        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('usuario', $usuario);
        $this->db->where('clave', $clave);   

        return $this->db->get()->result();
              
    }    
}

?>