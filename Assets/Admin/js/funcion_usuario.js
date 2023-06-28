//listar usuarios
document.addEventListener("DOMContentLoaded", function() {
    let base_url = 'http://localhost/Pos_venta/';

    $('#tableUsuarios').dataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
        dom: 'lBfrtip',
        "columnDefs": [
            { 'className': "textcenter", "targets": [5] }, //status
            { 'className': "textcenter", "targets": [4] }, //accion            
        ],
        "ajax": {
            "url": " " + base_url + "Usuarios/listar",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "usuario" },
            { "data": "nombre" },
            { "data": "caja" },
            { "data": "rol" },
            { "data": "estado" },
            { "data": "acciones" },

        ],
        buttons: [{
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Expotar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5]
                }
            }, {
                "extend": "csvHtml5",
                "text": "<i class='faa fa-file-csv'></i> CSV",
                "titleAttr": "Eportar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5]
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

//listar usuarios eliminados
document.addEventListener("DOMContentLoaded", function() {
    let base_url = 'http://localhost/Pos_venta/';

    $('#tableUsuariosEliminados').dataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
        dom: 'lBfrtip',
        "columnDefs": [
            { 'className': "textcenter", "targets": [5] }, //status
            { 'className': "textcenter", "targets": [4] }, //accion            
        ],
        "ajax": {
            "url": " " + base_url + "Usuarios/listarEliminados",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "usuario" },
            { "data": "nombre" },
            { "data": "caja" },
            { "data": "rol" },
            { "data": "estado" },
            { "data": "acciones" },

        ],
        buttons: [{
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Expotar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5]
                }
            }, {
                "extend": "csvHtml5",
                "text": "<i class='faa fa-file-csv'></i> CSV",
                "titleAttr": "Eportar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5]
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

//registrar usuario
function registrarUsuario(e) {
    e.preventDefault();

    const usuario = document.getElementById("usuario");
    const nombre = document.getElementById("nombre");
    const clave = document.getElementById("clave");
    const confirmar = document.getElementById("confirmar");
    const caja = document.getElementById("caja");
    const rol = document.getElementById("rol");

    if (usuario.value == "" || nombre.value == "" || caja.value == "" || clave == "" || confirmar == "" || rol == "") {

        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 2200
        })

    } else {
        let base_url = 'http://localhost/Pos_venta/';

        const url = base_url + "Usuarios/registrarUser";
        const frm = document.getElementById("frmUsuarios");
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
                    $('#nuevo_usuario').modal('hide');
                    window.location.reload();

                } else if (resp.modificado == true) {

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: resp.post,
                        showConfirmButton: false,
                        timer: 2200
                    })
                    $('#nuevo_usuario').modal('hide');
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
function editarUsuario(id) {

    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    document.querySelector('#titleModal').innerHTML = "Actualizar Usuario";
    document.querySelector('#frmUsuarios').reset();

    let base_url = 'http://localhost/Pos_venta/';
    $.ajax({
        url: base_url + 'Usuarios/editar/' + id,
        type: "GET",
        dataType: "json",
        data: {
            id: id
        },
        success: function(resp) {
            $('#idUsuario').val(resp[0].id);
            $('#usuario').val(resp[0].usuario);
            $('#nombre').val(resp[0].nombre);
            $('#caja').val(resp[0].id_caja);
            $('#rol').val(resp[0].rol);
            $('#clave').val(resp[0].clave);
            $('#nuevo_usuario').modal('show');
        }
    });
}
//eliminado
function usuarioEliminado() {
    let base_url = 'http://localhost/Pos_venta/';
    window.location = base_url + "Usuarios/usuarioEliminado";
}
//vaciar usuario
function usuarioVaciar() {
    let base_url = 'http://localhost/Pos_venta/';

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere vaciar los usuarios?',
        text: "Los usuarios se eliminarán permanentemente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Usuarios/vaciarUsuarios/";
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
                'Los usuarios no fueron vaciado',
                'error'
            )
        }
    })
}
//volver
function volverUsuarios() {
    let base_url = 'http://localhost/Pos_venta/';
    window.location = base_url + "usuarios";
}
//eliminar
function eliminarUsuario(id) {

    let base_url = 'http://localhost/Pos_venta/';

    // Verificar la relación del usuario
    $.ajax({
        url: base_url + "Usuarios/eliminar/" + id,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                console.log(response);
                // No hay relación, eliminar directamente
                eliminarUser(id);
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
                        eliminarUser(id);
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

function eliminarUser(id) {
    let base_url = 'http://localhost/Pos_venta/';

    // Eliminar el usuario
    $.ajax({
        url: base_url + "Usuarios/deleteUsuario/" + id,
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

//reingresar usuario
function reingresarUsuario(id) {
    let base_url = 'http://localhost/Pos_venta/';

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere reingresar el Usuario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Restaurar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Usuarios/reingresarUsuario/" + id;
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
                'El usuario no fue restaurado',
                'error'
            )
        }
    })
}
//cambiar password
function frmPass(e) {
    e.preventDefault();
    const actual = document.getElementById("clave_actual").value;
    const nueva = document.getElementById("clave_nueva").value;
    const confirmar = document.getElementById("confirmar_clave").value;

    if (actual == "" || nueva == "" || confirmar == "") {

        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 2200
        })
    } else {
        if (nueva != confirmar) {

            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Las contraseñas no coinciden.',
                showConfirmButton: false,
                timer: 2200
            })
        } else {
            let base_url = 'http://localhost/Pos_venta/';

            const url = base_url + "Usuarios/cambiarPass";
            const frm = document.getElementById("frmPass");
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
                        $('#pass').modal('hide');
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
}

//registrar permisos 
function registrarPermisos(e) {
    e.preventDefault();
    let base_url = 'http://localhost/Pos_venta/';

    const url = base_url + "Usuarios/RegistrarPermisos";
    const frm = document.getElementById("formulario")
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


function openModalUsuarios() {

    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Registrar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.getElementById("claves").classList.remove("d-none");
    document.querySelector('#frmUsuarios').reset();
    $('#nuevo_usuario').modal('show');
}