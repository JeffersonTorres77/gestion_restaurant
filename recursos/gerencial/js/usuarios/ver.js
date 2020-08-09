/*================================================================================
 *
 *	
 *
================================================================================*/
var form = document.getElementById("form-datos");

/*================================================================================
 *
 *	
 *
================================================================================*/
document.getElementById("input-activo-aux").onchange = function()
{
    if( document.getElementById("input-activo-aux").checked ) {
        document.getElementById("input-activo").value = "1";
    } else {
        document.getElementById("input-activo").value = "0";
    }
}

/*================================================================================
 *
 *	
 *
================================================================================*/
function GuardarDatos()
{
    if(Formulario.Validar(form.id) == false) return;

    /**
     * Parametros
     */
    var url = `${HOST_GERENCIAL_AJAX}Usuarios/CRUD/`;
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
            location.reload();
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