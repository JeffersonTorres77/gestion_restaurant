/**
 * Variables
 */
var idBotonAcceso = "BotonAcceso";
var idInputUsuario = "input-usuario";
var idInputClave = "input-clave";

/**
 * Eventos
 */
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

/**
 * Acceder al sistema
 */
function Acceder() {
    /**
     * Validamos
     */
    if (!ValidarLogin()) {
        return;
    }

    /**
     * Data
     */
    var usuario = $("#" + idInputUsuario).val();
    var clave = $("#" + idInputClave).val();
    var data = new FormData();
    data.append("usuario", usuario);
    data.append("clave", clave);

    /**
     * Parametros
     */
    var objeto = {
        url: `${HOST_ADMIN_AJAX}Login/Acceder/`,
        data: data,
        antes: function() {
            Loader.Mostrar();
        },
        error: function(mensaje) {
            $("#" + idInputClave).val("");
            $("#" + idInputUsuario).select();
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },
        ok: function(data) {
            location.reload();
        }
    };

    /**
     * Enviamos
     */
    AJAX.Enviar(objeto);
}

/**
 * Validar Login
 */
function ValidarLogin()
{
    /**
     * Elementos
     */
    var inputUsuario = $("#" + idInputUsuario);
    var inputClave = $("#" + idInputClave);

    /**
     * Valores
     */
    var usuario = inputUsuario.val();
    var clave = inputClave.val();

    /**
     * Condicionales
     */
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

    /**
     * Respuesta
     */
    return true;
}
