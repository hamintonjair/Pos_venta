document.addEventListener("DOMContentLoaded", function() {
    let base_url = 'http://localhost/Pos_venta/';
    $('#tableCajas').dataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
        dom: 'lBfrtip',
        "columnDefs": [
            { 'className': "textcenter", "targets": [3] }, //status  
            { 'className': "textcenter", "targets": [2] }, //status           
        ],
        "ajax": {
            "url": " " + base_url + "Cajas/listar",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "caja" },
            { "data": "estado" },
            { "data": "acciones" },

        ],
        buttons: [{
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Expotar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0, 1]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0, 1]
                }
            }, {
                "extend": "csvHtml5",
                "text": "<i class='faa fa-file-csv'></i> CSV",
                "titleAttr": "Eportar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1]
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

//registrar caja
function registrarCaja(e) {
    e.preventDefault();

    const caja = document.getElementById("caja");
    if (caja.value == "") {

        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 2200
        })

    } else {
        let base_url = 'http://localhost/Pos_venta/';
        const url = base_url + "Cajas/registrarCaja";
        const frm = document.getElementById("frmCaja");
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
                    $('#nueva_caja').modal('hide');
                    window.location.reload();
                } else if (resp.modificado == true) {

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: resp.post,
                        showConfirmButton: false,
                        timer: 2200
                    })
                    $('#nueva_caja').modal('hide');
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
function editarCaja(id) {

    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    document.querySelector('#titleModal').innerHTML = "Actualizar Caja";
    document.querySelector('#frmCaja').reset();


    let base_url = 'http://localhost/Pos_venta/';
    $.ajax({
        url: base_url + 'Cajas/editar/' + id,
        type: "GET",
        dataType: "json",
        data: {
            id: id
        },
        success: function(resp) {
            $('#idCaja').val(resp[0].id);
            $('#caja').val(resp[0].caja);
            $('#nueva_caja').modal('show');
        }
    });

}

//eliminar
function eliminarCaja(id) {
    let base_url = 'http://localhost/Pos_venta/';
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere eliminar el Caja?',
        text: "El caja se eliminará de forma permanente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Cajas/deleteCaja/" + id;
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
                'El caja no fue eliminado',
                'error'
            )
        }
    })
}
//reingresar caja
function reingresarCaja(id) {
    let base_url = 'http://localhost/Pos_venta/';
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere reingresar el Caja?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Restaurar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Cajas/reingresarCaja/" + id;
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
                'El caja no fue restaurada',
                'error'
            )
        }
    })
}

function openArqueo() {
    let base_url = 'http://localhost/Pos_venta/';
    window.location = base_url + "cajas/arqueo";
}
//abrir modal
function arqueoCaja() {
    document.getElementById('ocultar_campos').classList.add('d-none');
    document.getElementById('monto_inicial').value = "";
    document.getElementById('id_caja').value = "";
    document.getElementById('btnActionForm').textContent = 'Abrir caja';
    $('#abrir_caja').modal('show');
}

function abrirArqueo(e) {
    e.preventDefault();
    const monto_inicial = document.getElementById("monto_inicial").value;
    const id_caja = document.getElementById("id_caja").value;


    if (monto_inicial == "" || id_caja == "" || id_caja == "") {

        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 2200
        })
    } else {
        let base_url = 'http://localhost/Pos_venta/';
        const frmAbrirCaja = document.getElementById("frmAbrirCaja");
        const url = base_url + "Cajas/abrirArqueo";
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frmAbrirCaja));
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
                    $('#abrir_caja').modal('hide');
                    window.location.reload();
                } else {

                    Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: resp.post,
                        showConfirmButton: false,
                        timer: 2200
                    })
                }

            }
        }
    }
}
//arqueo
document.addEventListener("DOMContentLoaded", function() {
    let base_url = 'http://localhost/Pos_venta/';
    $('#tableArqueoCajas').dataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
        dom: 'lBfrtip',
        "columnDefs": [
            { 'className': "textcenter", "targets": [8] }, //status  

        ],
        "ajax": {
            "url": " " + base_url + "Cajas/listarArqueo",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "caja" },
            { "data": "monto_inicial", render: $.fn.dataTable.render.number('.', ',', 2) },
            { "data": "monto_final", render: $.fn.dataTable.render.number('.', ',', 2) },
            { "data": "fecha_apertura" },
            { "data": "fecha_cierre" },
            { "data": "total_ventas" },
            { "data": "monto_total", render: $.fn.dataTable.render.number('.', ',', 2) },
            { "data": "estado" },

        ],
        buttons: [{
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5, 6, 7]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Expotar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5, 6, 7]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5, 6, 7]
                }
            }, {
                "extend": "csvHtml5",
                "text": "<i class='faa fa-file-csv'></i> CSV",
                "titleAttr": "Eportar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5, 6, 7]
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

//cerrar caja
function cerrarArqueo() {

    let base_url = 'http://localhost/Pos_venta/';
    $.ajax({
        url: base_url + 'Cajas/consultarVentas/',
        type: "GET",
        dataType: "json",

        success: function(resp) {

            if (resp.ok == false) {

                Swal.fire({
                    position: 'top-end',
                    icon: 'warning',
                    title: resp.post,
                    showConfirmButton: false,
                    timer: 2200
                })
            }
            $('#ocultar_campos2').addClass('d-none');
            $('#monto_inicial').val(resp.inicial[0].monto_inicial);
            $('#monto_final').val(resp.monto_total[0].total);
            $('#total_ventas').val(resp.total_ventas[0].total);
            $('#monto_general').val(resp.monto_general);
            $('#id').val(resp.inicial[0].id);
            $('#ocultar_campos').removeClass('d-none');
            $('#btnActionForm').text('Cerrar caja');
            $('#abrir_caja').modal('show');
        }
    });

}
//volver
function volverCaja() {
    let base_url = 'http://localhost/Pos_venta/';
    window.location = base_url + "cajas";
}

function openModalCaja() {

    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Registrar";
    document.querySelector('#titleModal').innerHTML = "Nueva Caja";
    document.querySelector('#frmCaja').reset();
    $('#nueva_caja').modal('show');
}