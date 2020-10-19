/**
 * 
 */
var botonActualizar = document.getElementById('boton-actualizar-cuenta');
var botonCamarero = document.getElementById('boton-llamarCamarero');
var tbody = document.getElementById('tbody-cuenta');
var listaPedidos = [];

var botonPagar = document.getElementById('boton-pagar');
var modalPagar = $("#modal-pagar");
var formPagar = document.getElementById("form-pagar");

/**
 * 
 */
botonActualizar.onclick = function() { Actualizar(); }
Actualizar();

/**
 * 
 */
function Actualizar()
{
    var url = WEBSOCKET_URL + "Pedidos/Consulta/";
    var data = new FormData();
    data.append("key", KEY);
    data.append("para_llevar", true);
    data.append('status', 0);

    AJAX.api({
        url: url,
        data: data,

        antes: function() {
            tbody.innerHTML = `<tr>
                <td colspan="100">
                    <h5 center>Cargando...</h5>
                </td>
            </tr>`;
        },

        error: function(mensaje) {
            mensaje = (mensaje == "404") ? 'Servidor de WebSockets no activo' : mensaje;
            tbody.innerHTML = `<tr>
                <td colspan="100" class="table-danger">
                    <h5 center class="mb-0 py-3">${mensaje}</h5>
                </td>
            </tr>`;
        },

        ok: function(data) {
            var botonPagarActivo = false;
            var codeHTML = "";
            listaPedidos = data.pedidos;
            var pedidos = data.pedidos;
            var totalCuenta = 0;

            if(pedidos.length > 0)
            {
                for(var indexPedido in pedidos)
                {
                    var pedido = pedidos[indexPedido];
                    var esCombo = pedido.esCombo;
                    var platos = pedido.platos;
                    var combo = pedido.combo;

                    if(esCombo)
                    {
                        for(var plato of platos)
                        {
                            var descripcion = combo.nombre + " - " + plato.plato.nombre;
                            var status = plato.status;
                            var precio = plato.precioUnitario * (1 - (plato.descuento / 100));
                            var cantidad = plato.cantidad;
                            var total = plato.precioTotal;
                            var numero_factura = plato.numero_factura;
                            codeHTML += CodigoPlato(descripcion, status, precio, cantidad, total, indexPedido, numero_factura);

                            if(plato.status == 0) {
                                botonPagarActivo = true;
                            }

                            if(plato.status == 4) {
                                botonListoActivo = true;
                            }

                            totalCuenta += Number(total);
                        }
                    }
                    else
                    {
                        var plato = pedido.platos[0];
                        var descripcion = plato.plato.nombre;
                        var status = plato.status;
                        var precio = plato.precioUnitario * (1 - (plato.descuento / 100));
                        var cantidad = plato.cantidad;
                        var total = plato.precioTotal;
                        var numero_factura = plato.numero_factura;

                        if(plato.status == 0) {
                            botonPagarActivo = true;
                        }

                        codeHTML += CodigoPlato(descripcion, status, precio, cantidad, total, indexPedido, numero_factura);

                        totalCuenta += Number(total);
                    }
                }

                botonPagar.disabled = !(botonPagarActivo);

                codeHTML += `<tr class="table-sm">
                    <td colspan="4">
                        <b>TOTAL</b>
                    </td>

                    <td right>
                        <b>
                            ${MONEDA} ${Formato.Numerico(totalCuenta, 2)}
                        </b>
                    </td>
                </tr>`;
            }
            else
            {
                codeHTML = `<tr>
                    <td colspan="100">
                        <h5 center class="p-2 mb-0">No hay pedidos registrados.</h5>
                    </td>
                </tr>`;
            }
            
            tbody.innerHTML = codeHTML;
        }
    });
}

/**
 * 
 * @param {*} descripcion 
 * @param {*} idStatus 
 * @param {*} precio 
 * @param {*} cantidad 
 * @param {*} total 
 * @param {*} index 
 */
function CodigoPlato(descripcion, idStatus, precio, cantidad, total, index, numero_factura)
{
    idStatus = idStatus.toString();
    var codePlato = "";
    var status = "Error";

    if(numero_factura == undefined) numero_factura = "";

    switch(idStatus) {
        case "0":
            status = `<div class="badge badge-success">Sin confirmar</div>`;
            break;

        case "1":
            status = `<div class="badge badge-primary">En espera</div>`;
            break;
            
        case "2":
            status = `<div class="badge badge-primary">En espera</div>`;
            break;
            
        case "3":
            status = `<div class="badge badge-dark">Entregado</div>`;
            break;
            
        case "4":
            status = `<div class="badge badge-dark">Entregado</div>`;
            break;
    }

    let botonEliminar = '';
    if(idStatus == 0) {
        botonEliminar = `
        <label class="badge badge-danger" tabindex="0" style="cursor: pointer;" onclick="EliminarPedidoCliente(${index})">
            <i class="fas fa-sm fa-times"></i>
        </label>`;
    }

    codePlato = `<tr class="table-sm">
        <td style="vertical-align: middle;" center>
            ${botonEliminar}
        </td>

        <td left class="text-truncate" style="vertical-align: middle;">
            ${descripcion}
        </td>

        <td center style="vertical-align: middle;">
            ${status}
        </td>

        <td center style="vertical-align: middle;">
            ${cantidad}
        </td>

        <td right class="text-truncate" style="vertical-align: middle;">
           ${MONEDA}  ${Formato.Numerico(total, 2)}
        </td>
    </tr>`;

    return codePlato;
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
            Actualizar();
        }
    });
}

botonPagar.onclick = function() { ModalPagar(); }

/**
 * 
 */
function ModalPagar()
{
    modalPagar.modal('show');
}

/**
 * 
 */
function Pagar()
{
    var url = WEBSOCKET_URL + "Pedidos/Confirmar/";
    var data = new FormData(formPagar);
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
            Actualizar();
            formPagar.reset();
            Loader.Ocultar();
            modalPagar.modal("hide");
            
            window.open(HOST_GERENCIAL_AJAX+'Facturas/PDF/'+data.idFactura+'/', '_blank');
        }
    });
}