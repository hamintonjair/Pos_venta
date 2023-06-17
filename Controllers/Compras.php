<?php

class Compras extends Controller {

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
        $verificar = $this->model->verificarPermisos( $id_user, 'nueva_compra' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
             $data['productos'] = $this->model->getProducto();    

            $this->views->getView( $this, 'compra', $data );
        } else {
            header( 'location:'.base_url.'Errors/permisos' );
        }

    }
    //buscar código

    public function buscarCompra( $cod ) {

        if ( is_numeric( $cod ) == true ) {

            $data = $this->model->getProCodi( $cod );
            $_SESSION['proveedorid'] = $data['id_proveedor'];
          
        } else {
            $data = $this->model->getProCodi( $cod );     
            $_SESSION['proveedorid'] = $data['id_proveedor'];
     
        }
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }

    //ingresar dellates

    public function ingresar() {

        $id = $_POST[ 'id' ];
        $datos = $this->model->getProductos( $id );
        $id_producto = $datos[ 'id' ];
        $id_usuario = $_SESSION[ 'id_usuario' ];
        // $precio = $datos[ 'precio_compra' ];
        $precio = $_POST[ 'precio' ];
        $cantidad = $_POST[ 'cantidad' ];

        // var_dump($precio2);exit();

        $comprobar = $this->model->consultarDetalleC( $id_producto, $id_usuario );

        if ( empty( $comprobar ) ) {

            $sub_total = $precio * $cantidad;
            $data = $this->model->registrarDetallesC( $id_producto, $id_usuario, $precio, $cantidad, $sub_total );

            if ( $data == 'modificado' ) {
                $msg = ( array( 'modificado'=> true, 'post' => 'Producto agregado.' ) );

            } else {
                $msg = ( array( 'modificado'=>false, 'post' => 'Error al ingresar el producto.' ) );
            }
        } else {
            // $total_cantidad = $comprobar[ 'cantidad' ] + $cantidad;
            $sub_total = $cantidad * $precio;
            $data = $this->model->actualizarDetallesC( $precio, $cantidad, $sub_total, $id_producto, $id_usuario );

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

        $data[ 'detalle' ] = $this->model->getDetalleC( $id_usuario );

        $data[ 'total_pagar' ] = $this->model->calcularCompra( $id_usuario );

        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
    //eliminar productos del detalle

    public function delete( int $id ) {

        $data = $this->model->deleteDetalleC( $id );

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

        // $datos = $this->model->getProCodi( $cod );
        $pagos = $this->model->getidCompra();
        $id_proveedor = $_POST[ 'id_proveedor' ];  
  
      if($_SESSION['proveedorid'] == $id_proveedor){

        foreach ( $pagos as $row ) {
                if ( $row[ 'pago' ] ==  $TipoPago ) {
                    $idcompra = $row[ 'id_pago' ];
                }

            }
            $total = $this->model->calcularCompra( $id_usuario );
        
            if($total[ 'total' ] != $efectivo.'.00' && $TipoPago == "Debito"){
                $msg = ( array( 'modificado'=>false, 'post' => 'El valor ingresado es diferente a la deuda.' ) );
            }else{
                $data = $this->model->registrarCompra( $total[ 'total' ], $id_proveedor, $idcompra, $id_usuario);

            if ( $data == 'modificado' ) {
                $detalle = $this->model->getDetalleC( $id_usuario );

                //traer el id compra
                $id_compra = $this->model->id_Compra();
                foreach ( $detalle as $row ) {
                    $cantidad = $row[ 'cantidad' ];
                    $precio = $row[ 'precio' ];
                    $id_prod = $row[ 'id_producto' ];
                    $sub_total = $cantidad * $precio;
                    $this->model->registrarDetalleCompra( $id_compra[ 'id' ], $id_prod, $cantidad, $precio, $sub_total );
                    $stock_actual = $this->model->getProductos( $id_prod );
                    $stock =  $stock_actual[ 'cantidad' ] + $cantidad;
                    $this->model->actualizarStockC( $stock, $id_prod );
                }
                $vaciar = $this->model->vaciarDetalleC( $id_usuario );

                if ( $vaciar == 'modificado' ) {
                    $msg = ( array( 'modificado'=> true, 'post' => 'Compra realizada.',  'id_compra' => $id_compra[ 'id' ] ) );
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

    public function generarPDF( $id_compra ) {

        //traer datos d ela empresa
        $empresa = $this->model->getEmpresa();

        $id_usuario = $_SESSION[ 'id_usuario' ];

        $usuario = $this->model->getUsuario( $id_usuario );
        //traer datos de la compra
        $productos = $this->model->getCompra( $id_compra );

        require( 'Libraries/fpdf/fpdf.php' );

        $pdf = new FPDF( 'P', 'mm', 'letter', true );
        $pdf->AddPage( 'PORTRAIT', 'letter' );
        $pdf->setMargins( 15, 30, 20, 20 );
        $pdf->setTitle( 'Reporte Compra' );

        $pdf->Image( base_url.'Assets/img/logo.png', 170, 50, 20, 20, 'png' );

        $pdf->setFillColor( 77, 182, 172 );
        $pdf->Rect( 0, 0, 220, 20, 'F' );

        $pdf->Ln( 20 );

        $pdf->SetFont( 'Arial', 'B', 14 );
        $pdf->Cell( 0, 5, 'Factura de Compra ', 0, 1, 'C' );
       

        foreach ( $productos as $row ) {

            $fecha = $row[ 'fecha' ];
            $nombre = $row[ 'nombre' ];
            $estado = $row[ 'estado' ];
            $pago = $row[ 'pago' ];

        }
        $pdf->Cell( 0, 5,   $empresa['ciudad'], 0, 1, 'C' );
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
        $pdf->Cell( 24, 5, 'Usuario: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, utf8_decode( $usuario[ 'nombre' ] ), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 24, 5, 'Proveedor: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, utf8_decode( $nombre ), 0, 1, 'L' );

        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 24, 5, 'Factura #: ', 0, 0, 'L' );
        $pdf->SetFont( 'Arial', '', 12 );
        $pdf->Cell( 20, 5, $id_compra, 0, 1, 'L' );
     
    
        $pdf->SetFont( 'Arial', 'B', 12 );

        $pdf->Cell( 125, 5, 'Estado:', 0, 0, 'R' );

        $pdf->SetFont( 'Arial', '', 12 );
        if ( $estado == 0 ) {
            $pdf->Cell( 18, 5, 'Anulado', 0, 1, 'R' );

        } else {
            $pdf->Cell( 25, 5, 'Completado', 0, 1, 'R' );

        }
        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 125, 5, 'Tipo de pago:', 0, 0, 'R' );
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

        $pdf->Cell( 24, 5, utf8_decode( $empresa[ 'mensaje' ] ), 0, 1, 'L' );

        $pdf->Ln(4);

        //encabezado de productos
        $pdf->Ln( 1 );

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
        $pdf->Line( 15, 115, 200, 115 );

        $pdf->Ln();

        $total = 0.00;

        //fondo
        $pdf->setFillColor( 240, 240, 240 );
        $pdf->SetTextColor( 40, 40, 40 );
        $pdf->SetDrawColor( 255, 255, 255 );

        $pdf->SetFont( 'Arial', '', 12 );
        foreach ( $productos as $row ) {
            $total = $total + $row[ 'sub_total' ];
            $pdf->Cell( 15, 5, $row[ 'cantidad' ], 1, 0, 'L', 1 );
            $pdf->Cell( 90, 5, utf8_decode( $row[ 'descripcion' ] ), 1, 0, 'L', 1 );
            $pdf->Cell( 40, 5, formatMoney( $row[ 'precio' ] ), 1, 0, 'L', 1 );
            $pdf->Cell( 40, 5, formatMoney( $row[ 'sub_total' ] ), 1, 1, 'L', 1 );
        }

        $pdf->Ln();

        $pdf->setFillColor( 79, 78, 77 );
        $pdf->SetTextColor( 255, 255, 255 );

        $pdf->SetFont( 'Arial', 'B', 12 );

        $pdf->Cell( 150, 5,  $pagar, 0, 0, 'R', 1 );
        $pdf->Cell( 35, 5, formatMoney( $total ), 0, 1, 'R', 1 );

        $pdf->Output();
    }

    //historial compras

    public function historialCompra() {

        $id_user = $_SESSION[ 'id_usuario' ];
        $verificar = $this->model->verificarPermisos( $id_user, 'historial_compra' );
        if ( !empty( $verificar ) || $id_user == 1 ) {
            $this->views->getView( $this, 'historial' );
        } else {
            header( 'location:'.base_url.'Errors/permisos' );
        }

    }

    //listar historial compra

    public function listar_historial() {

        $data = $this->model->getHistorialCompra();
        for ( $i = 0; $i < count( $data );
        $i++ ) {

            if ( $data[ $i ][ 'estado' ] == 1 ) {
                $data[ $i ][ 'estado' ] = '<span class="badge badge-success">Completado</span>';

                if( $_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                    $data[ $i ][ 'acciones' ] = '<div>  
                    <button class="btn btn-warning" title="Anular" onclick="btnAnularC('.$data[ $i ][ 'id' ].')"><i class="fas fa-ban"></i></button>          
                    <a type="button" class="btn btn-danger" href="'.base_url.'Compras/generarPDF/'.$data[ $i ][ 'id' ].'" target="_blank"  title="PDF"><i class="fas fa-file-pdf"></i></a>                            
                </div>';
                }else{
                    $data[ $i ][ 'acciones' ] = '<div>  
                    <button class="btn btn-warning" disabled="" title="Anular" onclick="btnAnularC('.$data[ $i ][ 'id' ].')"><i class="fas fa-ban"></i></button>          
                     <a type="button"  class="btn btn-danger" href="'.base_url.'Compras/generarPDF/'.$data[ $i ][ 'id' ].'" target="_blank"  title="PDF"><i class="fas fa-file-pdf"></i></a>                            
                  </div>';
                }
              
            } else {

                if($_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Supervisor'){
                     $data[ $i ][ 'estado' ] = ' <span class="badge badge-danger">Anulado</span>';

                $data[ $i ][ 'acciones' ] = '<div>                        
                <a type="button" class="btn btn-danger" href="'.base_url.'Compras/generarPDF/'.$data[ $i ][ 'id' ].'" target="_blank"  title="PDF"><i class="fas fa-file-pdf"></i></a>                            
                </div>';
                }
               

            }

        }
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }

    public function anularCompra( $id_compra ) {

        $data = $this->model->getAnularCompra( $id_compra );
        $Anular = $this->model->getAnular( $id_compra );

        foreach ( $data as $row ) {
            $stock_actual = $this->model->getProductos( $row[ 'id_producto' ] );
            $stock =  $stock_actual[ 'cantidad' ] - $row[ 'cantidad' ];

            $datos = $this->model->actualizarStockC( $stock, $row[ 'id_producto' ] );
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

        $_SESSION[ 'tipoPago' ] = $_POST[ 'pago' ];
        $_SESSION[ 'pago' ] = $_POST[ 'efectivo' ];
        $msg =  $_SESSION[ 'tipoPago' ] ;
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
    }
    //buscar proveedor
    //buscar cliente por nombre

    public function buscarProveedor( $nit ){

        $data = $this->model->getProveedor( $nit );
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();

    }
}
?>
