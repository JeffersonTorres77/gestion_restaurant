/**
 * Elementos
 */
let botonActualizar = document.getElementById('boton-actualizar-cuenta');
let contenedor = document.getElementById('contenedor');

let modal = $("#modal-entrega");
let label = document.getElementById('label-entrega');
let form = document.getElementById('form-entrega');
let inputLoteOrden = document.getElementById('loteOrden-entrega');

let lista_pedidos = [];

/**
 * Al cargar la pagina
 */
Actualizar();

/**
 * Evento del boton de actualizar
 */
botonActualizar.onclick = () => {
    Actualizar();
}

/**
 * Actualizar datos
 */
function Actualizar() {
    var url = WEBSOCKET_URL + "Pedidos/Consulta/";
    var data = new FormData();
    data.append("key", KEY);
    data.append("para_llevar", true);
    data.append("no_status", 0);

    AJAX.api({
        url: url,
        data: data,

        antes: () => {
            contenedor.innerHTML = `<div class="col-12 p-0 px-3">
                <div center>
                    <div class="spinner-grow text-primary" role="status"></div>
                </div>
            </div>`;
        },

        error: (mensaje) => {
            contenedor.innerHTML = `<div class="col-12 p-0 px-3">
                <div class="card bg-light text-danger font-weight-bold center p-2" center>
                    ${mensaje}
                </div>
            </div>`;
        },

        ok: (data) => {
            lista_pedidos = EmpaquetarPedidos(data);

            if(lista_pedidos.cantidad > 0) {
                let codeHTML = "";

                for(let keyLote in lista_pedidos.lotes) {
                    let objLote = lista_pedidos.lotes[keyLote];

                    codeHTML += `<div class="col-12 col-md-6 mb-3">
                    <div class="card h-100 sombra" onclick="ModalEntrega('${keyLote}')">
                        <div class="card-body p-0">`;

                    for(let keyPedido in objLote) {
                        objPedido = objLote[keyPedido];
                        if(objPedido.esCombo) {
                            codeHTML += codeCombo(objPedido);
                        } else {
                            codeHTML += codePlato(objPedido.platos[0]);
                        }
                    }

                    let datetime = objLote[0].platos[0].fecha_registro.split(' ');
                    let fecha = datetime[0];
                    let hora = datetime[1];

                    codeHTML += `</div>
                            <div class="card-footer p-2 small" center>
                                ${fecha} a las ${hora}
                            </div>
                        </div>
                    </div>`;
                }

                contenedor.innerHTML = codeHTML;
            } else {
                contenedor.innerHTML = `<div class="col-12 p-0 px-3">
                    <div class="card bg-light text-dark font-weight-bold center p-3 mb-0 h5" center>
                        No hay pedidos registrados.
                    </div>
                </div>`;
            }
        }
    });
}

/**
 * Estructura el codigo HTML del combo
 * @param {Object} pedido 
 */
function codeCombo(pedido) {
    comboHTML = `<div class="small px-1 pt-1 font-weight-bold">${pedido.combo.nombre}</div>`;

    for(let i=0; i<pedido.platos.length; i++) {
        comboHTML += codePlato(pedido.platos[i]);
    }

    return comboHTML;
}

/**
 * Estructura el codigo HTML del plato
 * @param {Object} objPlato 
 */
function codePlato(objPlato) {
    let nombre = objPlato.plato.nombre;
    let cantidad = objPlato.cantidad;
    let classStatus = "danger";
    let status = "Error";

    switch(objPlato.status) {
        case 1:
            classStatus = "primary";
            status = "En cocina";
            break;

        case 2:
            classStatus = "primary";
            status = "Por entregar";
            break;

        case 4:
            classStatus = "success";
            status = "Por entregar";
            break;
    }

    return `<div class="px-2 py-1">
        ${nombre} (${cantidad})
        <div class="float-right">
            <div class="badge badge-${classStatus}">${status}</div>
        </div>
    </div>`;
}

/**
 * 
 * @param {Object} listaPedidos 
 */
function EmpaquetarPedidos(listaPedidos) {
    let response = {
        cantidad: listaPedidos.cantidad,
        lotes: {}
    };

    for(let i=0; i<listaPedidos.pedidos.length; i++) {
        let pedidoActual = listaPedidos.pedidos[i];
        let loteOrden = pedidoActual.loteOrden;

        if(response.lotes[loteOrden] == undefined) {
            response.lotes[loteOrden] = [];
        }

        response.lotes[loteOrden].push(pedidoActual);
    }

    return response;
}

/**
 * Mostrar el modal de entrega
 * @param {Int} loteOrden 
 */
function ModalEntrega(loteOrden) {
    let pedidos = lista_pedidos.lotes[loteOrden];
    for(let pedido of pedidos) {
        for(let plato of pedido.platos) {
            if(plato.status != 4) {
                return;
            }
        }
    }

    modal.modal('show');
    inputLoteOrden.value = loteOrden;
}

/**
 * Entregar los pedidos
 */
function Entregar()
{
    var url = WEBSOCKET_URL + "Pedidos/Facturar/Para_Llevar/";
    var data = new FormData(form);
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
            inputLoteOrden.value = "";
            Actualizar();
            Loader.Ocultar();
            modal.modal("hide");
        }
    });
}