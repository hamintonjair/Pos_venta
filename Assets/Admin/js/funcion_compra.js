let cod_producto;
let id_producto;
let t_h_c;

function buscarCodigo(e) {
    e.preventDefault();
    let base_url = 'http://localhost/Pos_venta/';

    if (e.which == 13) {
        const cod = document.getElementById("codigo2").value;
        cod_producto = document.getElementById("codigo2").value;
        const url = base_url + "Compras/buscarCompra/" + cod;
        const http = new XMLHttpRequest();
        http.open("GET", url, true);
        http.send();
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const resp = JSON.parse(this.responseText);

                if (resp) {

                    $("#descripcion").val(resp[0].descripcion);
                    $("#precio").val(resp[0].precio_compra);
                    $("#id").val(resp[0].id);
                    $("#nit").val(resp[0].nit);
                    $("#id_proveedor").val(resp[0].id_proveedor);
                    $("#proveedor").val(resp[0].nombre);
                    $("#cantidad").focus();
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Producto no existe',
                        showConfirmButton: false,
                        timer: 2200
                    })
                    $("#descripcion").val("Descripcion del producto");
                    $("#cantidad").val("0.00");
                    $("#precio").val("0.00");
                    $("#sub_total").val("0.00");
                    $("#nit").val("");
                    $("#proveedor").val(resp.nombre);
                    $("#precio").focus();

                }


            }
        }
    }

}

// //buscar por nombre
function buscarNombreC() {
    let base_url = 'http://localhost/Pos_venta/';

    // const nomb = document.getElementById("nombre").value;
    const select = $("#nombre");
    const nomb = select.val();
    // const cod = nomb.replace(/ /g, '+');
    const cod = encodeURIComponent(nomb.replace(/ /g, '+'));

    cod_producto = cod;
    const url = base_url + "Compras/buscarCompra/" + cod;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);


            if (resp) {

                $("#descripcion").val(resp[0].descripcion);
                $("#precio").val(resp[0].precio_compra);
                $("#id").val(resp[0].id);
                $("#nit").val(resp[0].nit);
                $("#id_proveedor").val(resp[0].id_proveedor);
                $("#proveedor").val(resp[0].nombre);
                $("#cantidad").focus();
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Producto no existe',
                    showConfirmButton: false,
                    timer: 2200
                })
                $("#descripcion").val("Descripcion del producto");
                $("#cantidad").val("0.00");
                $("#precio").val("0.00");
                $("#sub_total").val("0.00");
                $("#nit").val("");
                $("#proveedor").val(resp.nombre);
                $("#precio").focus();
            }


        }

    }

}
//filtro
function filtrarProductosC() {
    const input = document.getElementById("buscador");
    const filter = input.value.toUpperCase();
    const select = document.getElementById("nombre");
    const options = select.getElementsByTagName("option");

    for (let i = 0; i < options.length; i++) {
        const text = options[i].textContent || options[i].innerText;
        if (text.toUpperCase().indexOf(filter) > -1) {
            options[i].style.display = "";
        } else {
            options[i].style.display = "none";
        }
    }
}

//buscar cliente 
function buscarProveedor(e) {
    e.preventDefault();
    if (e.which == 13) {
        let base_url = 'http://localhost/Pos_venta/';

        const nit = document.getElementById("nit").value;
        const url = base_url + "Compras/buscarProveedor/" + nit;
        const http = new XMLHttpRequest();
        http.open("GET", url, true);
        http.send();
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const resp = JSON.parse(this.responseText);

                if (resp) {
                    $("#proveedor").val(resp[0].nombre);
                    $("#id_proveedor").val(resp[0].id);

                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'El proveedor no existe',
                        showConfirmButton: false,
                        timer: 2200
                    })
                    $("#nit").val("");
                    $("#nit").focus();
                    $("#proveedor").val("");

                }

            }
        }
    }

}
//tipo de pago compra
// function pago(e) {
//     e.preventDefault();

//     if (e.which == 13) {
//         efectivo = document.getElementById("efectivo").value;
//         cambio = efectivo - Pagar;
//         document.getElementById("devolver").value = new Intl.NumberFormat().format(cambio);

//         const url = base_url + "Ventas/ingresarCambio";
//         const frm = document.getElementById("frmCerrar");
//         const http = new XMLHttpRequest();
//         http.open("POST", url, true);
//         http.send(new FormData(frm));
//         http.onreadystatechange = function() {
//             if (this.readyState == 4 && this.status == 200) {
//                 const resp = JSON.parse(this.responseText);
//                 if (resp.modificado == true) {
//                     Swal.fire({
//                         position: 'top-end',
//                         icon: 'success',
//                         title: resp.post,
//                         showConfirmButton: false,
//                         timer: 2200
//                     })
//                 } else {
//                     alert(resp.msg, "error");
//                     document.getElementById("efectivo").focus();
//                     document.getElementById("efectivo").value = "";
//                     cambio = document.getElementById("devolver").value = "";
//                 }

//             }
//         }
//     }
// }
let totalPagar = 0;
//cerrar
function cerrarCompra() {

    let nit = document.querySelector('#nit').value;
    if (nit == '') {
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 2200
        })
        return false;
    } else {
        $('#cerrarCompra').modal('show');
        document.getElementById("valor_pagar").value = totalPagar;
        document.getElementById("efectivo").focus();
    }


}

// deshabilitar el combo box si el pago es a credito
function capturarValorSelect() {
    // Obtener el valor seleccionado
    var selectedValue = $('#pago').val();
    if (selectedValue == "Credito") {
        document.getElementById("efectivo").setAttribute('disabled', 'disabled');
    } else {
        var efectivo = document.getElementById("efectivo");
        efectivo.disabled = false;
    }


}
//calcular cantidad
function calcularPrecioC(e) {
    e.preventDefault();
    const cant = document.getElementById("cantidad").value;
    const precio = document.getElementById("precio").value;
    document.getElementById("sub_total").value = precio * cant;
    if (e.which == 13) {
        if (cant > 0) {
            let base_url = 'http://localhost/Pos_venta/';

            const url = base_url + "Compras/ingresar";
            const frm = document.getElementById("frmCompra");
            const http = new XMLHttpRequest();
            http.open("POST", url, true);
            http.send(new FormData(frm));
            http.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    const resp = JSON.parse(this.responseText);

                    if (resp.modificado == true) {

                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: resp.post,
                            showConfirmButton: false,
                            timer: 2200
                        })
                        frm.reset();
                        cargarDetalleC();

                    } else if (resp.actualizado == true) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: resp.post,
                            showConfirmButton: false,
                            timer: 2200
                        })
                        frm.reset();
                        cargarDetalleC();

                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: resp.post,
                            showConfirmButton: false,
                            timer: 2200
                        })
                    }
                    document.getElementById("codigo2").focus()

                }
            }
        }
    }
}

//mostar detalles del producto de la compra
function cargarDetalleC() {
    let base_url = 'http://localhost/Pos_venta/';

    const url = base_url + "Compras/listarC";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);
            let html = '';

            resp.detalle.forEach(row => {
                const precio = new Intl.NumberFormat().format(row['precio']);
                const sub_total = new Intl.NumberFormat().format(row['sub_total']);

                html += `<tr>
                <td>${row['id']}</td>
                <td>${row['descripcion']}</td>
                <td>${row['cantidad']}</td>
                <td>${precio}</td>
                <td>${sub_total}</td>     
                <td>
                   <button class="btn btn-danger" title="Eliminar" type="button" onclick="deleteDetalleC(${row['id']})"><i class="fas fa-trash-alt"></i></button>
                </td>            
                </tr>`
            });
            Pagar = resp.total_pagar[0].total;
            const pagar = new Intl.NumberFormat().format(resp.total_pagar[0].total);
            $("#tblDetalleC").html(html);
            $("#total").val(pagar);
            totalPagar = document.getElementById("total").value = pagar;


        }

    }
}
//eliminar detalle
function deleteDetalleC(id) {
    id_producto = id;
    let base_url = 'http://localhost/Pos_venta/';

    const url = base_url + "Compras/delete/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);
            if (resp.modificado == true) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: resp.post,
                    showConfirmButton: false,
                    timer: 2200
                })
                cargarDetalleC();
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: resp.post,
                    showConfirmButton: false,
                    timer: 2200
                })
            }
        }
    }
}

//generar compra
function generarCompra() {

    let efectivo = document.querySelector('#efectivo').value;
    let pago = document.querySelector('#pago').value;

    if (efectivo == '' && pago != "Credito") {
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'El campo efectivo no puede estar vacío',
            showConfirmButton: false,
            timer: 2200
        })
        return false;
    }
    compra();
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Está seguro de realizar la compra?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Aceptar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            let base_url = 'http://localhost/Pos_venta/';

            const url = base_url + "Compras/registrarCompra";
            const frm = document.getElementById("frmCompras");
            const http = new XMLHttpRequest();
            http.open("POST", url, true);
            http.send(new FormData(frm));
            http.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    const resp = JSON.parse(this.responseText);
                    console.log(resp);
                    if (resp.modificado == true) {
                        swalWithBootstrapButtons.fire(
                            'Compra generada!',
                            resp.post,
                            'success',
                        );
                        const ruta = base_url + 'Compras/imprimirPDF/' + resp.id_compra;
                        window.open(ruta);
                        setTimeout(() => {
                            window.location.reload();
                        }, 300);
                    } else {
                        swalWithBootstrapButtons.fire(
                            'Compra Cancelado!',
                            resp.post,
                            'error'
                        );
                    }
                }
            }

        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelado!',
                'La compra no se realizó',
                'error'
            )
        }
    })
}

//pago efectivo
function compra() {
    let base_url = 'http://localhost/Pos_venta/';

    const url = base_url + "Compras/TipoPago";
    const frm = document.getElementById("frmCerrarC");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            JSON.parse(this.responseText);
        }
    }
}
//historial de compras
document.addEventListener("DOMContentLoaded", function() {
    let base_url = 'http://localhost/Pos_venta/';

    $('#tableHistorial').dataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
        dom: 'lBfrtip',
        "columnDefs": [
            { 'className': "textcenter", "targets": [4] }, //status  
            { 'className': "textcenter", "targets": [5] }, //status  

        ],
        "ajax": {
            "url": " " + base_url + "Compras/listar_historial",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "nombre" },
            { "data": "total", render: $.fn.dataTable.render.number('.', ',', 2) },
            { "data": "fecha" },
            { "data": "estado" },
            { "data": "acciones" },

        ],
        buttons: [{
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Expotar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4]
                }
            }, {
                "extend": "csvHtml5",
                "text": "<i class='faa fa-file-csv'></i> CSV",
                "titleAttr": "Eportar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4]
                }
            },

        ],
        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ]
    });


})

//anular compra
function btnAnularC(id) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Está seguro de anular la compra?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Aceptar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            let base_url = 'http://localhost/Pos_venta/';

            const url = base_url + "Compras/anularCompra/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    const resp = JSON.parse(this.responseText);

                    if (resp.modificado == true) {
                        swalWithBootstrapButtons.fire(
                            'Atención!',
                            resp.post,
                            'success',
                        );
                        setTimeout(() => {
                            window.location.reload();
                        }, 300);
                    } else {
                        swalWithBootstrapButtons.fire(
                            'Atención!',
                            resp.msg,
                            'error'
                        );
                    }

                }
            }

        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelado!',
                'La anulación de la compra no se realizó',
                'error'
            )
        }
    })
}