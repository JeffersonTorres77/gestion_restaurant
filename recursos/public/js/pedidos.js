/*================================================================================
 *
 *	Variables
 *
================================================================================*/
var listaPlato = [];
var listaCombos = [];
var listaPedidos = [];

/*================================================================================
 *
 *	Valor del carrito (numero)
 *
================================================================================*/
ActualizarPedidos();
function ActualizarPedidos()
{
    var url = WEBSOCKET_URL + "Pedidos/Consulta/";
    var data = new FormData();
    data.append("key", KEY);
    data.append("status", 0);

    AJAX.api({
        url: url,
        data: data,

        antes: function() {

        },
        error: function(mensaje) {
            if(mensaje == "404") mensaje = "Servicio de WebSocket no activo.";
            Alerta.Danger(mensaje);
        },
        ok: function(data) {
            ActualizarNumeroPedidos(data.cantidad);
        }
    });
}

/**
 * Actualizar el numero rojo de pedidos
 * @param {*} cantidad 
 */
function ActualizarNumeroPedidos(cantidad)
{
    var divPedidos = document.getElementById("contenedor-pedidos");
    if(cantidad <= 0) {
        divPedidos.removeAttribute("cantidad");
    } else {
        divPedidos.setAttribute("cantidad", cantidad);
    }
}

/*================================================================================
 *
 *	Ver pedidos
 *
================================================================================*/
document.getElementById("boton-actualizar-ver-pedidos").onclick = function() { VerPedidos(); }
function VerPedidos()
{
    var url = WEBSOCKET_URL + "Pedidos/Consulta/";
    var data = new FormData();
    data.append("key", KEY);

    AJAX.api({
        url: url,
        data: data,

        antes: function() {
            Loader.Mostrar();
        },
        error: function(mensaje) {
            Loader.Ocultar();
            if(mensaje == "404") mensaje = "Servicio de WebSocket no activo.";
            Alerta.Danger(mensaje);
        },
        ok: function(data) {
            var cantidad = data.cantidad;
            var pedidos = data.pedidos;

            listaPedidos = pedidos;

            var cantSinConfirmar = 0;
            for(let pedido of pedidos) {
                for(let plato of pedido.platos) {
                    if(plato.status == 0) {
                        cantSinConfirmar += 1;
                    }
                }
            }

            ActualizarNumeroPedidos(cantSinConfirmar);
            ModalPedidosMesa();
            Loader.Ocultar();
        }
    });
}

function ModalPedidosMesa()
{
    var lista = document.getElementById("lista-pedidos-general");
    var modal = $("#consultar-pedidos-mesa");
    var botonConfirmar = document.getElementById("boton-confirmar-ver-pedidos");
    var botonActivo = false;

    var code = "";
    for(var keyPedido in listaPedidos)
    {
        var pedidoActual = listaPedidos[keyPedido];
        var esCombo = pedidoActual.esCombo;
        var lote = pedidoActual.lote;
        var combo = pedidoActual.combo;
        var platos = pedidoActual.platos;
        var botonEliminar = false;

        if(esCombo)
        {
            for(let indexPlato in platos) {
                var platoActual = platos[indexPlato];
                if(platoActual.status == 0) {
                    botonActivo = true;
                }
            }

            code += PedidoComboHTML(keyPedido);
        }
        else
        {
            var indexPlato = 0;
            var platoActual = platos[indexPlato];
            if(platoActual.status == 0) {
                botonActivo = true;
            }

            var codePlato = PedidoPlatoHTML(keyPedido, indexPlato);
            code += `<li class="list-group-item list-group-item-action"> ${codePlato} </li>`;
        }
    }

    botonConfirmar.disabled = (botonActivo) ? false : true;
    lista.innerHTML = (code != "") ? code : `<li class="list-group-item">
        <h5 center class="my-2">
            No hay pedidos registrados.
        </h5>
    </li>`;

    modal.modal('show');
}

/**
 * 
 * @param {*} keyPedido 
 * @param {*} keyPlato 
 * @param {*} botonEliminar 
 */
function PedidoPlatoHTML(keyPedido, keyPlato)
{
    let pedido = listaPedidos[keyPedido];
    let plato = pedido.platos[keyPlato];

    var idPedido = plato.idPedido;
    var imagen = HOST + plato.plato.imagen;
    var status = StatusHTML(plato.status);
    var idCollapse = `collapse-pedido-${idPedido}`;
    var statusNota = (plato.nota != "") ? '<div class="badge badge-warning">Con nota</div>' : '';
    var nota = (plato.nota == "") ? '<span class="text-muted">(Ninguna)</span>' : plato.nota;
    var botonEliminar = (plato.status == 0 && pedido.esCombo == false) ? true : false;
    var botones = `<button class="btn btn-sm btn-info mx-1" style="padding: 0.25rem 0.75rem;" data-toggle="collapse" data-target="#${idCollapse}">
        <i class="fas fa-info"></i>
    </button>`;

    if(botonEliminar) {
        botones = `<button class="btn btn-sm btn-danger mx-1" onclick="EliminarPedidoCliente('${keyPedido}')">
            <i class="fas fa-trash-alt"></i>
        </button>
        ${botones}`;
    }

    return `<div class="position-relative">
        <div class="tarjeta-miniatura-pedido">
            <div>
                <div class="imagen-pedido">
                    <img src="${imagen}" alt="...">
                </div>
            </div>

            <div>
                <h6 class="font-weight-bold mb-1">${plato.plato.nombre}</h6>
                <div>Cant: <b>${plato.cantidad}</b></div>
                <div>${status} ${statusNota}</div>
            </div>
        </div>

        <div class="position-absolute d-flex align-items-center h-100" style="top: 0px; right: 0px;">
            ${botones}
        </div>
    </div>

    <div class="collapse" id="${idCollapse}">
        <div class="border rounded mt-2 p-2 bg-light">
            Nota: <b>${nota}</b>
        </div>
    </div>`;
}

/**
 * 
 * @param {*} keyPedido 
 */
function PedidoComboHTML(keyPedido)
{
    let pedido = listaPedidos[keyPedido];
    let combo = pedido.combo;
    let platos = pedido.platos;
    let lote = pedido.lote;

    var imagen = HOST + combo.imagen;
    var status = platos[0].status;
    var statusNota = "";
    var botonEliminar = false;
    
    var codePlatos = "";
    for(indexPlato in platos) {
        var platoActual = platos[indexPlato];
        if(platoActual.status == 0) {
            botonActivo = true;
            botonEliminar = true;
        }

        var codePlato = PedidoPlatoHTML(keyPedido, indexPlato, botonEliminar);
        codePlatos += `<li class="list-group-item list-group-item-action"> ${codePlato} </li>`;

        if(status > platoActual.status) {
            status = platoActual.status;
        }

        if(statusNota == "" && platoActual.nota != "") {
            statusNota = `<div class="badge badge-warning">Con nota</div>`;
        }
    }

    var statusHTML = StatusHTML(status);
    if(status == 0) {
        botonEliminar = true;
    }

    var botones = `<button class="btn btn-sm btn-info mx-1" style="padding: 0.25rem 0.641rem;" data-toggle="collapse" data-target="#collapse-lote-${lote}">
        <i class="fas fa-angle-down"></i>
    </button>`;
    if(botonEliminar) {
        botones = `<button class="btn btn-sm btn-danger mx-1" onclick="EliminarPedidoCliente('${keyPedido}')">
            <i class="fas fa-trash-alt"></i>
        </button>
        ${botones}`;
    }

    return `<li class="list-group-item list-group-item-action">
        <div class="position-relative">
            <div class="tarjeta-miniatura-pedido">
                <div>
                    <div class="imagen-pedido">
                        <img src="${imagen}" alt="...">
                    </div>
                </div>

                <div>
                    <h6 class="font-weight-bold mb-1">${combo.nombre}</h6>
                    <div>Descuento: <b>${combo.descuento}%</b></div>
                    <div>${statusHTML} ${statusNota}</div>
                </div>
            </div>

            <div class="position-absolute d-flex align-items-center h-100" style="top: 0px; right: 0px;">
                ${botones}
            </div>
        </div>

        <div class="collapse" id="collapse-lote-${lote}">
            <div class="border rounded mt-2 p-2 bg-light">
                <ul class="list-group list-group-flush"> ${codePlatos} </ul>
            </div>
        </div>
    </li>`;
}

/**
 * 
 * @param {*} idStatus 
 */
function StatusHTML(idStatus)
{
    idStatus = Number(idStatus);
    var statusHTML = `<div class="badge badge-danger">Error</div>`;
    switch(idStatus)
    {
        case 0:
            statusHTML = `<div class="badge badge-success">Sin confirmar</div>`;
        break;

        case 1:
            statusHTML = `<div class="badge badge-primary">En espera</div>`;
        break;

        case 2:
            statusHTML = `<div class="badge badge-primary">En espera</div>`;
        break;

        case 3:
            statusHTML = `<div class="badge badge-dark">Entregado</div>`;
        break;
    }

    return statusHTML;
}

/*================================================================================
 *
 *	Eliminar pedido
 *
================================================================================*/
/**
 * 
 * @param {*} keyPedido 
 */
function EliminarPedidoCliente(keyPedido)
{
    var pedido = listaPedidos[keyPedido];
    var esCombo = pedido.esCombo;
    var combo = pedido.combo;
    var lote = pedido.lote;
    var platos = pedido.platos;

    var msj = "";
    if(esCombo) {
        msj = `¿Esta seguro que desea eliminar el combo ${lote} - ${combo.nombre} de la lista?`;
    } else {
        msj = `¿Esta seguro que desea eliminar el pedido ${platos[0].idPedido} - ${platos[0].plato.nombre} de la lista?`;
    }

    var r = confirm(msj);
    if(r == false) return;

    var url = WEBSOCKET_URL + "Pedidos/Eliminar/";
    var data = new FormData();
    data.append("key", KEY);
    data.append("idPedido", platos[0].idPedido);

    AJAX.api({
        url: url,
        data: data,

        antes: function() {
            Loader.Mostrar();
        },
        error: function(mensaje) {
            Loader.Ocultar();
            if(mensaje == "404") mensaje = "Servicio de WebSocket no activo.";
            Alerta.Danger(mensaje);
        },
        ok: function(data) {
            Loader.Ocultar();
            VerPedidos();
        }
    });
}

/*================================================================================
 *
 *	Confirmar todo
 *
================================================================================*/
/**
 * 
 */
document.getElementById("boton-confirmar-ver-pedidos").onclick = function() { ConfirmarTodosLosPedidosMesa(); }
function ConfirmarTodosLosPedidosMesa()
{
    var r = confirm(`¿Esta seguro que desea confirmar todos los pedidos?`);
    if(r == false) return;

    var modal = $("#consultar-pedidos-mesa");

    var url = WEBSOCKET_URL + "Pedidos/Confirmar/";
    var data = new FormData();
    data.append("key", KEY);

    AJAX.api({
        url: url,
        data: data,

        antes: function() {
            Loader.Mostrar();
        },
        error: function(mensaje) {
            Loader.Ocultar();
            if(mensaje == "404") mensaje = "Servicio de WebSocket no activo.";
            Alerta.Danger(mensaje);
        },
        ok: function(data) {
            ActualizarPedidos();
            Loader.Ocultar();
            modal.modal("hide");
        }
    });
}