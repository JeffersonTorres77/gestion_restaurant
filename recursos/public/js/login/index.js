var idBotonAcceso = "BotonAcceso";
var idInputCode = "input-code";
var idInputUsuario = "input-usuario";
var idInputClave = "input-clave";

$("#" + idInputCode).keyup(function (e) {
    if (e.key == "Enter") {
        $("#" + idInputUsuario).select();
    }
});

$("#" + idInputUsuario).keyup(function (e) {
    if (e.key == "Enter") {
        $("#" + idInputClave).select();
    }
});

$("#" + idInputClave).keyup(function (e) {
    if (e.key == "Enter") {
        Acceder();
    }
});

$("#" + idBotonAcceso).click(function (e) {
    Acceder();
});

function Acceder() {
    if (!ValidarLogin()) {
        return;
    }

    var code = $("#" + idInputCode).val();
    var usuario = $("#" + idInputUsuario).val();
    var clave = $("#" + idInputClave).val();
    var url = HOST_AJAX + "Login/Acceder/";
    var data = new FormData();
    data.append("code", code);
    data.append("usuario", usuario);
    data.append("clave", clave);

    AJAX.Enviar({
        url: url,
        data: data,

        antes: function ()
        {
            Loader.Mostrar();
        },

        error: function(mensaje)
        {
            $("#" + idInputClave).val("");
            $("#" + idInputUsuario).select();
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },
        ok: function (cuerpo)
        {
            location.reload();
        }
    });
}
function ValidarLogin() {
    var inputCode = $("#" + idInputCode);
    var inputUsuario = $("#" + idInputUsuario);
    var inputClave = $("#" + idInputClave);

    var code = inputCode.val();
    var usuario = inputUsuario.val();
    var clave = inputClave.val();
    
    if (code == "") {
        Alerta.Danger("El codigo no puede estar vacio.");
        inputCode.select();
        return false;
    }
    if (usuario == "") {
        Alerta.Danger("El usuario no puede estar vacio.");
        inputUsuario.select();
        return false;
    }
    if (clave == "") {
        Alerta.Danger("La contraseña no puede estar vacia.");
        inputClave.select();
        return false;
    }
    return true;
}