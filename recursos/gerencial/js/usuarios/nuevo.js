function ClickBoton()
{
    document.getElementById("form-nuevo").onsubmit();
}

document.getElementById("form-nuevo").onsubmit = function() { Registrar(); }

function Registrar()
{
    /**
     * Parametros
     */
    var url = `${HOST_GERENCIAL_AJAX}Usuarios/CRUD/`;
    var form = document.getElementById("form-nuevo");
    var data = new FormData(form);
    data.append("accion", "REGISTRAR");
    
    if(Formulario.Validar("form-nuevo") == false) return;

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
            var id = cuerpo.id;
            var link = HOST_GERENCIAL + "Usuarios/Ver/"+id+"/";
            location.href = link;
        }
    });
}