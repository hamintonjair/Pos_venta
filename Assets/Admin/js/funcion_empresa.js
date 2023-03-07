function actualizarEmpresa(e) {
    e.preventDefault();

    const frm = document.getElementById("frmEmpresa")
    const url = base_url + "Configuracion/editar/" + id;
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
                    timer: 1500
                })
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