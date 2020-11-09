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
    botonFacturar: document.getElementById('boton-facturar')
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
        accion: "MonitoreoCaja",
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
                <br>
                <br>
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

socket.on('actualizar', function(data)
{
    listaMesas = data;
    PintarMesas();
    if( keyMesaActualizar != null) ModalConfirmar(keyMesaActualizar);
    Loader.Ocultar();
});

/*================================================================================
 *
 *	Actualizar pedidos
 *
================================================================================*/
function ActualizarPedidos()
{
    socket.emit('actualizar', []);
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
    var pedidos = objMesa.pedidos;
    var nombreMesa = objMesa.alias;
    var classCardHeader = (objMesa.status == "CERRADA") ? "text-white bg-danger" : "text-white bg-primary";
    var alertaCamarero = "";
    var codePedidos = "";

    if(pedidos.length > 0)
    {
        var codePedidos = "";
        for(var keyPedido in pedidos)
        {
            var pedido = pedidos[keyPedido];
            var esCombo = pedido.esCombo;
            var lote = pedido.lote;
            var combo = pedido.combo;
            var platos = pedido.platos;

            if(esCombo)
            {
                for(let plato of platos) {
                    if(plato.status == 2) {
                        classCardHeader = "bg-warning";
                    }
                }

                codePedidos += ComboHTML(keyMesa, keyPedido);
            }
            else
            {
                if(platos[0].status == 2) {
                    classCardHeader = "bg-warning";
                }
                
                codePedidos += PlatoHTML(keyMesa, keyPedido, 0);
            }
        }

        if(codePedidos == "")
        {
            codePedidos = `<div class="text-muted p-3" center>
                En espera
            </div>`;
        }
    }
    else
    {
        if(objMesa.status != "CERRADA") {
            codePedidos = `<div class="text-muted p-3" center>
                (Vacio)
            </div>`;
        } else {
            codePedidos = `<div class="text-muted p-3" center>
                <i class="fas fa-lock"></i> Cerrada
            </div>`;
        }
    }

    var alertaCamarero = (objMesa.solicitar_camarero == '0') ? '' : `
    <div class="py-1 px-2 alert mb-0 rounded-0 font-weight-bold border-bottom ${(objMesa.solicitar_camarero == '1') ? 'border-warning alert-warning' : 'border-success alert-success'}" center>
        <i class="fas fa-bell"></i>
        ${(objMesa.solicitar_camarero == '1') ? 'Se solicita al camarero' : 'Se solicita la cuenta'}
    </div>`;

    return `<div class="card-pedido col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
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
}

/**
 * 
 * @param {*} keyMesa 
 * @param {*} keyPedido 
 */
function ComboHTML(keyMesa, keyPedido)
{
    var objPedido = listaMesas[keyMesa].pedidos[keyPedido];
    var arrayPlatos = objPedido.platos;
    
    var codeCombo = "";
    for(let indexPlato in arrayPlatos)
    {
        codeCombo += PlatoHTML(keyMesa, keyPedido, indexPlato);
    }

    return codeCombo;
}

/**
 * 
 * @param {*} keyMesa 
 * @param {*} keyPedido 
 */
function PlatoHTML(keyMesa, keyPedido, indexPlato)
{
    var objPedido = listaMesas[keyMesa].pedidos[keyPedido];
    var objPlato = objPedido.platos[indexPlato];

    var status = objPlato.status;
    var platoNombre = objPlato.plato.nombre;
    var cantidad = objPlato.cantidad;
    var classImg = "fas fa-times";
    var classDiv = "text-danger font-weight-bold";
    var classCantidad = "badge badge-danger";

    if(status == "1") {
        classImg = "far fa-clock";
        classDiv = "";
        classCantidad = "badge badge-primary";
    } else if(status == "2") {
        classImg = "fas fa-bell";
        classDiv = "text-warning font-weight-bold";
        classCantidad = "badge badge-warning";
    }  else {
        classImg = "fas fa-check";
        classDiv = "text-success font-weight-bold";
        classCantidad = "badge badge-success";
    }

    return `<div class="py-1 px-2 ${classDiv} hover position-relative">
        <i class="${classImg} mr-1"></i> ${platoNombre}

        <div class="position-absolute p-1" style="top: 0px; right: 0px">
            <div class="${classCantidad}">
                ${cantidad}
            </div>
        </div>
    </div>`;
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
    //
    var objMesa = listaMesas[keyMesa];

    //
    keyMesaActualizar = keyMesa;
    ver.modalTitle.innerHTML = objMesa.alias;
    ver.modalAlarma.innerHTML = (!objMesa.solicitar_camarero) ? '' : `<div class="alert mb-0 ${(objMesa.solicitar_camarero == '1') ? 'alert-warning' : 'alert-success'}">
        <i class="fas fa-bell"></i>
        ${(objMesa.solicitar_camarero == '1') ? 'Se solicita al camarero' : 'Se solicita la cuenta'}

        <button class="close" onclick="QuitarAlarma(${objMesa.idMesa})">&times;</button>
    </div>`;

    if(objMesa.pedidos.length > 0)
    {
        ver.botonFacturar.style.display = "";
        ver.botonFacturar.onclick = function(){ ModalConfirmarFacturacion(objMesa.idMesa); };
        ver.modalDialog.className = 'modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl';
        ver.modalHeader.className = 'modal-header bg-primary text-white border-bottom-0';

        ver.tbody.innerHTML = "";
        var codeHTML = "";

        for(var keyPedido in objMesa.pedidos)
        {
            var pedido = objMesa.pedidos[keyPedido];
            var platos = pedido.platos;
            var esCombo = pedido.esCombo;

            if(esCombo)
            {
                for(let keyPlato in platos) {
                    codeHTML += ModalCodePlatoHTML(keyMesa, keyPedido, keyPlato, true);
                }
            }
            else
            {
                codeHTML += ModalCodePlatoHTML(keyMesa, keyPedido, 0, false);
            }
        }

        ver.tbody.innerHTML = `${codeHTML}
        <tr>
            <td colspan="4" class="font-weight-bold" style="font-size: 18px;" right>
                <div class="custom-control custom-checkbox float-left">
                    <input type="checkbox" class="custom-control-input" id="check-all" onchange="CheckAll(this)">
                    <label class="custom-control-label" for="check-all">Check all</label>
                </div>    

                Total:
            </td>

            <td right class="font-weight-bold" style="font-size: 18px;" id="campoTotal">
                ${MONEDA} ${Formato.Numerico(0, 2)}
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
 * @param {*} keyMesa 
 * @param {*} keyPedido 
 * @param {*} keyPlato 
 */
function ModalCodePlatoHTML(keyMesa, keyPedido, keyPlato, esCombo)
{
    var plato = listaMesas[keyMesa].pedidos[keyPedido].platos[keyPlato];
    var checked = (plato.status == "3") ? 'checked' : '';
    var monto = plato.precioUnitario * (1 - (plato.descuento / 100));
    return `<tr class="table-${classStatus(plato.status)}" style="cursor: pointer;" onclick="CheckearItem(this, event)">
        <td class="text-truncate" style="min-width: 50px;">
            <div style="display: inline-block;">
                <button class="badge badge-danger border-0 eliminar" onclick="ModalEliminar('${plato.idPedido}')">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="custom-control custom-checkbox" style="display: inline-block;">
                <input type="checkbox"
                class="custom-control-input"
                id="check-pedido-${plato.idPedido}" ${checked}
                idPedido="${plato.idPedido}"
                total="${plato.precioTotal}">
                <label class="custom-control-label" for="check-pedido-${plato.idPedido}">
                    ${(esCombo) ? "COMBO - "+plato.plato.nombre : plato.plato.nombre}
                </label>
            </div>
        </td>

        <td center class="text-truncate" style="min-width: 50px;">
            ${statusText(plato.status)}
        </td>

        <td right class="text-truncate" style="min-width: 50px;">
            ${MONEDA} ${Formato.Numerico( monto, 2 )}
        </td>

        <td center class="text-truncate" style="min-width: 50px;">
            ${plato.cantidad}
        </td>

        <td right class="font-weight-bold text-truncate" style="min-width: 50px;">
            ${MONEDA} ${Formato.Numerico( plato.precioTotal, 2 )}
        </td>
    </tr>`;
}

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
    campoTotal.innerHTML = MONEDA + " " + Formato.Numerico(totalFactura, 2);
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
 * Alarmas
 * 
 */

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
 * Eliminar
 * 
 */

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






/**
 * 
 * Facturar
 * 
 */

 function ModalConfirmarFacturacion(idMesa) {
    let datos = listaMesas.filter(item => item.idMesa == idMesa)[0];
    document.getElementById("confirmarFacturacion-nombreMesa").innerHTML = datos.alias;
    document.getElementById("confirmarFacturacion-submit").setAttribute('onclick', `Facturar('${idMesa}')`);
    $("#modal-confirmar-facturacion").modal('show');
 }

 function ModalDespuesFacturacion(idFactura) {
    document.getElementById("despuesFacturacion-MostrarPDF").onclick = function() {
        let url = HOST_GERENCIAL_AJAX+`Facturas/PDF/${idFactura}/`;
        window.open(url, '_blank');
    }

    let formEnvioCorreo = document.getElementById('form-envio-correo');
    formEnvioCorreo.onsubmit = function(e) {
        e.preventDefault();
        let url = `${HOST_GERENCIAL_AJAX}Facturas/Enviar_Correo/`;
        let data = new FormData(formEnvioCorreo);
        data.append('idFactura', idFactura);
        AJAX.Enviar({
            url: url,
            data: data,
            antes() {
                Loader.Mostrar();
            },
            error(mensaje) {
                Loader.Ocultar();
                Alerta.Danger(mensaje);
            },
            ok(data) {
                Loader.Ocultar();
                Alerta.Success('Se ha enviado el correo exitosamente.');
            }
        });
    }

    $("#modal-despues-facturacion").modal('show');
 }

/**
 * 
 * @param {*} idMesa 
 */
function Facturar(idMesa)
{
    $("#modal-confirmar-facturacion").modal('hide');

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

    if(idsPedidos.length <= 0) {
        Alerta.Danger("Debe seleccionar almenos un pedido.");
        return;
    }
    
    socket.emit('facturar', {
        idMesa: idMesa,
        idsPedidos: idsPedidos
    });

    Loader.Mostrar();

    socket.on('cambio', function(data) {
        Loader.Ocultar();
    });
}

/**
 * 
 */
socket.on('imprimir', function(obj) {
    ModalDespuesFacturacion(obj.idFactura);
});

/**
 * 
 */
socket.on('ws:error-factura', function(mensaje) {
    Loader.Ocultar();
    Alerta.Danger(mensaje);
});

function CheckAll(element) {
    let form = document.getElementById('lista-pedidos-mesa');
    let elementos = form.elements;

    for(let elemento of elementos) {
        if(elemento.type != 'checkbox') continue;
        if(elemento == element) continue;
                
        if(element.checked)
        {
            elemento.checked = true;
        }
        else
        {
            elemento.checked = false;
        }

        CalcularFactura();
    }
}