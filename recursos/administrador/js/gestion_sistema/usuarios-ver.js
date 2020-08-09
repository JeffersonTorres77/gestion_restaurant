/*================================================================================
 *
 *	Variables
 *
================================================================================*/
//Personal
var idFormPersonal = "form-personal";
var idBotonLimpiarPersonal = "boton-limpiar-personal";
//Cuenta
var idFormCuenta = "form-cuenta";
var idBotonLimpiarCuenta = "boton-limpiar-cuenta";
//Inputs
var idInputNombre = "usuario-nombre";
var idInputCedula = "usuario-cedula";
var idInputClave = "usuario-clave";





/*================================================================================
 *
 *	
 *
================================================================================*/
$("#" + idBotonLimpiarPersonal).on("click", function(e)
{
    $("#" + idFormPersonal)[0].reset();
});

/*================================================================================
 * 
================================================================================*/
function GuardarPersonal()
{
    /**
     * Datos
     */
    var url = `${HOST_ADMIN_AJAX}Gestion_Sistema/CRUD_Usuarios/`;
    var form = document.getElementById(idFormPersonal);
    var data = new FormData(form);
    data.append("accion", "MODIFICAR");

    /**
     * Peticion
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
            $("#" + idInputNombre).attr("value", data.nombre);
            $("#" + idInputCedula).attr("value", data.cedula);

            Loader.Ocultar();
            Alerta.Success("Usuario modificado exitosamente.");
        }
    });
}





/*================================================================================
 *
 *	
 *
================================================================================*/
$("#" + idBotonLimpiarCuenta).on("click", function(e)
{
    $("#" + idFormCuenta)[0].reset();
});

/*================================================================================
 * 
================================================================================*/
function GuardarCuenta()
{
    /**
     * Datos
     */
    var url = `${HOST_ADMIN_AJAX}Gestion_Sistema/CRUD_Usuarios/`;
    var form = document.getElementById(idFormCuenta);
    var data = new FormData(form);
    data.append("accion", "MODIFICAR");

    /**
     * Peticion
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
            $("#" + idInputClave).attr("value", "");
            $("#" + idInputClave).val("");
            
            Loader.Ocultar();
            Alerta.Success("Usuario modificado exitosamente.");
        }
    });
}