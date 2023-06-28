document.addEventListener("DOMContentLoaded", function() {

    let base_url = 'http://localhost/Pos_venta/';

    $('#tableCategorias').dataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
        dom: 'lBfrtip',
        "columnDefs": [
            { 'className': "textcenter", "targets": [3] }, //status  
            { 'className': "textcenter", "targets": [2] }, //status           
        ],
        "ajax": {
            "url": " " + base_url + "Categorias/listar",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "nombre" },
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
document.addEventListener("DOMContentLoaded", function() {
    let base_url = 'http://localhost/Pos_venta/';

    $('#tableCategoriasEliminado').dataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
        dom: 'lBfrtip',
        "columnDefs": [
            { 'className': "textcenter", "targets": [3] }, //status  
            { 'className': "textcenter", "targets": [2] }, //status           
        ],
        "ajax": {
            "url": " " + base_url + "Categorias/listarEliminado",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "nombre" },
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

//eliminado
function categoriaEliminado() {
    let base_url = 'http://localhost/Pos_venta/';

    window.location = base_url + "Categorias/categoriaEliminado";
}
//vaciar categorias
function categoriaVaciar() {
    let base_url = 'http://localhost/Pos_venta/';

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere vaciar las categorías?',
        text: "Las categorías se eliminarán permanentemente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Categorias/vaciarCategorias/";
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
                'Las categorías no fueron vaciado',
                'error'
            )
        }
    })
}
//volver
function volverCategoria() {
    let base_url = 'http://localhost/Pos_venta/';

    window.location = base_url + "categorias";
}
//registrar categoria
function registrarCategoria(e) {
    e.preventDefault();
    let base_url = 'http://localhost/Pos_venta/';

    const categoria = document.getElementById("categoria");

    if (categoria.value == "") {

        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 2200
        })
    } else {
        const url = base_url + "Categorias/registrarCategoria";
        const frm = document.getElementById("frmCategoria");
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
                    $('#nueva_categoria').modal('hide');
                    window.location.reload();
                } else if (resp.modificado == true) {

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: resp.post,
                        showConfirmButton: false,
                        timer: 2200
                    })
                    $('#nueva_categoria').modal('hide');
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
function editarCategoria(id) {

    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    document.querySelector('#titleModal').innerHTML = "Actualizar Categoria";
    document.querySelector('#frmCategoria').reset();

    let base_url = 'http://localhost/Pos_venta/';
    $.ajax({
        url: base_url + 'Categorias/editar/' + id,
        type: "GET",
        dataType: "json",
        data: {
            id: id
        },
        success: function(resp) {
            $('#idCategoria').val(resp[0].id);
            $('#categoria').val(resp[0].nombre);
            $('#nueva_categoria').modal('show');
        }
    });

}

//eliminar
function eliminarCategoria(id) {

    let base_url = 'http://localhost/Pos_venta/';

    // Verificar la relación del categoria
    $.ajax({
        url: base_url + "Categorias/eliminar/" + id,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // No hay relación, eliminar directamente
                // eliminarCate(id);
                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    icon: 'success'
                });
                location.reload();
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
                        eliminarCate(id);
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

function eliminarCate(id) {

    let base_url = 'http://localhost/Pos_venta/';
    // Eliminar el categoria
    const url = base_url + "Categorias/deleteCategoria/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);

            if (resp.eliminado == true) {

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: resp.post,
                    showConfirmButton: false,
                    timer: 2200
                });
                location.reload()

            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: resp.msg,
                    showConfirmButton: false,
                    timer: 2200
                });
            }
        }
    }

}

//reingresar categoria
function reingresarCategoria(id) {
    let base_url = 'http://localhost/Pos_venta/';

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere reingresar el Categoría?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Restaurar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Categorias/reingresarCategoria/" + id;
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
                'La categoría no fue restaurada',
                'error'
            )
        }
    })
}

function openModalCategoria() {

    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Registrar";
    document.querySelector('#titleModal').innerHTML = "Nueva Categoría";
    document.querySelector('#frmCategoria').reset();
    $('#nueva_categoria').modal('show');
}