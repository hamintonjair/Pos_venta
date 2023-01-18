document.addEventListener("DOMContentLoaded", function () {
   $('#tableClientes').dataTable({
      "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
      dom: 'lBfrtip',
      "columnDefs": [
         { 'className': "textcenter", "targets": [6] }, //accion
         { 'className': "textcenter", "targets": [5] },  //status            
      ],
      "ajax": {
         "url": " " + base_url + "Clientes/listar",
         "dataSrc": ""
      },
      "columns": [
         { "data": "id" },
         { "data": "dni" },
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
      "order": [[0, "desc"]]
   });


})

//registrar cliente
function registrarCliente(e) {
   e.preventDefault();

   const dni = document.getElementById("dni");
   const nombre = document.getElementById("nombre");
   const telefono = document.getElementById("telefono");
   const direccion = document.getElementById("direccion");


   if (dni.value == "" || nombre.value == "" || telefono.value == "" || direccion.value == "") {

      alert("Error", "Todos los campos son obligatorios", "error");

   } else {
      const url = base_url + "Clientes/registrarCliente";
      const frm = document.getElementById("frmCliente");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
         if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);

            if (resp.ok == true) {
               alert(resp.post, "success"); 
               $('#nuevo_cliente').modal('hide');
               window.location.reload();
            } else if (resp.modificado == true) {

               alert(resp.post, "success"); 
               $('#nuevo_cliente').modal('hide');
               window.location.reload();
            } else {
               alert(resp.post, "error"); 
            }

         }
      }
   }

}
//editar
function editarCliente(id) {

   document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
   document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
   document.querySelector('#btnText').innerHTML = "Actualizar";
   document.querySelector('#titleModal').innerHTML = "Actualizar Cliente";
   document.querySelector('#frmCliente').reset();

   const url = base_url + "Clientes/editar/" + id;
   const http = new XMLHttpRequest();
   http.open("GET", url, true);
   http.send();
   http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
         const resp = JSON.parse(this.responseText);

         document.getElementById('idCliente').value = resp.id;
         document.getElementById("dni").value = resp.dni;
         document.getElementById("nombre").value = resp.nombre;
         document.getElementById("telefono").value = resp.telefono;
         document.getElementById("direccion").value = resp.direccion;
         $('#nuevo_cliente').modal('show');
      }
   }

}

//eliminar
function eliminarCliente(id) {

   const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
         confirmButton: 'btn btn-success',
         cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
   })
   swalWithBootstrapButtons.fire({
      title: '¿Realmente quiere eliminar el Cliente?',
      text: "El cliente no se eliminará de forma permanete, solo cambiará el estado de inactivo",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Si, Eliminar!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
   }).then((result) => {
      if (result.isConfirmed) {
         const url = base_url + "Clientes/deleteCliente/" + id;
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
            'El cliente no fue eliminado',
            'error'
         )
      }
   })
}
//reingresar cliente
function reingresarCliente(id) {
   const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
         confirmButton: 'btn btn-success',
         cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
   })
   swalWithBootstrapButtons.fire({
      title: '¿Realmente quiere reingresar el Cliente?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Si, Restaurar!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
   }).then((result) => {
      if (result.isConfirmed) {
         const url = base_url + "Clientes/reingresarCliente/" + id;
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
            'El cliente no fue restaurado',
            'error'
         )
      }
   })
}

function alert(msm, icon){
   Swal.fire({
      position: 'top-end',
      icon: icon,
      title: msm,
      showConfirmButton: false,
      timer: 1500
    })      
}

function openModalCliente() {

   document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
   document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
   document.querySelector('#btnText').innerHTML = "Registrar";
   document.querySelector('#titleModal').innerHTML = "Nuevo Cliente";
   document.querySelector('#frmCliente').reset();
   $('#nuevo_cliente').modal('show');
}
