<?php

class Cajas extends CI_Controller {

    public function __construct()
 {
        session_start();

        if ( empty( $_SESSION[ 'activo' ] ) ) {
            echo '<script>window.location.href="http://localhost/Pos_venta/"</script>';	
        }

        parent::__construct();
        $this->load->model('CajasModel');
        $this->load->model('DashboardModel');

    }
    //VISTA DASHBOARD

    public function vista_usuario() {

        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->DashboardModel->verificarPermisos($id_user, 'cajas');
        if(!empty($verificar) || $id_user == 1){
            $this->load->view('layouts/Templates/header_admin');
            $this->load->view('layouts/Templates/nav_admin');
            $this->load->view('layouts/Templates/body');
            $this->load->view('layouts/Cajas/caja');
            $this->load->view('layouts/Templates/footer_admin');
        }else{
            echo '<script>window.location.href="http://localhost/Pos_venta/Errors/permisos"</script>';	

        }
       
    }
    //Varqueo caja
    public function arqueo() {

       $data = array(
             'cajas' =>  $this->CajasModel->getCajas('caja')
        );  
       $this->load->view('layouts/Templates/header_admin');
       $this->load->view('layouts/Templates/nav_admin');
       $this->load->view('layouts/Templates/body');
       $this->load->view('layouts/Cajas/arqueo', $data);
       $this->load->view('layouts/Templates/footer_admin');
    }
    //registrar y actualizar caja

    public function registrarCaja() {

        $caja = $this->input->post('caja');
        $id = $this->input->post('idCaja');

        if ( empty( $caja ) ) {
            $msg = ( array( 'ok'=>false, 'post' => 'Todos los campos son obligatorios.' ) );
        } else {

            if ( $id == '' ) {
                //registrar
                $data = $this->CajasModel->registrarCaja( $caja );
                if ( $data == 'ok' ) {
                    $msg = ( array( 'ok'=>true, 'post' => 'Caja registrado con éxito.' ) );

                } else if ( $data == 'existe' ) {
                    $msg = ( array( 'ok'=>false, 'post' => 'la Caja ya existe.' ) );

                } else {
                    $msg = ( array( 'ok'=>false, 'post' => 'Error al registrar el Caja.' ) );
                }

            } else {
                //actualizar
                $data = $this->CajasModel->updateCaja( $caja, $id );
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

        $data = $this->CajasModel->getCajas('caja');
       
        for ( $i = 0; $i < count( $data );
        $i++ ) {

            if ( $data[ $i ]->estado == 1 ) {
                $data[ $i ]->estado = '<span class="badge badge-success">Activo</span>';
                if(  $_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                     $data[ $i ]->acciones= '<div>            
                            <button type="button" class="btn btn-primary" onclick="editarCaja('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit"></i></button>   
                            <button type="button" class="btn btn-danger" onclick="eliminarCaja('.$data[$i]->id.');" title="Eliminar"><i class="far fa-trash-alt"></i></button>            
                        </div>';
                }else{
                    $data[ $i ]->acciones = '<div>            
                    <button type="button" disabled="" class="btn btn-primary" onclick="editarCaja('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit"></i></button>   
                    <button type="button"  disabled="" class="btn btn-danger" onclick="eliminarCaja('.$data[$i]->id.');" title="Eliminar"><i class="far fa-trash-alt"></i></button>            
                   </div>';
                }
               

            } else {
                if($_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                     $data[ $i ]->estado = ' <span class="badge badge-danger">Inactivo</span>';
                $data[ $i ]->acciones = '<div>               
                    <button type="button" class="btn btn-success" onclick="reingresarCaja('.$data[$i]->id.');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
                </div>';
                }  
            }
        }

        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //Editar caja

    public function editar( int $id ) {

        $data = $this->CajasModel->editarCaja( $id );
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //eliminar caja

    public function deleteCaja( int $id ) {

        $data = $this->CajasModel->accionCaja( 0, $id );

        if ( $data == 1 ) {
            $msg = ( array( 'eliminado'=>true, 'post' => 'El Caja fue eliminado con éxito.' ) );
        } else {
            $msg = ( array( 'eliminado'=>false, 'msg' => 'Error al eliminar el Caja.' ) );
        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
    //reingresar caja

    public function reingresarCaja( int $id ) {

        $data = $this->CajasModel->accionCaja( 1, $id );

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

        $monto_inicial = $this->input->post('monto_inicial');
        date_default_timezone_set('America/Bogota');
        $fecha_apertura = date('Y-m-d H:i:s' );
        $id_usuario = $_SESSION['id_usuario'];
 
        $id = $this->input->post('id');

        if ( empty( $monto_inicial ) || empty( $fecha_apertura ) ) {
            $msg = ( array( 'ok'=>false, 'post' => 'Todos los campos son obligatorios.' ) );
        } else {
            if($id == ""){
                $id_caja = $this->input->post('id_caja');
                 //registrar
                $data = $this->CajasModel->registrarArqueoCaja($id_usuario, $id_caja, $monto_inicial, $fecha_apertura);
                if ( $data == 'ok' ) {
                    $msg = ( array( 'ok'=>true, 'post' => 'Caja abierta con éxito.' ) );

                } else if ( $data == 'existe' ) {
                    $msg = ( array( 'ok'=>false, 'post' => 'la Caja ya está abierta.' ) );

                } else {
                    $msg = ( array( 'ok'=>false, 'post' => 'Error al abrir la Caja.' ) );
                }
            }else{
                $monto_final = $this->CajasModel->getVentas(  $id_usuario );          
                $total_ventas = $this->CajasModel->getTotalVentas(  $id_usuario );           
                $inicial = $this->CajasModel->getMontoInicial( $id_usuario );
             
                $general = $monto_final[0]->total + $inicial[0]->monto_inicial;
                $mtoFinal = $monto_final[0]->total;

                if($mtoFinal== NULL){

                   $mtoFinal = 0;
                }
                $data = $this->CajasModel->actualizarArqueoCaja($mtoFinal, $fecha_apertura, $total_ventas[0]->total,$general, $inicial[0]->id);
                if ( $data == 'ok' ) {
                    $this->CajasModel->actualizarApertura($id_usuario);
                    $msg = ( array( 'ok'=>true, 'post' => 'Caja cerrada con éxito.' ) );

                } else {
                    $msg = ( array( 'ok'=>false, 'post' => 'Error al cerrar la caja.' ) );

                }
            }         
        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die;
    }
    //listar arqueo 
    public function listarArqueo() {

        $data = $this->CajasModel->getCaja();

        for ( $i = 0; $i < count( $data );
        $i++ ) {

            if ( $data[ $i ]->estado == 1 ) {
                $data[ $i ]->estado = '<span class="badge badge-success">Abierta</span>';           

            } else {
                $data[ $i ]->estado = ' <span class="badge badge-danger">Cerrada</span>';
              
            }
        }
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //consultar ventas
    public function consultarVentas(){
        
        $id_usuario = $_SESSION['id_usuario'];
        $data['inicial'] = $this->CajasModel->getMontoInicial( $id_usuario );
        
        if($data['inicial'] == false){            
            $data = ( array( 'ok'=>false, 'post' => 'No hay caja abierta.' ) ); 
        }else{           
            $data['monto_total'] = $this->CajasModel->getVentas( $id_usuario ); 
    
            $data['total_ventas'] = $this->CajasModel->getTotalVentas(  $id_usuario ); 
            $data['monto_general'] = $data['monto_total'][0]->total + $data['inicial'][0]->monto_inicial ;
            $data['caja'] = $data['inicial'][0]->caja ;
        }
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }

}
?>