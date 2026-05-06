function getBaseURL() {
    // Intentar obtener desde el meta tag o usar fallback
    const metaUrl = document.querySelector('meta[name="base-url"]');
    if (metaUrl) {
        return metaUrl.getAttribute('content');
    }
    // Fallback para desarrollo local
    return 'http://localhost/Pos_venta/';
}
document.addEventListener("DOMContentLoaded", function() {

    let formulario = document.querySelector("#frmLogin");
    formulario.onsubmit = function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        let base_url = getBaseURL();
        const usuarios = document.querySelector('#usuario').value;
        const clave = document.querySelector('#clave').value;

        if (usuarios == "" || clave == "") {
            alerta('Error', 'Todos los campos son obligatorios.', 'error');

        } else {
            $.ajax({
                type: 'post',
                url: base_url + 'Login/validar',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.ok === true) {
                        alerta('Success', response.post, 'success');
                        window.location = base_url + 'dashboard/inicio';

                    } else {
                        alerta('Error', response.post, 'error');

                    }
                }

            });
        }
    };
})



function alerta(title, text, icon) {
    Swal.fire({
        title,
        text,
        icon,
    })

}