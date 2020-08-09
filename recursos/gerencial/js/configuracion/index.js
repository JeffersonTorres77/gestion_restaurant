/*================================================================================
 *
 *	
 *
================================================================================*/
var idFormBasico = "form-basico";
var idFormRedes = "form-redes";
var idFormOtros= "form-otros";

/*================================================================================
 *
 *	
 *
================================================================================*/
$("#opciones-basico").on("show.bs.tab", function(e) { location.hash = "basico/"; });
$("#opciones-redes").on("show.bs.tab", function(e) { location.hash = "redes/"; });
$("#opciones-otros").on("show.bs.tab", function(e) { location.hash = "otros/"; });

if(location.hash != "")
{
    var hash = location.hash;
    hash = hash.replace("#", "");
    switch(hash)
    {
        case "basico/":
            document.getElementById("opciones-basico").click();
        break;

        case "redes/":
            document.getElementById("opciones-redes").click();
        break;

        case "otros/":
            document.getElementById("opciones-otros").click();
        break;
    }
}

/*================================================================================
 *
 *	
 *
================================================================================*/
function ModificarBasico()
{
    /**
     * Parametros
     */
    var url = `${HOST_GERENCIAL_AJAX}Configuracion/CRUD_Restaurantes/`;
    var form = document.getElementById(idFormBasico);
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
            Formulario.Sync(idFormBasico);
            Loader.Ocultar();
            Alerta.Success("Restaurant modificado exitosamente.");
        }
    });
}

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
function LimpiarBasico()
{
    var form = document.getElementById(idFormBasico);
    form.reset();
}

/*================================================================================
 *
 *	
 *
================================================================================*/
function ModificarRedes()
{
    /**
     * Parametros
     */
    var url = `${HOST_GERENCIAL_AJAX}Configuracion/CRUD_Restaurantes/`;
    var form = document.getElementById(idFormRedes);
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
            Formulario.Sync(idFormRedes);
            Loader.Ocultar();
            Alerta.Success("Restaurant modificado exitosamente.");
        }
    });
}

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
function LimpiarRedes()
{
    var form = document.getElementById(idFormRedes);
    form.reset();
}

/*================================================================================
 *
 *	
 *
================================================================================*/
document.getElementById("img-logo-restaurant").onchange = function()
{
    var input = this;
    var label = document.getElementById("label-logo-restaurant");
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

/*================================================================================
 *
 *	
 *
================================================================================*/
document.getElementById("img-comanda-restaurant").onchange = function()
{
    var input = this;
    var label = document.getElementById("label-imgcomanda-restaurant");
    var imgcomanda = label.getElementsByTagName("img")[0];

    if(input.files.length <= 0) {
        return;
    }

    var file = input.files[0];
    var reader = new FileReader();

    reader.onload = function(e)
    {
        imgcomanda.src = e.target.result;
    }

    reader.readAsDataURL( file );
}

document.getElementById("img-combo-restaurant").onchange = function()
{
    
    var input = this;
    var label = document.getElementById("label-imgcombo-restaurant");
    var imgcobo = label.getElementsByTagName("img")[0];

    if(input.files.length <= 0) {
        return;
    }

    var file = input.files[0];
    var reader = new FileReader();

    reader.onload = function(e)
    {
        imgcobo.src = e.target.result;
    }

    reader.readAsDataURL( file );
}

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
function LimpiarOtros()
{
    var form = document.getElementById(idFormOtros);
    form.reset();
}

function ModificarOtros()
{
    /**
     * Parametros
     */
    var url = `${HOST_GERENCIAL_AJAX}Configuracion/CRUD_Restaurantes/`;
    var form = document.getElementById(idFormOtros);
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
            Formulario.Sync(idFormOtros);
            Loader.Ocultar();
            Alerta.Success("Restaurant modificado exitosamente.");
        }
    });
}