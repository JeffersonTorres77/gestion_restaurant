var datos_combos = [];

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
    precio.innerHTML = "BsS. " + Formato.Numerico(datos.precio, 2);
    precioDescuento.innerHTML = "BsS. " + Formato.Numerico(datos.precio_descuento, 2);

    cantidad.value = (datos.cantidad > 0) ? datos.cantidad : 1;
    observaciones.value = datos.nota;

    document.getElementById("boton-confirmar").onclick = function() { GuardarPedidoTemporal(tarjeta, fila) };

    modal.modal("show");
}

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

    var tbody = document.getElementById("table-tbody");
    tbody.innerHTML = "";
    var total = 0;

    for(var plato of PLATOS)
    {
        if(plato.cantidad <= 0) continue;

        var nombre = plato.nombre;
        var cantidad = plato.cantidad;
        var totalPlato = cantidad * plato.precio_descuento;
        var nota = (plato.nota != "") ? 'Si' : 'No';

        total = Number(total) + Number(totalPlato);

        tbody.innerHTML += '<tr>' +
        '   <td class="text-truncate">' +
        '       <div class="d-flex align-items-center">' +
        '           <div class="plato-miniatura mr-2">' +
        '               <img class="float-left" src="'+plato.imagen+'">' +
        '           </div>' +
        '           ' + nombre + 
        '       </div>' +
        '   </td>' +

        '   <td center style="vertical-align: middle;">' +
        '       ' + cantidad +
        '   </td>' +

        '   <td class="text-truncate" right style="vertical-align: middle;">' +
        '       BsS. ' + Formato.Numerico(totalPlato, 2) +
        '   </td>' +

        '   <td center style="vertical-align: middle;">' +
        '       ' + nota +
        '   </td>' +
        '</tr>';
    }

    tbody.innerHTML += '<tr>' +
    '   <td colspan="2" right>' +
    '       <div class="h5 mb-0">Total</div>' +
    '   </td>' +
    
    '   <td right>' +
    '       BsS. ' + Formato.Numerico(total, 2) +
    '   </td>' +
    
    '   <td></td>' +
    '</tr>';

    modal.modal("show");
}