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
 * Actualizar
 * 
--------------------------------------------------------------------------------*/
function Actualizar()
{
    /**
     * Parametros adicionales
     */
    var url = `${HOST_GERENCIAL_AJAX}Platos/CRUD/`;
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

                        '   <td style="vertical-align: middle;">' +
                        '       ' + dato.categoria.nombre +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +
                        '       <div class="'+claseActivo+'">' +
                        '       ' + textoActivo +
                        '       </div>' +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +        
                        '       <button class="btn btn-sm btn-warning" onclick="ModalModificar('+i+')">' +
                        '           <i class="fas fa-edit"></i>' +
                        '       </button>' +
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

/*================================================================================
 *
 *	
 *
================================================================================*/
function Agregar()
{
    /**
     * Parametros
     */
    var url = `${HOST_GERENCIAL_AJAX}Platos/CRUD/`;
    var form = document.getElementById("form-nuevo");
    var modal = $("#staticBackdropnuevoPla");
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
            Alerta.Success("Nuevo Plato Agregado.");
            document.getElementById('label-foto-plato-nuevo').getElementsByTagName('img')[0].src = HOST+"recursos/core/img/plato-defecto.png";
        }
    });
}

document.getElementById("img-foto-plato-nuevo").onchange = function()
{
    var input = this;
    var label = document.getElementById("label-foto-plato-nuevo");
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

/*================================================================================
 *
 *	
 *
================================================================================*/
function ModalModificar(fila)
{
    var datos = tabla.getData()[fila];
    var modal = $("#staticBackdropmodificaPla");

    var inputId = document.getElementById("idPlato-modificar");
    var img = document.getElementById("label-foto-plato-modificar").getElementsByTagName("img")[0];
    var inputImg = document.getElementById("img-foto-plato-modificar");
    var inputNombre = document.getElementById("MNombrePlato");
    var inputDescripcion = document.getElementById("MDescripPlato");
    var inputCategoria = document.getElementById("MCategoriaPlato");
    var inputCosto = document.getElementById("MPrecioCostoPlato");
    var inputVenta = document.getElementById("MPrecioVentaPlato");
    var inputActivo = document.getElementById("customSwitch2");

    inputId.value = datos.id;
    img.src = datos.imagen;
    inputImg.value = "";
    inputNombre.value = datos.nombre;
    inputDescripcion.value = datos.descripcion;
    inputCategoria.value = datos.categoria.id;
    inputCosto.value = datos.precioCosto;
    inputVenta.value = datos.precioVenta;
    inputActivo.checked = datos.activo;

    modal.modal("show");
}

document.getElementById("img-foto-plato-modificar").onchange = function()
{
    var input = this;
    var label = document.getElementById("label-foto-plato-modificar");
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

function Modificar()
{
    /**
     * Parametros
     */
    var url = `${HOST_GERENCIAL_AJAX}Platos/CRUD/`;
    var modal = $("#staticBackdropmodificaPla");
    var form = document.getElementById("form-modificar");
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
            Alerta.Success("Plato modificado exitosamente.");
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

    var input = document.getElementById("idPlato-eliminar");
    var label = document.getElementById("label-eliminar");

    input.value = datos.id;
    label.innerHTML = datos.id+" - "+datos.nombre;
    
    modal.modal("show");
}

function Eliminar()
{
    /**
     * Parametros
     */
    var url = `${HOST_GERENCIAL_AJAX}Platos/CRUD/`;
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
            Alerta.Success("Plato eliminado exitosamente.");
        }
    });
}