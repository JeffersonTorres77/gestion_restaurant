/*================================================================================
 *
 *	Variables
 *
================================================================================*/
//Buscador
var buscador = new Buscador("input-buscador", "boton-buscador", "Actualizar");

//Tabla
var idTable = "tabla";
var tabla = new TablaGestion(idTable);

//Modal nuevo
var idModalNuevo = "modal-nuevo";
var idFormNuevo = "form-nuevo";

//Modal eliminar
var idModalEliminar = "modal-eliminar";
var idFormEliminar = "form-eliminar";
var idTextUsuarioEliminar = "text-usuario-eliminar";
var idInputUsuarioEliminar = "input-usuario-eliminar";





/*================================================================================
 *
 *	Actualizar datos
 *
================================================================================*/
function Actualizar()
{    
    /**
     * Parametros adicionales
     */
    var url = `${HOST_ADMIN_AJAX}Gestion_Sistema/CRUD_Usuarios/`;
    var data = new FormData();
    data.append("accion", "CONSULTAR");
    var parametros = Hash.getParametros();
    for(var key in parametros)
    {
        data.append(key, parametros[key]);
    }

    /**
     * Enviamos la petición
     */
    AJAX.Enviar({
        url: url,
        data: data,
        antes: function()
        {
            tabla.Cargando();
        },

        error: function(mensaje)
        {
            console.error(mensaje);
            tabla.Error();
            Alerta.Danger(mensaje);
        },

        ok: function(cuerpo)
        {
            tabla.Actualizar({
                cuerpo: cuerpo,
                funcion: 'Actualizar',
                accion: (tbody, data) =>
                {
                    for(var i=0; i<data.length; i++)
                    {
                        let dato = data[i];
                        if(dato == undefined) continue;
                        var link = HOST_ADMIN + `Gestion_Sistema/Usuarios/${dato.usuario}/`;

                        tbody.innerHTML +=
                        '<tr>' +
                        '   <td>' +
                        '       ' + dato.nombre +
                        '   </td>' +

                        '   <td class="no-movil">' +
                        '       ' + Formato.Numerico( dato.cedula ) +
                        '   </td>' +

                        '   <td class="no-movil">' +
                        '       ' + ( dato.usuario ).toUpperCase() +
                        '   </td>' +

                        '   <td center>' +
                        '       <a class="btn btn-sm btn-success text-white" href="'+link+'">' +
                        '           <i class="fas fa-eye"></i>' +
                        '       </a>' +
                        
                        '       <button class="btn btn-sm btn-danger" onclick="ModalEliminar('+i+')">' +
                        '           <i class="fas fa-trash-alt"></i>' +
                        '       </button>' +
                        '   </td>' +
                        '</tr>';
                    }
                }
            });
        }
    });
}

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
Actualizar();





/*================================================================================
 *
 *	Nuevo Usuario
 *
================================================================================*/
$("#" + idModalNuevo).on("hidden.bs.modal", function(e)
{
    $("#"+idFormNuevo)[0].reset();
});

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
function Nuevo()
{
    /**
     * Datos
     */
    var url = `${HOST_ADMIN_AJAX}Gestion_Sistema/CRUD_Usuarios/`;
    var form = document.getElementById(idFormNuevo);
    var data = new FormData(form);
    data.append("accion", "REGISTRAR");

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
            var usuario = cuerpo.usuario;
            var link = HOST_ADMIN + "Gestion_Sistema/Usuarios/"+usuario+"/";
            location.href = link;
        }
    });
}





/*================================================================================
 *
 *	Eliminar
 *
================================================================================*/
function ModalEliminar(fila)
{
    var dato = tabla.getData()[fila];
    $("#" + idInputUsuarioEliminar).val(dato.usuario);
    $("#" + idTextUsuarioEliminar)[0].innerHTML = dato.nombre;
    $("#" + idModalEliminar).modal("show");
}

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
function Eliminar()
{
    /**
     * Datos
     */
    var url = `${HOST_ADMIN_AJAX}Gestion_Sistema/CRUD_Usuarios/`;
    var form = document.getElementById(idFormEliminar);
    var data = new FormData(form);
    data.append("accion", "ELIMINAR");

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
            Actualizar();
            Loader.Ocultar();
            $("#"+idModalEliminar).modal("hide");
            var usuario = cuerpo.usuario;
            Alerta.Success("Usuario <b>"+usuario+"</b> eliminado exitosamente.");
        }
    });
}