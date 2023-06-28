document.addEventListener("DOMContentLoaded", function() {
    let base_url = 'http://localhost/Pos_venta/';

    $('#tableMedidas').dataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
        dom: 'lBfrtip',
        "columnDefs": [
            { 'className': "textcenter", "targets": [3] }, //status  
            { 'className': "textcenter", "targets": [4] }, //status           
        ],
        "ajax": {
            "url": " " + base_url + "Medidas/listar",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "nombre" },
            { "data": "nombre_corto" },
            { "data": "estado" },
            { "data": "acciones" },

        ],
        buttons: [{
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Expotar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0, 1, 2, 3]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0, 1, 2, 3]
                }
            }, {
                "extend": "csvHtml5",
                "text": "<i class='faa fa-file-csv'></i> CSV",
                "titleAttr": "Eportar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3]
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

document.addEventListener("DOMContentLoaded", function() {
    let base_url = 'http://localhost/Pos_venta/';

    $('#tableMedidasEliminado').dataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
        dom: 'lBfrtip',
        "columnDefs": [
            { 'className': "textcenter", "targets": [3] }, //status  
            { 'className': "textcenter", "targets": [4] }, //status           
        ],
        "ajax": {
            "url": " " + base_url + "Medidas/listarEliminado",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "nombre" },
            { "data": "nombre_corto" },
            { "data": "estado" },
            { "data": "acciones" },

        ],
        buttons: [{
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Expotar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0, 1, 2]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0, 1, 2]
                }
            }, {
                "extend": "csvHtml5",
                "text": "<i class='faa fa-file-csv'></i> CSV",
                "titleAttr": "Eportar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2]
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

function medidasEliminado() {
    let base_url = 'http://localhost/Pos_venta/';

    window.location = base_url + "Medidas/medidasEliminado";
}

function volverMedidas() {
    let base_url = 'http://localhost/Pos_venta/';

    window.location = base_url + "medidas";
}
//registrar caja
function registrarMedida(e) {
    e.preventDefault();

    const nombre = document.getElementById("nombre");
    const nombre_corto = document.getElementById("nombre_corto");

    if (nombre.value == "" || nombre_corto.value == "") {
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'Todos los campos son obligatorios.',
            showConfirmButton: false,
            timer: 2200
        })


    } else {
        let base_url = 'http://localhost/Pos_venta/';

        const url = base_url + "Medidas/registrarMedida";
        const frm = document.getElementById("frmMedida");
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
                    $('#nueva_medida').modal('hide');
                    window.location.reload();
                } else if (resp.modificado == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: resp.post,
                        showConfirmButton: false,
                        timer: 2200
                    })
                    $('#nueva_medida').modal('hide');
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
function editarMedida(id) {

    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    document.querySelector('#titleModal').innerHTML = "Actualizar Medida";
    document.querySelector('#frmMedida').reset();

    let base_url = 'http://localhost/Pos_venta/';
    $.ajax({
        url: base_url + 'Medidas/editar/' + id,
        type: "GET",
        dataType: "json",
        data: {
            id: id
        },
        success: function(resp) {
            $('#idMedida').val(resp[0].id);
            $('#nombre').val(resp[0].nombre);
            $('#nombre_corto').val(resp[0].nombre_corto);
            $('#nueva_medida').modal('show');
        }
    });

}

//eliminar
function eliminarMedida(id) {

    let base_url = 'http://localhost/Pos_venta/';

    // Verificar la relación del usuario
    $.ajax({
        url: base_url + "Medidas/eliminar/" + id,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // No hay relación, eliminar directamente
                eliminarMedi(id);
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
                        eliminarMedi(id);
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

function eliminarMedi(id) {

    let base_url = 'http://localhost/Pos_venta/';

    // Eliminar el usuario
    $.ajax({
        url: base_url + "Medidas/deleteMedida/" + id,
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

//reingresar caja
function reingresarMedida(id) {
    let base_url = 'http://localhost/Pos_venta/';

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere reingresar el Medida?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Restaurar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Medidas/reingresarMedida/" + id;
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
                'La medida no fue restaurada',
                'error'
            )
        }
    })
}
//vaciar medidas
function medidasVaciar() {
    let base_url = 'http://localhost/Pos_venta/';

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere vaciar las unidades de medidas?',
        text: "Las medidas se eliminarán permanentemente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Medidas/vaciarMedidas/";
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
                'Las medidas no fueron vaciado',
                'error'
            )
        }
    })
}

function openModalMedida() {

    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Registrar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Medida";
    document.querySelector('#frmMedida').reset();
    $('#nueva_medida').modal('show');
}