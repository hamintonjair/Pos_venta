<?php

class ProveedoresModel extends Query {
    private $nit, $razon_social, $nombre, $telefono, $direccion, $id, $estado;

    public function __construct()
 {
        parent::__construct();
    }

    //listar proveedor

    public function getProveedores() {

        $sql = 'SELECT * FROM proveedor';
        $data = $this->selectAll( $sql );
        return $data;
    }
    //registrar proveedor

    public function registrarProveedor( string $nit, string $razon_social, string $nombre, string $telefono, string $direccion ) {
        $this->nit = $nit;
        $this->razon_social = $razon_social;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $verificar = "SELECT * FROM proveedor WHERE nit = '$this->nit'";
        $existe = $this->select( $verificar );
        if ( empty( $existe ) ) {
            $sql = 'INSERT INTO proveedor(nit, razon_social, nombre, telefono, direccion) VALUES (?,?,?,?,?)';
            $data = array( $this->nit, $this->razon_social, $this->nombre, $this->telefono, $this->direccion );
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

    public function editarProveedor( int $id ) {

        $sql = "SELECT * FROM proveedor WHERE id = $id";
        $data = $this->select( $sql );
        return $data;

    }
    //update usuario

    public function updateProveedor( string $nit, string $razon_social, string $nombre, string $telefono, string $direccion, int $id_proveedor ) {
        $this->nit = $nit;
        $this->razon_social = $razon_social;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->id = $id_proveedor;

        $sql = 'UPDATE proveedor SET nit = ?, razon_social = ?, nombre = ?, telefono = ?, direccion = ? WHERE id = ? ';
        $data = array( $this->nit, $this->razon_social, $this->nombre, $this->telefono, $this->direccion, $this->id );
        $datos = $this->save( $sql, $data );

        if ( $datos == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;
    }
    //eliminar usuario

    public function accionProveedor( int $estado, int $id ) {

        $this->id = $id;
        $this->estado = $estado;
        $sql = 'UPDATE proveedor SET estado = ? WHERE id = ?';
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