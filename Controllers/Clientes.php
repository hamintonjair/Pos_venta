<?php

class Clientes extends Controller {

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

        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->model->verificarPermisos( $id_user, 'clientes' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
            $this->views->getView( $this, 'cliente' );
        } else {
            header( 'location:'.base_url.'Errors/permisos' );
        }

    }
    //registrar y actualizar clientes

    public function registrarCliente() {

        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->model->verificarPermisos( $id_user, 'registrar_clientes' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
            $dni = $_POST[ 'dni' ];
            $nombre = $_POST[ 'nombre' ];
            $telefono = $_POST[ 'telefono' ];
            $direccion = $_POST[ 'direccion' ];

            $id = $_POST[ 'idCliente' ];

            if ( empty( $dni ) || empty( $nombre ) || empty( $telefono ) || empty( $dni ) || empty( $direccion ) ) {
                $msg = ( array( 'ok'=>false, 'post' => 'Todos los campos son obligatorios.' ) );
            } else {

                if ( $id == '' ) {
                    //registrar
                    $data = $this->model->registrarCliente( $dni, $nombre, $telefono, $direccion );
                    if ( $data == 'ok' ) {
                        $msg = ( array( 'ok'=>true, 'post' => 'Cliente registrado con éxito.' ) );

                    } else if ( $data == 'existe' ) {
                        $msg = ( array( 'ok'=>false, 'post' => 'la cédula ya existe.' ) );

                    } else {
                        $msg = ( array( 'ok'=>false, 'post' => 'Error al registrar el Cliente.' ) );
                    }

                } else {
                    //actualizar
                    $data = $this->model->updateCliente( $dni, $nombre, $telefono, $direccion, $id );
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

        $data = $this->model->getClientes();
        for ( $i = 0; $i < count( $data );
        $i++ ) {
     
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                if($data[$i]['id'] == 1){
                     $data[$i]['acciones'] = '<div>                     
                        <span class="badge bg-primary">Genérico</span>';
                     '<div>   
                 </div>';
                }else{               
                    $data[ $i ][ 'acciones' ] = '<div>            
                    <button type="button" class="btn btn-primary" onclick="editarCliente('.$data[ $i ][ 'id' ].');" title="Editar"><i class="fas fa-edit"></i></button>   
                    <button type="button" class="btn btn-danger" onclick="eliminarCliente('.$data[ $i ][ 'id' ].');" title="Eliminar"><i class="far fa-trash-alt"></i></button>            
                   </div>';
                }                

        }
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    public function listarEliminados() {

        $data = $this->model->getClientesEliminados();
        for ( $i = 0; $i < count( $data );
        $i++ ) {
        
                $data[ $i ][ 'estado' ] = ' <span class="badge badge-danger">Inactivo</span>';
                $data[ $i ][ 'acciones' ] = '<div>               
                    <button type="button" class="btn btn-success" onclick="reingresarCliente('.$data[ $i ][ 'id' ].');" title="Reingresar"><i class="fa fa-undo" aria-hidden="true"></i></button>      
                </div>';
        }
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    public function clienteEliminado(){ 
           
        $this->views->getView($this, "clienteEliminado");
    }
   
    //Editar cliente
    public function editar( int $id ) {

        $data = $this->model->editarCliente( $id );
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //eliminar cliente

    public function deleteCliente( int $id ) {

        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->model->verificarPermisos( $id_user, 'eliminar_clientes' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
            $data = $this->model->accionCliente( 0, $id );

            if ( $data == 1 ) {
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
    //reingresar cliente

    public function reingresarCliente( int $id ) {

        $data = $this->model->accionCliente( 1, $id );

        if ( $data == 1 ) {
            $msg = ( array( 'reingresado'=>true, 'post' => 'El Cliente fue reingresado con éxito.' ) );
        } else {
            $msg = ( array( 'reingresado'=>false, 'msg' => 'Error al reingresar el Cliente.' ) );
        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }

}
?>