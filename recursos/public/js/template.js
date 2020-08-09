const CARPETA_RESTAURANT = HOST + "recursos/restaurantes/";

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