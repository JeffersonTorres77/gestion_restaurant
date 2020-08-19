/*================================================================================
 *
 *	Variables
 *
================================================================================*/
var listaMesas = [];
var keyMesaActualizar = null;

// IDs Elementos
var idBotonStatus = "boton-status";
var idContenedorMesas = "contenedor-mesas";
var idVer = {
    modal: "modal-ver",
    textTitulo: "text-ver-nombreMesa",
    listaPedido: "lista-pedidos-mesa"
}

// Elementos
var botonStatus = document.getElementById(idBotonStatus);
var contenedorMesas = document.getElementById(idContenedorMesas);

// Extra
botonStatus.setAttribute("class", "btn btn-sm btn-secondary");
botonStatus.innerHTML = "Conectando...";
var ver = {
    modal: $("#" + idVer.modal),
    textTitulo: document.getElementById(idVer.textTitulo),
    listaPedido: document.getElementById(idVer.listaPedido)
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
                codePedidos += ComboHTML(datos);
                for(let pedido of datos.pedidos) {
                    if(pedido.status == 2) {
                        classCardHeader = "bg-warning";
                    }
                }
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
                Entregado
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
    <div class="py-1 px-2 bg-warning font-weight-bold border-bottom border-warning" center>
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
        return "";
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
    keyMesaActualizar = keyMesa;
    var objMesa = listaMesas[keyMesa];
    var listaModal = ver.listaPedido;
    var header = ver.textTitulo.parentElement.parentElement;
    ver.textTitulo.innerHTML = objMesa.alias;

    header.className = "modal-header bg-primary text-white";
    listaModal.innerHTML = '';

    if(objMesa.solicitar_camarero) {
        listaModal.innerHTML += `<div onclick="QuitarAlarma('${objMesa.id}')" class="list-group-item list-group-item-action list-group-item-warning position-relative" center>
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

        for(var objPedido of objMesa.pedidos)
        {
            var esCombo = objPedido.esCombo;
            var datos = objPedido.datos;

            if(esCombo)
            {
                var conNota = false;
                for(var pedido of datos.pedidos) {
                    if(pedido.nota != "") {
                        conNota = true;
                        break;
                    }
                }

                codePedidos += ComboModalHTML(
                    datos.lote, datos.imagen,
                    datos.nombre, datos.descuento,
                    datos.status, conNota,
                    datos.pedidos
                );
            }
            else
            {
                var conNota = (datos.nota != "");
                var nota = (datos.nota == "") ? '<span class="text-muted">(Ninguna)</span>' : datos.nota;
                var codigoCollapse = `Nota: <b>${nota}</b>`;

                codePedidos += PlatoModalHTML(
                    datos.id, datos.plato.imagen,
                    datos.plato.nombre, datos.cantidad,
                    datos.status, conNota, codigoCollapse
                );
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
 * @param {*} loteCombo 
 * @param {*} imagen 
 * @param {*} nombre 
 * @param {*} descuento 
 * @param {*} idStatus 
 * @param {*} pedidos 
 */
function ComboModalHTML(loteCombo, imagen, nombre, descuento, idStatus, conNota, pedidos)
{
    var codeHTML = "";

    var codePlatos = "";
    for(var pedido of pedidos)
    {
        var conNota = (pedido.nota != "");
        var nota = (pedido.nota == "") ? '<span class="text-muted">(Ninguna)</span>' : pedido.nota;
        var codigoCollapse = `<div> Nota: <b>${nota}</b> </div>`;
                
        codePlatos += PlatoModalHTML(
            pedido.idPedido, pedido.imagenPlato,
            pedido.nombrePlato, pedido.cantidad,
            pedido.status, conNota,
            codigoCollapse);
    }

    codeHTML = `<div class="list-group-item pt-0 pr-0 hover">
        <div class="py-2 px-0" style="margin-left: -10px;">
            ${nombre}
        </div>

        <div class="list-group border rounded">
            ${codePlatos}
        </div>
    </div>`;
    return codeHTML;
}

/**
 * 
 * @param {*} idPedido 
 * @param {*} imagen 
 * @param {*} nombre 
 * @param {*} cantidad 
 * @param {*} idStatus 
 * @param {*} nota 
 */
function PlatoModalHTML(idPedido, imagen, nombre, cantidad, idStatus, conNota = false, codigoCollapse = "")
{
    imagen = HOST + imagen;
    var idCollapse = `collapse-pedido-${idPedido}`;
    var status = StatusHTML(idStatus);
    var statusNota = (conNota) ? '<div class="badge badge-warning">Con nota</div>' : '';

    var botones = `<button class="btn btn-sm btn-info mx-1" style="padding: 0.25rem 0.75rem;" data-toggle="collapse" data-target="#${idCollapse}">
        <i class="fas fa-info"></i>
    </button>`;

    var classItem = "list-group-item list-group-item-action";
    if(idStatus == '1')
    {
        classItem += " list-group-item-info";
    }
    else if(idStatus == '2')
    {
        classItem += " list-group-item-warning";
        botones = `<button class="btn btn-sm btn-success" onclick="ConfirmarPedido('${idPedido}')">
            <i class="fas fa-check"></i>
            ¡Listo!
        </button>
        ${botones}`;
    }

    var codeHTML = `<div class="${classItem}">
        <div class="position-relative">
            <div class="tarjeta-miniatura-pedido">
                <div>
                    <div class="imagen-pedido">
                        <img src="${imagen}" alt="...">
                    </div>
                </div>

                <div>
                    <h6 class="font-weight-bold mb-1">${nombre}</h6>
                    <div>Cantidad: <b>${cantidad}</b></div>
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

    return codeHTML;
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