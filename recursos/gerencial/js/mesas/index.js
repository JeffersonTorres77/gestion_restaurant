/*================================================================================
 *
 *	Variables
 *
================================================================================*/
//Tabla
var idTabla = "tabla";
/* Esta clase prepara una tabla (le anexa el empaginado) */
var tabla = new TablaGestion(idTabla);

//Buscador
var idInputBuscador = "input-buscador";
var idBotonBuscador = "boton-buscador";
//Esta clase recibe 3 parametros
//Id del input del buscador
//Id del boton del buscador
//Funcion a ejecutar (string) cuando se haga submit [Actualizar]
var buscador = new Buscador(idInputBuscador, idBotonBuscador, "Actualizar");

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
    var url = `${HOST_GERENCIAL_AJAX}Mesas/CRUD/`;
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

                        var claseStatus = "";
                        switch(dato.status.key)
                        {
                            case "ABIERTA":
                                claseStatus = "badge badge-success";
                                break;
                                
                            case "CERRADA":
                                claseStatus = "badge badge-danger";
                                break;
                        }

                        //Aqui imprimimos la data
                        tbody.innerHTML +=
                        '<tr>' +
                        '   <td>' +
                        '       ' + dato.alias +
                        '   </td>' +

                        '   <td center>' +
                        '       <div class="'+claseStatus+'">' +
                        '           ' + dato.status.nombre +
                        '       </div>' +
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
    var url = `${HOST_GERENCIAL_AJAX}Mesas/CRUD/`;
    var form = document.getElementById("form-nuevo");
    var modal = $("#staticBackdropnuevaMesa");
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
            Alerta.Success("Nueva Mesa Agregada.");
        }
    });
}

function ModalModificar(fila)
{
    var datos = tabla.getData()[fila];
    var modal = $("#staticBackdropModificaMesa");

    var inputId = document.getElementById("MIdMesa");
    var inputalias = document.getElementById("Maliasmesa");
    var usuarioalias = document.getElementById("Musuario");
    var clavealias = document.getElementById("Mclave");
    var status = document.getElementById("Mstatus");

    inputId.value = datos.id;
    inputalias.value = datos.alias;
    usuarioalias.value = datos.usuario;
    clavealias.value = datos.clave;
    status.value = datos.status.key;

    Formulario.QuitarClasesValidaciones("form-modificar");
    modal.modal("show");
}

function Modificar()
{
    /**
     * Parametros
     */
    var url = `${HOST_GERENCIAL_AJAX}Mesas/CRUD/`;
    var form = document.getElementById("form-modificar");
    var modal = $("#staticBackdropModificaMesa");
    var data = new FormData(form);
    data.append("accion", "MODIFICAR");

    if(Formulario.Validar("form-modificar") == false) return;

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
            Alerta.Success("Mesa Modificada con Exito.");
        }
    });
}

function ModalEliminar(fila)
{
    
    var datos = tabla.getData()[fila];
    var modal = $("#staticBackdropeliminaMesa");
    var inputId = document.getElementById("EidMesa");
    var text = document.getElementById("EText");

    inputId.value = datos.id;
    text.innerHTML = "¿Esta seguro que desea eliminar la Mesa <b>"+datos.alias+"</b>?";
    modal.modal("show");
}

function Eliminar()
{
    /**
     * Parametros
     */
    var url = `${HOST_GERENCIAL_AJAX}Mesas/CRUD/`;
    var form = document.getElementById("form-eliminarmesa");
    var modal = $("#staticBackdropeliminaMesa");
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