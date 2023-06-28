<?php

class Dashboard extends CI_Controller {

    public function __construct()
    {
        session_start();
      
        if ( empty( $_SESSION[ 'activo' ] ) ) {
            echo '<script>window.location.href="http://localhost/Pos_venta/"</script>';	

        }
        parent::__construct();
        $this->load->model('DashboardModel');
    }


    public function configuracion() {

        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->DashboardModel->verificarPermisos( $id_user, 'configuracion' );

        if ( !empty( $verificar ) || $id_user == 1 ) {

            $data['permisos'] = $this->DashboardModel->getEmpresa();
            $this->load->view('layouts/Templates/header_admin');
            $this->load->view('layouts/Templates/nav_admin');
            $this->load->view('layouts/Templates/body');
            $this->load->view('layouts/Configuracion/configuracion', $data);
            $this->load->view('layouts/Templates/footer_admin');


        } else {
            echo '<script>window.location.href="http://localhost/Pos_venta/Errors/permisos"</script>';			
        }

    }
    //mostrar la cantidad de acuerdo a la tabla     //VISTA DASHBOARD
    public function inicio() {
    
        $data['categorias'] =  $this->DashboardModel->getDatos( 'categorias' );
        $data['proveedores'] =  $this->DashboardModel->getDatos( 'proveedor' );
        $data['salidas'] =  $this->DashboardModel->getDatos( 'ventas' );
        $data['entrada'] =  $this->DashboardModel->getDatos( 'compras' );
        $data['usuarios'] = $this->DashboardModel->getDatos( 'usuarios' );
        $data['clientes'] = $this->DashboardModel->getDatos( 'clientes' );
        $data['productos'] = $this->DashboardModel->getDatos( 'productos' );
        $data['ventas'] = $this->DashboardModel->getVentas();

        $this->load->view('layouts/Templates/header_admin');
        $this->load->view('layouts/Templates/nav_admin');
        $this->load->view('layouts/Templates/body');
        $this->load->view('layouts/Configuracion/dashboard', $data);
        $this->load->view('layouts/Templates/footer_admin');
    }
    //editar empresa

    public function editar() {

        $nit = $this->input->post('nit');
        $regimen = $this->input->post('regimen');
        $resolucion = $this->input->post('resolucion');
        $nombre = $this->input->post('nombre');
        $telefono = $this->input->post('telefono');
        $direccion = $this->input->post('direccion');
        $ciudad = $this->input->post('ciudad');
        $mensaje = $this->input->post('mensaje');
        $impresora = $this->input->post('impresora');

        $id = $this->input->post('id');
        $cantidadCaracter = strlen( $mensaje);
    
        if ( $cantidadCaracter > 95 ) {            
              $msg = ( array( 'ok'=> false, 'post' => 'No debe superar la cantidad de caracteres permitidos (95).' ) );
        } else {
            $data = $this->DashboardModel->actualizar( $nit, $regimen, $resolucion, $nombre, $telefono, $direccion, $ciudad, $mensaje,$impresora, $id );
            if ( $data > 0 ) {

                $msg = ( array( 'ok'=> true, 'post' => 'Se actualizaron los datos.' ) );

            } else {
                $msg = ( array( 'ok'=> false, 'post' => 'Error al actualizar.' ) );
                
            }
        }

        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
    //stock muinimo

    public function reportStock() {
        $data = $this->DashboardModel->getStockMinimo();

        echo json_encode( $data );
        die();
    }
    //productos mas vendidos

    public function productosVendidos() {
        $data = $this->DashboardModel->getproductosMasVendidos();
        echo json_encode( $data );
        die();
    }
   

}
?>