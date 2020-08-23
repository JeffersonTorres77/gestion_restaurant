/**
 * 
 * @param {*} fila 
 * @param {*} tarjeta 
 */
function ModalVer(fila, tarjeta)
{
    var idModal = "modal-ver";
    var idForm = "form-ver";
    
    Formulario.QuitarClasesValidaciones(idForm);

    var id = document.getElementById("campo-ver-id");
    var img = document.getElementById("campo-ver-img");
    var nombre = document.getElementById("campo-ver-nombre");
    var categoria = document.getElementById("campo-ver-categoria");
    var descripcion = document.getElementById("campo-ver-descripcion");
    var precio = document.getElementById("campo-ver-precio");
    var precioDescuento = document.getElementById("campo-ver-precioDescuento");
    var cantidad = document.getElementById("campo-ver-cantidad");
    var observaciones = document.getElementById("campo-ver-observaciones");

    var modal = $("#" + idModal);
    var form = document.getElementById(idForm);
    var datos = PLATOS[fila];

    form.reset();

    id.value = datos.id;
    img.src = datos.imagen;
    nombre.innerHTML = datos.nombre;
    categoria.innerHTML = datos.categoria.nombre;
    descripcion.innerHTML = datos.descripcion;
    precio.innerHTML = MONEDA + " " + Formato.Numerico(datos.precio, 2);
    precioDescuento.innerHTML = MONEDA + " " + Formato.Numerico(datos.precio_descuento, 2);

    var form = document.getElementById("form-categoria-"+datos.categoria.id);
    var limiteActual = form.getAttribute("limite");
    var cantActual = getCantPlatosCategoria(datos.categoria.id, fila);
    if(cantActual < 0) cantActual = 0;
    var limite = (limiteActual - cantActual < 0) ? 0 : limiteActual - cantActual;
    for(let option of cantidad.getElementsByTagName('option'))
    {
        if(Number(option.value) <= limite) {
            option.disabled = false;
            option.className = "font-weight-bold";
        } else {
            option.disabled = true;
            option.className = "d-none";
        }
    }

    var cantSiguiente = (datos.cantidad <= 0) ? 1 : (Number(datos.cantidad) + 1);
    if(cantSiguiente > limite) cantSiguiente = limite;
    cantidad.value = cantSiguiente;

    observaciones.value = datos.nota;

    document.getElementById("boton-confirmar").onclick = function() { GuardarPedidoTemporal(tarjeta, fila) };
    document.getElementById("boton-ver-quitar").onclick = function() { EliminarSeleccion(tarjeta, fila); };

    modal.modal("show");
}

function getCantPlatosCategoria(idCategoria, fila = null)
{
    let count = 0;

    for(var key in PLATOS)
    {
        var plato = PLATOS[key];
        if(fila != null && fila == key) continue;
        if(plato.categoria.id != idCategoria) continue;
        count += Number(plato.cantidad);
    }

    return count;
}

/**
 * 
 * @param {*} fila 
 * @param {*} tarjeta 
 */
function EliminarSeleccion(tarjeta, fila)
{
    var cantidad = document.getElementById("campo-ver-cantidad");
    var observaciones = document.getElementById("campo-ver-observaciones");
    cantidad.value = 0;
    observaciones.value = "";
    GuardarPedidoTemporal(tarjeta, fila);
}

/**
 * 
 * @param {*} tarjeta 
 * @param {*} fila 
 */
function GuardarPedidoTemporal(tarjeta, fila)
{
    if(Formulario.Validar("form-ver") == false) return;
    var form = document.getElementById("form-ver");
    var modal = $("#modal-ver");

    var cantidad = document.getElementById("campo-ver-cantidad");
    var observaciones = document.getElementById("campo-ver-observaciones");

    var idCategoria = tarjeta.getAttribute("idCategoria");
    var idPlato = tarjeta.getAttribute("idPlato");

    if(ValidarCategoria(idCategoria, idPlato, cantidad.value) == false) {
        Alerta.Danger("Ya ha seleccionado suficientes platos en esta categoria.");
        return;
    }
    
    if(cantidad.value > 0) {
        tarjeta.getElementsByClassName("card")[0].style.border = "2px solid green";
    } else {
        tarjeta.getElementsByClassName("card")[0].removeAttribute("style");
    }

    PLATOS[fila].cantidad = cantidad.value;
    PLATOS[fila].nota = observaciones.value;

    tarjeta.getElementsByClassName("cantidad")[0].value = cantidad.value;

    modal.modal("hide");
    Formulario.QuitarClasesValidaciones("form-ver");
    form.reset();
}

/**
 * 
 * @param {*} idCategoria 
 * @param {*} idPlato 
 * @param {*} cantidadAgregar 
 */
function ValidarCategoria(idCategoria, idPlato, cantidadAgregar)
{
    var labelCantidad = document.getElementById("label-cantCategoria-"+idCategoria);
    var form = document.getElementById("form-categoria-"+idCategoria);
    var limite = form.getAttribute("limite");
    var cantidad = 0;

    for(var elemento of form.elements)
    {
        if(elemento.getAttribute("idPlato") == idPlato)
        {
            cantidad += Number(cantidadAgregar);
        }
        else
        {
            cantidad += Number(elemento.value);
        }
    }

    if(cantidad > limite) {
        return false;
    } else {
        labelCantidad.innerHTML = cantidad;
        return true;
    }
}

/**
 * 
 */
function ModalConfirmar()
{
    var modal = $("#modal-confirmar");
    
    for(var categoria of LIMITES)
    {
        var cantidad = 0;
        var limite = categoria.limite;

        for(var plato of PLATOS)
        {
            if(plato.categoria.id != categoria.id) continue;
            if(plato.cantidad <= 0) continue;
            cantidad = Number(cantidad) + Number(plato.cantidad);
        }

        if(cantidad < limite) {
            Alerta.Danger("Aun debe seleccionar <b>"+(limite - cantidad)+" platos</b> de la categoria <b>"+categoria.nombre+"</b>.");
            return;
        }

        if(cantidad > limite) {
            Alerta.Danger("Ha seleccionado demasiados platos en la categoria <b>"+categoria.nombre+"</b>.");
            return;
        }
    }

    var lista = document.getElementById('lista-pedidos');
    var totalLista = document.getElementById('lista-pedidos-total');
    var total = 0;

    lista.innerHTML = "";
    for(var plato of PLATOS)
    {
        if(plato.cantidad <= 0) continue;

        var id = plato.id;
        var nombre = plato.nombre;
        var cantidad = plato.cantidad;
        var totalPlato = cantidad * plato.precio_descuento;
        var nota = plato.nota;

        total = Number(total) + Number(totalPlato);

        lista.innerHTML += `<div class="list-group-item list-group-item-action">
            <div class="position-relative">
                <div class="tarjeta-miniatura-pedido">
                    <div class="imagen-pedido">
                        <img src="${plato.imagen}" alt="...">
                    </div>

                    <div>
                        <h6 class="font-weight-bold mb-1">${plato.nombre}</h6>

                        <div>
                            Cantidad: <b>${plato.cantidad}</b>
                            ${(nota == "") ? '' : `<div class="badge badge-warning">Nota</div>`}
                        </div>

                        <div class="font-weight-bold text-success big">
                            ${MONEDA} ${Formato.Numerico(totalPlato, 2)}
                        </div>
                    </div>
                </div>

                <div class="position-absolute d-flex align-items-center h-100" style="top: 0px; right: 0px;">
                    <button class="btn btn-sm btn-info mx-1" style="padding: 0.25rem 0.75rem;" data-toggle="collapse" data-target="#collapse-${id}">
                        <i class="fas fa-info"></i>
                    </button>
                </div>
            </div>

            <div class="collapse" id="collapse-${id}">
                <div class="border rounded mt-2 p-2 bg-light">
                    Nota: <b>${(nota == "") ? '(Vacio)' : nota}</b>
                </div>
            </div>
        </div>`;
    }
    
    totalLista.innerHTML = `${MONEDA} ${Formato.Numerico(total, 2)}`;

    modal.modal("show");
}

/**
 * 
 */
function ConfirmarPedido()
{
    var modal = $("#modal-confirmar");
    var url = WEBSOCKET_URL + "Registro/Combo/";
    var data = new FormData();
    data.append("key", KEY);

    for(var categoria of LIMITES)
    {
        var cantidad = 0;
        var limite = categoria.limite;

        for(var plato of PLATOS)
        {
            if(plato.categoria.id != categoria.id) continue;
            if(plato.cantidad <= 0) continue;
            cantidad = Number(cantidad) + Number(plato.cantidad);
        }

        if(cantidad < limite) {
            Alerta.Danger("Aun debe seleccionar <b>"+(limite - cantidad)+" platos</b> de la categoria <b>"+categoria.nombre+"</b>.");
            return;
        }

        if(cantidad > limite) {
            Alerta.Danger("Ha seleccionado demasiados platos en la categoria <b>"+categoria.nombre+"</b>.");
            return;
        }
    }
    
    data.append("idCombo", ID_COMBO);
    var index = 0;

    for(var plato of PLATOS)
    {
        if(plato.cantidad <= 0) continue;

        data.append("platos["+index+"][id]", plato.id);
        data.append("platos["+index+"][idCategoria]", plato.categoria.id);
        data.append("platos["+index+"][cantidad]", plato.cantidad);
        data.append("platos["+index+"][nota]", plato.nota);

        index += 1;
    }

    AJAX.api({
        url: url,
        data: data,

        antes: function()
        {
            Loader.Mostrar();
        },

        error: function(mensaje)
        {
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },

        ok: function(cuerpo)
        {            
            location.href = HOST + "Menus/";
        }
    });
}