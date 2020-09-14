/**
 * 
 */
function MenuLateral() {
    if (document.body.className == "sb-nav-fixed sb-sidenav-toggled") {
        document.body.className = "sb-nav-fixed";
    }
    else {
        document.body.className = "sb-nav-fixed sb-sidenav-toggled";
    }
}

/**
 * 
 */
function CerrarSesion() {
    var url = HOST_GERENCIAL_AJAX + "Salir/";
    var data = new FormData();

    AJAX.Enviar({
        url: url,
        data: data,

        antes: function()
        {
            Loader.Mostrar();
        },

        error: function(mensaje)
        {
            alert(mensaje);
            Loader.Ocultar();
        },

        ok: function(cuerpo)
        {
            location.href = HOST_GERENCIAL + "Login/";
        }
    });
}

/**
 * 
 */
function CambiarServicio()
{
    var msj = "¿Esta seguro que desea modificar el servicio?";
    var r = confirm(msj);
    if(r == false) return;

    /**
     * Variables
     */
    var url = `${WEBSOCKET_URL}Servicio/Cambiar/`;
    var data = new FormData();
    data.append("key", KEY);
    data.append("authService", false);

    /**
     * Enviamos la petición
     */
    AJAX.api({
        url: url,
        data: data,

        antes: function ()
        {
            Loader.Mostrar();
        },

        error: function (mensaje)
        {
            if(mensaje == "404") mensaje = "Servicio WebSocket no disponible.";
            console.error(mensaje);
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },

        ok: function (cuerpo)
        {            
            location.reload();
        }
    });
}

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})