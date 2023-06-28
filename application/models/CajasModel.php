<?php

class CajasModel extends CI_Model {


    public function __construct()
    {
        parent::__construct();
    }

    //listar caja
    public function getCajas( $table ) {

        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('estado', 1);
        return $this->db->get()->result();
      }
    //listar caja
    public function getCaja() {

        $this->db->select('c.*, ca.caja ');
        $this->db->from('cierre_caja c');
        $this->db->join('caja ca', 'c.id_caja = ca.id');
        return $this->db->get()->result();
    }
    //registrar caja

    public function registrarCaja($caja ) {
        
        $this->db->select('*');
        $this->db->from('caja');
        $this->db->where('caja', $caja);
        $existe = $this->db->get()->result();

        if (empty( $existe ) ) {

            $data = array(
                'caja' => $caja,
            );
            $this->db->insert('caja', $data);
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
    //editar caja

    public function editarCaja( $id ) {

        $this->db->where('id', $id);
        return $this->db->get('caja')->result();
    }
    //update caja
    public function updateCaja($caja,$id ) {
       
        $this->db->where('id', $id);
        $this->db->SET('caja',"");

        $data = array(
            'caja' => $caja,
        );
        $this->db->update('caja',$data);
        $result = $this->db->affected_rows();

        if ( $result > 0 ) {
            $result = 'modificado';
        } else {
            $result = 'error';
        }
        return $result;
    }
    //eliminar caja

    public function accionCaja( $estado, $id ) {

        $this->db->where('id', $id);
        $this->db->set('estado', "");

        $data = array(
            'estado' => $estado,
        );
        $this->db->update('caja', $data);    
        return $this->db->affected_rows();
    }
    //arqueo  caja
    public function verificarCajaAbierta($id_usuario) {
        $this->db->select('*');
        $this->db->from('cierre_caja');
        $this->db->where('id_usuario', $id_usuario);
        $this->db->where('estado', 1);
        $existe = $this->db->get()->result();
    
        if (empty($existe)) {
            // No existe una caja abierta, se puede abrir una nueva
            $data = array(
                'id_usuario' => $id_usuario,
                'id_caja' => $id_caja,
                'monto_inicial' => $monto_inicial,
                'fecha_apertura' => $fecha_apertura,
            );
            $this->db->insert('cierre_caja', $data);
            $result = $this->db->affected_rows();
    
            if ($result > 0) {
                $result = 'ok';
            } else {
                $result = 'error';
            }
        } else {
            // Ya existe una caja abierta
            $result = 'existe';
        }
        return $result;
    }
    
    public function registrarArqueoCaja( $id_usuario, $id_caja, $monto_inicial, $fecha_apertura ) {

        $this->db->select('*');
        $this->db->from('cierre_caja');
        $this->db->where('id_usuario', $id_usuario);
        $this->db->where('estado', 1);
        $existe = $this->db->get()->result();

        if (empty( $existe ) ) {

            $data = array(
                'id_usuario' => $id_usuario,
                'id_caja' => $id_caja,
                'monto_inicial' => $monto_inicial,
                'fecha_apertura' => $fecha_apertura,
            );
            $this->db->insert('cierre_caja', $data);
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
    //consultar ventas

    public function getVentas( $id_usuario ) {

        $this->db->select('total, SUM(total) as total');
        $this->db->from('ventas');
        $this->db->where('id_usuario', $id_usuario);
        $this->db->where('estado', 1);
        $this->db->where('apertura', 1);   
        return $this->db->get()->result();
    }
    //contar el valor total que hay en caja

    public function getTotalVentas( $id_usuario ) {

        $this->db->select('total, COUNT(total) as total');
        $this->db->from('ventas');
        $this->db->where('id_usuario', $id_usuario);
        $this->db->where('estado', 1);
        $this->db->where('apertura', 1);   
        return $this->db->get()->result();
    }

    public function getMontoInicial( $id_usuario ) {

        $this->db->select('c.id, c.monto_inicial, ca.caja');
        $this->db->from('cierre_caja c');
        $this->db->join('caja ca', 'c.id_caja = ca.id');
        $this->db->where('id_usuario', $id_usuario);
        $this->db->where('c.estado', 1);   
        return $this->db->get()->result();

    }
    //cierre caja
    public function actualizarArqueoCaja($final, $cierre, $total_ventas, $general, $id ) {

        $this->db->where('id',$id);
        $this->db->SET('monto_final', "");
        $this->db->SET('fecha_cierre', "");
        $this->db->SET('total_ventas', "");
        $this->db->SET('monto_total', "");
        $this->db->SET('estado', "");

        $data = array(
            'monto_final' => $final,
            'fecha_cierre' => $cierre,
            'total_ventas' => $total_ventas,
            'monto_total' => $general,
            'estado' => 0,
        );
        $this->db->update('cierre_caja', $data);
        $result = $this->db->affected_rows();

        if ( $result > 0 ) {
            $result = 'ok';
        } else {
            $result = 'error';
        }
        return $result;

    }
    //actualizar apertura
    public function actualizarApertura(  $id ){

        $this->db->where('id', $id);
        $this->db->SET('apertura', "");

        $data = array(
            'apertura' => 0,
        );
        $this->db->update('ventas', $data);
        return $this->db->affected_rows();
    
    }
//validar
public function consultarUsuario(){

    $this->db->select('c.id_usuario, u.nombre');
    $this->db->from('cierre_caja c');
    $this->db->join('usuarios u', 'c.id_usuario = u.id');
    $this->db->where('c.estado', 1);
    return $this->db->get()->result();
   }

}

?>