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

//Filtros
var filtro = new Filtro("filtros", "form-filtro", "boton-filtro", "Actualizar");

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
    var url = `${HOST_ADMIN_AJAX}Usuarios/CRUD/`;
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

                        var link = HOST_ADMIN + `Usuarios/Ver/${dato.id}/`;

                        var claseActivo = "badge badge-success";
                        if(!dato.activo) {
                            claseActivo = "badge badge-danger";
                        }


                        tbody.innerHTML +=
                        '<tr class="tab le-sm">' +
                        '   <td>' +
                        '       <a href="'+link+'">' +
                        '           <div class="d-flex align-items-center">' +
                        '               <div class="usuario-miniatura mr-2">' +
                        '                   <img class="float-left" src="'+dato.foto+'">' +
                        '               </div>' +
                        '               ' + dato.nombre + 
                        '           </div>' +
                        '       </a>' +
                        '   </td>' +

                        '   <td style="vertical-align: middle;">' +
                        '       ' + dato.usuario +
                        '   </td>' +

                        '   <td style="vertical-align: middle;">' +
                        '       ' + dato.restaurant +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +
                        '       <div class="'+claseActivo+'">' +
                        '           ' + Formato.bool2text( dato.activo ) +
                        '       </div>' +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +        
                        '       <button class="btn btn-sm btn-warning" onclick="CambiarActivo('+i+')">' +
                        '           <i class="fas fa-power-off"></i>' +
                        '       </button>' +
                          
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

/*================================================================================
 *
 *	Nuevo Usuario
 *
================================================================================*/
function NuevoUsuario()
{
    var idRestaurant = document.getElementsByName("idRestaurant-nuevo")[0].value;
    var link = HOST_ADMIN + "Usuarios/Nuevo/"+idRestaurant+"/";
    location.href = link;
}

/*================================================================================
 *
 *	
 *
================================================================================*/
function CambiarActivo(fila)
{
    /**
     * Variables
     */
    var datos = tabla.getData()[fila];
    var id = datos.id;
    var activo = (datos.activo) ? '0' : '1';

    /**
     * Parametros
     */
    var url = `${HOST_ADMIN_AJAX}Usuarios/CRUD/`;
    var data = new FormData();

    data.append("accion", "MODIFICAR");
    data.append("idUsuario", id);
    data.append("activo", activo);

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
            Alerta.Success("Cambio de estatus realizado exitosamente.");
        }
    });
}

/*================================================================================
 *
 *	
 *
================================================================================*/
function ModalEliminar(fila)
{
    var datos = tabla.getData()[fila];
    var modal = $("#modal-eliminar");
    var inputUsuario = document.getElementById("input-eliminar-usuario");
    var text = document.getElementById("text-eliminar");

    inputUsuario.value = datos.id;
    text.innerHTML = "¿Esta seguro que desea eliminar el usuario <b>"+datos.usuario+"</b>?";
    modal.modal("show");
}

function Eliminar()
{
    /**
     * Parametros
     */
    var url = `${HOST_ADMIN_AJAX}Usuarios/CRUD/`;
    var modal = $("#modal-eliminar");
    var form = document.getElementById("form-eliminar");
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
            modal.modal("hide");
            Alerta.Success("Se ha eliminado al usuario exitosamnte.");
        }
    });
}