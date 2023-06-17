let cod_productoV;
let Pagar = 0;
//buscar por codigo
function buscarCodigoVenta(e) {
    e.preventDefault();

    if (e.which == 13) {
        const cod = document.getElementById("codigo2").value;
        cod_productoV = cod;
        const url = base_url + "Ventas/buscarVenta/" + cod;
        const http = new XMLHttpRequest();
        http.open("GET", url, true);
        http.send();
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const resp = JSON.parse(this.responseText);

                if (resp.post == "Producto agotado." || resp.post == "Producto no existe.") {

                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: resp.post,
                        showConfirmButton: false,
                        timer: 2200
                    })

                    document.getElementById("descripcion").value = "Descripcion del producto";
                    document.getElementById("cantidad").value = "0.00";
                    document.getElementById("precio").value = "0.00";
                    document.getElementById("sub_total").value = "0.00";
                    document.getElementById("iva").value = "0.00";
                    document.getElementById("precio").focus()
                } else {
                    document.getElementById("nombre").value = "";
                    document.getElementById("descripcion").value = resp.descripcion;
                    document.getElementById("precio").value = resp.precio_venta;
                    document.getElementById("iva").value = resp.iva;
                    document.getElementById("id").value = resp.id;
                    document.getElementById("cantidad").removeAttribute('disabled');
                    document.getElementById("cantidad").value = "";
                    document.getElementById("cantidad").focus();
                }


            }
        }
    }

}
//buscar por nombre
function buscarNombre(e) {
    e.preventDefault();

    if (e.which == 13) {
        const nomb = document.getElementById("nombre").value;
        const valorCodificado = nomb.replace(/ /g, '+');
        cod_producto = valorCodificado;
        const url = base_url + "Ventas/buscarVenta/" + valorCodificado;
        const http = new XMLHttpRequest();
        http.open("GET", url, true);
        http.send();
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const resp = JSON.parse(this.responseText);


                if (resp.post == "Producto agotado." || resp.post == "Producto no existe.") {

                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: resp.post,
                        showConfirmButton: false,
                        timer: 2200
                    })

                    document.getElementById("descripcion").value = "Descripcion del producto";
                    document.getElementById("cantidad").value = "0.00";
                    document.getElementById("precio").value = "0.00";
                    document.getElementById("sub_total").value = "0.00";
                    document.getElementById("iva").value = "0.00";
                    document.getElementById("precio").focus()
                } else {
                    document.getElementById("codigo2").value = "";
                    document.getElementById("descripcion").value = resp.descripcion;
                    document.getElementById("precio").value = resp.precio_venta;
                    document.getElementById("iva").value = resp.iva;
                    document.getElementById("id").value = resp.id;
                    document.getElementById("cantidad").removeAttribute('disabled');
                    document.getElementById("cantidad").value = "";
                    document.getElementById("cantidad").focus();
                }


            }
        }
    }

}
//buscar cliente 
function buscarCliente(e) {
    e.preventDefault();
    if (e.which == 13) {
        const cedula = document.getElementById("cedula").value;
        const url = base_url + "Ventas/buscarCliente/" + cedula;
        const http = new XMLHttpRequest();
        http.open("GET", url, true);
        http.send();
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const resp = JSON.parse(this.responseText);

                if (resp) {
                    document.getElementById("cliente").value = resp.nombre;
                    document.getElementById("ID").value = resp.id;
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'El cliente no existe',
                        showConfirmButton: false,
                        timer: 2200
                    })
                    document.getElementById("cedula").value = "";
                    document.getElementById("cedula").focus();
                    document.getElementById("cliente").value = "";
                }


            }
        }
    }

}

let totalPago;
//calcular cantidad
function calcularPrecioVenta(e) {
    e.preventDefault();
    const cant = document.getElementById("cantidad").value;
    const precio = document.getElementById("precio").value;
    const iva = document.getElementById("iva").value;
    const subTotal = precio * cant;
    const subIva = (subTotal * iva) / 100;
    document.getElementById("sub_total").value = subIva + subTotal;
    if (e.which == 13) {
        if (cant > 0) {
            const url = base_url + "Ventas/ingresar";
            const frm = document.getElementById("frmVenta");
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
                        cargarDetalle();
                        document.getElementById("cantidad").setAttribute('disabled', 'disabled');
                        document.getElementById("codigo2").focus()

                    } else if (resp.actualizado == true) {

                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: resp.post,
                            showConfirmButton: false,
                            timer: 2200
                        })
                        frm.reset();
                        cargarDetalle();
                        document.getElementById("cantidad").setAttribute('disabled', 'disabled');
                        document.getElementById("codigo2").focus()

                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: resp.post,
                            showConfirmButton: false,
                            timer: 2200
                        })
                        document.getElementById("cantidad").value = "";
                    }
                }
            }
        }
    }
}
//mostar detalles del producto de la compra
function cargarDetalle() {
    const url = base_url + "Ventas/listar";
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
                <td><input class="form-control" placeholder="Descuento" type="text" onkeyup="calcularDescuento(event,${row['id']})"></td>
                <td>${row['descuento']}</td>
                <td>${precio}</td>
                <td>${row['iva']}</td>
                <td>${sub_total}</td>     
                <td>
                   <button class="btn btn-danger" title="Eliminar" type="button" onclick="deleteDetalle(${row['id']})"><i class="fas fa-trash-alt"></i></button>
                </td>            
                </tr>`
            });
            Pagar = resp.total_pagar.total
            const pagar = new Intl.NumberFormat().format(resp.total_pagar.total);
            document.getElementById("tblDetalle").innerHTML = html;
            totalPago = document.getElementById("total").value = pagar;
        }

    }
}
//calcular decuento
function calcularDescuento(e, id) {
    e.preventDefault();

    if (e.target.value == '') {

        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Ingrese el descuento ',
            showConfirmButton: false,
            timer: 2200
        })
    } else {

        if (e.which == 13) {
            const url = base_url + "Ventas/calcularDescuento/" + id + "/" + e.target.value;
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
                        cargarDetalle();
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
    }
}
//eliminar detalle
function deleteDetalle(id) {
    id_producto = id;
    const url = base_url + "Ventas/delete/" + id;
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
                cargarDetalle();
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

let efectivos = 0;
let cambio = 0;

//pago efectivo
function efectivo(e) {
    e.preventDefault();

    if (e.which == 13) {
        efectivos = document.getElementById("efectivos").value;
        cambio = efectivos - Pagar;
        document.getElementById("devolver").value = new Intl.NumberFormat().format(cambio);

        const url = base_url + "Ventas/ingresarCambio";
        const frm = document.getElementById("frmCerrar");
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
                } else {
                    alert(resp.msg, "error");
                    document.getElementById("efectivos").focus();
                    document.getElementById("efectivos").value = "";
                    cambio = document.getElementById("devolver").value = "";
                }

            }
        }
    }
}
//cerrar
function cerrarVenta() {

    $('#cerrarVenta').modal('show');
    document.getElementById("valor_pagar").value = totalPago;
}

//generar venta
function generarVenta() {

    if (efectivos == "") {
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'El campo efectivo no puede estar vacío ',
            showConfirmButton: false,
            timer: 2200
        })

    } else {

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
                const url = base_url + "Ventas/registrarVenta/";
                const frm = document.getElementById("frmVentas");
                frm.a = document.getElementById("frmCerrar");
                const http = new XMLHttpRequest();
                http.open("POST", url, true);
                http.send(new FormData(frm));
                http.onreadystatechange = function() {
                    $('#cerrarVenta').modal('hide');
                    if (this.readyState == 4 && this.status == 200) {
                        const resp = JSON.parse(this.responseText);
                        if (resp.modificado == true) {
                            swalWithBootstrapButtons.fire(
                                'Venta generada!',
                                resp.post,
                                'success',
                            );
                            const ruta = base_url + 'Ventas/generarPDF/' + resp.id_venta;
                            window.open(ruta);
                            setTimeout(() => {
                                window.location.reload();
                            }, 300);
                        } else {
                            swalWithBootstrapButtons.fire(
                                'Venta Cancelado!',
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
                    'La compra no se realizó',
                    'error'
                )
            }
        })

    }
}


//anular compra
function btnAnularV(id) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Está seguro de anular la venta?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Aceptar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Ventas/anularVenta/" + id;
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
                'La anulación de la venta no se realizó',
                'error'
            )
        }
    })
}
//hostorial ventas
document.addEventListener("DOMContentLoaded", function() {

    $('#tableHistorialVentas').dataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
        dom: 'lBfrtip',
        "columnDefs": [

            { 'className': "textcenter", "targets": [4] }, //status           
        ],
        "ajax": {
            "url": " " + base_url + "Ventas/listar_historial",
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