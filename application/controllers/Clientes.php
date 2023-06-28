<?php

class Clientes extends CI_Controller {

    public function __construct()
   {
        session_start();

        if ( empty( $_SESSION[ 'activo' ] ) ) {
            echo '<script>window.location.href="http://localhost/Pos_venta/"</script>';	

        }
        parent::__construct();
        $this->load->model('ClientesModel');
        $this->load->model('DashboardModel');

    }
    //VISTA DASHBOARD

    public function vista_usuario() {

        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->DashboardModel->verificarPermisos( $id_user, 'clientes' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
            $this->load->view('layouts/Templates/header_admin');
            $this->load->view('layouts/Templates/nav_admin');
            $this->load->view('layouts/Templates/body');
            $this->load->view('layouts/Clientes/cliente');
            $this->load->view('layouts/Templates/footer_admin');
        } else {
            echo '<script>window.location.href="http://localhost/Pos_venta/Errors/permisos"</script>';	
        }

    }
    //registrar y actualizar clientes

    public function registrarCliente() {

        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->DashboardModel->verificarPermisos( $id_user, 'registrar_clientes' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
            $dni = $this->input->post('dni');
            $nombre = $this->input->post('nombre');
            $telefono = $this->input->post('telefono');
            $direccion =$this->input->post('direccion');
            $id = $this->input->post('idCliente' );

            if ( empty( $dni ) || empty( $nombre ) || empty( $telefono ) || empty( $dni ) || empty( $direccion ) ) {
                $msg = ( array( 'ok'=>false, 'post' => 'Todos los campos son obligatorios.' ) );
            } else {

                if ( $id == '' ) {
                    //registrar
                    $data = $this->ClientesModel->registrarCliente( $dni, $nombre, $telefono, $direccion );
                    if ( $data == 'ok' ) {
                        $msg = ( array( 'ok'=>true, 'post' => 'Cliente registrado con éxito.' ) );

                    } else if ( $data == 'existe' ) {
                        $msg = ( array( 'ok'=>false, 'post' => 'la cédula ya existe.' ) );

                    } else {
                        $msg = ( array( 'ok'=>false, 'post' => 'Error al registrar el Cliente.' ) );
                    }

                } else {
                    //actualizar
                    $data = $this->ClientesModel->updateCliente( $dni, $nombre, $telefono, $direccion, $id );
                    if ( $data == 'modificado' ) {
                        $msg = ( array( 'modificado'=>true, 'post' => 'El Cliente fue actualizado con éxito.' ) );

                    } else {
                        $msg = ( array( 'modificado'=>false, 'post' => 'Error al actualizar el Cliente.' ) );
                    }
                }

            }

        } else {
            $msg = ( array( 'modificado'=>false, 'post' => 'No tiene permisos para registrar Cliente.' ) );
        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die;

    }

    //listar los cliente

    public function listar() {

        $data = $this->ClientesModel->getClientes();
        for ( $i = 0; $i < count( $data );
        $i++ ) {
     
                $data[$i]->estado = '<span class="badge badge-success">Activo</span>';
                if($data[$i]->id == 1){
                     $data[$i]->acciones = '<div>                     
                        <span class="badge bg-primary">Genérico</span>';
                     '<div>   
                 </div>';
                }else{       
                    if($_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                                $data[ $i ]->acciones = '<div>            
                            <button type="button" class="btn btn-primary" onclick="editarCliente('.$data[ $i ]->id.');" title="Editar"><i class="fas fa-edit"></i></button>   
                            <button type="button" class="btn btn-danger" onclick="eliminarCliente('.$data[ $i ]->id.');" title="Eliminar"><i class="far fa-trash-alt"></i></button>            
                        </div>';
                    }else{
                        $data[ $i ]->acciones = '<div>            
                        <button type="button" disabled="" class="btn btn-primary" onclick="editarCliente('.$data[ $i ]->id.');" title="Editar"><i class="fas fa-edit"></i></button>   
                        <button type="button" disabled="" class="btn btn-danger" onclick="eliminarCliente('.$data[ $i ]->id.');" title="Eliminar"><i class="far fa-trash-alt"></i></button>            
                       </div>';
                    }                       
                }                
        }
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //listar los clientes eliminados
    public function listarEliminados() {

        $data = $this->ClientesModel->getClientesEliminados();
        for ( $i = 0; $i < count( $data );
        $i++ ) {
        
                $data[ $i ]->estado = ' <span class="badge badge-danger">Inactivo</span>';
                $data[ $i ]->acciones = '<div>               
                    <button type="button" class="btn btn-success" onclick="reingresarCliente('.$data[ $i ]->id.');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
                </div>';
        }
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //vista cliente eliminados
    public function clienteEliminado(){ 
        $this->load->view('layouts/Templates/header_admin');
        $this->load->view('layouts/Templates/nav_admin');
        $this->load->view('layouts/Templates/body');
        $this->load->view('layouts/Clientes/clienteEliminado');
        $this->load->view('layouts/Templates/footer_admin');
    }
 
    //Editar cliente
    public function editar(int $id ) {

        $data = $this->ClientesModel->editarCliente( $id );
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //eliminar cliente

    public function deleteCliente( int $id ) {

        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->DashboardModel->verificarPermisos( $id_user, 'eliminar_clientes' );

        if ( !empty( $verificar ) || $id_user == 1 ) {
            $data = $this->ClientesModel->accionCliente( 0, $id );

            if ( $data > 0 ) {
                $msg = ( array( 'eliminado'=>true, 'post' => 'El Cliente fue eliminado con éxito.' ) );
            } else {
                $msg = ( array( 'eliminado'=>false, 'msg' => 'Error al eliminar el Cliente.' ) );
            }
                   
        } else {
            $msg = ( array( 'eliminado'=>false, 'msg' => 'No tiene permisos para eliminar el Cliente.' ) );
        }
         echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
       //vaciar clientes
     public function vaciarCliente(){
        $data = $this->ClientesModel->vaciarCliente();  

        if($data > 0){
            $msg = (array('eliminado'=>true, 'post' => 'Los Clientes fueron vaciados con éxito.'));
        }else{
            $msg = (array('eliminado'=>false, 'msg' => 'Error al vaciar los Clientes.'));
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
   
    //reingresar cliente

    public function reingresarCliente(int $id ) {

        $data = $this->ClientesModel->accionCliente( 1, $id );

        if ( $data > 0 ) {
            $msg = ( array( 'reingresado'=>true, 'post' => 'El Cliente fue reingresado con éxito.' ) );
        } else {
            $msg = ( array( 'reingresado'=>false, 'msg' => 'Error al reingresar el Cliente.' ) );
        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }

}
?>