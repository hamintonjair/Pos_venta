
document.addEventListener("DOMContentLoaded", function () {
   $('#tableCajas').dataTable({
      "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
      dom: 'lBfrtip',
      "columnDefs": [
         { 'className': "textcenter", "targets": [3] },  //status  
         { 'className': "textcenter", "targets": [2] },  //status           
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
      buttons: [
         {
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
      "iDisplayLength": 5,
      "order": [[0, "desc"]]
   });


})

//registrar caja
function registrarCaja(e) {
   e.preventDefault();

   const caja = document.getElementById("caja");

   if (caja.value == "") {

      alert("Todos los campos son obligatorios", "error");

   } else {
      const url = base_url + "Cajas/registrarCaja";
      const frm = document.getElementById("frmCaja");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
         if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);

            if (resp.ok == true) {
               alert(resp.post, "success");
               $('#nueva_caja').modal('hide');
               window.location.reload();
            } else if (resp.modificado == true) {

               alert(resp.post, "success");
               $('#nueva_caja').modal('hide');
               window.location.reload();
            } else {

               alert(resp.post, "error");
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

   const url = base_url + "Cajas/editar/" + id;
   const http = new XMLHttpRequest();
   http.open("GET", url, true);
   http.send();
   http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
         const resp = JSON.parse(this.responseText);

         document.getElementById('idCaja').value = resp.id;
         document.getElementById("caja").value = resp.caja;
         $('#nueva_caja').modal('show');
      }
   }

}

//eliminar
function eliminarCaja(id) {

   const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
         confirmButton: 'btn btn-success',
         cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
   })
   swalWithBootstrapButtons.fire({
      title: '¿Realmente quiere eliminar el Caja?',
      text: "El caja no se eliminará de forma permanete, solo cambiará el estado de inactivo",
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
            'El caja no fue eliminado',
            'error'
         )
      }
   })
}
//reingresar caja
function reingresarCaja(id) {
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
            'El caja no fue restaurada',
            'error'
         )
      }
   })
}
function openArqueo() {
   window.location = base_url + "cajas/arqueo";
}
//abrir modal
function arqueoCaja() {

   $('#abrir_caja').modal('show');
}
function abrirArqueo(e) {
   e.preventDefault();
   const monto_inicial = document.getElementById("monto_inicial").value;
   if (monto_inicial == "") {
      alert("Ingrese el monto inicial", "warning");
   } else {
      const frmAbrirCaja = document.getElementById("frmAbrirCaja");
      const url = base_url + "Cajas/abrirArqueo";
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frmAbrirCaja));
      http.onreadystatechange = function () {
         if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);

            if (resp.ok == true) {
               alert(resp.post, "success");             
               $('#abrir_caja').modal('hide');
            } else{
               alert(resp.post, "warning");            
            }
          
         }
      }
   }
}
//arqueo
document.addEventListener("DOMContentLoaded", function () {
   $('#tableArqueoCajas').dataTable({
      "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
      dom: 'lBfrtip',
      "columnDefs": [
         { 'className': "textcenter", "targets": [8] },  //status  
              
      ],
      "ajax": {
         "url": " " + base_url + "Cajas/listarArqueo",
         "dataSrc": ""
      },
      "columns": [
         { "data": "id" },
         { "data": "id_usuario" },
         { "data": "monto_inicial" },
         { "data": "monto_final" },
         { "data": "fecha_apertura" },
         { "data": "fecha_cierre" },
         { "data": "total_ventas" },
         { "data": "monto_total" },
         { "data": "estado" },

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
      "iDisplayLength": 5,
      "order": [[0, "desc"]]
   });


})

//cerrar caja
function cerrarArqueo(){

   const url = base_url + "Cajas/consultarVentas";
   const http = new XMLHttpRequest();
   http.open("GET", url, true);
   http.send();
   http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
         const resp = JSON.parse(this.responseText);    
          document.getElementById('monto_final').value = resp.monto_total.total;    
          document.getElementById('total_ventas').value = resp.total_ventas.total;      
            $('#abrir_caja').modal('show');
        
       
      }
   }

   // const swalWithBootstrapButtons = Swal.mixin({
   //    customClass: {
   //       confirmButton: 'btn btn-success',
   //       cancelButton: 'btn btn-danger'
   //    },
   //    buttonsStyling: false
   // })
   // swalWithBootstrapButtons.fire({
   //    title: '¿Está seguro de cerrar la caja?',
   //    icon: 'warning',
   //    showCancelButton: true,
   //    confirmButtonText: 'Si, Aceptar!',
   //    cancelButtonText: 'No, cancel!',
   //    reverseButtons: true
   // }).then((result) => {
   //    if (result.isConfirmed) {
   //       const url = base_url + "Cajas/cerrar";
   //       const http = new XMLHttpRequest();
   //       http.open("GET", url, true);
   //       http.send();
   //       http.onreadystatechange = function () {
  
   //          if (this.readyState == 4 && this.status == 200) {
   //            const resp = JSON.parse(this.responseText);
              
   //            if (resp.modificado == true) {
   //              swalWithBootstrapButtons.fire(
   //                 'Atención!',
   //                 resp.post,
   //                 'success',                 
   //              );                        
   //              setTimeout(() =>{
   //                window.location.reload();
   //               },300);
   //           } else {
   //              swalWithBootstrapButtons.fire(
   //                 'Atención!',
   //                 resp.msg,
   //                 'error'
   //              );
   //           }
  
   //          }
   //       }
  
   //    } else if (
   //       /* Read more about handling dismissals below */
   //       result.dismiss === Swal.DismissReason.cancel
   //    ) {
   //       swalWithBootstrapButtons.fire(
   //          'Cancelado!',
   //          'La caja no se cerró',
   //          'error'
   //       )
   //    }
   // })
}


function alert(msm, icon) {
   Swal.fire({
      position: 'top-end',
      icon: icon,
      title: msm,
      showConfirmButton: false,
      timer: 1500
   })
}
function openModalCaja() {

   document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
   document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
   document.querySelector('#btnText').innerHTML = "Registrar";
   document.querySelector('#titleModal').innerHTML = "Nuevo Caja";
   document.querySelector('#frmCaja').reset();
   $('#nueva_caja').modal('show');
}
