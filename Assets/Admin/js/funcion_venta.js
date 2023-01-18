function buscarCodigoVenta(e) {
    e.preventDefault();
  
    if (e.which == 13) {
      const cod = document.getElementById("codigo").value;      
      const url = base_url + "Ventas/buscarVenta/" + cod;
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
function calcularPrecioVenta(e) {
    e.preventDefault();
    const cant = document.getElementById("cantidad").value;
    const precio = document.getElementById("precio").value;
    document.getElementById("sub_total").value = precio * cant;
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
            //   cargarDetalle();
  
            } else if (resp.actualizado == true) {
              alert(resp.post, "success"); 
              frm.reset();
            //   cargarDetalle();
  
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
  