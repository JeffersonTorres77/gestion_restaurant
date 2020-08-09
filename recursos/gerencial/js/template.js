function MenuLateral() {
    if (document.body.className == "sb-nav-fixed sb-sidenav-toggled") {
        document.body.className = "sb-nav-fixed";
    }
    else {
        document.body.className = "sb-nav-fixed sb-sidenav-toggled";
    }
}

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