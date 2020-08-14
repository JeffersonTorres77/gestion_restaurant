/*================================================================================
 *
 *	Variables
 *
================================================================================*/
var listaMesas = [];
var keyMesaActualizar = null;

// Elementos
var botonStatus = document.getElementById("boton-status");
var contenedorMesas = document.getElementById("contenedor-mesas");

// Extra
botonStatus.setAttribute("class", "btn btn-sm btn-secondary");
botonStatus.innerHTML = "Conectando...";
var ver = {
    modal: $("#modal-ver"),
    modalDialog: document.getElementById('modal-ver-dialog'),
    modalHeader: document.getElementById('modal-ver-header'),
    modalTitle: document.getElementById('modal-ver-title'),
    modalAlarma: document.getElementById('modal-ver-alarma'),
    tbody: document.getElementById("modal-ver-tbody"),
    botonFacturar: document.getElementById('boton-facturar'),
    modalDatos: $('#modal-datos-factura'),
    formDatos: document.getElementById('form-datos-factura')
}

/*================================================================================
 *
 *	WebSocket Defecto
 *
================================================================================*/
// Web Sockets
var intentosConexion = 0;
var socket = io(WEBSOCKET_URL, {
    query: {
        area: AREA,
        modulo: MODULO,
        archivo: ARCHIVO,
        key: KEY
    }
});

// Eventos de conexión
socket.on('connect', function()
{
    intentosConexion = 0;
    botonStatus.setAttribute("class", "btn btn-sm btn-success");
    botonStatus.innerHTML = `<i class="fas fa-server"></i> Conectado`;

    ActualizarPedidos();
});

socket.on('disconnect', function()
{
    botonStatus.setAttribute("class", "btn btn-sm btn-danger");
    botonStatus.innerHTML = `<i class="fas fa-times"></i> Desconectado`;
});

socket.on('connect_error', function() {
    intentosConexion += 1;
    
    if(intentosConexion == 5){
        socket.disconnect();
        botonStatus.setAttribute("class", "btn btn-sm btn-danger");
        botonStatus.innerHTML = `<i class="fas fa-times"></i> No conectado`;
    }
});

socket.on('reconnecting', (intentoNumero) => {
    botonStatus.setAttribute("class", "btn btn-sm btn-danger");
    botonStatus.innerHTML = `<i class="fas fa-sync-alt"></i> Reconectando (${intentoNumero})`;
});

/*================================================================================
 *
 *	WebSocket Personalizado
 *
================================================================================*/
// Eventos propios
socket.on('ws:error', (data) =>
{
    Loader.Ocultar();
    contenedorMesas.setAttribute('vacio', 'true');
    contenedorMesas.innerHTML = `<div class="col-12 p-0 px-3">
        <div class="card bg-danger text-white">
            <div class="card-body" center>
                <span class="h5">${data}</span>

                <br><br>

                <button class="btn btn-sm btn-light text-danger" onclick="ActualizarPedidos()">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </div>`;
});

socket.on('cambio', () => {
    ActualizarPedidos();
});

socket.on('actualizar-todo', function(data)
{
    listaMesas = data;
    PintarMesas();
    if( keyMesaActualizar != null) {
        ModalConfirmar(keyMesaActualizar);
    }
    Loader.Ocultar();
});

/*================================================================================
 *
 *	Actualizar pedidos
 *
================================================================================*/
function ActualizarPedidos()
{
    socket.emit('actualizar-todo', []);
}

/**
 * 
 */
function PintarMesas()
{
    if(listaMesas.length > 0)
    {
        contenedorMesas.setAttribute('vacio', 'false');
        contenedorMesas.innerHTML = "";
        codeHTML = "";

        for(var keyMesa in listaMesas)
        {
            codeHTML += CodigoMesaHTML(keyMesa);
        }

        contenedorMesas.innerHTML = codeHTML;
    }
    else
    {
        contenedorMesas.setAttribute('vacio', 'true');
        contenedorMesas.innerHTML = `<div class="col-12 p-0 px-3">
            <div class="card bg-light">
                <div class="card-body" center>
                    <span class="h5">No se encontraron resultados.</span>
                </div>
            </div>
        </div>`;
    }
}

/**
 * 
 * @param {*} keyMesa 
 */
function CodigoMesaHTML(keyMesa)
{
    var objMesa = listaMesas[keyMesa];
    var mesaHTML = "";

    var nombreMesa = objMesa.alias;

    // Clase de la carta
    var classCardHeader = "";
    if(objMesa.status == "CERRADA") {
        classCardHeader = "bg-danger text-white";
    }

    // Con pedidos
    if(objMesa.pedidos.length > 0)
    {
        var codePedidos = "";
        for(var pedido of objMesa.pedidos)
        {
            var esCombo = pedido.esCombo;
            var datos = pedido.datos;

            if(esCombo)
            {
                for(let pedido of datos.pedidos) {
                    if(pedido.status == 2) {
                        classCardHeader = "bg-warning";
                    }
                }

                codePedidos += ComboHTML(datos);
            }
            else
            {
                codePedidos += PlatoHTML(datos.plato.nombre, datos.status, datos.cantidad);
                if(datos.status == 2) {
                    classCardHeader = "bg-warning";
                }
            }
        }

        if(codePedidos == "")
        {
            codePedidos = `<div class="text-muted p-3" center>
                En espera
            </div>`;
        }
    }
    // Sin pedidos
    else
    {
        if(objMesa.status != "CERRADA") {
            codePedidos = `<div class="text-muted p-3" center>
                (Vacio)
            </div>`;
        }

        if(objMesa.status == "CERRADA") {
            codePedidos = `<div class="text-muted p-3" center>
                <i class="fas fa-lock"></i> Cerrada
            </div>`;
        }
    }

    var alertaCamarero = (objMesa.solicitar_camarero == false) ? '' : `
    <div class="py-1 px-2 alert alert-warning mb-0 rounded-0 font-weight-bold border-bottom border-warning" center>
        <i class="fas fa-bell"></i>
        Se solicita al camarero
    </div>`;

    mesaHTML += `<div class="card-pedido col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
        <div class="card card-mesa sombra" style="cursor: pointer;" tabindex="0" onclick="ModalConfirmar('${keyMesa}')">
            <div class="card-header ${classCardHeader}">
                <div class="h6 mb-0">
                    ${nombreMesa}
                </div>
            </div>

            <div class="card-body p-0">
                ${alertaCamarero}
                ${codePedidos}
            </div>
        </div>
    </div>`;

    return mesaHTML;
}

/**
 * 
 * @param {*} datos 
 */
function PlatoHTML(nombre, idStatus, cantidad)
{
    var codePlato = "";

    var status = idStatus;
    var platoNombre = nombre;
    var classImg = "fas fa-times";
    var classDiv = "text-danger font-weight-bold";
    var classCantidad = "badge badge-danger";

    if(status == "1")
    {
        classImg = "far fa-clock";
        classDiv = "";
        classCantidad = "badge badge-primary";
    }
    else if(status == "2")
    {
        classImg = "fas fa-bell";
        classDiv = "text-warning font-weight-bold";
        classCantidad = "badge badge-warning";
    }
    else
    {
        classImg = "fas fa-check";
        classDiv = "text-success font-weight-bold";
        classCantidad = "badge badge-success";
    }
    
    codePlato += `<div class="py-1 px-2 ${classDiv} hover position-relative">
        <i class="${classImg} mr-1"></i> ${platoNombre}

        <div class="position-absolute p-1" style="top: 0px; right: 0px">
            <div class="${classCantidad}">
                ${cantidad}
            </div>
        </div>
    </div>`;

    return codePlato;
}

/**
 * 
 * @param {*} datos 
 */
function ComboHTML(datos)
{
    var codeCombo = "";

    for(let pedido of datos.pedidos)
    {
        codeCombo += PlatoHTML(pedido.nombrePlato, pedido.status, pedido.cantidad);
    }

    return codeCombo;
}

/*================================================================================
 *
 *	Modal Confirmar
 *
================================================================================*/
/**
 * 
 * @param {*} keyMesa 
 */
function ModalConfirmar(keyMesa)
{
    /**
     * 
     */
    keyMesaActualizar = keyMesa;
    var objMesa = listaMesas[keyMesa];
    ver.modalTitle.innerHTML = objMesa.alias;

    /**
     * 
     */
    if(objMesa.solicitar_camarero)
    {
        ver.modalAlarma.innerHTML = `<div class="alert alert-warning mb-0">
            <i class="fas fa-bell"></i>
            Se solicita al camarero

            <button class="close" onclick="QuitarAlarma(${objMesa.id})">&times;</button>
        </div>`;
    }
    else
    {
        ver.modalAlarma.innerHTML = "";
    }

    /**
     * 
     */
    if(objMesa.pedidos.length > 0)
    {
        ver.botonFacturar.style.display = "";
        ver.botonFacturar.onclick = function(){ ModalDatosFactura(objMesa.id); };
        ver.modalDialog.className = 'modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl';
        ver.modalHeader.className = 'modal-header bg-primary text-white border-bottom-0';

        ver.tbody.innerHTML = "";
        var codeHTML = "";
        for(var pedido of objMesa.pedidos)
        {
            var datos = pedido.datos;
            var esCombo = pedido.esCombo;

            if(esCombo)
            {
                for(let pedido of datos.pedidos)
                {
                    var checked = (pedido.status == "3") ? 'checked' : '';
                    var monto = pedido.precioUnitario * (1 - (pedido.descuento / 100));
                    codeHTML += `<tr class="table-${classStatus(pedido.status)}" style="cursor: pointer;" onclick="CheckearItem(this, event)">
                        <td class="text-truncate" style="min-width: 50px;">
                            <div style="display: inline-block;">
                                <button class="badge badge-danger border-0 eliminar" onclick="ModalEliminar('${pedido.idPedido}')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <div class="custom-control custom-checkbox" style="display: inline-block;">
                                <input type="checkbox"
                                class="custom-control-input"
                                id="check-pedido-${pedido.idPedido}" ${checked}
                                idPedido="${pedido.idPedido}"
                                total="${pedido.precioTotal}">
                                <label class="custom-control-label" for="check-pedido-${pedido.idPedido}">
                                    ${datos.nombre} - ${pedido.nombrePlato}
                                </label>
                            </div>
                        </td>

                        <td center class="text-truncate" style="min-width: 50px;">
                            ${statusText(pedido.status)}
                        </td>

                        <td right class="text-truncate" style="min-width: 50px;">
                            Bs. ${Formato.Numerico( monto, 2 )}
                        </td>

                        <td center class="text-truncate" style="min-width: 50px;">
                            ${pedido.cantidad}
                        </td>

                        <td right class="font-weight-bold text-truncate" style="min-width: 50px;">
                            Bs. ${Formato.Numerico( pedido.precioTotal, 2 )}
                        </td>
                    </tr>`;
                }
            }
            else
            {
                var checked = (datos.status == "3") ? 'checked' : '';
                var monto = datos.precioUnitario * (1 - (datos.descuento / 100));
                codeHTML += `<tr class="table-${classStatus(datos.status)}" style="cursor: pointer;" onclick="CheckearItem(this, event)">
                    <td class="text-truncate" style="min-width: 50px;">
                        <div style="display: inline-block;">
                            <button class="badge badge-danger border-0 eliminar" onclick="ModalEliminar('${datos.id}')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <div class="custom-control custom-checkbox" style="display: inline-block;">
                            <input type="checkbox"
                            class="custom-control-input"
                            id="check-pedido-${datos.id}" ${checked}
                            idPedido="${datos.id}"
                            total="${datos.precioTotal}">
                            <label class="custom-control-label" for="check-pedido-${datos.id}">
                                ${datos.plato.nombre}
                            </label>
                        </div>
                    </td>

                    <td center class="text-truncate" style="min-width: 50px;">
                        ${statusText(datos.status)}
                    </td>

                    <td right class="text-truncate" style="min-width: 50px;">
                        Bs. ${Formato.Numerico( monto, 2 )}
                    </td>

                    <td center class="text-truncate" style="min-width: 50px;">
                        ${datos.cantidad}
                    </td>

                    <td right class="font-weight-bold text-truncate" style="min-width: 50px;">
                        Bs. ${Formato.Numerico( datos.precioTotal, 2 )}
                    </td>
                </tr>`;
            }
        }

        ver.tbody.innerHTML = `${codeHTML}
        <tr>
            <td colspan="4" class="font-weight-bold" style="font-size: 18px;" right>
                Total:
            </td>

            <td right class="font-weight-bold" style="font-size: 18px;" id="campoTotal">
                ${Formato.Numerico(0, 2)}
            </td>
        </tr>`;
    }
    else if(objMesa.status == "CERRADA")
    {
        ver.botonFacturar.style.display = "none";
        ver.botonFacturar.onclick = function(){};
        ver.modalDialog.className = 'modal-dialog modal-dialog-centered modal-dialog-scrollable';
        ver.modalHeader.className = 'modal-header bg-danger text-white border-bottom-0';
        ver.tbody.innerHTML = `<tr>
            <td colspan="100">
                <h5 class="mb-0 text-muted py-2" center>
                    <i class="fas fa-lock"></i>
                    Cerrada
                </h5>
            </td>
        </tr>`;
    }
    else
    {
        ver.botonFacturar.style.display = "none";
        ver.botonFacturar.onclick = function(){};
        ver.modalDialog.className = 'modal-dialog modal-dialog-centered modal-dialog-scrollable';
        ver.modalHeader.className = 'modal-header border-bottom-0';
        ver.tbody.innerHTML = `<tr>
            <td colspan="100">
                <h5 class="mb-0 text-muted py-2" center>
                    (Vacio)
                </h5>
            </td>
        </tr>`;
    }

    CalcularFactura();
    ver.modal.modal('show');
}

ver.modal.on('hidden.bs.modal', function() {
    keyMesaActualizar = null;
});

/**
 * 
 */
function CalcularFactura()
{
    var inputs = ver.tbody.getElementsByTagName('input');
    var totalFactura = 0;
    for(var input of inputs)
    {
        var total = input.getAttribute("total");
        if(total == undefined) continue;
        if(isNaN(total)) continue;
        if(input.checked != true) continue;
        totalFactura = Number(totalFactura) + Number(total);
    }
    
    var campoTotal = document.getElementById('campoTotal');
    if(campoTotal == undefined || campoTotal == null) return;
    campoTotal.innerHTML = Formato.Numerico(totalFactura, 2);
}

/**
 * 
 * @param {*} element 
 */
function CheckearItem(element, event)
{
    var paths = event.path;
    for(var path of paths)
    {
        var tag = path.tagName;
        if(tag == undefined) continue;
        tag = tag.toLowerCase();
        if(tag != "button") continue;
        var className = path.className;
        var arrayClassName = className.split(' ');
        var result = arrayClassName.find(x => x == "eliminar");
        if(result.length > 0) {
            return;
        }
    }

    var input = element.getElementsByTagName('input')[0];
    var statusActual = input.checked;
    var statusNuevo = !statusActual;
    input.checked = statusNuevo
    CalcularFactura();
}

/**
 * 
 * @param {*} intStatus 
 */
function statusText(status)
{
    var salida = "";
    var intStatus = Number(status);

    switch(intStatus)
    {
        case 1:
            salida = `<div class="badge badge-primary">En Cocina</div>`;
        break;

        case 2:
            salida = `<div class="badge badge-warning">Cocinado</div>`;
        break;

        case 3:
            salida = `<div class="badge badge-success">Entregado</div>`;
        break;
    }

    return salida;
}

/**
 * 
 * @param {*} status 
 */
function classStatus(status)
{
    var salida = "";
    var intStatus = Number(status);

    switch(intStatus)
    {
        case 1:
            salida = "primary";
        break;

        case 2:
            salida = "warning";
        break;

        case 3:
            salida = "success";
        break;
    }

    return salida;
}

/**
 * 
 * @param {*} idMesa 
 */
function QuitarAlarma(idMesa)
{
    socket.emit('quitar-alarma', {
        idMesa: idMesa
    });
}

/**
 * 
 * @param {*} idMesa 
 */
function ModalDatosFactura(idMesa)
{
    document.getElementById('boton-facturar-final').onclick = function() { Facturar(idMesa); };
    ver.modalDatos.modal('show');
}

/**
 * 
 * @param {*} idMesa 
 */
function Facturar(idMesa)
{
    var inputNumeroFactura = document.getElementById('numero_factura');
    if(inputNumeroFactura.value == "") {
        alert("Debe introducir el numero de factura.");
        return;
    }

    var idsPedidos = [];
    var inputs = ver.tbody.getElementsByTagName("input");
    for(var input of inputs)
    {
        var idPedido = input.getAttribute("idPedido");
        if(idPedido == undefined) continue;
        if(isNaN(idPedido)) continue;
        if(input.checked != true) continue;
        idsPedidos.push(idPedido);
    }
    
    socket.emit('facturar', {
        idMesa: idMesa,
        idsPedidos: idsPedidos,
        numero_factura: inputNumeroFactura.value
    });

    Loader.Mostrar();

    socket.on('cambio', function(data) {
        Loader.Ocultar();
        ver.modalDatos.modal('hide');
        inputNumeroFactura.value = "";
    });
}

/**
 * 
 * @param {*} idPedido 
 */
function ModalEliminar(idPedido)
{
    document.getElementById('boton-eliminar-pedido').onclick = function() { EliminarPedido(idPedido) };
    var modal = $("#modal-eliminar-pedido");
    modal.modal('show');
}

/**
 * 
 * @param {*} idPedido 
 */
function EliminarPedido(idPedido)
{
    var modal = $("#modal-eliminar-pedido");
    var inputMotivo = document.getElementById('motivo');
    if(inputMotivo.value == "") {
        alert("Debe introducir el motivo.");
        return;
    }
    
    socket.emit('eliminar-pedido', {
        idPedido: idPedido,
        motivo: inputMotivo.value
    });

    Loader.Mostrar();

    socket.on('cambio', function(data) {
        Loader.Ocultar();
        modal.modal('hide');
        inputMotivo.value = "";
    });
}