<?php
defined('BASEPATH') OR exit('No direct script access allowed');   


class Ventas extends CI_Controller {

    public function __construct()
    {
        session_start();

        if ( empty( $_SESSION['activo']) ) {
            echo '<script>window.location.href="'.base_url().'"</script>';	
        }

        parent::__construct();
        $this->load->model('VentasModel');
        $this->load->model('DashboardModel');
    }
    //VISTA DASHBOARD

    public function vista_usuario() {

        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->DashboardModel->verificarPermisos( $id_user, 'nueva_venta' );
        $caja_abierta = $this->VentasModel->verificarCaja( $id_user );
        
        if ( !empty( $verificar ) || $id_user == 1 ) {
            if ( empty( $caja_abierta ) ) {
                // Mostrar modal de caja cerrada
                $this->load->view('layouts/Templates/header_admin');
                $this->load->view('layouts/Templates/nav_admin');
                $this->load->view('layouts/Ventas/modal_caja_cerrada');
                $this->load->view('layouts/Templates/footer_admin');
            } else {
                 $data['productos'] = $this->VentasModel->getProducto();  
                 $this->load->view('layouts/Templates/header_admin');
                 $this->load->view('layouts/Templates/nav_admin');
                 $this->load->view('layouts/Templates/body');
                 $this->load->view('layouts/Ventas/venta', $data);
                 $this->load->view('layouts/Templates/footer_admin');  
            }
        } else {
            echo '<script>window.location.href="'.base_url().'Errors/permisos"</script>';	
        }
       
    }
    //buscar código
    public function buscarVenta( $cod = null ) {
    
        if($cod == null)
        {
            $msg = ( array( 'modificado'=>false, 'post' => 'Producto no existe.' ) );
        }else{
            $codigo = urldecode($cod);
        
            // var_dump( $codigo );exit;
            if(is_numeric($cod) == true){

                $data = $this->VentasModel->getProCod($cod);
            }else{
                $data = $this->VentasModel->getProCod($codigo);
            }

            if ( $data ) {
                if ( $data[0]->cantidad == 0 ) {
                    $msg = ( array( 'modificado'=> false, 'post' => 'Producto agotado.' ) );

                }
                if ( $data[0]->cantidad > 0 ) {
                    $msg = $data;
                }
            } else {
                $msg = ( array( 'modificado'=>false, 'post' => 'Producto no existe.' ) );
            }
        }
       
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
    //buscar cliente por nombre
    public function buscarCliente( $cedula ) {
        $data = $this->VentasModel->getCliente( $cedula );
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();

    }
    //ingresar detalles ventas

    public function ingresar() {

        $id = $this->input->post('id');
        $datos = $this->VentasModel->getProductos( $id );
        $id_producto = $datos[0]->id;
        $id_usuario = $_SESSION['id_usuario'];
        $precio = $datos[0]->precio_venta;
        $cantidad = $this->input->post('cantidad');
        $iva = $datos[0]->iva;   
        $subTotal =   $precio *  $cantidad;
        $subIva = ($subTotal * $iva ) / 100 ;
        $total =    $subIva  +  $subTotal ;  

        if ( $datos[0]->cantidad >= $cantidad ) {

            $comprobar = $this->VentasModel->consultarDetalle( $id_producto, $id_usuario );

            if ( empty( $comprobar ) ) {

                $sub_total = $precio * $cantidad;
                $data = $this->VentasModel->registrarDetalles( $id_producto, $id_usuario, $precio, $cantidad, $iva, $total  );

                if ( $data == 'modificado' ) {
                    $msg = ( array( 'modificado'=> true, 'post' => 'Producto agregado.' ) );

                } else {
                    $msg = ( array( 'error'=>false, 'post' => 'Error al ingresar el producto.' ) );
                }
            } else {
                // $total_cantidad = $comprobar->cantidad+ $cantidad;
                $sub_total = $cantidad * $precio;
                $data = $this->VentasModel->actualizarDetalles( $precio, $cantidad, $iva, $total , $id_producto, $id_usuario );

                if ( $data == 'modificado' ) {
                    $msg = ( array( 'actualizado'=> true, 'post' => 'Se actualizó la cantidad.' ) );

                } else {
                    $msg = ( array( 'error'=>false, 'post' => 'Error al actualizar la cantidad.' ) );
                }
            }

        } else {
            $cantidad = $datos[0]->cantidad;
            $msg = ( array( 'error'=>false, 'post' => "Cantidad actual $cantidad" ) );
        }

        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
    //listar los productos al detalle

    public function listar() {

        $id_usuario = $_SESSION['id_usuario'];
        $data['detalle'] = $this->VentasModel->getDetalle( $id_usuario );

        $data['total_pagar'] = $this->VentasModel->calcularVenta( $id_usuario );
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //eliminar productos del detalle

    public function delete( int $id ) {

        $data = $this->VentasModel->deleteDetalle( $id );

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

        $efectivos = $this->input->post('efectivos');        
        $data = $this->VentasModel->getDetalles();
        $sub_total = $data[0]->total;

     
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
       
        $id_usuario = $_SESSION['id_usuario'];
        $verificar = $this->VentasModel->verificarCaja( $id_usuario );
    
        if (empty( $verificar) ) {
            $result = ( array( 'modificado'=>false, 'post' => 'La caja está cerrada.' ) );

        }else{
            $cliente = $this->input->post('ID');

            $total = $this->VentasModel->calcularVenta( $id_usuario );

         
            if ( empty( $cliente ) ) {
                $cliente = 1;
           
                $data = $this->VentasModel->registrarVenta( $id_usuario, $total[0]->total, $cliente, $_SESSION['pago'],  $_SESSION['cambio'] );
            } else {
                $data = $this->VentasModel->registrarVenta($id_usuario, $total[0]->total, $cliente, $_SESSION['pago'],  $_SESSION['cambio'] );

            }
    
            if ( $data == 'modificado' ) {
                $detalle = $this->VentasModel->getDetalle( $id_usuario );
                //traer el id compra
                $id_venta = $this->VentasModel->id_Venta();
                foreach ( $detalle as $row ) {
                    $iva = $row->iva;
                    $cantidad = $row->cantidad;
                    $descuento = $row->descuento;
                    $precio = $row->precio;
                    $id_prod = $row->id_producto;                 

                    $subTotal =   $precio *  $cantidad;
                    $subIva = ($subTotal * $iva ) / 100 ;
                    $sub_total =    $subIva  +  $subTotal ;  

                    $this->VentasModel->registrarDetalleVenta( $id_venta[0]->id, $id_prod, $cantidad, $iva,  $descuento, $precio, $sub_total );
                    $stock_actual = $this->VentasModel->getProductos( $id_prod );
                    $stock =  $stock_actual[0]->cantidad - $cantidad;
                    $this->VentasModel->actualizarStock( $stock, $id_prod );
                }
                $vaciar = $this->VentasModel->vaciarDetalle( $id_usuario );
                if ( $vaciar == 'modificado' ) {
                    $result = ( array( 'modificado'=> true, 'post' => 'Venta realizada.',  'id_venta' => $id_venta[0]->id) );
                }else{
                    $result = ( array( 'modificado'=> false, 'post' => 'no se proceso la venta.',  'id_venta' => $id_venta[0]->id) );

                }
            } else {
                $result = ( array( 'modificado'=>false, 'post' => 'Error al realizar la venta.' ) );
            }
        }

        echo json_encode( $result, JSON_UNESCAPED_UNICODE );
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
        $empresa = $this->VentasModel->getEmpresa();

        $id_usuario = $_SESSION['id_usuario'];

        $usuario = $this->VentasModel->getUsuario( $id_usuario );
        //descuento
        $descuento = $this->VentasModel->getDescuento( $id_venta );
        //traer datos de la compra
        $productos = $this->VentasModel->getVenta( $id_venta );

        require_once(APPPATH . 'libraries/fpdf/fpdf.php');

        $pdf = new FPDF( 'P', 'mm', 'letter', true );
        $pdf->AddPage( 'PORTRAIT', 'letter' );
        $pdf->setMargins( 15, 25, 15, 25 );
        $pdf->setTitle( 'Factura de Venta' );

        // Header con gradiente
        $pdf->setFillColor( 52, 152, 219 );
        $pdf->Rect( 0, 0, 220, 35, 'F' );
        
        $pdf->Ln( 5 );
        
        // Título principal
        $pdf->SetFont( 'Arial', 'B', 20 );
        $pdf->SetTextColor( 255, 255, 255 );
        $pdf->Cell( 0, 8, 'FACTURA DE VENTA', 0, 1, 'C' );
        
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->SetTextColor( 255, 255, 255 );
        $pdf->Cell( 0, 5, utf8_decode( $empresa[0]->ciudad ), 0, 1, 'C' );
        
        // Obtener datos
        foreach ( $productos['registro'] as $row ) {
            $fecha = $row->fecha;
            $nombre = $row->nombre;
            $estado = $row->estado; 
        }
        
        $pdf->Ln( 7 );
        $pdf->SetTextColor( 0, 0, 0 );
        
        // Sección de información de la empresa (arriba)
        $pdf->SetFont( 'Arial', 'B', 14 );
        $pdf->Cell( 0, 8, utf8_decode( 'Datos de la Empresa' ), 0, 1, 'L' );
        $pdf->SetDrawColor( 52, 152, 219 );
        $pdf->SetLineWidth( 0.5 );
        $pdf->Line( 15, $pdf->GetY(), 195, $pdf->GetY() );
        $pdf->Ln( 5 );
        
        $pdf->SetFont( 'Arial', 'B', 11 );
        $pdf->Cell( 30, 6, 'Empresa:', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 11 );
        $pdf->Cell( 70, 6, utf8_decode( $empresa[0]->nombre), 0, 0, 'L' );
        
        $pdf->SetFont( 'Arial', 'B', 11 );
        $pdf->Cell( 25, 6, 'NIT:', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 11 );
        $pdf->Cell( 70, 6, $empresa[0]->nit, 0, 1, 'L' );
        
        $pdf->SetFont( 'Arial', 'B', 11 );
        $pdf->Cell( 30, 6, 'Teléfono:', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 11 );
        $pdf->Cell( 70, 6, $empresa[0]->telefono, 0, 0, 'L' );
        
        $pdf->SetFont( 'Arial', 'B', 11 );
        $pdf->Cell( 25, 6, 'Dirección:', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 11 );
        $pdf->Cell( 70, 6, utf8_decode( $empresa[0]->direccion), 0, 1, 'L' );
        
        $pdf->Ln( 8 );
        
        // Sección de información de la venta (abajo)
        $pdf->SetFont( 'Arial', 'B', 14 );
        $pdf->Cell( 0, 8, utf8_decode( 'Información de la Venta' ), 0, 1, 'L' );
        $pdf->SetDrawColor( 52, 152, 219 );
        $pdf->Line( 15, $pdf->GetY(), 195, $pdf->GetY() );
        $pdf->Ln( 5 );
        
        // Información organizada en dos columnas
        $pdf->SetFont( 'Arial', 'B', 11 );
        $pdf->Cell( 40, 6, 'Fecha:', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 11 );
        $pdf->Cell( 60, 6, date('d/m/Y H:i', strtotime($fecha)), 0, 0, 'L' );
        
        $pdf->SetFont( 'Arial', 'B', 11 );
        $pdf->Cell( 30, 6, 'Factura #:', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 11 );
        $pdf->Cell( 55, 6, $id_venta, 0, 1, 'L' );
        
        $pdf->SetFont( 'Arial', 'B', 11 );
        $pdf->Cell( 40, 6, 'Cajero:', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 11 );
        $pdf->Cell( 60, 6, utf8_decode( $usuario[0]->nombre), 0, 0, 'L' );
        
        $pdf->SetFont( 'Arial', 'B', 11 );
        $pdf->Cell( 30, 6, 'Estado:', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 11 );
        $estado_text = ($estado == 0) ? 'Anulado' : 'Completado';
        $pdf->Cell( 55, 6, $estado_text, 0, 1, 'L' );
        
        $pdf->SetFont( 'Arial', 'B', 11 );
        $pdf->Cell( 40, 6, 'Cliente:', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 11 );
        $pdf->Cell( 145, 6, utf8_decode( $nombre ), 0, 1, 'L' );
        
        $pdf->Ln( 8 );
        
    

        // Encabezado de productos mejorado
        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 0, 8, utf8_decode( 'Detalle de Productos' ), 0, 1, 'L' );
        $pdf->SetDrawColor( 52, 152, 219 );
        $pdf->Line( 15, $pdf->GetY(), 195, $pdf->GetY() );
        $pdf->Ln( 3 );

        // Tabla de productos con diseño mejorado
        $pdf->setFillColor( 240, 248, 255 );
        $pdf->SetTextColor( 0, 0, 0 );
        $pdf->SetDrawColor( 150, 150, 150 );
        $pdf->SetFont( 'Arial', 'B', 11 );

        $pdf->Cell( 12, 7, 'Cant', 1, 0, 'C', true );
        $pdf->Cell( 95, 7, utf8_decode( 'Descripción' ), 1, 0, 'L', true );
        $pdf->Cell( 15, 7, 'IVA%', 1, 0, 'C', true );
        $pdf->Cell( 35, 7, 'P. Unitario', 1, 0, 'R', true );
        $pdf->Cell( 33, 7, 'P. Total', 1, 1, 'R', true );

        $pdf->SetDrawColor( 200, 200, 200 );
        $pdf->Ln( 2 );

        // Variables para cálculos
        $descuentos = 0.00;
        $Total = 0;
        $sub_total = 0;
        $totalPagar = 0;
        $cambio = 0;
        $pagado = 0;
        
        // Productos con diseño alternado
        $pdf->SetFont( 'Arial', '', 10 );
        $row_count = 0;
        foreach ( $productos['registro'] as $row ) {
            $Total += ($row->precio * $row->cantidad);
            $sub_total += $row->sub_total; 
            $descuentos = ($sub_total * $row->descuento) / 100;  
            $pagado = $row->pagado;  
            $cambio = $row->cambio;
            
            // Fondo alternado para filas
            if ($row_count % 2 == 0) {
                $pdf->setFillColor( 255, 255, 255 );
            } else {
                $pdf->setFillColor( 248, 248, 248 );
            }
            
            $pdf->Cell( 12, 6, $row->cantidad, 1, 0, 'C', true );
            $pdf->Cell( 95, 6, utf8_decode( $row->descripcion), 1, 0, 'L', true );
            $pdf->Cell( 15, 6, $row->iva.'%', 1, 0, 'C', true );
            $pdf->Cell( 35, 6, '$'.number_format( $row->precio, 2 ), 1, 0, 'R', true );
            $pdf->Cell( 33, 6, '$'.number_format( $row->sub_total, 2), 1, 1, 'R', true );
            $row_count++;
        }
        
        $totalPagar = (($sub_total - $Total) + $Total) - $descuentos;
        $pdf->Ln( 5 );

        // Sección de totales con diseño destacado
        $pdf->SetFont( 'Arial', 'B', 14 );
        $pdf->Cell( 0, 8, 'Resumen de la Venta', 0, 1, 'L' );
        $pdf->SetDrawColor( 52, 152, 219 );
        $pdf->Line( 15, $pdf->GetY(), 195, $pdf->GetY() );
        $pdf->Ln( 5 );

        // Totales con diseño profesional
        $pdf->SetFont( 'Arial', '', 11 );
        $pdf->setFillColor( 245, 245, 245 );
        
        $pdf->Cell( 140, 7, 'Sub Total:', 1, 0, 'R', true );
        $pdf->Cell( 40, 7, '$'.number_format( $Total, 2 ), 1, 1, 'R', true );

        $pdf->Cell( 140, 7, 'IVA:', 1, 0, 'R', true );
        $pdf->Cell( 40, 7, '$'.number_format($sub_total - $Total, 2), 1, 1, 'R', true );

        $pdf->Cell( 140, 7, 'Descuento Total:', 1, 0, 'R', true );
        $pdf->Cell( 40, 7, '$'.number_format( $descuentos, 2), 1, 1, 'R', true );

        // Total destacado
        $pdf->SetFont( 'Arial', 'B', 16 );
        $pdf->setFillColor( 52, 152, 219 );
        $pdf->SetTextColor( 255, 255, 255 );
        $pdf->Cell( 140, 10, 'TOTAL A PAGAR:', 1, 0, 'R', true );
        $pdf->Cell( 40, 10, '$'.number_format( $totalPagar, 2 ), 1, 1, 'R', true );
        
        // Pagado y cambio
        $pdf->Ln( 5 );
        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->SetTextColor( 0, 0, 0 );
        $pdf->setFillColor( 240, 255, 240 );
        
        $pdf->Cell( 90, 7, 'Valor Pagado:', 1, 0, 'L', true );
        $pdf->Cell( 90, 7, '$'.number_format( $pagado, 2 ), 1, 1, 'R', true );

        $pdf->setFillColor( 255, 240, 240 );
        $pdf->Cell( 90, 7, 'Cambio:', 1, 0, 'L', true );
        $pdf->Cell( 90, 7, '$'.number_format( $cambio, 2 ), 1, 1, 'R', true );

        // Mensaje de agradecimiento
        $pdf->Ln( 15 );
        $pdf->SetFont( 'Arial', 'I', 12 );
        $pdf->SetTextColor( 52, 152, 219 );
        $pdf->Cell( 0, 8, '¡Gracias por su compra!', 0, 1, 'C' );
        $pdf->SetFont( 'Arial', 'I', 10 );
        $pdf->SetTextColor( 100, 100, 100 );
            // Mensaje de bienvenida
        $pdf->SetFont( 'Arial', 'I', 11 );
        $pdf->SetTextColor( 52, 152, 219 );
        $pdf->Cell( 0, 6, utf8_decode( $empresa[0]->mensaje), 0, 1, 'C' );
        $pdf->SetTextColor( 0, 0, 0 );
        $pdf->Ln( 5 );
        $pdf->Cell( 0, 5, 'Este es un documento válido sin valor fiscal', 0, 1, 'C' );

        $pdf->Output();
    }

    public function generarPDF80mm($id_venta) {
        // Traer datos de la empresa
        $empresa = $this->VentasModel->getEmpresa();
    
        $id_usuario = $_SESSION['id_usuario'];
    
        $usuario = $this->VentasModel->getUsuario($id_usuario);
        // Descuento
        $descuento = $this->VentasModel->getDescuento($id_venta);
        // Traer datos de la compra
        $productos = $this->VentasModel->getVenta($id_venta);

        require_once(APPPATH . 'libraries/fpdf/fpdf.php');

        // Inicialización con dimensiones POS
        $pdf = new FPDF('P', 'mm', array(80, 210));
        $pdf->SetMargins(4, 2, 4); 
        // SOLUCIÓN AL ERROR: Uso del método público en lugar de la propiedad protegida
        $pdf->SetAutoPageBreak(true, 10); 
        $pdf->AddPage();

        // 1. Header Compacto (Mejora de espacio Empresa-Información)
        $pdf->setFillColor(52, 152, 219);
        $pdf->Rect(0, 0, 80, 20, 'F');
        $pdf->SetY(5);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(0, 5, utf8_decode('FACTURA DE VENTA'), 0, 1, 'C');
        
        // Obtener datos
        foreach ($productos['registro'] as $row){ 
            $fecha = $row->fecha;
            $nombre = $row->nombre;
            $estado = $row->estado;
        }
        
        // 2. Sección Información (Alineación optimizada)
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(12); // Ajuste por el rectángulo azul
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 4, utf8_decode($empresa[0]->nombre), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 3, utf8_decode('NIT: ') . $empresa[0]->nit . ' | Tel: ' . $empresa[0]->telefono, 0, 1, 'C');
        $pdf->Cell(0, 3, utf8_decode($empresa[0]->direccion), 0, 1, 'C');
        $pdf->Cell(0, 3, utf8_decode($empresa[0]->ciudad), 0, 1, 'C');
        
        // 3. Información Venta (Reducción de Ln para evitar dispersión)
        $pdf->Ln(2);
        $pdf->SetDrawColor(52, 152, 219);
        $pdf->Line(4, $pdf->GetY(), 76, $pdf->GetY());
        $pdf->Ln(1);
        $pdf->SetFont('Arial', 'B', 7);
        
        // Datos de venta (Reducción de Ln para evitar dispersión)
        $pdf->Cell(12, 4, 'Fecha:', 0, 0); $pdf->SetFont('Arial', '', 7); $pdf->Cell(0, 4, date('d/m/Y H:i', strtotime($fecha)), 0, 1);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(12, 4, 'F#:', 0, 0); $pdf->SetFont('Arial', '', 7); $pdf->Cell(0, 4, $id_venta, 0, 1);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(12, 4, 'Cajero:', 0, 0); $pdf->SetFont('Arial', '', 7); $pdf->Cell(0, 4, utf8_decode($usuario[0]->nombre), 0, 1);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(12, 4, 'Cliente:', 0, 0); $pdf->SetFont('Arial', '', 7); $pdf->Cell(0, 4, utf8_decode($productos['registro'][0]->nombre), 0, 1);
        $pdf->SetFont('Arial', 'B', 7);
        $estado_text = ($estado == 0) ? 'Anulado' : 'Completado';
        $pdf->Cell(12, 4, 'Estado:', 0, 0); $pdf->SetFont('Arial', '', 7); $pdf->Cell(0, 4, $estado_text, 0, 1);

        // 4. Tabla de Productos (Evitar apiñamiento)
        // Distribución: Cant(7), Desc(33), IVA(8), P.Unit(12), Total(12) = 72mm total
        $pdf->Ln(2);
        $pdf->SetFillColor(240, 248, 255);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(7, 5, 'Cant', 1, 0, 'C', true);
        $pdf->Cell(33, 5, utf8_decode('Descripción'), 1, 0, 'L', true);
        $pdf->Cell(8, 5, 'IVA', 1, 0, 'C', true);
        $pdf->Cell(12, 5, 'Unit', 1, 0, 'R', true);
        $pdf->Cell(12, 5, 'Total', 1, 1, 'R', true);

        $pdf->SetFont('Arial', '', 6.5);
        foreach ($productos['registro'] as $row) {
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            
            // MultiCell para que el nombre del producto se ajuste si es largo
            $pdf->Cell(7, 5, $row->cantidad, 1, 0, 'C');
            $pdf->MultiCell(33, 5, utf8_decode($row->descripcion), 1, 'L');
            
            // Reposicionar para columnas numéricas
            $pdf->SetXY($x + 40, $y); 
            $pdf->Cell(8, 5, $row->iva.'%', 1, 0, 'C');
            $pdf->Cell(12, 5, number_format($row->precio, 0), 1, 0, 'R');
            $pdf->Cell(12, 5, number_format($row->sub_total, 0), 1, 1, 'R');
        }

        // 5. Resumen de la venta
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(0, 5, utf8_decode('Resumen'), 0, 1, 'L');
        $pdf->SetDrawColor(52, 152, 219);
        $pdf->Line(4, $pdf->GetY(), 76, $pdf->GetY());
        $pdf->Ln(2);

        // Calcular totales correctamente
        $totalPagar = 0;
        $subtotal = 0;
        foreach ($productos['registro'] as $row) {
            $totalPagar += $row->sub_total;
            $subtotal += ($row->precio * $row->cantidad);
        }

        // Mostrar resumen con diseño profesional
        $pdf->SetFont('Arial', '', 7);
        $pdf->setFillColor(245, 245, 245);
        
        $pdf->Cell(45, 4, utf8_decode('Sub Total:'), 1, 0, 'R', true);
        $pdf->Cell(25, 4, '$ '.number_format($subtotal, 2), 1, 1, 'R', true);

        $pdf->Cell(45, 4, 'IVA:', 1, 0, 'R', true);
        $pdf->Cell(25, 4, '$ '.number_format($totalPagar - $subtotal, 2), 1, 1, 'R', true);

        // Total destacado
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->setFillColor(52, 152, 219);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(45, 6, utf8_decode('TOTAL:'), 1, 0, 'R', true);
        $pdf->Cell(25, 6, '$ '.number_format($totalPagar, 2), 1, 1, 'R', true);
        
        // Pagado y cambio
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->setFillColor(240, 255, 240);
        
        $pdf->Cell(35, 4, utf8_decode('Pagado:'), 1, 0, 'L', true);
        $pdf->Cell(35, 4, '$ '.number_format($productos['registro'][0]->pagado, 2), 1, 1, 'R', true);

        $pdf->setFillColor(255, 240, 240);
        $pdf->Cell(35, 4, utf8_decode('Cambio:'), 1, 0, 'L', true);
        $pdf->Cell(35, 4, '$ '.number_format($productos['registro'][0]->cambio, 2), 1, 1, 'R', true);

        // 6. Mensaje final
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->SetTextColor(52, 152, 219);
        $pdf->Cell(0, 5, utf8_decode('¡Gracias por su compra!'), 0, 1, 'C');
        $pdf->SetFont('Arial', 'I', 6);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell(0, 4, utf8_decode($empresa[0]->mensaje), 0, 1, 'C');
        $pdf->Cell(0, 4, utf8_decode('Válido sin valor fiscal'), 0, 1, 'C');

        $pdf->Output('I', 'Ticket_'.$id_venta.'.pdf');
    }

    //historial compras
    public function historialVenta() {

        $this->load->view('layouts/Templates/header_admin');
        $this->load->view('layouts/Templates/nav_admin');
        $this->load->view('layouts/Templates/body');
        $this->load->view('layouts/Ventas/historialC');
        $this->load->view('layouts/Templates/footer_admin');
    }
    //listar historial compra

    public function listar_historial() {

        $data = $this->VentasModel->getHistorialVenta();

        for ( $i = 0; $i < count( $data );
        $i++ ) {

            if ( $data[ $i ]->estado == 1 ) {
                $data[ $i ]->estado = '<span class="badge badge-success">Completado</span>';

                if($_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                    $data[ $i ]->acciones= '<div>  
                    <button class="btn btn-warning" title="Anular" onclick="btnAnularV('.$data[ $i ]->id.')"><i class="fas fa-ban"></i></button>          
                    <a type="button" class="btn btn-danger" href="'.base_url().'ventas/generarPDF/'.$data[ $i ]->id.'" target="_blank"  title="PDF"><i class="fas fa-file-pdf"></i></a>
                    <a type="button" class="btn btn-danger"  href="'.base_url().'ventas/generarPDF80mm/'.$data[ $i ]->id.'" target="_blank"  title="PDF 80mm"><i class="fas fa-file-pdf"></i> 80mm</a>                            
                            
                </div>';
                }else{
                    $data[ $i ]->acciones = '<div>  
                    <button class="btn btn-warning" disabled="" title="Anular" onclick="btnAnularV('.$data[ $i ]->id.')"><i class="fas fa-ban"></i></button>          
                    <a type="button" class="btn btn-danger"  href="'.base_url().'ventas/generarPDF/'.$data[ $i ]->id.'" target="_blank"  title="PDF"><i class="fas fa-file-pdf"></i></a>                            
                    <a type="button" class="btn btn-danger"  href="'.base_url().'ventas/generarPDF80mm/'.$data[ $i ]->id.'" target="_blank"  title="PDF 80mm"><i class="fas fa-file-pdf"></i> 80mm</a>                            
                    </div>';

                }
                
            } else {
                if($_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                    $data[ $i ]->estado = ' <span class="badge badge-danger">Anulado</span>';
                    $data[ $i ]->acciones = '<div>    
                    <button class="btn btn-warning" disabled="" title="Anular" onclick="btnAnularV('.$data[ $i ]->id.')"><i class="fas fa-ban"></i></button>                     
                    <a type="button" class="btn btn-danger" href="'.base_url().'ventas/generarPDF/'.$data[ $i ]->id.'" target="_blank"  title="PDF"><i class="fas fa-file-pdf"></i></a>
                    <a type="button" class="btn btn-danger"  href="'.base_url().'ventas/generarPDF80mm/'.$data[ $i ]->id.'" target="_blank"  title="PDF 80mm"><i class="fas fa-file-pdf"></i> 80mm</a>                                                        
                    </div>';
                }
                else{
                    $data[ $i ]->estado = ' <span class="badge badge-danger">Anulado</span>';
                    $data[ $i ]->acciones = '<div>  
                    <button class="btn btn-warning" disabled="" title="Anular" onclick="btnAnularV('.$data[ $i ]->id.')"><i class="fas fa-ban"></i></button>          
                    <a type="button" class="btn btn-danger"href="'.base_url().'ventas/generarPDF/'.$data[ $i ]->id.'" target="_blank"  title="PDF"><i class="fas fa-file-pdf"></i></a>
                                        <a type="button" class="btn btn-danger"  href="'.base_url().'ventas/generarPDF80mm/'.$data[ $i ]->id.'" target="_blank"  title="PDF 80mm"><i class="fas fa-file-pdf"></i> 80mm</a>                            
                            
                   </div>';

                }
            }
        }
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //calcular descuentos

    public function calcularDescuento( $id, $desc ) {


        if ( empty( $id ) || empty( $desc ) ) {
            $msg = ( array( 'modificado'=>false, 'post' => 'Error al aplicar el producto.' ) );
        } else {
            $descAct = $this->VentasModel->verificarDescuento( $id );

            $iva = $descAct[0]->iva;   
            $precio = $descAct[0]->precio;  
            $cantidad = $descAct[0]->cantidad;  
           

            $iva = $descAct[0]->iva;   
             $descAct[0]->descuento = $desc;
             $descuento_total =  $descAct[0]->descuento;
            //sum total
            $subTotal =   $precio *  $cantidad;
            $subIva = ($subTotal * $iva) / 100 ;  
            //total
            $totalC =  ($subIva  +  $subTotal);         
            //descuento
            $total =  ($totalC * $descuento_total) / 100;  
            $totalPagar = $totalC - $total;
          
            $datos = $this->VentasModel->actualizarDescuento($descuento_total, $totalPagar, $id);
 
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

        $data = $this->VentasModel->getAnularVenta( $id_ventas );
        $Anular = $this->VentasModel->getAnular( $id_ventas );

        foreach ( $data as $row ) {
            $stock_actual = $this->VentasModel->getProductos( $row->id_producto);
            $stock =  $stock_actual[0]->cantidad+ $row->cantidad;

            $datos = $this->VentasModel->actualizarStock( $stock, $row->id_producto);
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
        $desde = $this->input->post('desde');
        $hasta = $this->input->post('hasta');
        //traer datos d ela empresa
        $empresa = $this->VentasModel->getEmpresa();

        if(empty($desde) || empty($hasta)){
            $data = $this->VentasModel->getHistorialVenta();
        }else{
            $data = $this->VentasModel->getRangoFechas($desde, $hasta);
        }
        require( 'Libraries/fpdf/fpdf.php' );

        $pdf = new FPDF( 'P', 'mm', 'letter', true );
        $pdf->AddPage( 'PORTRAIT', 'letter' );
        $pdf->setMargins( 15, 30, 20, 20 );
        $pdf->setTitle( 'Reporte Venta' );
        $pdf->Image( base_url().'Assets/img/logo.png', 95, 23, 20, 20, 'png' );
        $pdf->setFillColor( 77, 182, 172 );
        $pdf->Rect( 0, 0, 220, 20, 'F' );


        $pdf->Ln( 35 );
        $pdf->SetFont( 'Arial', 'B', 14 );
        $pdf->Cell( 0, 5, 'Reporte de Ventas ', 0, 1, 'C' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 0, 5, $empresa->nombre, 0, 1, 'C' );
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
            $pdf->Cell(26, 5, $row->id, 0, 0, 'L', 1);
            $pdf->Cell(76, 5, $row->nombre, 0, 0, 'L', 1);
            $pdf->Cell(45, 5, $row->fecha, 0, 0, 'L', 1);
            $pdf->Cell(39, 5, formatMoney(  $row->total), 0, 1, 'L', 1);
    
        }
    
        $pdf->Output();
    }

}
?>
