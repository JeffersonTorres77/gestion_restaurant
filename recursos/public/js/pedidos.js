
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
/**
 * 
 */
ActualizarPedidos();
function ActualizarPedidos()
{
    var divPedidos = document.getElementById("contenedor-pedidos");

    var url = WEBSOCKET_URL + "Consultar/Cantidad-Pedidos/";
    var data = new FormData();
    data.append("key", KEY);

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
            var cantidad = data.cantidad;
            if(cantidad <= 0) {
                divPedidos.removeAttribute("cantidad");
            } else {
                divPedidos.setAttribute("cantidad", cantidad);
            }
        }
    });
}

/*================================================================================
 *
 *	Ver pedidos
 *
================================================================================*/
/**
 * 
 */
document.getElementById("boton-actualizar-ver-pedidos").onclick = function() { VerPedidos(); }
function VerPedidos()
{
    var divPedidos = document.getElementById("contenedor-pedidos");
    var lista = document.getElementById("lista-pedidos-general");
    var modal = $("#consultar-pedidos-mesa");
    var botonConfirmar = document.getElementById("boton-confirmar-ver-pedidos");

    var url = WEBSOCKET_URL + "Consultar/Pedidos/";
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

            var botonActivo = false;
            var code = "";

            if(cantidad <= 0) {
                divPedidos.removeAttribute("cantidad");
            } else {
                divPedidos.setAttribute("cantidad", cantidad);
            }
            
            for(var keyPedido in pedidos)
            {
                var pedidoActual = pedidos[keyPedido];
                var esCombo = pedidoActual.esCombo;
                var datos = pedidoActual.datos;
                var botonEliminar = false;

                if(esCombo)
                {
                    var comboActual = datos;
                    var imagen = HOST + comboActual.imagen;
                    var status = StatusHTML(comboActual.status);
                    var statusNota = "";
                    var botonEliminar = false;
                    if(comboActual.status == 0) {
                        botonActivo = true;
                        botonEliminar = true;
                    }

                    var codePedidos = "";
                    for(var pedido of comboActual.pedidos)
                    {
                        if(pedido.nota != "" && statusNota == "") {
                            statusNota = `<div class="badge badge-warning">Con nota</div>`;
                        }
    
                        var codePlato = PedidoPlatoHTML(keyPedido,
                            pedido.imagenPlato,
                            pedido.nombrePlato,
                            pedido.cantidad,
                            pedido.status,
                            `collapse-${pedido.idPedido}`,
                            pedido.nota,
                            false);
        
                        codePedidos += `<li class="list-group-item list-group-item-action"> ${codePlato} </li>`;
                    }

                    let botones = `<button class="btn btn-sm btn-info mx-1" style="padding: 0.25rem 0.641rem;" data-toggle="collapse" data-target="#collapse-lote-${comboActual.lote}">
                        <i class="fas fa-angle-down"></i>
                    </button>`;
                    if(botonEliminar) {
                        botones = `<button class="btn btn-sm btn-danger mx-1" onclick="EliminarComboCliente('${keyPedido}')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        ${botones}`;
                    }

                    code += `<li class="list-group-item list-group-item-action">
                        <div class="position-relative">
                            <div class="tarjeta-miniatura-pedido">
                                <div>
                                    <div class="imagen-pedido">
                                        <img src="${imagen}" alt="...">
                                    </div>
                                </div>

                                <div>
                                    <h6 class="font-weight-bold mb-1">${comboActual.nombre}</h6>
                                    <div>Descuento: <b>${comboActual.descuento}%</b></div>
                                    <div>${status} ${statusNota}</div>
                                </div>
                            </div>

                            <div class="position-absolute d-flex align-items-center h-100" style="top: 0px; right: 0px;">
                                ${botones}
                            </div>
                        </div>

                        <div class="collapse" id="collapse-lote-${comboActual.lote}">
                            <div class="border rounded mt-2 p-2 bg-light">
                                <ul class="list-group list-group-flush"> ${codePedidos} </ul>
                            </div>
                        </div>
                    </li>`;
                }
                else
                {
                    var platoActual = datos;
                    var pedido = platoActual;
                    if(pedido.status == 0) {
                        botonActivo = true;
                        botonEliminar = true;
                    }

                    var codePlato = PedidoPlatoHTML(keyPedido,
                        pedido.imagenPlato,
                        pedido.nombrePlato,
                        pedido.cantidad,
                        pedido.status,
                        `collapse-${pedido.idPedido}`,
                        pedido.nota,
                        botonEliminar);

                    code += `<li class="list-group-item list-group-item-action"> ${codePlato} </li>`;
                }
            }
            
            botonConfirmar.disabled = (botonActivo) ? false : true;
            lista.innerHTML = (code != "") ? code : `<li class="list-group-item">
                <h5 center class="my-2">
                    No hay pedidos registrados.
                </h5>
            </li>`;

            Loader.Ocultar();
            modal.modal('show');
        }
    });
}

/**
 * 
 * @param {*} objPedido 
 */
function PedidoPlatoHTML(keyPedido, imagen, nombre, cantidad, idStatus, idCollapse, nota, botonEliminar = true)
{
    imagen = HOST + imagen;
    var status = StatusHTML(idStatus);
    var statusNota = (nota != "") ? '<div class="badge badge-warning">Con nota</div>' : '';
    nota = (nota == "") ? '<span class="text-muted">(Ninguna)</span>' : nota;
    var botones = `<button class="btn btn-sm btn-info mx-1" style="padding: 0.25rem 0.75rem;" data-toggle="collapse" data-target="#${idCollapse}">
        <i class="fas fa-info"></i>
    </button>`;

    if(botonEliminar) {
        botones = `<button class="btn btn-sm btn-danger mx-1" onclick="EliminarPedidoCliente('${keyPedido}')">
            <i class="fas fa-trash-alt"></i>
        </button>
        ${botones}`;
    }

    var codeHTML = `<div class="position-relative">
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
            Nota: <b>${nota}</b>
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
            statusHTML = `<div class="badge badge-success">Sin confirmar</div>`;
        break;

        case ("1", 1):
            statusHTML = `<div class="badge badge-primary">En espera</div>`;
        break;

        case ("2", 2):
            statusHTML = `<div class="badge badge-primary">En espera</div>`;
        break;

        case ("3", 3):
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
    var datos = listaPedidos[keyPedido].datos;
    var r = confirm(`¿Esta seguro que desea eliminar el pedido ${datos.idPedido} - ${datos.nombrePlato} de la lista?`);
    if(r == false) return;

    var url = WEBSOCKET_URL + "Eliminar/Plato/";
    var data = new FormData();
    data.append("key", KEY);
    data.append("idPedido", datos.idPedido);

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

/**
 * 
 * @param {*} keyPedido 
 */
function EliminarComboCliente(keyPedido)
{
    var datos = listaPedidos[keyPedido].datos;
    var r = confirm(`¿Esta seguro que desea eliminar el combo ${datos.lote} - ${datos.nombre} de la lista?`);
    if(r == false) return;

    var url = WEBSOCKET_URL + "Eliminar/Combo/";
    var data = new FormData();
    data.append("key", KEY);
    data.append("idPedido", datos.pedidos[0].idPedido);

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

    var url = WEBSOCKET_URL + "Confirmar/Pedidos/";
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