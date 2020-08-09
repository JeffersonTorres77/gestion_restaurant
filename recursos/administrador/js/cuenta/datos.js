/**
 * Función para habilitar o desabilitar el boton
 * @param {*} event 
 * @param {*} element 
 */
function CambioClave(event, element)
{
    var boton = document.getElementById("boton-guardar-clave");
    
    if(element.value == "") {
        boton.className = "btn btn-outline-secondary";
    } else {
        boton.className = "btn btn-success";
    }
}

/**
 * Guardar Contraseña
 */
function GuardarClave()
{
    /**
     * Elementos
     */
    var form = document.getElementById("form-cuenta");
    var inputClave = document.getElementById("usuario-clave");

    /**
     * Data
     */
    var data = new FormData(form);
    data.append("accion", "MODIFICAR");

    /**
     * Enviar Petición
     */
    AJAX.Enviar({
        url: `${HOST_ADMIN_AJAX}Gestion_Sistema/CRUD_Usuarios/`,
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
        ok: function(data)
        {
            inputClave.value = "";
            var boton = document.getElementById("boton-guardar-clave");
            boton.className = "btn btn-outline-secondary";
            Loader.Ocultar();
            Alerta.Success("Cuenta modificada exitosamente.");
        }
    });
}