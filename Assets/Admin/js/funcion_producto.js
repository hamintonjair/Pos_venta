
document.addEventListener("DOMContentLoaded", function () {
   $('#tableProductos').dataTable({
      "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
      dom: 'lBfrtip',
      "columnDefs": [
         { 'className': "textcenter", "targets": [7] }, //accion
         { 'className': "textcenter", "targets": [6] }, //accion
         { 'className': "textcenter", "targets": [5] }, //status
         { 'className': "textleft", "targets": [4] },  //stock            
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
         { "data": "precio_venta" },
         { "data": "cantidad" },
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
               "columns": [0, 2, 3, 4, 5]
            }
         }, {
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr": "Expotar a Excel",
            "className": "btn btn-success",
            "exportOptions": {
               "columns": [0, 2, 3, 4, 5]
            }
         }, {
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr": "Exportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": {
               "columns": [0, 2, 3, 4, 5]
            }
         }, {
            "extend": "csvHtml5",
            "text": "<i class='faa fa-file-csv'></i> CSV",
            "titleAttr": "Eportar",
            "className": "btn btn-secondary",
            "exportOptions": {
               "columns": [0, 2, 3, 4, 5]
            }
         },

      ],
      "resonsieve": "true",
      "bDestroy": true,
      "iDisplayLength": 10,
      "order": [[0, "desc"]]
   });

})

//registrar producto
function registrarProducto(e) {
   e.preventDefault();

   const codigo = document.getElementById("codigo");
   const descripcion = document.getElementById("descripcion");
   const precio_venta = document.getElementById("precio_venta");
   const precio_compra = document.getElementById("precio_compra");
   const medida = document.getElementById("id_medida");
   const categoria = document.getElementById("id_categoria");
   const proveedor = document.getElementById("id_proveedor");

   if (codigo.value == "" || descripcion.value == "" || precio_venta.value == "" || precio_compra.value == "" || medida.value == "" || categoria.value == "" || proveedor.value == "") {

      alert("Error", "Todos los campos son obligatorios", "error");

   } else {
      const url = base_url + "Productos/registrarProductos";
      const frm = document.getElementById("frmProductos");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
         if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);

            if (resp.ok == true) {
               alert(resp.post, "success");
               $('#nuevo_producto').modal('hide');
               window.location.reload();
            } else if (resp.modificado == true) {
               alert(resp.post, "success");
               $('#nuevo_producto').modal('hide');
               window.location.reload();
            } else {
               alert(resp.post, "error");
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

   const url = base_url + "Productos/editar/" + id;
   const http = new XMLHttpRequest();
   http.open("GET", url, true);
   http.send();
   http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
         const resp = JSON.parse(this.responseText);

         document.getElementById('idProducto').value = resp.id;
         document.getElementById("codigo").value = resp.codigo;;
         document.getElementById("descripcion").value = resp.descripcion;
         document.getElementById("precio_venta").value = resp.precio_venta;
         document.getElementById("precio_compra").value = resp.precio_compra;
         document.getElementById("id_medida").value = resp.id_medida;
         document.getElementById("id_categoria").value = resp.id_categoria;
         document.getElementById("id_proveedor").value = resp.id_proveedor;
         document.getElementById("img-preview").src = base_url + "Assets/img/" + resp.foto;
         document.getElementById("icon-cerrar").innerHTML = `<button class="btn btn-danger" 
          onclick="deletImg()"><i class="fas fa-times"></i></button>`;
         document.getElementById("icon-image").classList.add("d-none");
         document.getElementById("foto_actual").value = resp.foto;
         $('#nuevo_producto').modal('show');
      }
   }
}

//eliminar
function eliminarProducto(id) {

   const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
         confirmButton: 'btn btn-success',
         cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
   })
   swalWithBootstrapButtons.fire({
      title: '¿Realmente quiere eliminar el Producto?',
      text: "El producto no se eliminará de forma permanete, solo cambiará el estado de inactivo",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Si, Eliminar!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
   }).then((result) => {
      if (result.isConfirmed) {
         const url = base_url + "Productos/deleteProducto/" + id;
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
            'El producto no fue eliminado',
            'error'
         )
      }
   })
}
//reingresar producto
function reingresarProducto(id) {
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
      timer: 1500
   })
}
if (document.getElementById('stockMinimo')) {
   reportStock();
   productosVendidos();
   
}

function reportStock() {
   const url = base_url + "Configuracion/reportStock";
   const http = new XMLHttpRequest();
   http.open("GET", url, true);
   http.send();
   http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
         const resp = JSON.parse(this.responseText);

         let nombre = [];
         let cantidad = [];
         for (let i = 0; i < resp.length; i++) {
            nombre.push(resp[i]['descripcion']);
            cantidad.push(resp[i]['cantidad']);

         }
         const ctxe = document.getElementById('stockMinimo');
         new Chart(ctxe, {
            type: 'pie',
            data: {
               labels: nombre,
               datasets: [{
                  data: cantidad,
                  backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745','#EC7063', '#5499C7', '#45B39D', '#F4D03F','#F39C12','#707B7C ']
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
function productosVendidos() {
   const url = base_url + "Configuracion/productosVendidos";
   const http = new XMLHttpRequest();
   http.open("GET", url, true);
   http.send();
   http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
         const resp = JSON.parse(this.responseText);

         let nombre = [];
         let cantidad = [];
         for (let i = 0; i < resp.length; i++) {
            nombre.push(resp[i]['descripcion']);
            cantidad.push(resp[i]['total']);

         }
         const ctx = document.getElementById('productosVendidos');
         new Chart(ctx, {
            type: 'doughnut',
            data: {
               labels: nombre,
               datasets: [{
                  data: cantidad,
                  backgroundColor: ['#EC7063', '#5499C7', '#45B39D', '#F4D03F','#EB984E','#138D75','#7D3C98','#9A7D0A','#566573','#1D8348 ']
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
   function openModalProductos() {

      document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
      document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
      document.querySelector('#btnText').innerHTML = "Registrar";
      document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
      document.querySelector('#frmProductos').reset();
      $('#nuevo_producto').modal('show');
      deletImg();
   }
