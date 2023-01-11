
document.addEventListener("DOMContentLoaded", function () {
    $('#tableProveedores').dataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
        dom: 'lBfrtip',
        "columnDefs": [
            { 'className': "textcenter", "targets": [6] }, //status
            { 'className': "textcenter", "targets": [7] },  //accion            
        ],
        "ajax": {
            "url": " " + base_url + "Proveedores/listar",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "nit" },
            { "data": "razon_social" },
            { "data": "nombre" },
            { "data": "telefono" },
            { "data": "direccion" },
            { "data": "estado" },
            { "data": "acciones" },

        ],
        buttons: [
            {
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
                    "columns": [0, 1, 2, 3, 45, 6, 7]
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
        "order": [[0, "desc"]]
    });


})

//registrar usuario
function registrarProveedor(e) {
    e.preventDefault();

    const nit = document.getElementById("nit");
    const razon_social = document.getElementById("razon_social");
    const nombre = document.getElementById("nombre");
    const telefono = document.getElementById("telefono");
    const direccion = document.getElementById("direccion");


    if (nit.value == "" || razon_social.value == "" || nombre.value == "" || telefono.value == "" || direccion.value == "") {

        alert("Error", "Todos los campos son obligatorios", "error");

    } else {
        const url = base_url + "Proveedores/registrarProveedor";
        const frm = document.getElementById("frmProveedores");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const resp = JSON.parse(this.responseText);

                if (resp.ok == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: resp.post,
                        showConfirmButton: false,
                        timer: 1500
                      })       
                    $('#nuevo_proveedor').modal('hide');
                    location.reload();
               
                } else if (resp.modificado == true) {

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: resp.post,
                        showConfirmButton: false,
                        timer: 1500
                      })       
                    $('#nuevo_proveedor').modal('hide');
                    location.reload();
                
                } else {
                    alert("Error", resp.post, "error");
                }

            }
        }
    }

}
//editar
function editarProveedor(id) {

    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    document.querySelector('#titleModal').innerHTML = "Actualizar Proveedor";
    document.querySelector('#frmProveedores').reset();

    const url = base_url + "Proveedores/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);

            document.getElementById('idProveedor').value = resp.id;
            document.getElementById("nit").value = resp.nit;
            document.getElementById("razon_social").value = resp.razon_social;
            document.getElementById("nombre").value = resp.nombre;
            document.getElementById("telefono").value = resp.telefono;
            document.getElementById("direccion").value = resp.direccion;
            $('#nuevo_proveedor').modal('show');
        }
    }

}

//eliminar
function eliminarProveedor(id) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere eliminar el Proveedor?',
        text: "El proveedor no se eliminará de forma permanete, solo cambiará el estado de inactivo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Proveedores/deleteProveedor/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {

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
                'El proveedor no fue eliminado',
                'error'
            )
        }
    })
}
//reingresar usuario
function reingresarProveedor(id) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere reingresar el Proveedor?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Restaurar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Proveedores/reingresarProveedor/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {

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
                'El proveedor no fue restaurado',
                'error'
            )
        }
    })
}

function openModalProveedor() {

    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Registrar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Proveedor";
    document.querySelector('#frmProveedores').reset();
    $('#nuevo_proveedor').modal('show');
}
