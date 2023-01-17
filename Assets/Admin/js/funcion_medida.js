
document.addEventListener("DOMContentLoaded", function () {
    $('#tableMedidas').dataTable({
       "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
       dom: 'lBfrtip',
       "columnDefs": [
          { 'className': "textcenter", "targets": [3] },  //status  
          { 'className': "textcenter", "targets": [4] },  //status           
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
       buttons: [
          {
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
       "iDisplayLength": 5,
       "order": [[0, "desc"]]
    });
 
 
 })
 
 //registrar caja
 function registrarMedida(e) {
    e.preventDefault();
 
    const nombre = document.getElementById("nombre");
    const nombre_corto = document.getElementById("nombre_corto");
 
    if (nombre.value == "" || nombre_corto.value == "") {
 
       alert("Error", "Todos los campos son obligatorios", "error");
 
    } else {
       const url = base_url + "Medidas/registrarMedida";
       const frm = document.getElementById("frmMedida");
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
                $('#nueva_medida').modal('hide');
                window.location.reload();
             } else if (resp.modificado == true) {
               Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: resp.post,
                  showConfirmButton: false,
                  timer: 1500
                })    
                $('#nueva_medida').modal('hide');
                window.location.reload();
             } else {
               Swal.fire({
                  position: 'top-end',
                  icon: 'error',
                  title: resp.post,
                  showConfirmButton: false,
                  timer: 1500
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
 
    const url = base_url + "Medidas/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
       if (this.readyState == 4 && this.status == 200) {
          const resp = JSON.parse(this.responseText);
 
          document.getElementById('idMedida').value = resp.id;
          document.getElementById("nombre").value = resp.nombre;
          document.getElementById("nombre_corto").value = resp.nombre_corto;
          $('#nueva_medida').modal('show');
       }
    }
 
 }
 
 //eliminar
 function eliminarMedida(id) {
 
    const swalWithBootstrapButtons = Swal.mixin({
       customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
       },
       buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
       title: '¿Realmente quiere eliminar el Medida?',
       text: "La medida no se eliminará de forma permanete, solo cambiará el estado de inactivo",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonText: 'Si, Eliminar!',
       cancelButtonText: 'No, cancel!',
       reverseButtons: true
    }).then((result) => {
       if (result.isConfirmed) {
          const url = base_url + "Medidas/deleteMedida/" + id;
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
             'La medida no fue eliminado',
             'error'
          )
       }
    })
 }
 //reingresar caja
 function reingresarMedida(id) {
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
             'La medida no fue restaurada',
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
 