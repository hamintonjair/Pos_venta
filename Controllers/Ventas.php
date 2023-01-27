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

        $this->views->getView( $this, 'venta' );
    }
    //buscar código

    public function buscarVenta( $cod ) {

        $data = $this->model->getProCod( $cod );

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
        $id_usuario = $_SESSION[ 'id_usuario' ];
        $precio = $datos[ 'precio_venta' ];
        $cantidad = $_POST[ 'cantidad' ];

        if ( $datos[ 'cantidad' ] >= $cantidad ) {

            $comprobar = $this->model->consultarDetalle( $id_producto, $id_usuario );

            if ( empty( $comprobar ) ) {

                $sub_total = $precio * $cantidad;
                $data = $this->model->registrarDetalles( $id_producto, $id_usuario, $precio, $cantidad, $sub_total );

                if ( $data == 'modificado' ) {
                    $msg = ( array( 'modificado'=> true, 'post' => 'Producto agregado.' ) );

                } else {
                    $msg = ( array( 'error'=>false, 'post' => 'Error al ingresar el producto.' ) );
                }
            } else {
                // $total_cantidad = $comprobar[ 'cantidad' ] + $cantidad;
                $sub_total = $cantidad * $precio;
                $data = $this->model->actualizarDetalles( $precio, $cantidad, $sub_total, $id_producto, $id_usuario );

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
    //registrar compra

    public function registrarVenta( $cod ) {

        $id_usuario = $_SESSION[ 'id_usuario' ];
        $cliente = $_POST[ 'ID' ];

        $total = $this->model->calcularVenta( $id_usuario );
        if(empty( $cliente)){
            $cliente = "1";
            $data = $this->model->registrarVenta( $id_usuario, $total[ 'total' ],$cliente  );
        }else{
           $data = $this->model->registrarVenta( $total[ 'total' ], $cliente ); 
        }
       

        if ( $data == 'modificado' ) {
            $detalle = $this->model->getDetalle( $id_usuario );

            //traer el id compra
            $id_venta = $this->model->id_Venta();
            foreach ( $detalle as $row ) {
                $cantidad = $row[ 'cantidad' ];
                $descuento = $row[ 'descuento' ];
                $precio = $row[ 'precio' ];
                $id_prod = $row[ 'id_producto' ];
                $sub_total = ($cantidad * $precio) - $descuento ;
                $this->model->registrarDetalleVenta( $id_venta[ 'id' ], $id_prod, $cantidad,  $descuento, $precio, $sub_total );
                $stock_actual = $this->model->getProductos( $id_prod );
                $stock =  $stock_actual[ 'cantidad' ] - $cantidad;
                $this->model->actualizarStock( $stock, $id_prod );
            }

            $vaciar = $this->model->vaciarDetalle( $id_usuario );

            if ( $vaciar == 'modificado' ) {
                $msg = ( array( 'modificado'=> true, 'post' => 'Venta realizada.',  'id_venta' => $id_venta[ 'id' ] ) );
            }
        } else {
            $msg = ( array( 'modificado'=>false, 'post' => 'Error al realizar la venta.' ) );
        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
    //generar pfd

    public function generarPDF( $id_venta ) {

        //traer datos d ela empresa
        $empresa = $this->model->getEmpresa();

        $id_usuario = $_SESSION['id_usuario'];       
        $usuario = $this->model->getUsuario($id_usuario);
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
            $estado = $row['estado'];
        }
        $pdf->Ln( 10 );
        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 35, 5, utf8_decode( 'Fecha de orden: ' ), 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, Ymd_dmY( $fecha ), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 24, 5, 'Empresa: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, $empresa[ 'nombre' ], 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 24, 5, 'Nit: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, $empresa[ 'nit' ], 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 24, 5, utf8_decode( 'Telefono: ' ), 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, $empresa[ 'telefono' ], 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 24, 5, utf8_decode( 'Dirección: ' ), 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, $empresa[ 'direccion' ], 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 24, 5, utf8_decode( 'Usuario: ' ), 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, utf8_decode( $usuario['nombre']), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 24, 5, 'Factura #: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, $id_venta, 0, 1, 'L' );

        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(24, 5, 'Cliente: ', 0, 0, 'L');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(20, 5, utf8_decode($nombre), 0, 0, 'L');  

        $pdf->SetFont('Arial','B',12);  
        $pdf->Cell(110, 5, 'Estado de la venta:', 0, 0, 'R'); 
        if($estado == 0){
            $pdf->Cell(20,5, "Anulado", 0, 1, 'R'); 
        }else{
            $pdf->Cell(27,5,"Completado", 0, 1, 'R'); 
        }

        $pdf->Ln(); 

        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 24, 5, utf8_decode( $empresa[ 'mensaje' ] ), 0, 1, 'L' );


        //encabezado de productos
        $pdf->Ln( 15 );

        $pdf->setTextColor( 40, 40, 40 );
        $pdf->setFillColor( 255, 255, 255 );

        $pdf->SetDrawColor( 88, 88, 88 );

        $pdf->Cell( 15, 5, 'Cant', 0, 0, 'L', true );
        $pdf->Cell( 90, 5, utf8_decode( 'Descripción ' ), 0, 0, 'L', true );
        $pdf->Cell( 15, 5, 'Iva', 0, 0, 'L', true );
        $pdf->Cell( 40, 5, 'P. Unitario', 0, 0, 'L', true );
        $pdf->Cell( 40, 5, 'P. Total', 0, 1, 'L', true );

        $pdf->SetLineWidth( 1 );

        $pdf->SetDrawColor( 61, 174, 273, 1 );

        $pdf->setTextColor( 0, 0, 0 );
        $pdf->Line( 15, 115, 200, 115 );

        $pdf->Ln();

        $total = 0.00;

        //fondo
        $pdf->setFillColor( 240, 240, 240 );
        $pdf->SetTextColor( 40, 40, 40 );
        $pdf->SetDrawColor( 255, 255, 255 );

        foreach ( $productos as $row ) {
            $total = $total + $row[ 'sub_total' ];
            $pdf->Cell( 15, 5, $row[ 'cantidad' ], 1, 0, 'L', 1 );
            $pdf->Cell( 90, 5, utf8_decode( $row[ 'descripcion' ] ), 1, 0, 'L', 1 );
            $pdf->Cell( 8, 5, 19, 1, 0, 'L', 1 );
            $pdf->Cell( 30, 5, formatMoney( $row[ 'precio' ] ), 1, 0, 'L', 1 );
            $pdf->Cell( 40, 5, formatMoney( $row[ 'sub_total' ] ), 1, 1, 'L', 1 );
        }

        $pdf->Ln();

      
        $pdf->setFillColor( 79, 78, 77 );
        $pdf->SetTextColor( 255, 255, 255 );

        $pdf->SetFont( 'Arial', 'B', 12 );

        $pdf->Cell( 150, 5, 'Sub Total:', 0, 0, 'R', 1 );
        $pdf->Cell( 35, 5, formatMoney( $descuento['total'] ), 0, 1, 'R', 1 );

        $pdf->Cell( 150, 5, 'Descuento Total:', 0, 0, 'R', 1 );
        $pdf->Cell( 35, 5, formatMoney( $descuento['total'] ), 0, 1, 'R', 1 );

        $pdf->Cell( 150, 5, 'Total a Pagar:', 0, 0, 'R', 1 );
        $pdf->Cell( 35, 5, formatMoney( $total ), 0, 1, 'R', 1 );
        
        $pdf->Ln();

        $pdf->SetFont( 'Arial', 'B', 12 );

        $pdf->Cell( 20, 5, 'IVA%:', 0, 0, 'L', 1 );
        $pdf->Cell( 25, 5, formatMoney( $descuento['total'] ), 0, 1, 'R', 1 );

        $pdf->Cell( 20, 5, 'SIN IVA:', 0, 0, 'L', 1 );
        $pdf->Cell( 25, 5, formatMoney( $descuento['total'] ), 0, 1, 'R', 1 );

        $pdf->Output();
    }

    //historial compras

    public function historialVenta() {

        $this->views->getView( $this, 'historialC' );
    }

    //listar historial compra

    public function listar_historial() {

        $data = $this->model->getHistorialVenta();

        for ( $i = 0; $i < count( $data );$i++ ) {

               if($data[$i]['estado'] == 1){
                $data[$i]['estado'] = '<span class="badge badge-success">Completado</span>';               
                $data[$i]['acciones'] = '<div>  
                <button class="btn btn-warning" title="Anular" onclick="btnAnularV('.$data[$i]['id'].')"><i class="fas fa-ban"></i></button>          
                <a type="button" class="btn btn-danger" href="'.base_url."Ventas/generarPDF/".$data[$i]['id'].'" target="_blank"  title="PDF"><i class="fas fa-file-pdf"></i></a>                            
               </div>';   
                
            }else{
                $data[$i]['estado'] = ' <span class="badge badge-danger">Anulado</span>';                        
                $data[$i]['acciones'] = '<div>                        
                <a type="button" class="btn btn-danger" href="'.base_url."Ventas/generarPDF/".$data[$i]['id'].'" target="_blank"  title="PDF"><i class="fas fa-file-pdf"></i></a>                            
                </div>';   
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
            $descAct = $this->model->verificarDescuento($id );    
            $descuento_total = $descAct['descuento'] + $desc;
            $subTotal  = ( $descAct[ 'cantidad' ] * $descAct[ 'precio' ] ) - $descuento_total;
            $datos = $this->model->actualizarDescuento( $descuento_total, $subTotal, $id );

            if ($datos == 'modificado' ) {
                $msg = ( array( 'modificado'=> true, 'post' => 'Descuento aplicado.' ) );

            } else {
                $msg = ( array( 'modificado'=>false, 'post' => 'Error al aplicar el producto.' ) );
            }

        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
    //anular venta
    public function anularVenta($id_ventas){

        $data = $this->model->getAnularVenta($id_ventas);
        $Anular = $this->model->getAnular($id_ventas);       
        foreach($data as $row){
            $stock_actual = $this->model->getProductos($row['id_producto']);
            $stock =  $stock_actual['cantidad'] + $row['cantidad'];          
            $datos = $this->model->actualizarStock( $stock, $row['id_producto']);
        }
        if( $Anular== 'modificado'){
            $msg = (array('modificado'=> true, 'post' => 'Venta anulada.'));
         }else{
            $msg = (array('modificado'=> false, 'post' => 'Error al anular.'));
         }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>