/*================================================================================
 *
 *	Variables
 *
================================================================================*/
var listaRoles = [];

//Buscador
var buscador = new Buscador("input-buscador", "boton-buscador", "Actualizar");

//Tabla
var idTable = "tabla";
var tabla = new TablaGestion(idTable);

// Modales
var nuevo = {
    modal: $("#modal-nuevo"),
    form: document.getElementById('form-nuevo'),
    botonSubmit: document.getElementById('boton-submit-nuevo')
};

var modificar = {
    modal: $("#modal-modificar"),
    form: document.getElementById('form-modificar'),
    botonSubmit: document.getElementById('boton-submit-modificar'),
    inputIdRol: document.getElementById('inputIdRol'),
    inputNombre: document.getElementById('modificar-nombre'),
    inputDescripcion: document.getElementById('modificar-descripcion'),
    selectResponsable: document.getElementById('modificar-responsable')
};

var eliminar = {
    modal: $("#modal-eliminar"),
    form: document.getElementById('form-eliminar'),
    botonSubmit: document.getElementById('boton-submit-eliminar'),
    inputIdRol: document.getElementById('eliminar-idRol'),
    labelData: document.getElementById('form-text'),
    inputIdRolSustituir: document.getElementById("eliminar-idRolSustituir")
};

var permisos = {
    modal: $("#modal-permisos"),
    inputIdRol: document.getElementById('permisos-idRol'),
    tbody: document.getElementById('permisos-tbody')
};





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
    var url = `${HOST_ADMIN_AJAX}Roles/CRUD/`;
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
                    listaRoles = data;

                    for(var i=0; i<data.length; i++)
                    {
                        let dato = data[i];
                        if(dato == undefined) continue;

                        var responsable = (dato.responsable) ? 'Si' : 'No';
                        var classResponsable = (dato.responsable) ? 'success' : 'primary';

                        tbody.innerHTML +=
                        '<tr>' +
                        '   <td style="vertical-align: middle;">' +
                        '       ' + dato.nombre +
                        '   </td>' +

                        '   <td style="vertical-align: middle;">' +
                        '       ' + dato.descripcion +
                        '   </td>' +

                        '   <td style="vertical-align: middle;" center>' +
                        '       <label class="badge badge-'+classResponsable+'">'+responsable+'</label>' +
                        '   </td>' +

                        '   <td center>' +
                        '       <button class="btn btn-sm btn-success text-white" onclick="ModalModificar('+i+')">' +
                        '           <i class="fas fa-edit"></i>' +
                        '       </button>' +

                        '       <button class="btn btn-sm btn-info text-white" onclick="ModalPermisos('+i+')">' +
                        '           <i class="fas fa-list"></i>' +
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

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
Actualizar();

/*================================================================================
 *
 *	Registrar
 *
================================================================================*/
function ModalNuevo()
{
    nuevo.modal.modal("show");
}

function Registrar()
{
    var url = HOST_ADMIN_AJAX + 'Roles/CRUD/';
    var data = new FormData(nuevo.form);
    data.append("accion", "REGISTRAR");

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
            Actualizar();
            Loader.Ocultar();
            nuevo.modal.modal('hide');
            nuevo.form.reset();
        }
    });
}

nuevo.botonSubmit.onclick = function() {
    Registrar();
}

/*================================================================================
 *
 *	Modificar
 *
================================================================================*/
function ModalModificar(index)
{
    var datos = listaRoles[index];

    modificar.inputIdRol.value = datos.id;
    modificar.inputNombre.value = datos.nombre;
    modificar.inputDescripcion.value = datos.descripcion;
    modificar.selectResponsable.value = (datos.responsable) ? 1 : 0;

    modificar.modal.modal("show");
}

function Modificar()
{
    var url = HOST_ADMIN_AJAX + 'Roles/CRUD/';
    var data = new FormData(modificar.form);
    data.append("accion", "MODIFICAR");

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
            Actualizar();
            Loader.Ocultar();
            modificar.modal.modal('hide');
            modificar.form.reset();
        }
    });
}

modificar.botonSubmit.onclick = function() {
    Modificar();
}

/*================================================================================
 *
 *	Eliminar
 *
================================================================================*/
function ModalEliminar(index)
{
    var datos = listaRoles[index];

    eliminar.inputIdRol.value = datos.id;
    eliminar.labelData.innerHTML = datos.id+" - "+datos.nombre;

    eliminar.inputIdRolSustituir.innerHTML = "";
    var codeSelect = "";
    for(let objRol of listaRoles) {
        if(objRol.id == datos.id) continue;
        codeSelect += `<option value="${objRol.id}">${objRol.nombre}</option>`;
    }

    eliminar.inputIdRolSustituir.innerHTML = codeSelect;

    eliminar.modal.modal("show");
}

function Eliminar()
{
    var url = HOST_ADMIN_AJAX + 'Roles/CRUD/';
    var data = new FormData(eliminar.form);
    data.append("accion", "ELIMINAR");

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
            Actualizar();
            Loader.Ocultar();
            eliminar.modal.modal('hide');
            eliminar.form.reset();
        }
    });
}

eliminar.botonSubmit.onclick = function() {
    Eliminar();
}

/*================================================================================
 *
 *	Permisos
 *
================================================================================*/
/**
 * 
 * @param {*} index 
 */
function ModalPermisos(index)
{
    var datos = listaRoles[index];
    permisos.inputIdRol.value = datos.id;

    var url = HOST_ADMIN_AJAX + 'Roles/CRUD/';
    var data = new FormData();
    data.append("idRol", datos.id);
    data.append("accion", "PERMISOS-CONSULTAR");

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
            let codeHTML = "";
            for(let menuA of data)
            {
                var imgA = menuA.img;
                var nombreA = menuA.nombre;
                var opciones = menuA.opciones;
                var statusClassA = (menuA.status) ? 'success' : 'danger';
                var statusTextA = (menuA.status) ? 'Si' : 'No';

                codeHTML += `<tr>
                    <td left style="vertical-align: middle;">
                        <i class="${imgA}"></i> ${nombreA}
                    </td>

                    <td center style="vertical-align: middle;">
                        <button class="btn btn-sm btn-${statusClassA}" onclick="ModificarPermiso(${index}, ${menuA.idMenuA}, 'A')">
                            ${statusTextA}
                            <i class="ml-3 fas fa-sync"></i>
                        </button>
                    </td>
                </tr>`;

                for(let menuB of opciones)
                {
                    var imgB = menuB.img;
                    var nombreB = menuB.nombre;
                    var statusClassB = (menuB.status) ? 'success' : 'danger';
                    var statusTextB = (menuB.status) ? 'Si' : 'No';

                    codeHTML += `<tr>
                        <td left style="vertical-align: middle;">
                            <div class="ml-3">
                                <i class="${imgB}"></i> ${nombreB}
                            </div>
                        </td>

                        <td center style="vertical-align: middle;">
                            <button class="btn btn-sm btn-${statusClassB}" onclick="ModificarPermiso(${index}, ${menuB.idMenuB}, 'B')">
                                ${statusTextB}
                                <i class="ml-3 fas fa-sync"></i>
                            </button>
                        </td>
                    </tr>`;
                }
            }

            permisos.tbody.innerHTML = codeHTML;
            Loader.Ocultar();
            permisos.modal.modal("show");
        }
    });
}

/**
 * 
 * @param {*} idMenu 
 * @param {*} tipo 
 */
function ModificarPermiso(indexRol, idMenu, tipo)
{
    var url = HOST_ADMIN_AJAX + 'Roles/CRUD/';
    var data = new FormData(permisos.form);
    data.append("accion", "PERMISOS-MODIFICAR");
    data.append("idRol", listaRoles[indexRol].id);
    data.append("idMenu", idMenu);
    data.append("tipo", tipo);

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
            ModalPermisos(indexRol);
            Loader.Ocultar();
        }
    });
}