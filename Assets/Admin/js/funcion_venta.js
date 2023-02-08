let cod_productoV;
function buscarCodigoVenta(e) {
    e.preventDefault();
  
    if (e.which == 13) {
      const cod = document.getElementById("codigo").value;   
      cod_productoV = cod;   
      const url = base_url + "Ventas/buscarVenta/" + cod;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const resp = JSON.parse(this.responseText);
  
         
          if(resp.post == "Producto agotado." || resp.post == "Producto no existe.") {
         
            alert(resp.post, "error"); 

            document.getElementById("descripcion").value = "Descripcion del producto";
            document.getElementById("cantidad").value = "0.00";
            document.getElementById("precio").value = "0.00";
            document.getElementById("sub_total").value = "0.00";
            document.getElementById("iva").value = "0.00";
            document.getElementById("precio").focus()
          }else{
            
            document.getElementById("descripcion").value = resp.descripcion;
            document.getElementById("precio").value = resp.precio_venta;
            document.getElementById("iva").value = resp.iva;
            document.getElementById("id").value = resp.id;
            document.getElementById("cantidad").removeAttribute('disabled');
            document.getElementById("cantidad").focus();
          }
  
  
        }
      }
    }
  
}
//buscar cliente 
function buscarCliente(e){
  e.preventDefault();
  if (e.which == 13) {
    const cliente = document.getElementById("cliente").value;      
    const url = base_url + "Ventas/buscarCliente/" + cliente;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const resp = JSON.parse(this.responseText);

        if (resp) {
          document.getElementById("nombre").value = resp.nombre;        
          document.getElementById("ID").value = resp.id;          
        } else {
          Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'El cliente no existe',
            showConfirmButton: false,
            timer: 1500
          })  
          document.getElementById("cliente").value = "";
          document.getElementById("cliente").focus()
        }


      }
    }
  }
  
}

//calcular cantidad
function calcularPrecioVenta(e) {
    e.preventDefault();
    const cant = document.getElementById("cantidad").value;
    const precio = document.getElementById("precio").value;
    const iva = document.getElementById("iva").value;
    const subTotal =  precio * cant
    const subIva = (subTotal * iva) / 100 ;
    document.getElementById("sub_total").value = subIva +  subTotal;
   if (e.which == 13) {
      if (cant > 0) {
        const url = base_url + "Ventas/ingresar";
        const frm = document.getElementById("frmVenta");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {         
            const resp = JSON.parse(this.responseText);
  
            if (resp.modificado == true) {  
              alert(resp.post, "success"); 
              frm.reset();
              cargarDetalle();
              document.getElementById("cantidad").setAttribute('disabled', 'disabled');
              document.getElementById("codigo").focus()
  
            } else if (resp.actualizado == true) {

              alert(resp.post, "success"); 
              frm.reset();
              cargarDetalle();
              document.getElementById("cantidad").setAttribute('disabled', 'disabled');
              document.getElementById("codigo").focus()
  
            } else {
              alert(resp.post, "error"); 
              document.getElementById("cantidad").value = "";
            }
          }
        }
      }
    }
  }

  //mostar detalles del producto de la compra
function cargarDetalle() {
  const url = base_url + "Ventas/listar";
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
                <td><input class="form-control" placeholder="Descuento" type="text" onkeyup="calcularDescuento(event,${row['id']})"></td>
                <td>${row['descuento']}</td>
                <td>${row['precio']}</td>
                <td>${row['iva']}</td>
                <td>${row['sub_total']}</td>     
                <td>
                   <button class="btn btn-danger" title="Eliminar" type="button" onclick="deleteDetalle(${row['id']})"><i class="fas fa-trash-alt"></i></button>
                </td>            
                </tr>`
      });
      document.getElementById("tblDetalle").innerHTML = html;
      document.getElementById("total").value = resp.total_pagar.total;
    }

  }
}
//calcular decuento
function calcularDescuento(e, id){
        e.preventDefault();

        if (e.target.value == '') {
          alert("Ingrese el descuento", "error"); 

        }else{

          if (e.which == 13) {            
            const url = base_url + "Ventas/calcularDescuento/" +id +"/"+e.target.value;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
              if (this.readyState == 4 && this.status == 200) {
                  const resp = JSON.parse(this.responseText);
                  if (resp.modificado == true) {
                    alert(resp.post, "success");
                    cargarDetalle();
                  } else {
                     alert(resp.post, "error");                  
                  
                  } 
              }
          }
        }
     }
}
//eliminar detalle
function deleteDetalle(id) {
  id_producto = id;
  const url = base_url + "Ventas/delete/" + id;
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
        cargarDetalle();
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

//generar venta
function generarVenta(){

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
       const url = base_url + "Ventas/registrarVenta/" + cod_productoV;
       const frm = document.getElementById("frmVentas");
       const http = new XMLHttpRequest();
       http.open("POST", url, true);
       http.send(new FormData(frm));
       http.onreadystatechange = function () {

          if (this.readyState == 4 && this.status == 200) {
             const resp = JSON.parse(this.responseText);             
             if (resp.modificado == true) {
                swalWithBootstrapButtons.fire(
                   'Venta generada!',
                   resp.post,
                   'success',                 
                );
                const ruta = base_url + 'Ventas/generarPDF/' + resp.id_venta;
                window.open(ruta);
                setTimeout(() =>{
                  window.location.reload();
                 },300);
             } else {
                swalWithBootstrapButtons.fire(
                   'Venta Cancelado!',
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


//anular compra
function btnAnularV(id){
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
       confirmButton: 'btn btn-success',
       cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
 })
 swalWithBootstrapButtons.fire({
    title: '¿Está seguro de anular la venta?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Si, Aceptar!',
    cancelButtonText: 'No, cancel!',
    reverseButtons: true
 }).then((result) => {
    if (result.isConfirmed) {
       const url = base_url + "Ventas/anularVenta/" + id;
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
          'La anulación de la venta no se realizó',
          'error'
       )
    }
 })
}

document.addEventListener("DOMContentLoaded", function () {
   
  $('#tableHistorialVentas').dataTable({
     "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
     dom: 'lBfrtip',
     "columnDefs": [
      
    { 'className': "textcenter", "targets": [4] },  //status           
     ],
     "ajax": {
        "url": " " + base_url + "Ventas/listar_historial",
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
     "iDisplayLength": 5,
     "order": [[0, "desc"]]
  });


})
function alert(msm, icon){
  Swal.fire({
     position: 'top-end',
     icon: icon,
     title: msm,
     showConfirmButton: false,
     timer: 1500
   })      
}
  