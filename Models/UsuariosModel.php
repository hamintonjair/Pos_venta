<?php

class UsuariosModel extends Query {
    private $usuario, $nombre, $clave, $id_caja, $id, $estado;

    public function __construct()
 {
        parent::__construct();
    }

    //listar caja

    public function getCajas() {

        $sql = 'SELECT * FROM caja  WHERE estado = 1';
        $data = $this->selectAll( $sql );
        return $data;
    }
    //listar usuarios

    public function getUsuarios() {

        $sql = 'SELECT u.*, c.id as id_caja, c.caja FROM usuarios u INNER JOIN caja c WHERE u.id_caja = c.id AND u.estado = 1';
        $data = $this->selectAll( $sql );
        return $data;
    }
    public function getUsuariosEliminados() {

        $sql = 'SELECT u.*, c.id as id_caja, c.caja FROM usuarios u INNER JOIN caja c WHERE u.id_caja = c.id AND u.estado = 0';
        $data = $this->selectAll( $sql );
        return $data;
    }

    //vaciar usuarios
    public function vaciarUsuarios(){
        $sql = 'DELETE FROM clientes WHERE estado = 0';   
        $data = $this->delete( $sql); 
        return $data;
    }
    //registrar usuarios

    public function registrarUsuario( string $usuario, string $nombre, string $clave, int $id_caja, string $rol ) {
        $this->usuario = $usuario;
        $this->nombre = $nombre;
        $this->clave = $clave;
        $this->id_caja = $id_caja;
        $this->rol = $rol;
        $verificar = "SELECT * FROM usuarios WHERE usuario = '$this->usuario'";
        $existe = $this->select( $verificar );
        if ( empty( $existe ) ) {
            $sql = 'INSERT INTO usuarios(usuario,nombre,clave,id_caja, rol) VALUES (?,?,?,?,?)';
            $data = array( $this->usuario, $this->nombre, $this->clave, $this->id_caja, $this->rol );
            $datos = $this->save( $sql, $data );

            if ( $datos == 1 ) {
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

    public function editarUsuario( int $id ) {

        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $data = $this->select( $sql );
        return $data;

    }
    //update usuario

    public function updateUsuario( string $usuario, string $nombre, int $id_caja, string $rol, string $clave, int $id ) {
        $this->usuario = $usuario;
        $this->nombre = $nombre;
        $this->id = $id;
        $this->clave = $clave;
        $this->id_caja = $id_caja;
        $this->rol = $rol;
    
        $sql = 'UPDATE usuarios SET usuario = ?, nombre = ?, clave = ?, id_caja = ?, rol = ? WHERE id = ? ';
        $data = array( $this->usuario, $this->nombre, $this->clave, $this->id_caja, $this->rol, $this->id );
        $datos = $this->save( $sql, $data );

        if ( $datos == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;
    }
    //eliminar usuario

    public function accionUsuario( int $estado, int $id ) {

        $this->id = $id;
        $this->estado = $estado;
        $sql = 'UPDATE usuarios SET estado = ? WHERE id = ?';
        $datos = array( $this->estado, $this->id );
        $data = $this->save( $sql, $datos );

        return $data;

    }
    //cambiar password

    public function modificarPass( string $claveN, int $id ) {

        $this->id = $id;
        $this->claveN = $claveN;
        $sql = 'UPDATE usuarios SET clave = ? WHERE id = ?';
        $datos = array( $this->claveN, $this->id );

        $data = $this->save( $sql, $datos );

        return $data;
    }

    //validar claves

    public function getPass( string $clave, int $id ) {

        $sql = "SELECT * FROM usuarios WHERE clave = '$clave' AND id = $id";
        $data = $this->select( $sql );
        return $data;

    }
    //permisos

    public function getPermisos() {

        $sql = 'SELECT * FROM permisos';
        $data = $this->selectAll( $sql );
        return $data;
    }
    //añadir permisos

    public function registrarPermisos( int $id_user, int $id_permiso ) {

        $sql = 'INSERT INTO detalle_permisos (id_usuario, id_permiso) VALUES (?,?)';
        $datos = array( $id_user, $id_permiso );

        $data = $this->save( $sql, $datos );

        if ( $data == 1 ) {

            $res = 'ok';
        } else {
            $res = 'error';
        }

        return $res;
    }
    //eliminar permisos

    public function eliminarPermisos( int $id_user ) {

        $sql = 'DELETE FROM detalle_permisos  WHERE id_usuario = ?';
        $datos = array( $id_user );

        $data = $this->save( $sql, $datos );

        if ( $data == 1 ) {

            $res = 'ok';
        } else {
            $res = 'error';
        }
        return $res;
    }
    //detalle permisos

    public function getDetallePermisos( int $id_user ) {

        $sql = "SELECT * FROM detalle_permisos WHERE id_usuario = $id_user";
        $data = $this->selectAll( $sql );
        return $data;
    }
    //verificar permisos

    public function verificarPermisos( int $id_user, string $nombre )
    {
        $sql = "SELECT p.id, p.permiso, d.id, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.permiso = '$nombre' ";
        $data = $this->selectAll( $sql );
        return $data;
    }
    //validar login
    public function getUsuario(string $usuario, string $clave){

        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave' ";
        $data = $this->select($sql);

        return $data;
              
    }    
}

?>