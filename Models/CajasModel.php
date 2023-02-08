<?php

class CajasModel extends Query {

    private $caja, $id, $estado;

    public function __construct()
 {
        parent::__construct();
    }

    //listar caja

    public function getCajas( string $table ) {

        $sql = "SELECT * FROM $table";
        $data = $this->selectAll( $sql );
        return $data;
    }
    //registrar caja

    public function registrarCaja( string $caja ) {
        $this->caja = $caja;

        $verificar = "SELECT * FROM caja WHERE caja = '$this->caja'";
        $existe = $this->select( $verificar );
        if ( empty( $existe ) ) {
            $sql = 'INSERT INTO caja (caja) VALUES (?)';
            $data = array( $this->caja );
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
    //editar caja

    public function editarCaja( int $id ) {

        $sql = "SELECT * FROM caja WHERE id = $id";
        $data = $this->select( $sql );
        return $data;

    }
    //update caja

    public function updateCaja( string $caja, int $id ) {
        $this->caja = $caja;

        $this->id = $id;

        $sql = 'UPDATE caja SET caja = ? WHERE id = ? ';
        $data = array( $this->caja, $this->id );
        $datos = $this->save( $sql, $data );

        if ( $datos == 1 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }

        return $result;
    }
    //eliminar caja

    public function accionCaja( int $estado, int $id ) {

        $this->id = $id;
        $this->estado = $estado;
        $sql = 'UPDATE caja SET estado = ? WHERE id = ?';
        $datos = array( $this->estado, $this->id );
        $data = $this->save( $sql, $datos );

        return $data;

    }
    //arqueo  caja

    public function registrarArqueoCaja( int $id_usuario, string $monto_inicial, string $fecha_apertura ) {

        $verificar = "SELECT * FROM cierre_caja WHERE id_usuario = '$id_usuario' AND estado = 1";
        $existe = $this->select( $verificar );
        if ( empty( $existe ) ) {

            $sql = 'INSERT INTO cierre_caja (id_usuario, monto_inicial, fecha_apertura) VALUES (?,?,?)';
            $data = array( $id_usuario, $monto_inicial, $fecha_apertura );
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
    //consultar ventas

    public function getVentas( int $id_usuario ) {

        $sql = "SELECT total, SUM(total) as total FROM ventas WHERE id_usuario = $id_usuario AND estado = 1 AND apertura = 1";
        $data = $this->select( $sql );
        return $data;
    }
    //contar el valor total que hay en caja

    public function getTotalVentas( int $id_usuario ) {

        $sql = "SELECT COUNT(total) AS total FROM ventas WHERE id_usuario = $id_usuario AND estado = 1 AND apertura = 1";
        $data = $this->select( $sql );
        return $data;
    }

    public function getMontoInicial( int $id_usuario ) {

        $sql = "SELECT id, monto_inicial FROM cierre_caja WHERE id_usuario = $id_usuario AND estado = 1";
        $data = $this->select( $sql );
        return $data;
    }
    //cierre caja
    public function actualizarArqueoCaja( string $final, string $cierre, string $total_ventas, string $general, int $id ) {

        $sql = "UPDATE cierre_caja SET monto_final = ?, fecha_cierre = ?, total_ventas = ?, monto_total = ?, estado = ? WHERE id = ?";
        $data = array( $final, $cierre, $total_ventas, $general, 0, $id  );
        $datos = $this->save( $sql, $data );

        if ( $datos == 1 ) {
            $result = 'ok';
        } else {
            $result = 'error';
        }
        return $result;

    }
    //actualizar apertura
    public function actualizarApertura( int $id ){
        $sql = "UPDATE ventas SET apertura = ? WHERE id_usuario = ?";
        $data = array( 0, $id );
        $this->save( $sql, $data );
    }
}

?>