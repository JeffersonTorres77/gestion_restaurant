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

//Platos seleccionados
var categorias = [];
var platos = [];

//Registrar
var idModificar = {
    modal: "modal-modificar",
    form: "form-modificar"
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

                        var checkStatus = "";
                        for(var index=0; index<platos.length; index++) {
                            if(platos[index].id == dato.id) {
                                checkStatus = "checked";
                                break;
                            }
                        }

                        //Aqui imprimimos la data
                        tbody.innerHTML +=
                        '<tr style="cursor: pointer;" onclick="ClickRow(\''+i+'\', \''+dato.id+'\')">' +
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
                        '       <div class="custom-control custom-switch">' +
                        '           <input type="checkbox" '+checkStatus+' class="custom-control-input" id="check-id-'+dato.id+'">' +
                        '           <label class="custom-control-label" for="check-id-'+dato.id+'"></label>' +
                        '       </div>' +
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
 * 
 * 
--------------------------------------------------------------------------------*/
function ClickRow(index, id)
{
    var check = document.getElementById("check-id-"+id);
    check.checked = !check.checked;
    ClickCheckBox(index, id);
}

function ClickCheckBox(index, id)
{
    var datos = tabla.getData()[index];
    var check = document.getElementById("check-id-"+id);

    if(check.checked)
    {
        platos.push({
            id: datos.id,
            nombre: datos.nombre
        });
    }
    else
    {
        for(var i=0; i<platos.length; i++) {
            if(platos[i].id == id) {
                platos.splice(i, 1);
                break;
            }
        }
    }
}

/*--------------------------------------------------------------------------------
 * 
 * 
 * 
--------------------------------------------------------------------------------*/
function Continuar()
{
    if(platos.length == 0) {
        Alerta.Danger("Para continuar debe seleccionar al menos un plato.");
        return;
    }

    /**
     * Parametros
     */
    var url = `${HOST_GERENCIAL_AJAX}Menus/CRUD/`;
    var modal = $("#" + idModificar.modal);
    var data = new FormData();
    data.append("platos", JSON.stringify(platos));
    data.append("accion", "ANALIZAR-PLATOS");

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
            Loader.Ocultar();
            modal.modal("show");

            platos = cuerpo.platos;
            var categorias_detalles = cuerpo.categorias;

            var tbody = document.getElementById("tbody-platos");
            tbody.innerHTML = "";

            var index = 0;
            for(var categoria_det of categorias_detalles)
            {
                var cantidad_defecto = 1;
                for(var categoria of categorias) {
                    if(categoria_det.id == categoria.id) {
                        cantidad_defecto = categoria.cantidad;
                        break;
                    }
                }

                tbody.innerHTML += `<tr>
                    <td style="vertical-align: center;" left>
                        ${categoria_det.nombre}
                    </td>

                    <td style="vertical-align: center;" center>
                        ${categoria_det.cantidad}
                    </td>

                    <td style="vertical-align: center;" center>
                        <div class="input-group input-group-sm">
                        <input type="hidden" name="categorias[${index}][id]" value="${categoria_det.id}" />
                            <input type="number" class="form-control" name="categorias[${index}][cantidad]" required value="${cantidad_defecto}" />
                        </div>
                    </td>
                </tr>`;

                index += 1;
            }
        }
    });
}

/*--------------------------------------------------------------------------------
 * 
 * 
 * 
--------------------------------------------------------------------------------*/
function Modificar()
{
    if(platos.length == 0) {
        Alerta.Danger("Para continuar debe seleccionar al menos un plato.");
        return;
    }

    /**
     * Parametros
     */
    var url = `${HOST_GERENCIAL_AJAX}Menus/CRUD/`;
    var form = document.getElementById(idModificar.form);
    var modal = $("#" + idModificar.modal);
    var data = new FormData(form);
    data.append("platos", JSON.stringify(platos));
    data.append("accion", "MODIFICAR");

    if( Formulario.Validar(idModificar.form) == false ) return;

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
            location.href = HOST_GERENCIAL + "Menus/";
        }
    });
}

/*--------------------------------------------------------------------------------
 * 
 * 
 * 
--------------------------------------------------------------------------------*/
function Filtros(input)
{
    var valor = input.value;
    var hash = "/";
    if(valor != "") {
        hash = '/buscar=categoria-'+valor+"/";
    }

    location.hash = hash;
    Actualizar();
}

/*--------------------------------------------------------------------------------
 * 
 * 
 * 
--------------------------------------------------------------------------------*/
function Limpiar()
{
    platos = [];
    Actualizar();
}

/*--------------------------------------------------------------------------------
 * 
 * 
 * 
--------------------------------------------------------------------------------*/
document.getElementById("img-foto-combo-modificar").onchange = function()
{
    var input = this;
    var label = document.getElementById("label-foto-combo-modificar");
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