<?php

class MedidasModel extends Query {

    private $nombre, $nombre_corto, $id, $estado;

    public function __construct()
 {
        parent::__construct();
    }

    //listar medidas

    public function getMedidas() {

        $sql = 'SELECT * FROM medidas WHERE estado = 1';
        $data = $this->selectAll( $sql );
        return $data;
    }
    public function getMedidasEliminados() {

        $sql = 'SELECT * FROM medidas WHERE estado = 0';
        $data = $this->selectAll( $sql );
        return $data;
    }
    //registrar medidas

    public function registrarMedida( string $nombre, string $nombre_corto ) {
        $this->nombre = $nombre;

        $this->nombre_corto = $nombre_corto;

        $verificar = "SELECT * FROM medidas WHERE nombre = '$this->nombre'";
        $existe = $this->select( $verificar );
        if ( empty( $existe ) ) {
            $sql = 'INSERT INTO medidas (nombre, nombre_corto) VALUES (?,?)';
            $data = array( $this->nombre,  $this->nombre_corto );
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
    //editar medidas

    public function editarMedida( int $id ) {

        $sql = "SELECT * FROM medidas WHERE id = $id";
        $data = $this->select( $sql );
        return $data;

    }
    //update medidas

    public function updateMedida( string $nombre, string $nombre_corto, int $id ) {
        $this->nombre = $nombre;

        $this->nombre_corto = $nombre_corto;

        $this->id = $id;

        $sql = 'UPDATE medidas SET nombre = ? , nombre_corto = ? WHERE id = ? ';
        $data = array( $this->nombre, $this->nombre_corto, $this->id );
        $datos = $this->save( $sql, $data );

        if ( $datos == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;
    }
    //eliminar medidas

    public function accionMedida( int $estado, int $id ) {

        $this->id = $id;
        $this->estado = $estado;
        $sql = 'UPDATE medidas SET estado = ? WHERE id = ?';
        $datos = array( $this->estado, $this->id );
        $data = $this->save( $sql, $datos );

        return $data;

    }
    //verificar permisos
    public function verificarPermisos( int $id_user, string $nombre )
    {
        $sql = "SELECT p.id, p.permiso, d.id, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.permiso = '$nombre' ";
        $data = $this->selectAll( $sql );
        return $data;
    }
}

?>