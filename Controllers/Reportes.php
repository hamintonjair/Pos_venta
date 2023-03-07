<?php

class Reportes extends Controller {

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
        $verificar = $this->model->verificarPermisos( $id_user, 'reportes' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
           
            $this->views->getView( $this, 'reporte' );
        } else {
            header( 'location:'.base_url.'Errors/permisos' );
        }

    }
     //listar reportes cierre de caja
     public function listarReporteCierre(){

        $data = $this->model->getreporteCierre();      

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //vista reporte por mempleado
    public function reporteEmpleado(){
        $data = array(
            'empleado' =>  $this->model->getUsuarios()
       );
        $this->views->getView($this, 'reporteEmpleado',  $data);
    }

    //listar reporte por empleado
    public function buscarReporteEmpleado(){

        $id_empleado = $_POST[ 'id_empleado' ];
       $data = array(
            'empleado' =>  $this->model->getreporteCierreEmpleado($id_empleado)
       );      
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //vista reporte ganancias por mes
    public function reporteGananciasMes(){
      
        // $data = $this->model->getreporteGananciasMes();     
        $this->views->getView($this, 'reporteGanancias'); 
        
    }
    //listar reportes de ganacias
    public function listarGanancias(){

        $data = $this->model->getreporteGananciasMes();    

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //buscar por rango de fecha
    public function rangoFecha(){
      
           $desde = $_POST['desde'];
           $hasta = $_POST['hasta'];        
         
            $data = array( 
                'reporte' => $this->model->getRangoFechas($desde, $hasta)
            );

           echo json_encode($data, JSON_UNESCAPED_UNICODE);
           die();
    }
}
?>