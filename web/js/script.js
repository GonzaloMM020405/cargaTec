document.addEventListener("DOMContentLoaded", function () {
    var btnCancelar = document.getElementById("btnCancelar");
    var txtUsuario = document.getElementById("txtUsuario");
    var txtPwd = document.getElementById("txtPwd");

    btnCancelar.addEventListener("click", function () {
        txtUsuario.value = "";
        txtPwd.value = "";
    });
});
