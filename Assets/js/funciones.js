let tblUsuarios;

document.addEventListener("DOMContentLoaded", function(){
    tblUsuarios = $(document).ready(function () {
        $('#tblUsuarios').DataTable({
            ajax:{
                url: base_url + "Usuarios/listar",
                dataSrc: ''
            },
            columns: [
                { data: 'id' },
                { data: 'usuario' },
                { data: 'nombre' },
                { data: 'id_caja' },
            ],
        });
    })
})

function frmLogin(e){
    e.preventDefault();

    const usuarios = document.getElementById("usuario");
    const clave = document.getElementById("clave");
    if(usuarios.value == ""){
        clave.classList.remove("is-invalid");
        usuarios.classList.add("is-invalid");
        usuarios.focus();
    }else if(clave.value == ""){
        usuarios.classList.remove("is-invalid");
        clave.classList.add("is-invalid");
        clave.focus();
    }else{
        const url = base_url + "Usuarios/validar";
        const frm = document.getElementById("frmLogin");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
               const resp = JSON.parse(this.responseText);

               if(resp == "ok"){
               window.location = base_url + "Usuarios";
               }else{
                document.getElementById("alerta").classList.remove("d-none");
                document.getElementById("alerta").innerHTML = resp;
               }
            }
        }
    }

}
