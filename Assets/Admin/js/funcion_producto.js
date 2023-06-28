document.addEventListener("DOMContentLoaded", function() {
    let base_url = 'http://localhost/Pos_venta/';

    $('#tableProductos').dataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
        dom: 'lBfrtip',
        "columnDefs": [
            { 'className': "textcenter", "targets": [7] }, //accion
            { 'className': "textcenter", "targets": [6] }, //accion
            { 'className': "textcenter", "targets": [5] }, //status
            { 'className': "textleft", "targets": [4] }, //stock            
        ],
        "ajax": {
            "url": " " + base_url + "Productos/listar",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "imagen" },
            { "data": "codigo" },
            { "data": "descripcion" },
            { "data": "precio_venta", render: $.fn.dataTable.render.number('.', ',', 2) },
            { "data": "cantidad" },
            { "data": "iva" },
            { "data": "vencimiento" },
            { "data": "fecha_vencimiento" },
            { "data": "estado" },
            { "data": "acciones" },

        ],
        buttons: [{
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 2, 3, 4, 5, 6, 7, 8, 9]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Expotar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0, 2, 3, 4, 5, 6, 7, 8, 9]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0, 2, 3, 4, 5, 6, 7, 8, 9]
                }
            }, {
                "extend": "csvHtml5",
                "text": "<i class='faa fa-file-csv'></i> CSV",
                "titleAttr": "Eportar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 2, 3, 4, 5, 6, 7, 8, 9]
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
    if (document.getElementById('stockMinimo')) {
        reportStock();
        productosVendidos();
    }
})

//productos eliminados
document.addEventListener("DOMContentLoaded", function() {
    let base_url = 'http://localhost/Pos_venta/';

    $('#tableProductosEliminados').dataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
        dom: 'lBfrtip',
        "columnDefs": [
            { 'className': "textcenter", "targets": [7] }, //accion
            { 'className': "textcenter", "targets": [6] }, //accion
            { 'className': "textcenter", "targets": [5] }, //status
            { 'className': "textleft", "targets": [4] }, //stock            
        ],
        "ajax": {
            "url": " " + base_url + "Productos/listarEliminados",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "imagen" },
            { "data": "codigo" },
            { "data": "descripcion" },
            { "data": "precio_venta", render: $.fn.dataTable.render.number('.', ',', 2) },
            { "data": "cantidad" },
            { "data": "iva" },
            { "data": "vencimiento" },
            { "data": "fecha_vencimiento" },
            { "data": "estado" },
            { "data": "acciones" },

        ],
        buttons: [{
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 2, 3, 4, 5, 6]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Expotar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0, 2, 3, 4, 5, 6]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0, 2, 3, 4, 5, 6]
                }
            }, {
                "extend": "csvHtml5",
                "text": "<i class='faa fa-file-csv'></i> CSV",
                "titleAttr": "Eportar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 2, 3, 4, 5, 6]
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
    if (document.getElementById('stockMinimo')) {
        reportStock();
        productosVendidos();


    }

})

function productosEliminados() {
    let base_url = 'http://localhost/Pos_venta/';

    window.location = base_url + "Productos/productosEliminados";
}

function volver() {
    let base_url = 'http://localhost/Pos_venta/';

    window.location = base_url + "productos";
}

//registrar producto
function registrarProducto(e) {
    e.preventDefault();

    const codigo = document.getElementById("codigo");
    const descripcion = document.getElementById("descripcion");
    const precio_venta = document.getElementById("precio_venta");
    const medida = document.getElementById("id_medida");
    const categoria = document.getElementById("id_categoria");
    const proveedor = document.getElementById("id_proveedor");
    const vencimiento = document.getElementById("vencimiento");
    const iva = document.getElementById("iva");

    if (codigo.value == "" || descripcion.value == "" || precio_venta.value == "" || medida.value == "" ||
        categoria.value == "" || proveedor.value == "" || vencimiento.value == "" || iva.value == "") {


        Swal.fire({
                position: 'top-end',
                icon: 'info',
                title: 'Todos los campos son obligatorios',
                showConfirmButton: false,
                timer: 2200
            })
            // alert("Todos los campos son obligatorios", "info");

    } else {
        let base_url = 'http://localhost/Pos_venta/';

        const url = base_url + "Productos/registrarProductos";
        const frm = document.getElementById("frmProductos");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const resp = JSON.parse(this.responseText);

                if (resp.ok == true) {

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: resp.post,
                        showConfirmButton: false,
                        timer: 2200
                    })

                    $('#nuevo_producto').modal('hide');
                    window.location.reload();
                } else if (resp.modificado == true) {

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: resp.post,
                        showConfirmButton: false,
                        timer: 2200
                    })

                    $('#nuevo_producto').modal('hide');
                    window.location.reload();
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

//editar
function editarProducto(id) {

    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    document.querySelector('#titleModal').innerHTML = "Actualizar Producto";
    document.querySelector('#frmProductos').reset();

    let base_url = 'http://localhost/Pos_venta/';
    $.ajax({
        url: base_url + 'Productos/editar/' + id,
        type: "GET",
        dataType: "json",
        data: {
            id: id
        },
        success: function(resp) {
            $('#idProducto').val(resp[0].id);
            $('#codigo').val(resp[0].codigo);
            $('#descripcion').val(resp[0].descripcion);
            $('#precio_venta').val(resp[0].precio_venta);
            $('#precio_compra').val(resp[0].precio_compra);
            $('#cantidad').val(resp[0].nombre_corto).prop('disabled', true);
            $('#cantidad').val(resp[0].id);
            $('#iva').val(resp[0].iva);
            $('#vencimiento').val(resp[0].vencimiento);
            $('#fecha').val(resp[0].fecha);
            $('#id_medida').val(resp[0].id_medida);
            $('#id_categoria').val(resp[0].id_categoria);
            $('#id_proveedor').val(resp[0].id_proveedor);
            document.getElementById("img-preview").src = base_url + "assets/img/" + resp[0].foto;
            document.getElementById("icon-cerrar").innerHTML = `<button class="btn btn-danger" 
          onclick="deletImg()"><i class="fas fa-times"></i></button>`;
            document.getElementById("icon-image").classList.add("d-none");
            $('#foto_actual').val(resp[0].foto);
            fntBarcode();
            document.querySelector("#divBarcode").classList.remove("notblock");
            $('#nuevo_producto').modal('show');
        }
    });

}


//Barcode
if (document.querySelector("#codigo")) {
    let inputCodigo = document.querySelector("#codigo");
    inputCodigo.onkeyup = function() {
        if (inputCodigo.value.length >= 5) {
            document.querySelector('#divBarcode').classList.remove("notblock");
            fntBarcode();
        } else {
            document.querySelector('#divBarcode').classList.add("notblock");
        }
    }
}

function fntBarcode() {
    let codigo = document.querySelector('#codigo').value;
    JsBarcode("#barcode", codigo);
}

function printBarcode(area) {
    let elementArea = document.querySelector(area);
    let vprint = window.open(' ', 'popimpr', 'height=400,width=600');
    vprint.document.write(elementArea.innerHTML);
    vprint.document.close();
    vprint.print();
    vprint.close();
}
//eliminar
// function eliminarProductos(id) {

//     const swalWithBootstrapButtons = Swal.mixin({
//         customClass: {
//             confirmButton: 'btn btn-success',
//             cancelButton: 'btn btn-danger'
//         },
//         buttonsStyling: false
//     })
//     swalWithBootstrapButtons.fire({
//         title: '¿Realmente quiere eliminar el Producto?',
//         text: "El producto no se eliminará de forma permanete, solo cambiará el estado a inactivo",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonText: 'Si, Eliminar!',
//         cancelButtonText: 'No, cancel!',
//         reverseButtons: true
//     }).then((result) => {
//         if (result.isConfirmed) {
//             const url = base_url + "Productos/deleteProducto/" + id;
//             const http = new XMLHttpRequest();
//             http.open("GET", url, true);
//             http.send();
//             http.onreadystatechange = function() {

//                 if (this.readyState == 4 && this.status == 200) {
//                     const resp = JSON.parse(this.responseText);

//                     if (resp.eliminado == true) {
//                         swalWithBootstrapButtons.fire(
//                             'Eliminado!',
//                             resp.post,
//                             'success',
//                             location.reload()
//                         );
//                     } else {
//                         swalWithBootstrapButtons.fire(
//                             'Cancelado!',
//                             resp.msg,
//                             'error'
//                         );
//                     }
//                 }
//             }

//         } else if (
//             /* Read more about handling dismissals below */
//             result.dismiss === Swal.DismissReason.cancel
//         ) {
//             swalWithBootstrapButtons.fire(
//                 'Cancelado!',
//                 'El producto no fue eliminado',
//                 'error'
//             )
//         }
//     })
// }

function eliminarProducto(id) {

    let base_url = 'http://localhost/Pos_venta/';

    // Verificar la relación del usuario
    $.ajax({
        url: base_url + "Productos/eliminar/" + id,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // No hay relación, eliminar directamente
                eliminarPro(id);
            } else {
                // Mostrar confirmación adicional si hay relación
                Swal.fire({
                    title: 'Advertencia',
                    text: response.message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        eliminarPro(id);
                    }
                });
            }
        },
        error: function() {
            Swal.fire({
                title: 'Error',
                text: 'Ha ocurrido un error al verificar la relación',
                icon: 'error'
            });
        }
    });
};

function eliminarPro(id) {

    let base_url = 'http://localhost/Pos_venta/';

    // Eliminar el usuario
    $.ajax({
        url: base_url + "Productos/deleteProducto/" + id,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.eliminado == true) {
                // Usuario eliminado correctamente
                Swal.fire({
                    title: 'Eliminado',
                    text: response.post,
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Recargar la página
                        location.reload();
                    }
                });
            } else {
                // Error al eliminar el usuario
                Swal.fire({
                    title: 'Error',
                    text: response.post,
                    icon: 'error'
                });
            }
        },
        error: function() {
            // Mostrar mensaje de error en caso de falla en la petición Ajax
            Swal.fire({
                title: 'Error',
                text: 'Ha ocurrido un error al procesar la solicitud',
                icon: 'error'
            });
        }
    });
}

function productosVaciar() {
    let base_url = 'http://localhost/Pos_venta/';

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere vaciar los productos?',
        text: "Los productos se eliminarán permanentemente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Productos/vaciarProducto/";
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    const resp = JSON.parse(this.responseText);

                    if (resp.eliminado == true) {
                        swalWithBootstrapButtons.fire(
                            'Eliminado!',
                            resp.post,
                            'success',
                            location.reload()
                        );
                    } else {
                        swalWithBootstrapButtons.fire(
                            'Cancelado!',
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
                'Los productos no fueron vaciado',
                'error'
            )
        }
    })
}
//reingresar producto
function reingresarProducto(id) {
    let base_url = 'http://localhost/Pos_venta/';

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere reingresar el Producto?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Restaurar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Productos/reingresarProducto/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    const resp = JSON.parse(this.responseText);

                    if (resp.reingresado == true) {
                        swalWithBootstrapButtons.fire(
                            'Reingresado!',
                            resp.post,
                            'success',
                            location.reload()
                        );
                    } else {
                        swalWithBootstrapButtons.fire(
                            'Cancelado!',
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
                'El producto no fue restaurado',
                'error'
            )
        }
    })
}

//cargar imagen
function preview(e) {
    const url = e.target.files[0];
    const urlTmp = URL.createObjectURL(url);
    document.getElementById("img-preview").src = urlTmp;
    document.getElementById("icon-image").classList.add("d-none");
    document.getElementById("icon-cerrar").innerHTML = `<button class="btn btn-danger"
    onclick="deletImg()"><i class="fas fa-times"></i></button>
    ${url['name']}`;
}

function deletImg() {
    document.getElementById("icon-cerrar").innerHTML = '';
    document.getElementById("icon-image").classList.remove("d-none");
    document.getElementById("img-preview").src = '';
    document.getElementById("imagen").value = '';
    document.getElementById("foto_actual").value = '';
}

function alert(msm, icon) {
    Swal.fire({
        position: 'top-end',
        icon: icon,
        title: msm,
        showConfirmButton: false,
        timer: 2200
    })
}
//stock bajos
function reportStock() {
    let base_url = 'http://localhost/Pos_venta/';

    const url = base_url + "Dashboard/reportStock";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);

            let nombre = [];
            let cantidad = [];
            for (let i = 0; i < resp.length; i++) {
                nombre.push(resp[i]['descripcion']);
                cantidad.push(resp[i]['cantidad']);

                const ctxe = document.getElementById('stockMinimo');
                // if (window.myChart) {
                //     window.myChart.destroy(); // Destruir la instancia existente si existe
                // }
                window.productosbajos = new Chart(ctxe, {
                    type: 'pie',
                    data: {
                        labels: nombre,
                        datasets: [{
                            data: cantidad,
                            backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745', '#EC7063', '#5499C7', '#45B39D', '#F4D03F', '#F39C12', '#707B7C ']
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });


            }
        }
    }
}
//productos mas vendidos
function productosVendidos() {
    let base_url = 'http://localhost/Pos_venta/';
    const url = base_url + "Dashboard/productosVendidos";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);

            let nombre = [];
            let cantidad = [];
            for (let i = 0; i < resp.length; i++) {
                nombre.push(resp[i]['descripcion']);
                cantidad.push(resp[i]['total']);

            }
            const ctx = document.getElementById('productosVendidos');
            if (window.myChartProductosVendidos) {
                window.myChartProductosVendidos.destroy(); // Destruir la instancia existente si existe
            }
            window.myChartProductosVendidos = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: nombre,
                    datasets: [{
                        data: cantidad,
                        backgroundColor: ['#EC7063', '#5499C7', '#45B39D', '#F4D03F', '#EB984E', '#138D75', '#7D3C98', '#9A7D0A', '#566573', '#1D8348 ']
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }
}
//grafica
function ganancias() {
    let base_url = 'http://localhost/Pos_venta/';

    const yearInput = document.getElementById('id');
    const year = yearInput.value;


    // Verificar que se haya ingresado un año válido
    if (year < 1900 || year > 2099) {
        alert('Por favor, ingresa un año válido.');
        return;
    }

    const canvas = document.getElementById('gananciasMes');
    const context = canvas.getContext('2d');

    // Destruir la instancia de la gráfica anterior si existe
    // if (window.myChart !== undefined) {
    //     window.myChart.destroy();
    // }

    if (window.myChart !== undefined && window.myChart !== null) {
        window.myChart.canvas.parentNode.removeChild(window.myChart.canvas);
        window.myChart.destroy();
        window.myChart = null;
    }

    const url = base_url + "Reportes/verGanancia/" + year;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);

            let mes = [];
            let total = [];
            for (let i = 0; i < resp.length; i++) {
                mes.push(resp[i]['mes']);
                total.push(resp[i]['total_mes']);
            }

            // Configuración de la gráfica
            const data = {
                labels: mes,
                datasets: [{
                    label: 'Total de ventas por mes',
                    data: total,
                    borderColor: 'blue',
                    backgroundColor: 'red',
                    fill: false,
                }],
            };

            // Configuración de la gráfica
            const chartConfig = {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Total de ventas por mes',
                        },
                    },
                },
            };

            // Crear la gráfica
            window.myChart = new Chart(context, chartConfig);
        }
    }
}

function reloadPage() {
    location.reload();
}


function openModalProductos() {

    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Registrar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
    document.querySelector("#frmProductos ").reset();
    console.log(document.querySelector('#frmProductos').reset());
    $('#nuevo_producto').modal('show');

}