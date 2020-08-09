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

//Eliminar
var idEliminar = {
    modal: "modal-eliminar",
    form: "form-eliminar",
    boton: "botom-eliminar",
    inputId: "input-idCombo-eliminar",
    textNombre: "label-nombre-eliminar"
};

/*--------------------------------------------------------------------------------
 * 
 * Actualizar
 * 
--------------------------------------------------------------------------------*/
function Actualizar()
{
    /**
     * Parametros adicionales
     */
    var url = `${HOST_GERENCIAL_AJAX}Menus/CRUD/`;
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
                        //Verificamos que la data no sea nula
                        let dato = data[i];
                        if(dato == undefined) continue;

                        var textoActivo = "Si";
                        var claseActivo = "badge badge-success";
                        if(!dato.activo) {
                            textoActivo = "No";
                            claseActivo = "badge badge-danger";
                        }

                        var linkModificar = HOST_GERENCIAL+"Menus/Modificar/"+dato.id+"/";
                        var linkVer = HOST_GERENCIAL+"Menus/Ver/"+dato.id+"/";

                        //Aqui imprimimos la data
                        tbody.innerHTML +=
                        '<tr>' +
                        '   <td>' +
                        '       <div class="d-flex align-items-center">' +
                        '           <div class="plato-miniatura mr-2">' +
                        '               <img class="float-left" src="'+dato.imagen+'">' +
                        '           </div>' +
                        '           ' + dato.nombre + 
                        '       </div>' +
                        '   </td>' +

                        '   <td style="vertical-align: middle;" center>' +
                        '       ' + Formato.Numerico( dato.descuento, 2 ) + "%" +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +
                        '       <div class="'+claseActivo+'">' +
                        '           ' + textoActivo +
                        '       </div>' +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +        
                        '       <a class="btn btn-sm btn-success" href="'+linkVer+'">' +
                        '           <i class="fas fa-eye"></i>' +
                        '       </a>' +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +        
                        '       <a class="btn btn-sm btn-warning" href="'+linkModificar+'">' +
                        '           <i class="fas fa-edit"></i>' +
                        '       </a>' +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +        
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

//Ejecutamos la funcion actualizar al cargar la pagina o de inmediato
Actualizar();

/*--------------------------------------------------------------------------------
 * 
 * Ver
 * 
--------------------------------------------------------------------------------*/
function ModalVer(fila)
{
    var datos = tabla.getData()[fila];
    var modal = $("#" + idVer.modal);

    document.getElementById(idVer.img).src = datos.imagen;

    modal.modal("show");
}

/*--------------------------------------------------------------------------------
 * 
 * Eliminar
 * 
--------------------------------------------------------------------------------*/
function ModalEliminar(fila)
{
    var datos = tabla.getData()[fila];
    var modal = $("#" + idEliminar.modal);
    var inputId = document.getElementById(idEliminar.inputId);
    var textNombre = document.getElementById(idEliminar.textNombre);

    inputId.value = datos.id;
    textNombre.innerHTML = datos.nombre;

    modal.modal("show");
}

function Eliminar()
{
    /**
     * Parametros
     */
    var url = `${HOST_GERENCIAL_AJAX}Menus/CRUD/`;
    var modal = $("#" + idEliminar.modal);
    var form = document.getElementById(idEliminar.form);
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
            Alerta.Success("Se ha eliminado el combo exitosamente.");
        }
    });
}