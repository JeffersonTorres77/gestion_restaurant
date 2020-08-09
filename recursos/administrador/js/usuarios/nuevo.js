function ClickBoton()
{
    document.getElementById("form-nuevo").onsubmit();
}

document.getElementById("form-nuevo").onsubmit = function() { Registrar(); }

function Registrar()
{
    /**
     * Validamos
     */
    if(Formulario.Validar("form-nuevo") == false) return;

    /**
     * Variables
     */
    var url = `${HOST_ADMIN_AJAX}Usuarios/CRUD/`;
    var form = document.getElementById("form-nuevo");
    var data = new FormData(form);

    data.append("accion", "REGISTRAR");

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
            var link = HOST_ADMIN + "Usuarios/Ver/"+id+"/";
            location.href = link;
        }
    });
}