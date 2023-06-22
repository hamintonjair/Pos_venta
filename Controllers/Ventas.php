<?php

class Ventas extends Controller {

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
        $verificar = $this->model->verificarPermisos( $id_user, 'nueva_venta' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
                 $data['productos'] = $this->model->getProducto();    
            $this->views->getView( $this, 'venta', $data );
        } else {
            header( 'location:'.base_url.'Errors/permisos' );
        }
       
    }
    //buscar código
    public function buscarVenta( $cod ) {
       
        if(is_numeric($cod) == true){

            $data = $this->model->getProCod($cod);
        }else{
            $data = $this->model->getProCod($cod);
        }

        if ( $data ) {
            if ( $data[ 1 ][ 'cantidad' ] == 0 ) {
                $msg = ( array( 'modificado'=> false, 'post' => 'Producto agotado.' ) );

            }
            if ( $data[ 1 ][ 'cantidad' ] > 0 ) {
                $msg = $data[ 1 ];
            }
        } else {
            $msg = ( array( 'modificado'=>false, 'post' => 'Producto no existe.' ) );
        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
    //buscar cliente por nombre
    public function buscarCliente( $cedula ) {
        $data = $this->model->getCliente( $cedula );
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();

    }
    //ingresar detalles ventas

    public function ingresar() {

        $id = $_POST[ 'id' ];
        $datos = $this->model->getProductos( $id );
        $id_producto = $datos[ 'id' ];
        $id_usuario = $_SESSION['id_usuario'];
        $precio = $datos[ 'precio_venta' ];
        $cantidad = $_POST[ 'cantidad' ];
        $iva = $datos[ 'iva' ];   
        $subTotal =   $precio *  $cantidad;
        $subIva = ($subTotal * $iva ) / 100 ;
        $total =    $subIva  +  $subTotal ;  

        if ( $datos[ 'cantidad' ] >= $cantidad ) {

            $comprobar = $this->model->consultarDetalle( $id_producto, $id_usuario );

            if ( empty( $comprobar ) ) {

                $sub_total = $precio * $cantidad;
                $data = $this->model->registrarDetalles( $id_producto, $id_usuario, $precio, $cantidad, $iva, $total  );

                if ( $data == 'modificado' ) {
                    $msg = ( array( 'modificado'=> true, 'post' => 'Producto agregado.' ) );

                } else {
                    $msg = ( array( 'error'=>false, 'post' => 'Error al ingresar el producto.' ) );
                }
            } else {
                // $total_cantidad = $comprobar[ 'cantidad' ] + $cantidad;
                $sub_total = $cantidad * $precio;
                $data = $this->model->actualizarDetalles( $precio, $cantidad, $iva, $total , $id_producto, $id_usuario );

                if ( $data == 'modificado' ) {
                    $msg = ( array( 'actualizado'=> true, 'post' => 'Se actualizó la cantidad.' ) );

                } else {
                    $msg = ( array( 'error'=>false, 'post' => 'Error al actualizar la cantidad.' ) );
                }
            }

        } else {
            $cantidad = $datos[ 'cantidad' ];
            $msg = ( array( 'error'=>false, 'post' => "Cantidad actual $cantidad" ) );
        }

        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
    //listar los productos al detalle

    public function listar() {

        $id_usuario = $_SESSION[ 'id_usuario' ];
        $data[ 'detalle' ] = $this->model->getDetalle( $id_usuario );

        $data[ 'total_pagar' ] = $this->model->calcularVenta( $id_usuario );

        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //eliminar productos del detalle

    public function delete( int $id ) {

        $data = $this->model->deleteDetalle( $id );

        if ( $data == 'modificado' ) {
            $msg = ( array( 'modificado'=> true, 'post' => 'Producto eliminado.' ) );

        } else {
            $msg = ( array( 'modificado'=>false, 'post' => 'Error al eliminar el producto.' ) );
        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();

    }
    //cambio
    public function ingresarCambio(){

        $efectivos = $_POST[ 'efectivos' ];        
        $data = $this->model->getDetalles();
        $sub_total = $data['total'];

     
        if( $efectivos < $sub_total){
            $msg = ( array( 'modificado'=>false, 'msg' => 'Error el valor debe ser mayor a la compra.' ) );
                   
        }else{
           $_SESSION['cambio'] = $total = $efectivos - $sub_total;
           $_SESSION['pago'] = $efectivos ;
           $msg = ( array( 'modificado'=> true, 'post' => 'Exitoso.' ) );
        }  
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();       
    }
    //registrar compra

    public function registrarVenta() {
       
        $id_usuario = $_SESSION[ 'id_usuario' ];
        $verificar = $this->model->verificarCaja( $id_usuario );

    
        if (empty( $verificar) ) {
            $msg = ( array( 'modificado'=>false, 'msg' => 'La caja está cerrada.' ) );

        }else{
            $cliente = $_POST[ 'ID' ];

            $total = $this->model->calcularVenta( $id_usuario );

          
            if ( empty( $cliente ) ) {
                $cliente = '1';
                $data = $this->model->registrarVenta( $id_usuario, $total[ 'total' ], $cliente, $_SESSION['pago'],  $_SESSION['cambio'] );
            } else {
                $data = $this->model->registrarVenta($id_usuario, $total[ 'total' ], $cliente, $_SESSION['pago'],  $_SESSION['cambio'] );

            }
    
            if ( $data == 'modificado' ) {
                $detalle = $this->model->getDetalle( $id_usuario );

                //traer el id compra
                $id_venta = $this->model->id_Venta();
                foreach ( $detalle as $row ) {
                    $iva = $row[ 'iva' ];
                    $cantidad = $row[ 'cantidad' ];
                    $descuento = $row[ 'descuento' ];
                    $precio = $row[ 'precio' ];
                    $id_prod = $row[ 'id_producto' ];                 
 
                    $subTotal =   $precio *  $cantidad;
                    $subIva = ($subTotal * $iva ) / 100 ;
                    $sub_total =    $subIva  +  $subTotal ;  

                    $this->model->registrarDetalleVenta( $id_venta[ 'id' ], $id_prod, $cantidad, $iva,  $descuento, $precio, $sub_total );
                    $stock_actual = $this->model->getProductos( $id_prod );
                    $stock =  $stock_actual[ 'cantidad' ] - $cantidad;
                    $this->model->actualizarStock( $stock, $id_prod );
                }

                $vaciar = $this->model->vaciarDetalle( $id_usuario );

                if ( $vaciar == 'modificado' ) {
                    $msg = ( array( 'modificado'=> true, 'post' => 'Venta realizada.',  'id_venta' => $id_venta[ 'id' ] ) );
                }
            } else {
                $msg = ( array( 'modificado'=>false, 'msg' => 'Error al realizar la venta.' ) );
            }
        }

        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
    public function imprimirPDF($id){

        if ($_SESSION['impresora'] == '80mm') {
            $this->generarPDF80mm($id);
        } else {
            $this->generarPDF($id);
        }

    }
    //generar pfd
    public function generarPDF( $id_venta ) {

        //traer datos d ela empresa
        $empresa = $this->model->getEmpresa();

        $id_usuario = $_SESSION[ 'id_usuario' ];

        $usuario = $this->model->getUsuario( $id_usuario );
        //descuento
        $descuento = $this->model->getDescuento( $id_venta );
        //traer datos de la compra
        $productos = $this->model->getVenta( $id_venta );

        require( 'Libraries/fpdf/fpdf.php' );

        $pdf = new FPDF( 'P', 'mm', 'letter', true );
        $pdf->AddPage( 'PORTRAIT', 'letter' );
        $pdf->setMargins( 15, 30, 20, 20 );
        $pdf->setTitle( 'Reporte Venta' );

        $pdf->Image( base_url.'Assets/img/logo.png', 170, 50, 20, 20, 'png' );

        $pdf->setFillColor( 77, 182, 172 );
        $pdf->Rect( 0, 0, 220, 20, 'F' );

        $pdf->Ln( 20 );

        $pdf->SetFont( 'Arial', 'B', 14 );
        $pdf->Cell( 0, 5, 'Factura de Venta ', 0, 1, 'C' );

        foreach ( $productos as $row ) {

            $fecha = $row[ 'fecha' ];
            $nombre = $row[ 'nombre' ];
            $estado = $row[ 'estado' ]; 
             
        }
        $pdf->Cell( 0, 5,   $empresa['ciudad'], 0, 1, 'C' );
        $pdf->Ln( 10 );       

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 35, 5, 'Fecha de venta: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, Ymd_dmY( $fecha ), 0, 1, 'L' );
        
        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 26, 5, 'Empresa: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, $empresa[ 'nombre' ], 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 26, 5, 'Nit: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, $empresa[ 'nit' ], 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 26, 5, utf8_decode( 'Regimen: ' ), 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, utf8_decode($empresa['regimen']), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 26, 5, 'Resolucion: ' , 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5,  $empresa['resolucion'], 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 26, 5, utf8_decode( 'Teléfono: ' ), 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, $empresa[ 'telefono' ], 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 26, 5, utf8_decode( 'Dirección: ' ), 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, utf8_decode( $empresa[ 'direccion' ]), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 26, 5, 'Cajero: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, utf8_decode( $usuario[ 'nombre' ] ), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 26, 5, 'Cliente: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, utf8_decode( $nombre ), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 26, 5, 'Factura #: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, $id_venta, 0, 1, 'L' );


        $pdf->SetFont( 'Arial', 'B', 12 );

        $pdf->Cell( 110, 5, 'Estado de la venta:', 0, 0, 'R' );
        $pdf->SetFont( 'Arial', '', 12 );
        if ( $estado == 0 ) {
            $pdf->Cell( 20, 5, 'Anulado', 0, 1, 'R' );

        } else {
            $pdf->Cell( 27, 5, 'Completado', 0, 1, 'R' );

        }

        $pdf->Ln();

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 24, 5, utf8_decode( $empresa[ 'mensaje' ] ), 0, 1, 'J' );

        //encabezado de productos
        $pdf->Ln( 5 );

        $pdf->setTextColor( 40, 40, 40 );
        $pdf->setFillColor( 255, 255, 255 );

        $pdf->SetDrawColor( 88, 88, 88 );

        $pdf->Cell( 15, 5, 'Cant', 0, 0, 'L', true );
        $pdf->Cell( 90, 5, utf8_decode( 'Descripción ' ), 0, 0, 'L', true );
        $pdf->Cell( 8, 5, 'Iva', 0, 0, 'L', true );
        $pdf->Cell( 35, 5, 'P. Unitario', 0, 0, 'L', true );
        $pdf->Cell( 38, 5, 'P. Total', 0, 1, 'L', true );

        $pdf->SetLineWidth( 1 );

        $pdf->SetDrawColor( 61, 174, 273, 1 );

        $pdf->setTextColor( 0, 0, 0 );
        $pdf->Line( 15, 118, 200, 118 );

        $pdf->Ln(1);

        $descuentos = 0.00;
        $Total = 0;
        $sub_total  = 0;
        $totalPagar = 0;
        $cambio = 0;
        $pagado = 0;
        //fondo
        $pdf->setFillColor( 240, 240, 240 );
        $pdf->SetTextColor( 40, 40, 40 );
        $pdf->SetDrawColor( 255, 255, 255 );
        $pdf->SetFont( 'Arial', '', 12 );
        foreach ( $productos as $row ) {

            $Total =    $Total + ($row['precio'] * $row['cantidad']);
            $sub_total = $sub_total + $row['sub_total']; 
            $descuentos =  ($sub_total * $row['descuento']) / 100;  
            $pagado =  $row['pagado'] ;  
            $cambio =  $row['cambio'] ;      
            $pdf->Cell( 15, 5, $row['cantidad'], 1, 0, 'L', 1 );
            $pdf->Cell( 90, 5, utf8_decode( $row['descripcion' ] ), 1, 0, 'L', 1 );
            $pdf->Cell( 8, 5,  $row['iva'] , 1, 0, 'L', 1 );
            $pdf->Cell( 35, 5, '$'.number_format( $row['precio'] ), 1, 0, 'L', 1 );
            $pdf->Cell( 38, 5, '$'.number_format( $row['sub_total']), 1, 1, 'L', 1 );
           
        }

        //descuento
         $totalPagar =  (($sub_total -  $Total) +  $Total) -  $descuentos;  
        //   $totalPagar = $totalC - $total;

       
        // $totalApagar = $sub_total - $descuento[ 'total' ];
        $pdf->Ln();

        $pdf->setFillColor( 79, 78, 77 );
        $pdf->SetTextColor( 255, 255, 255 );

        $pdf->SetFont( 'Arial', '', 12 );

        $pdf->Cell( 140, 5, 'Sub Total:', 0, 0, 'R', 1 );
        $pdf->Cell( 45, 5, '$'.number_format(  $Total ), 0, 1, 'R', 1 );

        $pdf->Cell( 140, 5, 'IVA%:', 0, 0, 'R', 1 );
        $pdf->Cell( 45, 5, '$'.number_format($sub_total -  $Total), 0, 1, 'R', 1 );

        $pdf->Cell( 140, 5, 'Descuento Total:', 0, 0, 'R', 1 );
        $pdf->Cell( 45, 5, '$'.number_format( $descuentos), 0, 1, 'R', 1 );

        $pdf->SetFont( 'Arial', 'B', 15 );
        $pdf->Cell( 140, 5, 'Total a Pagar:', 0, 0, 'R', 1 );
        $pdf->Cell( 45, 5, '$'.number_format( $totalPagar ), 0, 1, 'R', 1 );
        
        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 20, 5, 'Pagado:', 0, 0, 'L', 1 );
        $pdf->Cell( 35, 5, '$'.number_format( $pagado ), 0, 1, 'L', 1 );

        $pdf->Cell( 20, 5, 'Cambio:', 0, 0, 'L', 1 );
        $pdf->Cell( 35, 5, '$'.number_format( $cambio ), 0, 1, 'L', 1 );

        $pdf->Output();
    }

    public function generarPDF80mm($id_venta) {
        // Traer datos de la empresa
        $empresa = $this->model->getEmpresa();
    
        $id_usuario = $_SESSION['id_usuario'];
    
        $usuario = $this->model->getUsuario($id_usuario);
        // Descuento
        $descuento = $this->model->getDescuento($id_venta);
        // Traer datos de la compra
        $productos = $this->model->getVenta($id_venta);
    
        require('Libraries/fpdf/fpdf.php');
    
        // Crea una instancia de FPDF con el tamaño personalizado 3
        $pdf = new FPDF('P', 'mm', array(80, 210), true);
    
        // Configurar los márgenes
        $pdf->SetMargins(5, 5, 5);
    
        $pdf->AddPage('PORTRAIT', array(80, 210));
        $pdf->setFillColor(77, 182, 172);
        $pdf->Rect(0, 0, 80, 20, 'F');
        $pdf->Ln(5);
        $pdf->setTitle( 'Reporte de Venta' );

        $pdf->Image( base_url.'Assets/img/logo.png', 33, 23, 10, 10, 'png' );
    
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 5, 'Factura de Venta', 0, 1, 'C');
        
        foreach ($productos as $row) {
            $fecha = $row['fecha'];
            $nombre = $row['nombre'];
            $estado = $row['estado'];
        }
        
        $pdf->Cell(0, 5, $empresa['ciudad'], 0, 1, 'C');
        $pdf->Ln(15);
    
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(26, 5, 'Fecha de venta:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(20, 5, Ymd_dmY($fecha), 0, 1, 'L');
    
        // Resto del código...
        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, 'Empresa: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5, $empresa[ 'nombre' ], 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, 'Nit: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5, $empresa[ 'nit' ], 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, utf8_decode( 'Regimen: ' ), 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5, utf8_decode($empresa['regimen']), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, 'Resolucion: ' , 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5,  $empresa['resolucion'], 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, utf8_decode( 'Teléfono: ' ), 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5, $empresa[ 'telefono' ], 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, utf8_decode( 'Dirección: ' ), 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5, utf8_decode( $empresa[ 'direccion' ]), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, 'Cajero: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5, utf8_decode( $usuario[ 'nombre' ] ), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, 'Cliente: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5, utf8_decode( $nombre ), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 26, 5, 'Factura #: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->Cell( 20, 5, $id_venta, 0, 1, 'L' );


        $pdf->SetFont( 'Arial', 'B', 8 );

        $pdf->Cell( 26, 5, 'Estado de la venta:', 0, 0, 'l' );
        $pdf->SetFont( 'Arial', '', 8 );
        if ( $estado == 0 ) {
            $pdf->Cell( 15, 5, 'Anulado', 0, 1, 'R' );

        } else {
            $pdf->Cell( 20, 5, 'Completado', 0, 1, 'R' );

        }
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->MultiCell( 0, 5, utf8_decode( $empresa[ 'mensaje' ] ), 0, 1, 'J' );

        $pdf->Ln(5);

        $pdf->setTextColor( 40, 40, 40 );
        $pdf->setFillColor( 255, 255, 255 );
        $pdf->SetDrawColor( 88, 88, 88 );


         // Encabezados de las columnas
         $pdf->SetFont('Arial', 'B', 8);
         $pdf->Cell(8, 5, 'Cant', 1, 0, 'L', true);
         $pdf->Cell(20, 5, utf8_decode('Descripción'), 1, 0, 'L', true);
         $pdf->Cell(8, 5, 'Iva', 1, 0, 'L', true);
         $pdf->Cell(18, 5, 'P. Unitario', 1, 0, 'L', true);
         $pdf->Cell(16, 5, 'P. Total', 1, 1, 'L', true);
         
         $pdf->SetLineWidth(1);
         $pdf->SetDrawColor(61, 174, 273, 1);
         $pdf->SetTextColor(0, 0, 0);
         $pdf->Ln(1);
         
         $descuentos = 0.00;
         $Total = 0;
         $sub_total = 0;
         $totalPagar = 0;
         $cambio = 0;
         $pagado = 0;
        //  $pdf->SetFillColor(240, 240, 240);
         $pdf->SetTextColor(40, 40, 40);
         $pdf->SetDrawColor(255, 255, 255);
         $pdf->SetFont('Arial', '', 8);
         
   
        foreach ( $productos as $row ) {

            $Total =    $Total + ($row['precio'] * $row['cantidad']);
            $sub_total = $sub_total + $row['sub_total']; 
            $descuentos =  ($sub_total * $row['descuento']) / 100;  
            $pagado =  $row['pagado'] ;  
            $cambio =  $row['cambio'] ;      
            $pdf->Cell( 8, 5, $row['cantidad'], 1, 0, 'L', 1 );
            $pdf->Cell( 20, 5, utf8_decode( $row['descripcion' ] ), 1, 0, 'L', 1 );
            $pdf->Cell( 8, 5,  $row['iva'] , 1, 0, 'L', 1 );
            $pdf->Cell( 18, 5, '$'.number_format( $row['precio'] ), 1, 0, 'L', 1 );
            $pdf->Cell( 18, 5, '$'.number_format( $row['sub_total']), 1, 1, 'L', 1 );
           
        }
                //descuento
         $totalPagar =  (($sub_total -  $Total) +  $Total) -  $descuentos;  

        $pdf->Ln();

        $pdf->setFillColor( 99, 108, 97 );
        $pdf->SetTextColor( 255, 255, 255 );

        $pdf->SetFont( 'Arial', '', 8 );

        $pdf->Cell( 35, 5, 'Sub Total:', 0, 0, 'R', 1 );
        $pdf->Cell( 30, 5, '$'.number_format(  $Total ), 0, 1, 'R', 1 );

        $pdf->Cell( 35, 5, 'IVA%:', 0, 0, 'R', 1 );
        $pdf->Cell( 30, 5, '$'.number_format($sub_total -  $Total), 0, 1, 'R', 1 );

        $pdf->Cell( 35, 5, 'Descuento Total:', 0, 0, 'R', 1 );
        $pdf->Cell( 30, 5, '$'.number_format( $descuentos), 0, 1, 'R', 1 );

        $pdf->SetFont( 'Arial', 'B', 10 );
        $pdf->Cell( 35, 5, 'Total a Pagar:', 0, 0, 'R', 1 );
        $pdf->Cell( 30, 5, '$'.number_format( $totalPagar ), 0, 1, 'R', 1 );
        
        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell( 35, 5, 'Pagado:', 0, 0, 'R', 1 );
        $pdf->Cell( 30, 5, '$'.number_format( $pagado ), 0, 1, 'R', 1 );

        $pdf->Cell( 35, 5, 'Cambio:', 0, 0, 'R', 1 );
        $pdf->Cell( 30, 5, '$'.number_format( $cambio ), 0, 1, 'R', 1 );
    
        $pdf->Output();
    }

    //historial compras

    public function historialVenta() {

        $this->views->getView( $this, 'historialC' );
    }

    //listar historial compra

    public function listar_historial() {

        $data = $this->model->getHistorialVenta();

        for ( $i = 0; $i < count( $data );
        $i++ ) {

            if ( $data[ $i ][ 'estado' ] == 1 ) {
                $data[ $i ][ 'estado' ] = '<span class="badge badge-success">Completado</span>';

                if($_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                    $data[ $i ][ 'acciones' ] = '<div>  
                    <button class="btn btn-warning" title="Anular" onclick="btnAnularV('.$data[ $i ][ 'id' ].')"><i class="fas fa-ban"></i></button>          
                    <a type="button" class="btn btn-danger" href="'.base_url.'ventas/generarPDF/'.$data[ $i ][ 'id' ].'" target="_blank"  title="PDF"><i class="fas fa-file-pdf"></i></a>
                    <a type="button" class="btn btn-danger"  href="'.base_url.'ventas/generarPDF80mm/'.$data[ $i ][ 'id' ].'" target="_blank"  title="PDF 80mm"><i class="fas fa-file-pdf"></i> 80mm</a>                            
                            
                </div>';
                }else{
                    $data[ $i ][ 'acciones' ] = '<div>  
                    <button class="btn btn-warning" disabled="" title="Anular" onclick="btnAnularV('.$data[ $i ][ 'id' ].')"><i class="fas fa-ban"></i></button>          
                    <a type="button" class="btn btn-danger"  href="'.base_url.'ventas/generarPDF/'.$data[ $i ][ 'id' ].'" target="_blank"  title="PDF"><i class="fas fa-file-pdf"></i></a>                            
                    <a type="button" class="btn btn-danger"  href="'.base_url.'ventas/generarPDF80mm/'.$data[ $i ][ 'id' ].'" target="_blank"  title="PDF 80mm"><i class="fas fa-file-pdf"></i> 80mm</a>                            
                    </div>';

                }
                

            } else {
                if($_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                    $data[ $i ][ 'estado' ] = ' <span class="badge badge-danger">Anulado</span>';
                    $data[ $i ][ 'acciones' ] = '<div>    
                    <button class="btn btn-warning" title="Anular" onclick="btnAnularV('.$data[ $i ][ 'id' ].')"><i class="fas fa-ban"></i></button>                     
                    <a type="button" class="btn btn-danger" href="'.base_url.'ventas/generarPDF/'.$data[ $i ][ 'id' ].'" target="_blank"  title="PDF"><i class="fas fa-file-pdf"></i></a>
                    <a type="button" class="btn btn-danger"  href="'.base_url.'ventas/generarPDF80mm/'.$data[ $i ][ 'id' ].'" target="_blank"  title="PDF 80mm"><i class="fas fa-file-pdf"></i> 80mm</a>                                                        
                    </div>';
                }
                else{
                    $data[ $i ][ 'estado' ] = ' <span class="badge badge-danger">Anulado</span>';
                    $data[ $i ][ 'acciones' ] = '<div>  
                    <button class="btn btn-warning" disabled="" title="Anular" onclick="btnAnularV('.$data[ $i ][ 'id' ].')"><i class="fas fa-ban"></i></button>          
                    <a type="button" class="btn btn-danger"href="'.base_url.'ventas/generarPDF/'.$data[ $i ][ 'id' ].'" target="_blank"  title="PDF"><i class="fas fa-file-pdf"></i></a>
                                        <a type="button" class="btn btn-danger"  href="'.base_url.'ventas/generarPDF80mm/'.$data[ $i ][ 'id' ].'" target="_blank"  title="PDF 80mm"><i class="fas fa-file-pdf"></i> 80mm</a>                            
                            
                   </div>';

                }
                

            }

        }
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //calcular descuentos

    public function calcularDescuento( $data ) {

        $array = explode( ',', $data );
        $id = $array[ 0 ];
        $desc = $array[ 1 ];

        if ( empty( $id ) || empty( $desc ) ) {
            $msg = ( array( 'modificado'=>false, 'post' => 'Error al aplicar el producto.' ) );
        } else {
            $descAct = $this->model->verificarDescuento( $id );

            $iva = $descAct[ 'iva' ];   
            $precio = $descAct[ 'precio' ];  
            $cantidad = $descAct[ 'cantidad' ];  
           

            $iva = $descAct[ 'iva' ];   
            $descuento_total = $descAct[ 'descuento' ] + $desc;
            //sum total
            $subTotal =   $precio *  $cantidad;
            //valor iva
            $subIva = ($subTotal * $iva) / 100 ;  
            //total
            $totalC =  ($subIva  +  $subTotal);         
            //descuento
            $total =  ($totalC * $descuento_total) / 100;  
            $totalPagar = $totalC - $total;
         
            $datos = $this->model->actualizarDescuento($descuento_total, $totalPagar, $id);


            // $descuento_total = $descAct[ 'descuento' ] + $desc;
            // $subTotal  = ( $descAct[ 'cantidad' ] * $descAct[ 'precio' ] ) - $descuento_total;
            // $datos = $this->model->actualizarDescuento( $descuento_total, $subTotal, $id );

            if ( $datos == 'modificado' ) {
                $msg = ( array( 'modificado'=> true, 'post' => 'Descuento aplicado.' ) );

            } else {
                $msg = ( array( 'modificado'=>false, 'post' => 'Error al aplicar el producto.' ) );
            }

        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
    //anular venta

    public function anularVenta( $id_ventas ) {

        $data = $this->model->getAnularVenta( $id_ventas );
        $Anular = $this->model->getAnular( $id_ventas );

        foreach ( $data as $row ) {
            $stock_actual = $this->model->getProductos( $row[ 'id_producto' ] );
            $stock =  $stock_actual[ 'cantidad' ] + $row[ 'cantidad' ];

            $datos = $this->model->actualizarStock( $stock, $row[ 'id_producto' ] );
        }
        if ( $Anular == 'modificado' ) {
            $msg = ( array( 'modificado'=> true, 'post' => 'Venta anulada.' ) );
        } else {
            $msg = ( array( 'modificado'=> false, 'post' => 'Error al anular.' ) );
        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
    public function pdf( ) {

        //traer datos d ela empresa
        $desde = $_POST['desde'];
        $hasta = $_POST['hasta'];
        //traer datos d ela empresa
        $empresa = $this->model->getEmpresa();

        if(empty($desde) || empty($hasta)){
            $data = $this->model->getHistorialVenta();
        }else{
            $data = $this->model->getRangoFechas($desde, $hasta);
        }
        require( 'Libraries/fpdf/fpdf.php' );

        $pdf = new FPDF( 'P', 'mm', 'letter', true );
        $pdf->AddPage( 'PORTRAIT', 'letter' );
        $pdf->setMargins( 15, 30, 20, 20 );
        $pdf->setTitle( 'Reporte Venta' );
        $pdf->Image( base_url.'Assets/img/logo.png', 95, 23, 20, 20, 'png' );
        $pdf->setFillColor( 77, 182, 172 );
        $pdf->Rect( 0, 0, 220, 20, 'F' );


        $pdf->Ln( 35 );
        $pdf->SetFont( 'Arial', 'B', 14 );
        $pdf->Cell( 0, 5, 'Reporte de Ventas ', 0, 1, 'C' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 0, 5, $empresa[ 'nombre' ], 0, 1, 'C' );
        $pdf->Ln( 10 );
      
        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell(26, 5, 'Id', 0, 0, 'L');
        $pdf->Cell(76, 5, 'Nombre', 0, 0, 'L');
        $pdf->Cell(45, 5, 'Fecha', 0, 0, 'L');
        $pdf->Cell(39, 5, 'Total', 0, 1, 'L');


        $pdf->SetLineWidth( 1 );
        $pdf->SetDrawColor( 61, 174, 273, 1 );

        $pdf->setTextColor( 0, 0, 0 );
        $pdf->Line( 15, 70, 200, 70 );

        $pdf->Ln();

        //fondo
        $pdf->setFillColor( 240, 240, 240 );
        $pdf->SetTextColor( 40, 40, 40 );
        $pdf->SetDrawColor( 255, 255, 255 );

        $pdf->SetFont( 'Arial', '', 12 );
        foreach ( $data as $row ) {
            $pdf->Cell(26, 5, $row[ 'id' ], 0, 0, 'L', 1);
            $pdf->Cell(76, 5, $row[ 'nombre' ], 0, 0, 'L', 1);
            $pdf->Cell(45, 5, $row[ 'fecha' ], 0, 0, 'L', 1);
            $pdf->Cell(39, 5, formatMoney(  $row[ 'total' ]), 0, 1, 'L', 1);
    
        }
        // $pdf->SetFont( 'Arial', 'B', 14 );
        // $pdf->Cell( 0, 5, 'Reporte Ventas ', 0, 1, 'C' );
        // $pdf->Cell( 20, 5, $row[ 'cantidad' ], 0, 1, 'L' );



    
        $pdf->Output();
    }

}
?>
