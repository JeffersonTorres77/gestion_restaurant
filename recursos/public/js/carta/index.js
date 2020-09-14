var datos_platos = [];

function Actualizar()
{
    var contenedor = document.getElementById("contenedor-platos");
    var url = `${HOST_AJAX}Carta/Consultar/`;
    var data = new FormData();

    var parametros = Hash.getParametros();
    if(parametros.categoria != null && parametros.categoria != undefined)
    {
        data.append("categoria", parametros.categoria);
    }

    AJAX.Enviar({
        url: url,
        data: data,

        antes: function()
        {
            contenedor.innerHTML = `<div class="w-100 p-3" center>
                <div class="spinner-grow" role="status"></div>
            </div>`;
        },

        error: function(mensaje)
        {
            Alerta.Danger(mensaje);
            contenedor.innerHTML = `<div class="alert alert-danger">
                Error al cargar los datos.
                <button class="float-right btn btn-sm btn-danger" onclick="Actualizar()"><i class="fas fa-sync-alt"></i></button>
            </div>`;
        },

        ok: function(cuerpo)
        {
            contenedor.innerHTML = '';

            var categorias = cuerpo.categorias;
            datos_platos = [];
            var code = "";

            var index = 0;
            for(var categoria of categorias)
            {
                var platos = categoria.platos;

                code += '<div class="card mb-3">';
                code += '   <div class="card-header">';
                code += '       <h5 class="mb-0">'+categoria.nombre+'</h5>';
                code += '   </div>';

                code += '   <div class="card-body">';
                code += '       <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 px-2">';

                for(var plato of platos)
                {
                    code += '<div class="mb-4 d-flex justify-content-center px-2" onclick="ModalVer('+index+')">';
                    code += '   <div class="card card-especial" tabindex="0">';
                    code += '       <img src="'+plato.imagen+'" class="card-img-top border-bottom">';

                    code += '       <div class="card-body">';
                    code += '           <p class="card-text mb-1">';
                    code += '               ' + plato.nombre;
                    code += '           </p>';
                    
                    code += '           <h5 class="card-title mb-0">';
                    code += '               ' + MONEDA + ' ' + Formato.Numerico(plato.precio, 2);
                    code += '           </h5>';
                    code += '       </div>';
                    code += '   </div>';
                    code += '</div>';

                    datos_platos.push(plato);
                    index += 1;
                }

                code += '       </div>';
                code += '   </div>';
                code += '</div>';
            }

            contenedor.innerHTML = code;
        }
    });
}

window.onhashchange = function() { ActualizarHash(); }
window.onload = function() { ActualizarHash(); }

function ActualizarHash()
{
    Actualizar();
    var hash = location.hash.substr(1);
    var opcionesCategorias = document.getElementById("menu-lateral-categorias-opciones").getElementsByTagName("a");
    var select = document.getElementById("select-carta-categoria");

    for(var opcion of opcionesCategorias)
    {
        opcion.setAttribute("class", opcion.getAttribute("class").replace(" active", ""));
    }

    var idCategoria = hash.split("=")[1];
    if(idCategoria == undefined)
    {
        opcionesCategorias[0].setAttribute("class", opcionesCategorias[0].getAttribute("class") + " active");
        select.value = "";
    }
    else
    {
        var id = idCategoria.replace("/", "");
        select.value = id;
        for(var opcion of opcionesCategorias)
        {
            if(opcion.getAttribute("categoria") != id) {
                continue;
            }

            opcion.setAttribute("class", opcion.getAttribute("class") + " active");
        }
    }
}

Actualizar();

/**
 * 
 * @param {*} elemento 
 */
function CambioCategoria(elemento)
{
    var valor = elemento.value;
    var hash = "/";

    if(valor != "") {
        hash = "/categoria="+valor+"/";
    }

    location.hash = hash;
}

/**
 * 
 * @param {*} fila 
 */
function ModalVer(fila)
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

    var modal = $("#" + idModal);
    var form = document.getElementById(idForm);
    var datos = datos_platos[fila];

    form.reset();

    id.value = datos.id;
    img.src = datos.imagen;
    nombre.innerHTML = datos.nombre;
    categoria.innerHTML = datos.categoria.nombre;
    descripcion.innerHTML = datos.descripcion.replace(/\n/g, "<br>");
    precio.innerHTML = MONEDA + " " + Formato.Numerico(datos.precio, 2);

    modal.modal("show");
}

/**
 * 
 */
function ConfirmarPedido()
{
    var idModal = "modal-ver";
    var idForm = "form-ver";

    if(Formulario.Validar(idForm) == false) return;
    
    var modal = $("#" + idModal);
    var form = document.getElementById(idForm);

    var url = WEBSOCKET_URL + "Pedidos/Registro/Plato/";
    var data = new FormData(form);
    data.append("key", KEY);

    AJAX.api({
        url: url,
        data: data,

        antes: function ()
        {
            Loader.Mostrar();
        },

        error: function (mensaje)
        {
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },

        ok: function (cuerpo)
        {
            ActualizarPedidos();
            Loader.Ocultar();
            modal.modal("hide");
            form.reset();
            Formulario.QuitarClasesValidaciones(idForm);
        }
    });
}