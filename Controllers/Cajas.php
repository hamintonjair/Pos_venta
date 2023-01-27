<?php

class Cajas extends Controller {

    public function __construct()
 {
        session_start();

        if ( empty( $_SESSION[ 'activo' ] ) ) {
            header( 'location:'.base_url );
        }

        parent::__construct();
    }
    //VISTA DASHBOARD

    public function index() {

        $this->views->getView( $this, 'caja' );
    }
    //Varqueo caja

    public function arqueo() {

        $this->views->getView( $this, 'arqueo' );
    }
    //registrar y actualizar caja

    public function registrarCaja() {

        $caja = $_POST[ 'caja' ];

        $id = $_POST[ 'idCaja' ];

        if ( empty( $caja ) ) {
            $msg = ( array( 'ok'=>false, 'post' => 'Todos los campos son obligatorios.' ) );
        } else {

            if ( $id == '' ) {
                //registrar
                $data = $this->model->registrarCaja( $caja );
                if ( $data == 'ok' ) {
                    $msg = ( array( 'ok'=>true, 'post' => 'Caja registrado con éxito.' ) );

                } else if ( $data == 'existe' ) {
                    $msg = ( array( 'ok'=>false, 'post' => 'la Caja ya existe.' ) );

                } else {
                    $msg = ( array( 'ok'=>false, 'post' => 'Error al registrar el Caja.' ) );
                }

            } else {
                //actualizar
                $data = $this->model->updateCaja( $caja, $id );
                if ( $data == 'modificado' ) {
                    $msg = ( array( 'modificado'=>true, 'post' => 'La Caja fue actualizado con éxito.' ) );

                } else {
                    $msg = ( array( 'modificado'=>false, 'post' => 'Error al actualizar la Caja.' ) );
                }
            }

        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die;
    }
    //listar las caja

    public function listar() {

        $data = $this->model->getCajas('caja');

        for ( $i = 0; $i < count( $data );
        $i++ ) {

            if ( $data[ $i ][ 'estado' ] == 1 ) {
                $data[ $i ][ 'estado' ] = '<span class="badge badge-success">Activo</span>';
                $data[ $i ][ 'acciones' ] = '<div>            
                <button type="button" class="btn btn-primary" onclick="editarCaja('.$data[ $i ][ 'id' ].');" title="Editar"><i class="fas fa-edit"></i></button>   
                <button type="button" class="btn btn-danger" onclick="eliminarCaja('.$data[ $i ][ 'id' ].');" title="Eliminar"><i class="far fa-trash-alt"></i></button>            
               </div>';

            } else {
                $data[ $i ][ 'estado' ] = ' <span class="badge badge-danger">Inactivo</span>';
                $data[ $i ][ 'acciones' ] = '<div>               
                    <button type="button" class="btn btn-success" onclick="reingresarCaja('.$data[ $i ][ 'id' ].');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
                </div>';
            }

        }

        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //Editar caja

    public function editar( int $id ) {

        $data = $this->model->editarCaja( $id );
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //eliminar caja

    public function deleteCaja( int $id ) {

        $data = $this->model->accionCaja( 0, $id );

        if ( $data == 1 ) {
            $msg = ( array( 'eliminado'=>true, 'post' => 'El Caja fue eliminado con éxito.' ) );
        } else {
            $msg = ( array( 'eliminado'=>false, 'msg' => 'Error al eliminar el Caja.' ) );
        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
    //reingresar caj

    public function reingresarCaja( int $id ) {

        $data = $this->model->accionCaja( 1, $id );

        if ( $data == 1 ) {
            $msg = ( array( 'reingresado'=>true, 'post' => 'El Caja fue reingresado con éxito.' ) );
        } else {
            $msg = ( array( 'reingresado'=>false, 'msg' => 'Error al reingresar el Caja.' ) );
        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
    // abrirArqueo

    public function abrirArqueo() {

        $monto_inicial = $_POST[ 'monto_inicial' ];

        $fecha_apertura = date('Y-m-d' );
        $id_usuario = $_SESSION['id_usuario'];

        if ( empty( $monto_inicial ) || empty( $fecha_apertura ) ) {
            $msg = ( array( 'ok'=>false, 'post' => 'Todos los campos son obligatorios.' ) );
        } else {

            //registrar
            $data = $this->model->registrarArqueoCaja($id_usuario, $monto_inicial,    $fecha_apertura);
            if ( $data == 'ok' ) {
                $msg = ( array( 'ok'=>true, 'post' => 'Caja abierta con éxito.' ) );

            } else if ( $data == 'existe' ) {
                $msg = ( array( 'ok'=>false, 'post' => 'la Caja ya está abierta.' ) );

            } else {
                $msg = ( array( 'ok'=>false, 'post' => 'Error al abrir la Caja.' ) );
            }

        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die;
    }
    //listar arqueo
    
    public function listarArqueo() {

        $data = $this->model->getCajas('cierre_caja');

        for ( $i = 0; $i < count( $data );
        $i++ ) {

            if ( $data[ $i ][ 'estado' ] == 1 ) {
                $data[ $i ][ 'estado' ] = '<span class="badge badge-success">Abierta</span>';           

            } else {
                $data[ $i ][ 'estado' ] = ' <span class="badge badge-danger">Cerrada</span>';
              
            }
        }
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //consultar ventas
    public function consultarVentas(){
        
        $id_usuario = $_SESSION['id_usuario'];
        $data['monto_total'] = $this->model->getVentas(  $id_usuario );
        $data['total_ventas'] = $this->model->getTotalVentas(  $id_usuario );
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }

}
?>