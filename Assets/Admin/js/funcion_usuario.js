
document.addEventListener("DOMContentLoaded", function () {
   $('#tableUsuarios').dataTable({
      "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
      dom: 'lBfrtip',
      "columnDefs": [
         { 'className': "textcenter", "targets": [5] }, //status
         { 'className': "textcenter", "targets": [4] },  //accion            
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
      "order": [[0, "desc"]]
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

   if (usuario.value == "" || nombre.value == "" || caja.value == "") {

      alert("Error", "Todos los campos son obligatorios", "error");

   } else {
      const url = base_url + "Usuarios/registrarUser";
      const frm = document.getElementById("frmUsuarios");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
         if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);

            if (resp.ok == true) {
               alert(resp.post, "success");              
               $('#nuevo_usuario').modal('hide');
               window.location.reload();
               
            } else if (resp.modificado == true) {
               
               alert(resp.post, "success");                 
               $('#nuevo_usuario').modal('hide');
               window.location.reload();
            } else {

               alert(resp.post, "error");     
             
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

   const url = base_url + "Usuarios/editar/" + id;
   const http = new XMLHttpRequest();
   http.open("GET", url, true);
   http.send();
   http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
         const resp = JSON.parse(this.responseText);

         document.getElementById('idUsuario').value = resp.id;
         document.getElementById("usuario").value = resp.usuario;
         document.getElementById("nombre").value = resp.nombre;
         document.getElementById("caja").value = resp.id_caja;
         document.getElementById("claves").classList.add("d-none");
         $('#nuevo_usuario').modal('show');
      }
   }

}

//eliminar
function eliminarUsuario(id) {

   const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
         confirmButton: 'btn btn-success',
         cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
   })
   swalWithBootstrapButtons.fire({
      title: '¿Realmente quiere eliminar el Usuario?',
      text: "El usuario no se eliminará de forma permanete, solo cambiará el estado de inactivo",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Si, Eliminar!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
   }).then((result) => {
      if (result.isConfirmed) {
         const url = base_url + "Usuarios/deleteUsuario/" + id;
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
            'El usuario no fue eliminado',
            'error'
         )
      }
   })
}
//reingresar usuario
function reingresarUsuario(id) {
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
            'El usuario no fue restaurado',
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
function openModalUsuarios() {

   document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
   document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
   document.querySelector('#btnText').innerHTML = "Registrar";
   document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
   document.getElementById("claves").classList.remove("d-none");
   document.querySelector('#frmUsuarios').reset();
   $('#nuevo_usuario').modal('show');
}
