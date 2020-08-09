function CambiarServicio()
{
    var msj = "¿Esta seguro que desea modificar el servicio?";
    var r = confirm(msj);
    if(r == false) return;

    /**
     * Variables
     */
    var url = `${HOST_GERENCIAL_AJAX}Mesas/Servicio/`
    var data = new FormData();

    /**
     * Enviamos la petición
     */
    AJAX.Enviar({
        url: url,
        data: data,

        antes: function ()
        {
            Loader.Mostrar();
        },

        error: function (mensaje)
        {
            console.error("Error: " + mensaje);
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },

        ok: function (cuerpo)
        {            
            location.reload();
        }
    });
}