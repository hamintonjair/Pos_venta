<?php

const base_url = "http://localhost/Pos_venta/";
const host = "localhost";
const user = "root";
const pass = "menaH01*";
const db = "sistema";
const charset = "charset=utf8";



const SPD = ',';
const SPM = '.';
function formatMoney($cantidad, $signo = '$'){
    $cantidad = $signo.number_format($cantidad,2,SPD,SPM);
    return $cantidad;
}

//formatear la fecha
function Ymd_dmY(string $fecha, string $separador = "/"):string{
   
    $ano = substr($fecha,0,4);
    $mes = substr($fecha,5,2);
    $dia = substr($fecha,8,2);

    $_fecha = $dia.$separador.$mes.$separador.$ano;
    return $_fecha;
}

?>