/*================================================================================
 *
 *	
 *
================================================================================*/
var idFormBasico = "form-basico";
var idFormRedes = "form-redes";

/*================================================================================
 *
 *	
 *
================================================================================*/
$("#opciones-basico").on("show.bs.tab", function(e) { location.hash = "basico/"; });
$("#opciones-redes").on("show.bs.tab", function(e) { location.hash = "redes/"; });
$("#opciones-roles").on("show.bs.tab", function(e) { location.hash = "roles/"; });

if(location.hash != "")
{
    var hash = location.hash;
    hash = hash.replace("#", "");
    switch(hash)
    {
        case "redes/":
            document.getElementById("opciones-redes").click();
        break;

        case "roles/":
            document.getElementById("opciones-roles").click();
        break;
    }
}

/*================================================================================
 *
 *	
 *
================================================================================*/
document.getElementById("input-basico-activo-aux").onchange = function()
{
    if( document.getElementById("input-basico-activo-aux").checked ) {
        document.getElementById("input-basico-activo").value = "1";
    } else {
        document.getElementById("input-basico-activo").value = "0";
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
     * Variables
     */
    var url = `${HOST_ADMIN_AJAX}Restaurantes/CRUD/`;
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
     * Variables
     */
    var url = `${HOST_ADMIN_AJAX}Restaurantes/CRUD/`;
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
var listaRoles = [];

/**
 * 
 */
function ActualizarRoles()
{
    var tbody = document.getElementById("tbody");
    var url = `${HOST_ADMIN_AJAX}Restaurantes/CRUD_Roles/`;
    var data = new FormData();
    data.append("accion", "CONSULTAR");
    data.append("idRestaurant", ID_RESTAURANT);

    AJAX.Enviar({
        url: url,
        data: data,
        antes: function() {
            Loader.Mostrar();
        },
        error: function(mensaje) {
            tbody.innerHTML = `<tr>
                <td colspan="2" center>
                    <h5 class="my-2">${mensaje}</h5>
                    <button class="my-2 btn btn-sm btn-primary" onclick="ActualizarRoles()">
                        <i class="fas fa-sync"></i>
                    </button>
                </td>
            </tr>`;

            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },
        ok: function(data) {
            listaRoles = data;

            var codeHTML = "";
            for(var keyRol in data)
            {
                var rol = data[keyRol];
                var classStatus = (rol.status) ? 'success' : 'danger';
                var textStatus = (rol.status) ? 'Si' : 'No';

                codeHTML += `<tr>
                    <td style="vertical-align: middle;" left>
                        ${rol.nombre}
                    </td>
                    
                    <td style="vertical-align: middle;" center>
                        <button class="btn btn-sm btn-${classStatus}" onclick="ModificarRol(${keyRol})">
                            ${textStatus}
                            <i class="ml-3 fas fa-sync"></i>
                        </button>
                    </td>
                </tr>`;
            }

            tbody.innerHTML = codeHTML;

            Loader.Ocultar();
        }
    });
}

function ModificarRol(keyRol)
{
    var objRol = listaRoles[keyRol];
    var url = `${HOST_ADMIN_AJAX}Restaurantes/CRUD_Roles/`;
    var data = new FormData();
    data.append("accion", "MODIFICAR");
    data.append("idRestaurant", ID_RESTAURANT);
    data.append("idRol", objRol.id);

    AJAX.Enviar({
        url: url,
        data: data,
        antes: function() {
            Loader.Mostrar();
        },
        error: function(mensaje) {
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },
        ok: function(data) {
            ActualizarRoles();
            Loader.Ocultar();
        }
    });
}

/**
 * 
 */
ActualizarRoles();





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