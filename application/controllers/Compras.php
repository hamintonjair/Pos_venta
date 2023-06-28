<?php

class Compras extends CI_Controller {

    public function __construct()
 {
        session_start();

        if ( empty( $_SESSION[ 'activo' ] ) ) {
            echo '<script>window.location.href="http://localhost/Pos_venta/"</script>';	
        }
        parent::__construct();
        $this->load->model('ComprasModel');
        $this->load->model('DashboardModel');
        $this->load->model('VentasModel');


    }
    //VISTA DASHBOARD
    public function vista_usuario() {

        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->DashboardModel->verificarPermisos( $id_user, 'nueva_compra' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
             $data['productos'] = $this->VentasModel->getProducto();    
             $this->load->view('layouts/Templates/header_admin');
             $this->load->view('layouts/Templates/nav_admin');
             $this->load->view('layouts/Templates/body');
             $this->load->view('layouts/Compras/compra', $data);
             $this->load->view('layouts/Templates/footer_admin');  
        } else {
            echo '<script>window.location.href="http://localhost/Pos_venta/Errors/permisos"</script>';	 
         }

    }
    //buscar código
    public function buscarCompra( $cod = NULL) {
  
        if($cod == null)
        {
           $data = false;
        }else{
              $d = str_replace('', '%2B',urldecode($cod));
            $codigo = str_replace('', '+',urldecode($d));

            if(is_numeric( $cod ) == true ) {

                $data = $this->ComprasModel->getProCodi( $cod );

                if(!empty($data[0]->id_proveedor)){
                    $_SESSION['proveedorid'] = $data[0]->id_proveedor;

                }else{
                    $data = false;
                }
            
            }else {
                $data = $this->ComprasModel->getProCodi( $codigo );     
                if(!empty($data[0]->id_proveedor)){
                    $_SESSION['proveedorid'] = $data[0]->id_proveedor;

                }else{
                    $data = false;
                } 
            }
      
        }
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }

    //ingresar dellates

    public function ingresar() {

        $id = $this->input->post('id');
        $datos = $this->VentasModel->getProductos( $id );
        $id_producto = $datos[0]->id;
        $id_usuario = $_SESSION[ 'id_usuario' ];
        // $precio = $datos[ 'precio_compra' ];
        $precio = $this->input->post('precio');
        $cantidad = $this->input->post('cantidad');

        // var_dump($precio2);exit();

        $comprobar = $this->ComprasModel->consultarDetalleC( $id_producto, $id_usuario );

        if ( empty( $comprobar ) ) {

            $sub_total = $precio * $cantidad;
            $data = $this->ComprasModel->registrarDetallesC( $id_producto, $id_usuario, $precio, $cantidad, $sub_total );

            if ( $data == 'modificado' ) {
                $msg = ( array( 'modificado'=> true, 'post' => 'Producto agregado.' ) );

            } else {
                $msg = ( array( 'modificado'=>false, 'post' => 'Error al ingresar el producto.' ) );
            }
        } else {
            // $total_cantidad = $comprobar[ 'cantidad' ] + $cantidad;
            $sub_total = $cantidad * $precio;
            $data = $this->ComprasModel->actualizarDetallesC( $precio, $cantidad, $sub_total, $id_producto, $id_usuario );

            if ( $data == 'modificado' ) {
                $msg = ( array( 'actualizado'=> true, 'post' => 'Se actualizó la cantidad.' ) );

            } else {
                $msg = ( array( 'actualizado'=>false, 'post' => 'Error al actualizar la cantidad.' ) );
            }
        }

        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
    //listar los productos al detalle

    public function listarC() {

        $id_usuario = $_SESSION[ 'id_usuario' ];

        $data[ 'detalle' ] = $this->ComprasModel->getDetalleC( $id_usuario );

        $data[ 'total_pagar' ] = $this->ComprasModel->calcularCompra( $id_usuario );

        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //eliminar productos del detalle

    public function delete( int $id ) {

        $data = $this->ComprasModel->deleteDetalleC( $id );

        if ( $data == 'modificado' ) {
            $msg = ( array( 'modificado'=> true, 'post' => 'Producto eliminado.' ) );

        } else {
            $msg = ( array( 'modificado'=>false, 'post' => 'Error al eliminar el producto.' ) );
        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();

    }
    //registrar compra

    public function registrarCompra( ) {

        $id_usuario = $_SESSION[ 'id_usuario' ];
        $TipoPago = $_SESSION[ 'tipoPago' ];
        $efectivo = $_SESSION[ 'pago' ];
        $proveedorid = $_SESSION['proveedorid'];

        // $datos = $this->ComprasModel->getProCodi( $cod );
        $pagos = $this->ComprasModel->getidCompra();
        $id_proveedor = $_POST[ 'id_proveedor' ];  
  
      if($_SESSION['proveedorid'] == $id_proveedor){

        foreach ( $pagos as $row ) {
                if ( $row->pago ==  $TipoPago ) {
                    $idcompra = $row->id_pago;
                }

            }
            $total = $this->ComprasModel->calcularCompra( $id_usuario );
        
            if($total[0]->total != $efectivo.'.00' && $TipoPago == "Debito"){
                $msg = ( array( 'modificado'=>false, 'post' => 'El valor ingresado es diferente a la deuda.' ) );
            }else{
                $data = $this->ComprasModel->registrarCompra( $total[0]->total, $id_proveedor, $idcompra, $id_usuario);

            if ( $data == 'modificado' ) {
                $detalle = $this->ComprasModel->getDetalleC( $id_usuario );

                //traer el id compra
                $id_compra = $this->ComprasModel->id_Compra();
                foreach ( $detalle as $row ) {
                    $cantidad = $row->cantidad;
                    $precio = $row->precio;
                    $id_prod = $row->id_producto;
                    $sub_total = $cantidad * $precio;
                    $this->ComprasModel->registrarDetalleCompra( $id_compra[0]->id, $id_prod, $cantidad, $precio, $sub_total );
                    $stock_actual = $this->VentasModel->getProductos( $id_prod );
                    $stock =  $stock_actual[0]->cantidad + $cantidad;
                    $this->ComprasModel->actualizarStockC( $stock, $id_prod );
                }
                $vaciar = $this->ComprasModel->vaciarDetalleC( $id_usuario );

                if ( $vaciar == 'modificado' ) {
                    $msg = ( array( 'modificado'=> true, 'post' => 'Compra realizada.',  'id_compra' => $id_compra[0]->id) );
                }
                } else {
                    $msg = ( array( 'modificado'=>false, 'post' => 'Error al realizar la compra.' ) );
                }
            }

      }else{
             $msg = ( array( 'modificado'=>false, 'post' => 'No puedes cambiar el proveedor de este producto, debes crear el proveedor, luego en el módulo de producto editarlo
             y asignarlo al nuevo proveedor para poder hacer la compra.' ) );
        }
        
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
    //generar pfd

  
    public function imprimirPDF($id){

        if ($_SESSION['impresora'] == '80mm') {
            $this->generarPDF80mm($id);
        } else {
            $this->generarPDF($id);
        }

    }
    //generar pfd
    public function generarPDF( $id_compra ) {

        //traer datos d ela empresa
        $empresa = $this->VentasModel->getEmpresa();

        $id_usuario = $_SESSION[ 'id_usuario' ];

        $usuario = $this->VentasModel->getUsuario( $id_usuario );
        //traer datos de la compra
        $productos = $this->ComprasModel->getCompra( $id_compra );

        require_once(APPPATH . 'libraries/fpdf/fpdf.php');

        $pdf = new FPDF( 'P', 'mm', 'letter', true );
        $pdf->AddPage( 'PORTRAIT', 'letter' );
        $pdf->setMargins( 15, 30, 20, 20 );
        $pdf->setTitle( 'Reporte Compra' );

        $pdf->Image( base_url().'assets/img/logo.png', 170, 50, 20, 20, 'png' );

        $pdf->setFillColor( 77, 182, 172 );
        $pdf->Rect( 0, 0, 220, 20, 'F' );

        $pdf->Ln( 20 );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 0, 5, 'Factura de Compra ', 0, 1, 'C' );
       

        foreach ( $productos['registro'] as $row ) {

            $fecha = $row->fecha;
            $nombre = $row->nombre;
            $estado = $row->estado;
            $pago = $row->pago;

        }
        // $formattedFecha = date('Ymd_dmY', strtotime($fecha));

        $pdf->Cell( 0, 5,   $empresa[0]->ciudad, 0, 1, 'C' );
        $pdf->Ln( 10 );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 35, 5, utf8_decode( 'Fecha de orden: ' ), 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, $fecha, 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 24, 5, 'Empresa: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, $empresa[0]->nombre, 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 24, 5, 'Nit: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, $empresa[0]->nit, 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 24, 5, utf8_decode( 'Telefono: ' ), 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, $empresa[0]->telefono, 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 24, 5, utf8_decode( 'Dirección: ' ), 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, $empresa[0]->direccion, 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 24, 5, 'Usuario: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, utf8_decode( $usuario[0]->nombre), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 24, 5, 'Proveedor: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, utf8_decode( $nombre ), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 24, 5, 'Factura #: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, $id_compra, 0, 1, 'L' );
     
    
        $pdf->SetFont( 'Arial', 'B', 12 );

        $pdf->Cell( 85, 5, 'Estado:', 0, 0, 'R' );

        $pdf->SetFont( 'Arial', '', 12 );
        if ( $estado == 0 ) {
            $pdf->Cell( 18, 5, 'Anulado', 0, 1, 'R' );

        } else {
            $pdf->Cell( 25, 5, 'Completado', 0, 1, 'R' );

        }
        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 85, 5, 'Tipo de pago:', 0, 0, 'R' );
        $pdf->SetFont( 'Arial', '', 12 );
        if ( $pago == 'Credito' ) {

            $pdf->Cell( 16, 5, $pago, 0, 1, 'R' );
            $pagar = 'Total a pagar:';

        } else {
            $pdf->Cell( 15, 5, $pago, 0, 1, 'R' );
            $pagar = 'Total pagado:';

        }
        $pdf->Ln();
        $pdf->SetFont( 'Arial', 'B', 12 );

        $pdf->Cell( 24, 5, utf8_decode( $empresa[0]->mensaje ), 0, 1, 'L' );

        $pdf->Ln(5);

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->setTextColor( 40, 40, 40 );
        $pdf->setFillColor( 255, 255, 255 );

        $pdf->SetDrawColor( 88, 88, 88 );

        $pdf->Cell( 15, 5, 'Cant', 0, 0, 'L', true );
        $pdf->Cell( 90, 5, utf8_decode( 'Descripción ' ), 0, 0, 'L', true );
        $pdf->Cell( 40, 5, 'P.Unitario', 0, 0, 'L', true );
        $pdf->Cell( 40, 5, 'Sub Total', 0, 1, 'L', true );

        $pdf->SetLineWidth( 1 );

        $pdf->SetDrawColor( 61, 174, 273, 1 );

        $pdf->setTextColor( 0, 0, 0 );
        $pdf->Line( 15, 114, 200, 114 );

        $pdf->Ln(1);

        $total = 0.00;

        //fondo
        $pdf->setFillColor( 240, 240, 240 );
        $pdf->SetTextColor( 40, 40, 40 );
        $pdf->SetDrawColor( 255, 255, 255 );

        $pdf->SetFont( 'Arial', '', 12 );
        foreach ( $productos['registro'] as $row ) {
            $total = $total + $row->sub_total;
            $pdf->Cell( 15, 5, $row->cantidad, 1, 0, 'L', 1 );
            $pdf->Cell( 90, 5, utf8_decode( $row->descripcion ), 1, 0, 'L', 1 );
            $pdf->Cell( 40, 5, '$'.number_format( $row->precio ), 1, 0, 'L', 1 );
            $pdf->Cell( 40, 5, '$'.number_format( $row->sub_total ), 1, 1, 'L', 1 );
        }

        $pdf->Ln();

        $pdf->setFillColor( 79, 78, 77 );
        $pdf->SetTextColor( 255, 255, 255 );

        $pdf->SetFont( 'Arial', 'B', 12 );

        $pdf->Cell( 150, 5,  $pagar, 0, 0, 'R', 1 );
        $pdf->Cell( 35, 5, '$'.number_format( $total ), 0, 1, 'R', 1 );
        $pdf->Cell( 150, 5, 'total de productos comprados:' , 0, 0, 'R', 1 );
        $pdf->Cell( 35, 5, '$'.number_format($productos['count']), 0, 1, 'R', 1 );

        $pdf->Output();
    }

    public function generarPDF80mm($id_venta) {
        // Traer datos de la empresa
        $empresa = $this->VentasModel->getEmpresa();
    
        $id_usuario = $_SESSION['id_usuario'];
    
        $usuario = $this->VentasModel->getUsuario($id_usuario);
       // Traer datos de la compra
        $productos = $this->ComprasModel->getCompra($id_venta);
    
        require_once(APPPATH . 'libraries/fpdf/fpdf.php');
    
        // Crea una instancia de FPDF con el tamaño personalizado 3
        $pdf = new FPDF('P', 'mm', array(80, 210), true);
    
        // Configurar los márgenes
        $pdf->SetMargins(5, 5, 5);
    
        $pdf->AddPage('PORTRAIT', array(80, 210));
        $pdf->setFillColor(77, 182, 172);
        $pdf->Rect(0, 0, 80, 20, 'F');
        $pdf->Ln(5);
        $pdf->setTitle( 'Reporte de Compra' );

        $pdf->Image( base_url().'assets/img/logo.png', 33, 23, 10, 10, 'png' );
    
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 5, 'Factura de Compra', 0, 1, 'C');
        
        foreach ($productos['registro'] as $row) {
            $fecha = $row->fecha;
            $nombre = $row->nombre;
            $estado = $row->estado;
            $pago = $row->pago;
        }
        // $formattedFecha = date('Ymd_dmY', strtotime($fecha));

        $pdf->Cell(0, 5, $empresa[0]->ciudad, 0, 1, 'C');
        $pdf->Ln(15);
    
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(26, 5, 'Fecha de Compra:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(20, 5, $fecha, 0, 1, 'L');
    
        // Resto del código...
        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, 'Empresa: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5, $empresa[0]->nombre, 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, 'Nit: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5, $empresa[0]->nit, 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, utf8_decode( 'Regimen: ' ), 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5, utf8_decode($empresa[0]->regimen), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, 'Resolucion: ' , 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5,  $empresa[0]->resolucion, 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, utf8_decode( 'Teléfono: ' ), 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5, $empresa[0]->telefono, 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, utf8_decode( 'Dirección: ' ), 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5, utf8_decode( $empresa[0]->direccion), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, 'Cajero: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5, utf8_decode( $usuario[0]->nombre ), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, 'Cliente: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5, utf8_decode( $nombre ), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, 'Factura #: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5, $id_venta, 0, 1, 'L' );


        $pdf->SetFont( 'Arial', 'B', 8 );

        $pdf->Cell( 26, 5, 'Estado de la Compra:', 0, 0, 'l' );
        $pdf->SetFont( 'Arial', '', 8 );
        if ( $estado == 0 ) {
            $pdf->Cell( 16, 5, 'Anulado', 0, 1, 'R' );

        } else {
            $pdf->Cell( 20, 5, 'Completado', 0, 1, 'R' );

        }
        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 20, 5, 'Tipo de pago:', 0, 0, 'R' );
        $pdf->SetFont( 'Arial', '', 8 );
      
        if ( $pago == 'Credito' ) {

            $pdf->Cell( 20, 5, $pago, 0, 1, 'R' );
            $pagar = 'Total a pagar:';

        } else {
            $pdf->Cell( 20, 5, $pago, 0, 1, 'R' );
            $pagar = 'Total pagado:';

        }

        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->MultiCell( 0, 5, utf8_decode( $empresa[0]->mensaje), 0, 1, 'J' );

        $pdf->Ln( 5 );
     
        $pdf->setTextColor( 40, 40, 40 );
        $pdf->setFillColor( 255, 255, 255 );
        $pdf->SetDrawColor( 88, 88, 88 );

         // Encabezados de las columnas
         $pdf->SetFont('Arial', 'B', 8);
         $pdf->Cell(8, 5, 'Cant', 1, 0, 'L', true);
         $pdf->Cell(25, 5, utf8_decode('Descripción'), 1, 0, 'L', true);
         $pdf->Cell(18, 5, 'P. Unitario', 1, 0, 'L', true);
         $pdf->Cell(18, 5, 'Sub Total', 1, 1, 'L', true);

         
         $pdf->SetLineWidth(1);
         $pdf->SetDrawColor(61, 174, 273, 1);
         $pdf->SetTextColor(0, 0, 0);
         $pdf->Ln(1);
         
         $total = 0.00;
    
        //  $pdf->SetFillColor(240, 240, 240);
         $pdf->SetTextColor(40, 40, 40);
         $pdf->SetDrawColor(255, 255, 255);
         
         $pdf->SetFont( 'Arial', '', 8 );
         foreach ( $productos['registro'] as $row ) {
             $total = $total + $row->sub_total;
             $pdf->Cell( 8, 5, $row->cantidad, 1, 0, 'L', 1 );
             $pdf->Cell( 25, 5, utf8_decode( $row->descripcion ), 1, 0, 'L', 1 );
             $pdf->Cell( 18, 5, '$'.number_format( $row->precio), 1, 0, 'L', 1 );
             $pdf->Cell( 18, 5, '$'.number_format( $row->sub_total), 1, 1, 'L', 1 );
         }

      
        $pdf->setFillColor( 99, 108, 97 );
        $pdf->SetTextColor( 255, 255, 255 );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Ln();

        $pdf->Cell( 40, 5, $pagar , 0, 0, 'R', 1 );
        $pdf->Cell( 30, 5, '$'.number_format($total), 0, 1, 'R', 1 );
        $pdf->Cell( 40, 5, 'total de comprados:' , 0, 0, 'R', 1 );
        $pdf->Cell( 30, 5, '$'.number_format($productos['count']), 0, 1, 'R', 1 );
    
    
        $pdf->Output();
    }

    //historial compras
    public function historialCompra() {

        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->DashboardModel->verificarPermisos( $id_user, 'historial_compra' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
            $this->load->view('layouts/Templates/header_admin');
            $this->load->view('layouts/Templates/nav_admin');
            $this->load->view('layouts/Templates/body');
            $this->load->view('layouts/Compras/historial');
            $this->load->view('layouts/Templates/footer_admin'); 
        } else {
            echo '<script>window.location.href="http://localhost/Pos_venta/Errors/permisos"</script>';	   
        }

    }

    //listar historial compra

    public function listar_historial() {

        $data = $this->ComprasModel->getHistorialCompra();
        for ( $i = 0; $i < count( $data );
        $i++ ) {

            if ( $data[ $i ]->estado == 1 ) {
                $data[ $i ]->estado = '<span class="badge badge-success">Completado</span>';

                if( $_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                    $data[ $i ]->acciones = '<div>  
                    <button class="btn btn-warning" title="Anular" onclick="btnAnularC('.$data[ $i ]->id.')"><i class="fas fa-ban"></i></button>          
                    <a type="button" class="btn btn-danger" href="'.base_url().'Compras/generarPDF/'.$data[ $i ]->id.'" target="_blank"  title="PDF"><i class="fas fa-file-pdf"></i></a>       
                    <a type="button"  class="btn btn-danger" href="'.base_url().'Compras/generarPDF80mm/'.$data[ $i ]->id.'" target="_blank"  title="PDF 80mm"><i class="fas fa-file-pdf"> 80mm</i></a>                            
                     
                </div>';
                }else{
                    $data[ $i ]->acciones = '<div>  
                    <button class="btn btn-warning" disabled="" title="Anular" onclick="btnAnularC('.$data[ $i ]->id.')"><i class="fas fa-ban"></i></button>          
                     <a type="button"  class="btn btn-danger" href="'.base_url().'Compras/generarPDF/'.$data[ $i ]->id.'" target="_blank"  title="PDF"><i class="fas fa-file-pdf"></i></a>
                     <a type="button"  class="btn btn-danger" href="'.base_url().'Compras/generarPDF80mm/'.$data[ $i ]->id.'" target="_blank"  title="PDF 80mm"><i class="fas fa-file-pdf"> 80mm</i></a>                            
                            
                  </div>';
                }
                
            } else {

                if($_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                     $data[ $i ]->estado = ' <span class="badge badge-danger">Anulado</span>';

                $data[ $i ]->acciones = '<div>     
                <button class="btn btn-warning" disabled=""  title="Anular" onclick="btnAnularC('.$data[ $i ]->id.')"><i class="fas fa-ban"></i></button>                       
                <a type="button" class="btn btn-danger" href="'.base_url().'Compras/generarPDF/'.$data[ $i ]->id.'" target="_blank"  title="PDF"><i class="fas fa-file-pdf"></i></a> 
                <a type="button"  class="btn btn-danger" href="'.base_url().'Compras/generarPDF80mm/'.$data[ $i ]->id.'" target="_blank"  title="PD 80mmF"><i class="fas fa-file-pdf"> 80mm</i></a>                            
                           
                </div>';
                }else{
                    $data[ $i ]->estado = ' <span class="badge badge-danger">Anulado</span>';
                    $data[ $i ]->acciones = '<div>  
                    <button class="btn btn-warning" disabled="" title="Anular" onclick="btnAnularC('.$data[ $i ]->id.')"><i class="fas fa-ban"></i></button>          
                     <a type="button"  class="btn btn-danger" href="'.base_url().'Compras/generarPDF/'.$data[ $i ]->id.'" target="_blank"  title="PDF"><i class="fas fa-file-pdf"></i></a> 
                     <a type="button"  class="btn btn-danger" href="'.base_url().'Compras/generarPDF80mm/'.$data[ $i ]->id.'" target="_blank"  title="PDF 80mm"><i class="fas fa-file-pdf"> 80mm</i></a>                            
                           
                  </div>';
                }
               

            }

        }
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }

    public function anularCompra( $id_compra ) {

        $data = $this->ComprasModel->getAnularCompra( $id_compra );
       
        $Anular = $this->ComprasModel->getAnular( $id_compra  );
        foreach ( $data as $row ) {
            $stock_actual = $this->VentasModel->getProductos( $row->id_producto );
            $stock =  $stock_actual[0]->cantidad - $row->cantidad;

            $datos = $this->ComprasModel->actualizarStockC( $stock, $row->id_producto );
        }
        if ( $Anular == 'modificado' ) {
            $msg = ( array( 'modificado'=> true, 'post' => 'Compra anulada.' ) );
        } else {
            $msg = ( array( 'modificado'=> false, 'post' => 'Error al anular.' ) );
        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }

    public function TipoPago() {

        $_SESSION[ 'tipoPago' ] = $this->input->post('pago');
        $_SESSION[ 'pago' ] = $this->input->post('efectivo');
        $msg =  $_SESSION[ 'tipoPago' ] ;
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
    }
    //buscar proveedor
    //buscar cliente por nombre

    public function buscarProveedor( $nit ){

        $data = $this->ComprasModel->getProveedor( $nit );
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();

    }
}
?>
