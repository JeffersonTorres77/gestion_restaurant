function MenuLateral() {
    if (document.body.className == "sb-nav-fixed sb-sidenav-toggled") {
        document.body.className = "sb-nav-fixed";
    }
    else {
        document.body.className = "sb-nav-fixed sb-sidenav-toggled";
    }
}
function CerrarSesion() {
    var url = HOST_ADMIN_AJAX + "Salir/";
    var method = "POST";
    var dataType = "json";
    var data = {};

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
            location.href = HOST_ADMIN + "Login/";
        }
    });
}
