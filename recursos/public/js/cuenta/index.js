/**
 * 
 */
var botonActualizar = document.getElementById('boton-actualizar-cuenta');
var botonCamarero = document.getElementById('boton-llamarCamarero');
var tbody = document.getElementById('tbody-cuenta');

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
    var url = WEBSOCKET_URL + "Consultar/Pedidos/";
    var data = new FormData();
    data.append("key", KEY);

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
            var codeHTML = "";
            var pedidos = data.pedidos;
            var totalCuenta = 0;

            if(pedidos.length > 0)
            {
                for(var pedido of pedidos)
                {
                    var esCombo = pedido.esCombo;
                    var datos = pedido.datos;

                    if(esCombo)
                    {
                        for(var pedidoCombo of datos.pedidos)
                        {
                            var descripcion = pedidoCombo.nombreCombo + " - " + pedidoCombo.nombrePlato;
                            var status = pedidoCombo.status;
                            var precio = pedidoCombo.precioUnitario * (1 - (pedidoCombo.descuento / 100));
                            var cantidad = pedidoCombo.cantidad;
                            var total = pedidoCombo.precioTotal;
                            codeHTML += CodigoPlato(descripcion, status, precio, cantidad, total);

                            totalCuenta += Number(total);
                        }
                    }
                    else
                    {
                        var descripcion = datos.nombrePlato;
                        var status = datos.status;
                        var precio = datos.precioUnitario * (1 - (datos.descuento / 100));
                        var cantidad = datos.cantidad;
                        var total = datos.precioTotal;
                        codeHTML += CodigoPlato(descripcion, status, precio, cantidad, total);

                        totalCuenta += Number(total);
                    }
                }

                codeHTML += `<tr>
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
 */
function CodigoPlato(descripcion, idStatus, precio, cantidad, total)
{
    idStatus = idStatus.toString();
    var codePlato = "";
    var status = "Error";

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
    }

    codePlato = `<tr class="table-sm">
        <td left class="text-truncate">
            ${descripcion}
        </td>

        <td center>
            ${status}
        </td>

        <td right class="text-truncate">
            ${MONEDA} ${Formato.Numerico(precio, 2)}
        </td>

        <td center>
            ${cantidad}
        </td>

        <td right class="text-truncate">
           ${MONEDA}  ${Formato.Numerico(total, 2)}
        </td>
    </tr>`;

    return codePlato;
}

/**
 * 
 */
botonCamarero.onclick = function() { Llamar_Camarero(); }

/**
 * 
 */
function Llamar_Camarero()
{
    LlamarCamarero();
}