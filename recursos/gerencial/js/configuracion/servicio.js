/**
 * 
 */
var form = document.getElementById('form-servicio');
var imagenComanda = {
    label: document.getElementById('label-imgcomanda-restaurant'),
    input: document.getElementById('img-comanda-restaurant')
};
var imagenCombo = {
    label: document.getElementById('label-imgcombo-restaurant'),
    input: document.getElementById('img-combo-restaurant')
};

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

/*================================================================================
 *
 *	
 *
================================================================================*/
imagenComanda.input.onchange = function()
{
    var input = this;
    var label = imagenComanda.label;
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

imagenCombo.input.onchange = function()
{
    
    var input = this;
    var label = imagenCombo.label;
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