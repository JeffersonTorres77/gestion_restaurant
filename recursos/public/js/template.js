const CARPETA_RESTAURANT = HOST + "recursos/restaurantes/";
var llamando_camarero = false;

/**==================================================================
 * Cerrar Sesión
 ===================================================================*/
 // Variables
var cerrar_sesion = {
    modal: "modal-cerrarSesion",
    form: "form-cerrarSesion",
    boton: "boton-cerrarSesion"
};

//Modal
function ModalCerrarSesion()
{
    var modal = $("#" + cerrar_sesion.modal);

    modal.modal("show");
}

//Evento
$("#" + cerrar_sesion.modal).on("hidden.bs.modal", function(e)
{
    location.hash = "/";
    document.getElementById(cerrar_sesion.form).reset();
});

//Boton
document.getElementById(cerrar_sesion.boton).onclick = function() { CerrarSesion(); }

//Cerrar sesión
function CerrarSesion()
{
    var url = `${HOST_AJAX}Salir/`;
    var form = document.getElementById(cerrar_sesion.form);
    var data = new FormData(form);

    if(Formulario.Validar(cerrar_sesion.form) == false) return;

    AJAX.Enviar({
        url: url,
        data: data,

        antes: function()
        {
            Loader.Mostrar();
        },

        error: function(mensaje)
        {
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },

        ok: function(cuerpo)
        {
            location.href = HOST + "Login/";
        }
    });
}

/**==================================================================
 * Menu lateral
 ===================================================================*/
function MenuLateral()
{
    if (document.body.className == "sb-nav-fixed sb-sidenav-toggled")
    {
        document.body.className = "sb-nav-fixed";
    }
    else
    {
        document.body.className = "sb-nav-fixed sb-sidenav-toggled";
    }
}

/**
 * 
 */
function LlamarCamarero()
{
    var url = WEBSOCKET_URL + "Camarero/Llamar/";
    var data = new FormData();
    data.append("key", KEY);

    AJAX.api({
        url: url,
        data: data,

        antes: function() {
            Loader.Mostrar();
        },
        error: function(mensaje) {
            Loader.Ocultar();
            if(mensaje == "404") mensaje = "Servicio de WebSocket no activo.";
            Alerta.Danger(mensaje);
        },
        ok: function(data) {
            Loader.Ocultar();
            llamando_camarero = data.status;
            CambiarColorBotonCamarero(llamando_camarero);
            IntervalLlamarCamarero();
        }
    });
}

/**
 * 
 */
IntervalLlamarCamarero();
function IntervalLlamarCamarero()
{
    ConsultarLLamadoCamarero();
    setTimeout(function() {
        if(llamando_camarero) {
            IntervalLlamarCamarero();
        }
    }, 2000);
}

/**
 * 
 */
function ConsultarLLamadoCamarero()
{
    var url = WEBSOCKET_URL + "Camarero/Consultar/";
    var data = new FormData();
    data.append("key", KEY);

    AJAX.api({
        url: url,
        data: data,

        antes: function() {
        },
        error: function(mensaje) {
            if(mensaje == "404") mensaje = "Servicio de WebSocket no activo.";
            Alerta.Danger(mensaje);
        },
        ok: function(data) {
            var llamando = data.status;
            llamando_camarero = data.status;
            CambiarColorBotonCamarero(llamando);
        }
    });
}

/**
 * 
 * @param {*} llamando 
 */
function CambiarColorBotonCamarero(llamando)
{
    var botonCamarero = document.getElementById('boton-camarero');
    if(llamando)
    {
        botonCamarero.className = "btn btn-sm text-warning";
    }
    else
    {
        botonCamarero.className = "btn btn-sm";
    }
}