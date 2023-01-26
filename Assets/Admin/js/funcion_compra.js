let cod_producto;
let id_producto;
let t_h_c;
function buscarCodigo(e) {
  e.preventDefault();

  if (e.which == 13) {
    const cod = document.getElementById("codigo").value;
    cod_producto= document.getElementById("codigo").value;
    const url = base_url + "Compras/buscarCodigo/" + cod;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const resp = JSON.parse(this.responseText);

        if (resp) {
          document.getElementById("descripcion").value = resp.descripcion;
          document.getElementById("precio").value = resp.precio_venta;
          document.getElementById("id").value = resp.id;
          document.getElementById("cantidad").removeAttribute('disabled');
          document.getElementById("cantidad").focus();
        } else {
          Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Producto no existe',
            showConfirmButton: false,
            timer: 1500
          })
          document.getElementById("descripcion").value = "Descripcion del producto";
          document.getElementById("cantidad").value = "0.00";
          document.getElementById("precio").value = "0.00";
          document.getElementById("sub_total").value = "0.00";
          document.getElementById("precio").focus()
        }


      }
    }
  }

}
//calcular cantidad
function calcularPrecioC(e) {
  e.preventDefault();
  const cant = document.getElementById("cantidad").value;
  const precio = document.getElementById("precio").value;
  document.getElementById("sub_total").value = precio * cant;
 if (e.which == 13) {
    if (cant > 0) {
      const url = base_url + "Compras/ingresar";
      const frm = document.getElementById("frmCompra");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {         
          const resp = JSON.parse(this.responseText);

          if (resp.modificado == true) {

            alert(resp.post, "success"); 
            frm.reset();
            cargarDetalleC();

          } else if (resp.actualizado == true) {
            alert(resp.post, "success"); 
            frm.reset();
            cargarDetalleC();

          } else {
            alert(resp.post, "error"); 
          }
          document.getElementById("cantidad").setAttribute('disabled', 'disabled');
          document.getElementById("codigo").focus()
        }
      }
    }
  }
}

//mostar detalles del producto de la compra
function cargarDetalleC() {
  const url = base_url + "Compras/listarC";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const resp = JSON.parse(this.responseText);
      let html = '';

      resp.detalle.forEach(row => {
            
        html += `<tr>
                <td>${row['id']}</td>
                <td>${row['descripcion']}</td>
                <td>${row['cantidad']}</td>
                <td>${row['precio']}</td>
                <td>${row['sub_total']}</td>     
                <td>
                   <button class="btn btn-danger" title="Eliminar" type="button" onclick="deleteDetalleC(${row['id']})"><i class="fas fa-trash-alt"></i></button>
                </td>            
                </tr>`
      });
      document.getElementById("tblDetalleC").innerHTML = html;
      document.getElementById("total").value = resp.total_pagar.total;
    }

  }
}
//eliminar detalle
function deleteDetalleC(id) {
  id_producto = id;
  const url = base_url + "Compras/delete/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const resp = JSON.parse(this.responseText);
      if (resp.modificado == true) {
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: resp.post,
          showConfirmButton: false,
          timer: 1500
        })
        cargarDetalleC();
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
//generar compra
function generarCompra(){

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
       confirmButton: 'btn btn-success',
       cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
 })
 swalWithBootstrapButtons.fire({
    title: '¿Está seguro de realizar la compra?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Si, Aceptar!',
    cancelButtonText: 'No, cancel!',
    reverseButtons: true
 }).then((result) => {
    if (result.isConfirmed) {
       const url = base_url + "Compras/registrarCompra/" + cod_producto;
       const http = new XMLHttpRequest();
       http.open("GET", url, true);
       http.send();
       http.onreadystatechange = function () {

          if (this.readyState == 4 && this.status == 200) {
             const resp = JSON.parse(this.responseText);

             if (resp.modificado == true) {
                swalWithBootstrapButtons.fire(
                   'Compra generada!',
                   resp.post,
                   'success',                 
                );
                const ruta = base_url + 'Compras/generarPDF/' + resp.id_compra;
                window.open(ruta);
                setTimeout(() =>{
                  window.location.reload();
                 },300);
             } else {
                swalWithBootstrapButtons.fire(
                   'Compra Cancelado!',
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
          'La compra no se realizó',
          'error'
       )
    }
 })
}

document.addEventListener("DOMContentLoaded", function () {
  $('#tableHistorial').dataTable({
     "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
     dom: 'lBfrtip',
     "columnDefs": [
        { 'className': "textcenter", "targets": [2] },  //status  
           
     ],
     "ajax": {
        "url": " " + base_url + "Compras/listar_historial",
        "dataSrc": ""
     },
     "columns": [
        { "data": "id" },
        { "data": "nombre" },
        { "data": "total" },
        { "data": "fecha" },       
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

//anular compra
function btnAnularC(id){
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
       confirmButton: 'btn btn-success',
       cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
 })
 swalWithBootstrapButtons.fire({
    title: '¿Está seguro de anular la compra?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Si, Aceptar!',
    cancelButtonText: 'No, cancel!',
    reverseButtons: true
 }).then((result) => {
    if (result.isConfirmed) {
       const url = base_url + "Compras/anularCompra/" + id;
       const http = new XMLHttpRequest();
       http.open("GET", url, true);
       http.send();
       http.onreadystatechange = function () {

          if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);
            
            if (resp.modificado == true) {
              swalWithBootstrapButtons.fire(
                 'Atención!',
                 resp.post,
                 'success',                 
              );                        
              setTimeout(() =>{
                window.location.reload();
               },300);
           } else {
              swalWithBootstrapButtons.fire(
                 'Atención!',
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
          'La anulación de la compra no se realizó',
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
