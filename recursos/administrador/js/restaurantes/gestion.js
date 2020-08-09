/*================================================================================
 *
 *	Variables
 *
================================================================================*/
//Tabla
var idTabla = "tabla";
var tabla = new TablaGestion(idTabla);

//Buscador
var buscador = new Buscador("input-buscador", "boton-buscador", "Actualizar");

//Modal
var idModal = "modal-cambiar-acceso";
var idForm = "form-cambiar-acceso";
var idLabelText = "label-cambiar-acceso";
var idInputId = "id-cambiar-acceso";

/*================================================================================
 *
 *	Actualizar datos
 *
================================================================================*/

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
Actualizar();

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
function Actualizar()
{
    /**
     * Parametros adicionales
     */
    var url = `${HOST_ADMIN_AJAX}Restaurantes/CRUD/`;
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

                        var link = HOST_ADMIN + `Restaurantes/Gestion/${dato.id}/`;

                        var claseActivo = "badge badge-success";
                        if(!dato.activo) {
                            claseActivo = "badge badge-danger";
                        }


                        tbody.innerHTML +=
                        '<tr class="table-sm">' +
                        '   <td>' +
                        '       <a href="'+link+'">' +
                        '           <div class="d-flex align-items-center">' +
                        '               <img class="mr-2 rounded float-left img-thumbnail" style="width: 48px; height: 48px;" src="'+dato.logo+'">' +
                        '               ' + dato.nombre + 
                        '           </div>' +
                        '       </a>' +
                        '   </td>' +

                        '   <td class="no-table" style="vertical-align: middle;">' +
                        '       ' + dato.documento +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +
                        '       <div class="'+claseActivo+'">' +
                        '           ' + Formato.bool2text( dato.activo ) +
                        '       </div>' +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +        
                        '       <button class="btn btn-sm btn-warning" onclick="CambiarAcceso('+i+')">' +
                        '           <i class="fas fa-power-off"></i>' +
                        '       </button>' +
                        '   </td>' +
                        '</tr>';
                    }
                }
            });
        }
    });
}

/*================================================================================
 *
 *	CAMBIAR ACCESO
 *
================================================================================*/
function CambiarAcceso(fila)
{
    var datos = tabla.getData()[fila];
    var label = document.getElementById(idLabelText);
    var inputId = document.getElementById(idInputId);

    inputId.setAttribute("value", datos.id);

    if(datos.activo) {
        label.innerHTML = '¿Esta seguro que desea <b>desactivar</b> el restaurant <b>'+datos.nombre+'</b>?';
    } else {
        label.innerHTML = '¿Esta seguro que desea <b>activar</b> el restaurant <b>'+datos.nombre+'</b>?';
    }

    $("#" + idModal).modal("show");
}

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
function ModificarAcceso()
{
    /**
     * Parametros adicionales
     */
    var url = `${HOST_ADMIN_AJAX}Restaurantes/CRUD/`;
    var form = document.getElementById(idForm);
    var data = new FormData(form);
    data.append("accion", "ELIMINAR");

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
            Actualizar();
            Loader.Ocultar();
            $("#" + idModal).modal("hide");
            Alerta.Success("Se ha modificado el restaurant exitosamente.");
        }
    });
}