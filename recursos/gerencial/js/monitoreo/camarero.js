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
    textTitulo: document.getElementById("text-ver-nombreMesa"),
    listaPedido: document.getElementById("lista-pedidos-mesa")
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
        accion: "MonitoreoCamarero",
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

socket.on('actualizar', function(data)
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

    var alertaCamarero = (objMesa.solicitar_camarero == false) ? '' : `
    <div class="py-1 px-2 alert alert-warning mb-0 rounded-0 font-weight-bold border-bottom border-warning" center>
        <i class="fas fa-bell"></i>
        Se solicita al camarero
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
    keyMesaActualizar = keyMesa;
    var objMesa = listaMesas[keyMesa];
    var listaModal = ver.listaPedido;
    var header = ver.textTitulo.parentElement.parentElement;
    ver.textTitulo.innerHTML = objMesa.alias;

    header.className = "modal-header bg-primary text-white";
    listaModal.innerHTML = '';

    if(objMesa.solicitar_camarero) {
        listaModal.innerHTML += `<div onclick="QuitarAlarma('${objMesa.idMesa}')" class="list-group-item list-group-item-action list-group-item-warning position-relative" center>
            <i class="fas fa-bell"></i>
            Se solicita al camarero

            <div class="position-absolute p-2" style="top: 0px; right: 0px;">
                <button class="btn btn-sm btn-danger">
                    <i class="fas fa-xs fa-times"></i>
                </button>
            </div>
        </div>`;
    }

    if(objMesa.pedidos.length > 0)
    {
        var codePedidos = "";

        for(var keyPedido in objMesa.pedidos)
        {
            var objPedido = objMesa.pedidos[keyPedido];
            var esCombo = objPedido.esCombo;
            var platos = objPedido.platos;

            if(esCombo)
            {
                var conNota = false;
                for(var plato of platos) {
                    if(plato.nota != "") {
                        conNota = true;
                        break;
                    }
                }

                codePedidos += ComboModalHTML(keyMesa, keyPedido);
            }
            else
            {
                codePedidos += PlatoModalHTML(keyMesa, keyPedido, 0);
            }
        }

        listaModal.innerHTML += codePedidos;
    }
    else
    {
        if(objMesa.status == "CERRADA")
        {
            header.className = "modal-header bg-danger text-white";
            listaModal.innerHTML += `<li class="list-group-item">
                <h5 center class="mb-0 text-muted p-2">
                    <i class="fas fa-lock"></i> Cerrada
                </h5>
            </li>`;
        }
        else
        {
            listaModal.innerHTML += `<li class="list-group-item">
                <h5 center class="mb-0 text-muted p-2">
                    (Vacio)
                </h5>
            </li>`;
        }
    }

    ver.modal.modal('show');
}

ver.modal.on('hidden.bs.modal', function() {
    keyMesaActualizar = null;
});

/**
 * 
 * @param {*} keyMesa 
 * @param {*} keyPedido 
 */
function ComboModalHTML(keyMesa, keyPedido)
{
    var objMesa = listaMesas[keyMesa];
    var objPedido = objMesa.pedidos[keyPedido];

    var codePlatos = "";
    for(var keyPlato in objPedido.platos)
    {                
        codePlatos += PlatoModalHTML(keyMesa, keyPedido, keyPlato);
    }

    return `<div class="list-group-item pt-0 pr-0 hover">
        <div class="py-2 px-0" style="margin-left: -10px;">
            ${objPedido.combo.nombre}
        </div>

        <div class="list-group border rounded">
            ${codePlatos}
        </div>
    </div>`;
}

/**
 * 
 * @param {*} keyMesa 
 * @param {*} keyPedido 
 * @param {*} keyPlato 
 */
function PlatoModalHTML(keyMesa, keyPedido, keyPlato)
{
    var objMesa = listaMesas[keyMesa];
    var objPedido = objMesa.pedidos[keyPedido];
    var objPlato = objPedido.platos[keyPlato];

    imagen = HOST + objPlato.plato.imagen;
    var idCollapse = `collapse-pedido-${objPlato.idPedido}`;
    var status = StatusHTML(objPlato.status);
    var statusNota = (objPlato.nota != "") ? '<div class="badge badge-warning">Con nota</div>' : '';
    var codigoCollapse = `Nota: <b>${objPlato.nota}</b>`;

    var botones = `<button class="btn btn-sm btn-info mx-1" style="padding: 0.25rem 0.75rem;" data-toggle="collapse" data-target="#${idCollapse}">
        <i class="fas fa-info"></i>
    </button>`;

    var classItem = "list-group-item list-group-item-action";
    if(objPlato.status == '1')
    {
        classItem += " list-group-item-info";
    }
    else if(objPlato.status == '2')
    {
        classItem += " list-group-item-warning";
        botones = `<button class="btn btn-sm btn-success" onclick="ConfirmarPedido('${objPlato.idPedido}')">
            <i class="fas fa-check"></i>
            ¡Listo!
        </button>
        ${botones}`;
    }

    return `<div class="${classItem}">
        <div class="position-relative">
            <div class="tarjeta-miniatura-pedido">
                <div>
                    <div class="imagen-pedido">
                        <img src="${imagen}" alt="...">
                    </div>
                </div>

                <div>
                    <h6 class="font-weight-bold mb-1">${objPlato.plato.nombre}</h6>
                    <div>Cantidad: <b>${objPlato.cantidad}</b></div>
                    <div>${status} ${statusNota}</div>
                </div>
            </div>

            <div class="position-absolute d-flex align-items-center h-100" style="top: 0px; right: 0px;">
                ${botones}
            </div>
        </div>

        <div class="collapse" id="${idCollapse}">
            <div class="border rounded mt-2 p-2 bg-light">
                ${codigoCollapse}
            </div>
        </div>
    </div>`;
}

/**
 * 
 * @param {*} idStatus 
 */
function StatusHTML(idStatus)
{
    var statusHTML = `<div class="badge badge-danger">Error</div>`;
    switch(idStatus)
    {
        case ("0", 0):
            statusHTML = `<div class="badge badge-light">Sin confirmar</div>`;
        break;

        case ("1", 1):
            statusHTML = `<div class="badge badge-primary">En cocina</div>`;
        break;

        case ("2", 2):
            statusHTML = `<div class="badge badge-warning">Cocinado</div>`;
        break;

        case ("3", 3):
            statusHTML = `<div class="badge badge-dark">Entregado</div>`;
        break;

        case ("4", 4):
            statusHTML = `<div class="badge badge-success">Entregado</div>`;
        break;
    }

    return statusHTML;
}

/*================================================================================
 *
 *	Confirmar
 *
================================================================================*/
/**
 * 
 * @param {*} idPedido 
 */
function ConfirmarPedido(idPedido)
{
    Loader.Mostrar();

    socket.emit('entrega', {
        idPedido: idPedido
    });
}

socket.on('exito', function(data) {
    var idMesa = data.idMesa;
    var key = null;

    for(var keyMesa in listaMesas)
    {
        var objMesa = listaMesas[keyMesa];
        if(objMesa.id == idMesa) {
            key = keyMesa;
            break;
        }
    }

    keyMesaActualizar = key;
});

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