var listaPedidos = [];

// Elementos
var botonStatus = document.getElementById("boton-status");
var selectArea = document.getElementById("select-area");
var contenedorPedidos = document.getElementById("contenedor-pedidos");
var ver = {
    modal: $("#modal-ver"),
    textId: document.getElementById("text-ver-idPedido"),
    inpuVerId: document.getElementById("input-ver-id"),
    inpuVerPlato: document.getElementById("input-ver-plato"),
    inpuVerCategoria: document.getElementById("input-ver-categoria"),
    inpuVerNumero: document.getElementById("input-ver-numero"),
    inpuVerMesa: document.getElementById("input-ver-mesa"),
    inpuVerCantidad: document.getElementById("input-ver-cantidad"),
    inpuVerNota: document.getElementById("input-ver-nota"),
    imgVerPlato: document.getElementById("img-ver-plato"),
    tagCombo: document.getElementById("tag-combo")
};

// Extra
botonStatus.setAttribute("class", "btn btn-sm btn-secondary");
botonStatus.innerHTML = "Conectando...";

// Web Sockets
var intentosConexion = 0;
var socket = io(WEBSOCKET_URL, {
    query: {
        accion: "MonitoreoPedidos",
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

// Eventos propios
socket.on('ws:error', (data) =>
{
    Loader.Ocultar();
    contenedorPedidos.setAttribute('vacio', 'true');
    contenedorPedidos.innerHTML = `<div class="col-12 p-0 px-3">
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
    Loader.Ocultar();
    ver.modal.modal('hide');
    ActualizarPedidos();
});

socket.on('actualizar', function(data)
{
    Loader.Ocultar();
    listaPedidos = data;
    PintarPedidos();
});

// Otros eventos
selectArea.onchange = function() {
    ActualizarPedidos();
}

// Funciones
function ActualizarPedidos()
{
    socket.emit('actualizar', {
        idAreaMonitoreo: selectArea.value
    });
}

/**
 * 
 */
function PintarPedidos()
{
    if(listaPedidos.length > 0)
    {
        contenedorPedidos.setAttribute('vacio', 'false');
        contenedorPedidos.innerHTML = "";
        codeHTML = "";

        for(var keyPedido in listaPedidos)
        {
            codeHTML += PedidoHTML(keyPedido);
        }

        contenedorPedidos.innerHTML = codeHTML;
    }
    else
    {
        contenedorPedidos.setAttribute('vacio', 'true');
        contenedorPedidos.innerHTML = `<div class="col-12 p-0 px-3">
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
 * @param {*} keyPedido 
 */
function PedidoHTML(keyPedido)
{
    var objPedido = listaPedidos[keyPedido];

    var arrayFR = objPedido.fecha_registro.split(" ");
    var fechaRegistro = arrayFR[0];
    var horaRegistro = arrayFR[1];

    var arrayFM = objPedido.fecha_modificacion.split(" ");
    var fechaModificacion = arrayFR[0];
    var horaModificacion = arrayFR[1];

    var nota = (objPedido.nota == "") ? `<span class="text-muted">(Vacio)</span>` : objPedido.nota;

    var code = `<div class="card-pedido col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-3" style="cursor: pointer;" onclick="ModalVer('${keyPedido}')">
        <div class="card sombra h-100 sombra">
            <div class="card-header p-2">
                <div class="h6 mb-0">${objPedido.plato.nombre}</div>
            </div>

            <div class="card-body p-2">
                <p class="mb-0"><b>Pedido N° ${objPedido.id}</b></p>
                <p class="mb-0">Cant: <b>${objPedido.cantidad}</b></p>
                <p class="mb-0">Nota: <b>${nota}</b></p>
            </div>

            <div class="card-footer p-1" center>
                <small>${Formato.Fecha(fechaModificacion)} a las ${horaModificacion}</small>
            </div>
        </div>
    </div>`;

    return code;
}

/**
 * 
 * @param {*} keyPedido 
 */
function ModalVer(keyPedido)
{
    var objPedido = listaPedidos[keyPedido];

    ver.textId.innerHTML = objPedido.id;
    ver.inpuVerId.value = objPedido.id;
    ver.inpuVerPlato.innerHTML = objPedido.plato.nombre;
    ver.inpuVerCategoria.innerHTML = objPedido.categoria.nombre;
    ver.inpuVerNumero.innerHTML = objPedido.id;
    ver.inpuVerMesa.innerHTML = objPedido.mesa.nombre;
    ver.inpuVerCantidad.innerHTML = objPedido.cantidad;
    ver.inpuVerNota.innerHTML = (objPedido.nota == "") ? '(Vacio)' : objPedido.nota;
    ver.imgVerPlato.src = HOST+objPedido.plato.imagen;

    ver.tagCombo.className = (objPedido.combo == undefined) ? 'd-none' : 'badge badge-success';

    ver.modal.modal('show');
}

function ConfirmarPedido()
{
    var idPedido = ver.inpuVerId.value;

    Loader.Mostrar();

    socket.emit('entrega', {
        idPedido: idPedido
    });
}