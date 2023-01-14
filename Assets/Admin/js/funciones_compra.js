
function buscarCodigo(e) {
  e.preventDefault();

  if (e.which == 13) {
    const cod = document.getElementById("codigo").value;
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
function calcularPrecio(e) {
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

            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: resp.post,
              showConfirmButton: false,
              timer: 1500
            })
            frm.reset();
            cargarDetalle();

          } else {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: resp.post,
              showConfirmButton: false,
              timer: 1500
            })
          }
        }
      }
    }
  }
}

function cargarDetalle() {
  const url = base_url + "Compras/listar";
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
                   <button class="btn btn-danger" title="Eliminar" type="button" onclick="deleteDetalle(${row['id']})"><i class="fas fa-trash-alt"></i></button>
                </td>            
                </tr>`
      });
      document.getElementById("tblDetalle").innerHTML = html;
      document.getElementById("total").value = resp.total_pagar.total;
    }

  }
}//eliminar detalle
function deleteDetalle(id) {
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