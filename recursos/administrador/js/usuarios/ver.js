/*================================================================================
 *
 *	
 *
================================================================================*/
var idFormPersonal = "form-personal";
var idFormCuenta = "form-cuenta";

/*================================================================================
 *
 *	
 *
================================================================================*/
document.getElementById("input-cuenta-activo-aux").onchange = function()
{
    if( document.getElementById("input-cuenta-activo-aux").checked ) {
        document.getElementById("input-cuenta-activo").value = "1";
    } else {
        document.getElementById("input-cuenta-activo").value = "0";
    }
}

/*================================================================================
 *
 *	
 *
================================================================================*/
function LimpiarPersonal()
{
    document.getElementById(idFormPersonal).reset();
}

function GuardarPersonal()
{
    /**
     * Validamos
     */
    if(Formulario.Validar(idFormPersonal) == false) return;

    /**
     * Variables
     */
    var url = `${HOST_ADMIN_AJAX}Usuarios/CRUD/`;
    var form = document.getElementById(idFormPersonal);
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
            Formulario.Sync(idFormPersonal);
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
function LimpiarCuenta()
{
    document.getElementById(idFormCuenta).reset();
}

function GuardarCuenta()
{
    /**
     * Validamos
     */
    if(Formulario.Validar(idFormCuenta) == false) return;

    /**
     * Variables
     */
    var url = `${HOST_ADMIN_AJAX}Usuarios/CRUD/`;
    var form = document.getElementById(idFormCuenta);
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
            Formulario.Sync(idFormPersonal);
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
document.getElementById("img-foto-usuario").onchange = function()
{
    var input = this;
    var label = document.getElementById("label-foto-usuario");
    var img = label.getElementsByTagName("img")[0];

    if(input.files.length <= 0) {
        return;
    }

    var file = input.files[0];
    var reader = new FileReader();

    reader.onload = function(e)
    {
        img.src = e.target.result;
    }

    reader.readAsDataURL( file );
}