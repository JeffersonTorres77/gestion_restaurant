/**
 * 
 */
var form = document.getElementById('form-redes');

/**
 * 
 */
form.onsubmit = function() { GuardarCambios(event); }

/**
 * 
 */
function GuardarCambios(e)
{
    e.preventDefault();

    /**
     * Parametros
     */
    var url = `${HOST_GERENCIAL_AJAX}Configuracion/CRUD_Restaurantes/`;
    var data = new FormData(form);
    data.append("accion", "MODIFICAR");

    /**
     * Enviamos la petición
     */
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
            Formulario.Sync(form.id);
            Loader.Ocultar();
            Alerta.Success("Restaurant modificado exitosamente.");
        }
    });
}