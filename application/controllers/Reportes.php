<?php

class Reportes extends CI_Controller {

    public function __construct()
 {
        session_start();

        if ( empty( $_SESSION[ 'activo' ] ) ) {
            echo '<script>window.location.href="http://localhost/Pos_venta/"</script>';				
        }
        parent::__construct();
        $this->load->model('ReportesModel');
    }
    //VISTA DASHBOARD

    public function vistaReportes() {

        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->ReportesModel->verificarPermisos( $id_user, 'reportes' );
        if ( !empty( $verificar ) || $id_user == 1 ) {

            $this->load->view('layouts/Templates/header_admin');
            $this->load->view('layouts/Templates/nav_admin');
            $this->load->view('layouts/Templates/body');
            $this->load->view('layouts/Reportes/reporte');
            $this->load->view('layouts/Templates/footer_admin');
        } else {
            echo '<script>window.location.href="http://localhost/Pos_venta/Errors/permisos"</script>';				

       }

    }
    //listar reportes cierre de caja

    public function listarReporteCierre() {

        $data = $this->ReportesModel->getreporteCierre();

        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //vista reporte por mempleado

    public function reporteEmpleado() {
        $data = array(
            'empleado' =>  $this->ReportesModel->getUsuarios()
        );
        $this->load->view('layouts/Templates/header_admin');
        $this->load->view('layouts/Templates/nav_admin');
        $this->load->view('layouts/Templates/body');
        $this->load->view('layouts/Reportes/reporteEmpleado', $data);
        $this->load->view('layouts/Templates/footer_admin');
    }

    //listar reporte por empleado

    public function buscarReporteEmpleado() {

        $id_empleado = $_POST[ 'id_empleado' ];
        $data = array(
            'empleado' =>  $this->ReportesModel->getreporteCierreEmpleado( $id_empleado )
        );

        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    // listar empleados
    public function listarEmpleados() {

        $data = $this->ReportesModel->getreporteEmpleados();

        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //vista reporte ganancias por mes

    public function reporteVentasMes() {

        $this->load->view('layouts/Templates/header_admin');
        $this->load->view('layouts/Templates/nav_admin');
        $this->load->view('layouts/Templates/body');
        $this->load->view('layouts/Reportes/reporteVentas');
        $this->load->view('layouts/Templates/footer_admin');

    }

    //listar reportes de ganacias

    public function listarVentasMes() {

        $data = $this->ReportesModel->getreporteVentasMes();

        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }

    //buscar por rango de fecha

    public function rangoFecha() {

        $desde = $this->input->post('desde');
        $hasta = $this->input->post('hasta');

        $data = array(
            'reporte' => $this->ReportesModel->getRangoFechas( $desde, $hasta )
        );
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //vista reporte compras por mes

    public function reporteComprasMes() {

        $this->load->view('layouts/Templates/header_admin');
        $this->load->view('layouts/Templates/nav_admin');
        $this->load->view('layouts/Templates/body');
        $this->load->view('layouts/Reportes/reporteCompras');
        $this->load->view('layouts/Templates/footer_admin');

    }

    //vista reporte por proveedor
    public function reporteProveedor() {
        $data = array(
            'proveedor' =>  $this->ReportesModel->getProveedor()
        );    
        $this->load->view('layouts/Templates/header_admin');
        $this->load->view('layouts/Templates/nav_admin');
        $this->load->view('layouts/Templates/body');
        $this->load->view('layouts/Reportes/reporteCompras', $data);
        $this->load->view('layouts/Templates/footer_admin');
    }
    //buscar reporte por proveedor

    public function buscarComprasProveedor() {

        $id_proveedor = $this->input->post('id_proveedor');  
      
        $data = array(
            'empleado' =>  $this->ReportesModel->getreporteCompraProveedores( $id_proveedor )
        );
   
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //listar reportes de compras
    public function listarCompras() {

        $data = $this->ReportesModel->getreporteCompras();

        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //grafica ganancias
    public function verGanancia($año){
    
        $data = $this->ReportesModel->gananciaMes($año);
 
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //listar ganancias
    public function verGanancias(){
    
        $data = $this->ReportesModel->listargananciaMes();

        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //vista ganacias
        //vista reporte por proveedor
    public function ganacias() {
      
        $this->load->view('layouts/Templates/header_admin');
        $this->load->view('layouts/Templates/nav_admin');
        $this->load->view('layouts/Templates/body');
        $this->load->view('layouts/Reportes/ganancias');
        $this->load->view('layouts/Templates/footer_admin');
      }

}
?>