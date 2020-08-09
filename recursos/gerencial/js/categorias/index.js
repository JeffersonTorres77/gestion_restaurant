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

/*--------------------------------------------------------------------------------
 * 
 * Aqui lo que hacemos es solicitar la informacion mediante AJAX.
 * Podemos imprimirla directo en PHP y es mas rapido, pero no podemos actualizar la data en tiempo real
 * 
--------------------------------------------------------------------------------*/
function Actualizar()
{
    /**
     * Parametros adicionales
     */
    var url = `${HOST_GERENCIAL_AJAX}Categorias/CRUD/`;
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

                        //Aqui imprimimos la data
                        tbody.innerHTML +=
                        '<tr>' +
                        '   <td>' +
                        '       ' + dato.nombre +
                        '   </td>' +

                        '   <td>' +
                        '       ' + dato.atiende.nombre +
                        '   </td>' +

                        '   <td center>' +        
                        '       <button class="btn btn-sm btn-warning" onclick="ModalModificar('+i+')">' +
                        '           <i class="fas fa-edit"></i>' +
                        '       </button>' +
                        '   </td>' +
                        '   <td center>' +        
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

function Agregar()
{
    /**
     * Parametros
     */
    var url = `${HOST_GERENCIAL_AJAX}Categorias/CRUD/`;
    var form = document.getElementById("form-nuevo");
    var modal = $("#staticBackdropnuevaCat");
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
            Actualizar();
            Loader.Ocultar();
            modal.modal("hide");
            form.reset();
            Alerta.Success("Nueva Categoría Agregada.");
        }
    });
}

function ModalModificar(fila)
{
    var datos = tabla.getData()[fila];
    var modal = $("#staticBackdropmodificaCat");
    var inputId = document.getElementById("MIdCategoria");
    var inputNombre = document.getElementById("MNombreCategoria");
    var inputEnviar = document.getElementById("MEnviaCategoria");

    inputId.value = datos.id;
    inputNombre.value = datos.nombre;
    inputEnviar.value = datos.atiende.id;
    modal.modal("show");
}

function Modificar()
{
    /**
     * Parametros
     */
    var url = `${HOST_GERENCIAL_AJAX}Categorias/CRUD/`;
    var form = document.getElementById("form-modificar");
    var modal = $("#staticBackdropmodificaCat");
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
            Actualizar();
            Loader.Ocultar();
            modal.modal("hide");
            Alerta.Success("Categoría Modificada con Exito.");
        }
    });
}

function ModalEliminar(fila)
{
    var datos = tabla.getData()[fila];
    var modal = $("#staticBackdropeliminaCat");
    var inputId = document.getElementById("EIdCategoria");
    var text = document.getElementById("EText");

    inputId.value = datos.id;
    text.innerHTML = "¿Esta seguro que desea eliminar la categoria <b>"+datos.nombre+"</b>?";
    modal.modal("show");
}

function Eliminar()
{
    /**
     * Parametros
     */
    var url = `${HOST_GERENCIAL_AJAX}Categorias/CRUD/`;
    var form = document.getElementById("form-eliminar");
    var modal = $("#staticBackdropeliminaCat");
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
            Alerta.Success("Categoría Eliminada Con Exito.");
        }
    });
}