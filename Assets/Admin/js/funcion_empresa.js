function actualizarEmpresa(e) {
    e.preventDefault();
    let base_url = 'http://localhost/Pos_venta/';
    // const id = document.getElementById("id");
    // const valorCodificado = nomb.replace(/ /g, '+');
    // cod_producto = valorCodificado;
    const frm = document.getElementById("frmEmpresa")
    const url = base_url + "Dashboard/editar/";
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);

            if (resp.ok == true) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: resp.post,
                    showConfirmButton: false,
                    timer: 2200
                })
                window.location.reload();

            } else {

                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: resp.post,
                    showConfirmButton: false,
                    timer: 2200
                })
            }

        }
    }
}