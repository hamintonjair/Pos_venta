<?php

const base_url = "http://localhost/Pos_venta/";
const host = "localhost";
const user = "root";
const pass = "menaH01*";
const db = "sistema";
const charset = "charset=utf8";


function formatMoney($cantidad){
    $cantidad = number_format($cantidad,2,SPD,SPM);
    return $cantidad;
}

?>