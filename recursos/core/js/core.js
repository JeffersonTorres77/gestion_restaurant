"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (this && this.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (_) try {
            if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [op[0] & 2, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};
var AJAX = (function () {
    function AJAX() {
    }
    AJAX.Enviar = function (objeto) {
        if (objeto === void 0) { objeto = {
            url: "",
            data: new FormData(),
            method: "POST",
            antes: function () { },
            error: function (mensaje) { },
            ok: function (datos) { }
        }; }
        return __awaiter(this, void 0, void 0, function () {
            var response, respuesta, e_1, error, cuerpo, mensaje_1;
            return __generator(this, function (_a) {
                switch (_a.label) {
                    case 0:
                        if (objeto.url == undefined || objeto.url == null)
                            throw "[AJAX][Error] -> No se envio la URL.";
                        if (objeto.data == undefined || objeto.data == null)
                            objeto.data = new FormData();
                        if (objeto.method == undefined || objeto.method == null)
                            objeto.method = "POST";
                        if (objeto.antes == undefined || objeto.antes == null)
                            objeto.antes = function () { };
                        if (objeto.error == undefined || objeto.error == null)
                            objeto.error = function () { };
                        if (objeto.ok == undefined || objeto.ok == null)
                            objeto.ok = function () { };
                        _a.label = 1;
                    case 1:
                        _a.trys.push([1, 7, , 8]);
                        objeto.antes();
                        return [4, fetch(objeto.url, {
                                method: objeto.method,
                                body: objeto.data
                            })];
                    case 2:
                        response = _a.sent();
                        _a.label = 3;
                    case 3:
                        _a.trys.push([3, 5, , 6]);
                        return [4, response.json()];
                    case 4:
                        respuesta = _a.sent();
                        return [3, 6];
                    case 5:
                        e_1 = _a.sent();
                        alert("Ocurrio un error con la petición AJAX.");
                        console.error(e_1);
                        return [3, 6];
                    case 6:
                        error = respuesta.error;
                        cuerpo = respuesta.cuerpo;
                        if (error.status == true) {
                            if (AUDITORIA)
                                console.error(cuerpo);
                            objeto.error(error.mensaje);
                        }
                        else {
                            objeto.ok(cuerpo);
                        }
                        return [3, 8];
                    case 7:
                        mensaje_1 = _a.sent();
                        if (AUDITORIA) {
                            console.error(mensaje_1);
                        }
                        objeto.error("[AJAX][Error]:\n" + mensaje_1);
                        return [3, 8];
                    case 8: return [2];
                }
            });
        });
    };
    AJAX.api = function (objeto) {
        return __awaiter(this, void 0, void 0, function () {
            var jsonAux_1;
            return __generator(this, function (_a) {
                if (objeto.url == undefined || objeto.url == null)
                    throw "[AJAX][Error] -> No se envio la URL.";
                if (objeto.data == undefined || objeto.data == null)
                    objeto.data = {};
                if (objeto.method == undefined || objeto.method == null)
                    objeto.method = "POST";
                if (objeto.antes == undefined || objeto.antes == null)
                    objeto.antes = function () { };
                if (objeto.error == undefined || objeto.error == null)
                    objeto.error = function () { };
                if (objeto.ok == undefined || objeto.ok == null)
                    objeto.ok = function () { };
                if (objeto.data instanceof FormData) {
                    jsonAux_1 = {};
                    objeto.data.forEach(function (value, key) {
                        jsonAux_1[key] = value;
                    });
                    objeto.data = jsonAux_1;
                }
                $.ajax({
                    url: objeto.url,
                    data: objeto.data,
                    method: objeto.method,
                    dataType: 'json',
                    beforeSend: function () {
                        objeto.antes();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error(errorThrown);
                        objeto.error(errorThrown);
                    },
                    success: function (data, status, xhr) {
                        var error = data.error;
                        var cuerpo = data.cuerpo;
                        if (error.status) {
                            console.error(error.mensaje);
                            objeto.error(error.mensaje);
                        }
                        else {
                            objeto.ok(cuerpo);
                        }
                    }
                });
                return [2];
            });
        });
    };
    return AJAX;
}());
var Alerta = (function () {
    function Alerta() {
    }
    Alerta.Iniciar = function () {
        var div = document.createElement("div");
        div.setAttribute("class", "contenedor-alertas");
        div.setAttribute("id", this.id);
        document.body.appendChild(div);
    };
    Alerta.Agregar = function (mensaje, tipo) {
        var contenedor = document.getElementById(this.id);
        if (contenedor == null || contenedor == undefined) {
            this.Iniciar();
            contenedor = document.getElementById(this.id);
        }
        var alerta = document.createElement("div");
        var cantidad = contenedor.getElementsByClassName("alert").length;
        var id = "alerta-sistema-" + cantidad;
        if (cantidad == 10) {
            alert(mensaje);
            return;
        }
        alerta.setAttribute("class", "alert alert-" + tipo + " alert-dismissible fade show m-3");
        alerta.setAttribute("id", id);
        alerta.innerHTML =
            '<button class="close" data-dismiss="alert">' +
                '   <span>&times;</span>' +
                '</button>' +
                mensaje;
        contenedor.append(alerta);
        setTimeout(function () { $("#" + id).alert("close"); }, 5000);
    };
    Alerta.Primary = function (mensaje) {
        this.Agregar(mensaje, "primary");
    };
    Alerta.Secondary = function (mensaje) {
        this.Agregar(mensaje, "secondary");
    };
    Alerta.Success = function (mensaje) {
        this.Agregar(mensaje, "success");
    };
    Alerta.Danger = function (mensaje) {
        this.Agregar(mensaje, "danger");
    };
    Alerta.Warning = function (mensaje) {
        this.Agregar(mensaje, "warning");
    };
    Alerta.Info = function (mensaje) {
        this.Agregar(mensaje, "info");
    };
    Alerta.Light = function (mensaje) {
        this.Agregar(mensaje, "light");
    };
    Alerta.Dark = function (mensaje) {
        this.Agregar(mensaje, "dark");
    };
    Alerta.id = "contendor-alertas-general";
    return Alerta;
}());
var Buscador = (function () {
    function Buscador(idInputBuscador, idBotonBuscador, funcionBuscar) {
        this.idInputBuscador = idInputBuscador;
        this.idBotonBuscador = idBotonBuscador;
        this.funcionBuscar = funcionBuscar;
        var input = document.getElementById(this.idInputBuscador);
        var boton = document.getElementById(this.idBotonBuscador);
        if (input == null || input == undefined) {
            console.error("Input del buscador no existe.");
            return;
        }
        if (boton == null || boton == undefined) {
            console.error("Boton del buscador no existe.");
            return;
        }
        this.AsignarActividad();
    }
    Buscador.prototype.AsignarActividad = function () {
        var input = document.getElementById(this.idInputBuscador);
        var boton = document.getElementById(this.idBotonBuscador);
        var thisObj = this;
        input.onkeyup = function (e) {
            if (e.key == "Enter") {
                boton.click();
            }
        };
        boton.onclick = function (e) {
            var valor = input.value;
            Buscar(valor);
        };
        function Buscar(valor) {
            var parametros = [];
            if (valor != "") {
                parametros['buscar'] = valor;
            }
            var hash = "/" + Hash.Parametro2String(parametros);
            hash = hash.replace(/ /g, "_");
            location.hash = hash;
            window[thisObj.funcionBuscar]();
        }
    };
    return Buscador;
}());
var Filtro = (function () {
    function Filtro(idCollapse, idForm, idBoton, funcionBuscar) {
        this.idCollapse = idCollapse;
        this.idForm = idForm;
        this.idBoton = idBoton;
        this.funcionBuscar = funcionBuscar;
        var collapse = document.getElementById(this.idCollapse);
        var form = document.getElementById(this.idForm);
        var boton = document.getElementById(this.idBoton);
        if (collapse == null || collapse == undefined) {
            console.error("Collapse del filtro no existe.");
            return;
        }
        if (form == null || form == undefined) {
            console.error("Form del filtro no existe.");
            return;
        }
        if (boton == null || boton == undefined) {
            console.error("Boton del filtro no existe.");
            return;
        }
        this.AsignarAcciones();
    }
    Filtro.prototype.AsignarAcciones = function () {
        var collapse = document.getElementById(this.idCollapse);
        var form = document.getElementById(this.idForm);
        var boton = document.getElementById(this.idBoton);
        var thisObj = this;
        boton.onclick = function (e) {
            Filtro();
        };
        function Filtro() {
            var parametros = [];
            var cant = 0;
            for (var i = 0; i < form.elements.length; i++) {
                var elemento = form.elements[i];
                var name_1 = elemento.name;
                var valor = elemento.value;
                if (valor == "")
                    continue;
                cant += 1;
                parametros[name_1] = valor;
            }
            if (cant > 0) {
                parametros['filtros'] = "si";
            }
            var hash = "/" + Hash.Parametro2String(parametros);
            hash = hash.replace(/ /g, "_");
            location.hash = hash;
            window[thisObj.funcionBuscar]();
            $("#" + thisObj.idCollapse).collapse("hide");
        }
    };
    return Filtro;
}());
var Formulario = (function () {
    function Formulario() {
    }
    Formulario.Sync = function (idForm) {
        var form = document.getElementById(idForm);
        for (var i = 0; i < form.elements.length; i++) {
            var input = form.elements[i];
            if (input.type == "select-one") {
                var options = input.getElementsByTagName("option");
                var indexSelected = input.selectedIndex;
                for (var j = 0; j < options.length; j++) {
                    options[j].removeAttribute("selected");
                }
                options[indexSelected].setAttribute("selected", "");
            }
            else if (input.type == "checkbox") {
                if (input.checked) {
                    input.setAttribute("checked", "");
                }
                else {
                    input.removeAttribute("checked");
                }
            }
            else if (input.type == "textarea") {
                input.innerHTML = input.value;
            }
            else {
                input.setAttribute("value", input.value);
            }
        }
        form.reset();
    };
    Formulario.Validar = function (idForm) {
        this.QuitarClasesValidaciones(idForm);
        var form = $("#" + idForm)[0];
        var elements = form.elements;
        var formValido = true;
        for (var _i = 0, elements_1 = elements; _i < elements_1.length; _i++) {
            var element = elements_1[_i];
            var clase = element.getAttribute("class");
            clase = (clase == null || clase == undefined) ? '' : clase;
            if (element.checkValidity() == false) {
                formValido = false;
                element.setAttribute('class', clase.replace('is-valid', ''));
                element.setAttribute('class', clase + ' is-invalid');
            }
            else {
                element.setAttribute('class', clase.replace('is-invalid', ''));
                element.setAttribute('class', clase + ' is-valid');
            }
            element.onchange = function () {
                Formulario.Validar(idForm);
            };
        }
        return formValido;
    };
    Formulario.QuitarClasesValidaciones = function (idForm) {
        var form = $("#" + idForm)[0];
        var elements = form.elements;
        for (var _i = 0, elements_2 = elements; _i < elements_2.length; _i++) {
            var element = elements_2[_i];
            if (element.getAttribute("class") == undefined || element.getAttribute("class") == null)
                continue;
            element.setAttribute('class', element.getAttribute("class").replace('is-valid', ''));
            element.setAttribute('class', element.getAttribute("class").replace('is-invalid', ''));
        }
    };
    return Formulario;
}());
var Formato = (function () {
    function Formato() {
    }
    Formato.Numerico = function (numero, decimales) {
        if (decimales === void 0) { decimales = 0; }
        if (typeof (numero) == "string")
            numero = parseFloat(numero);
        numero = Number(numero).toFixed(decimales);
        var numeroString = String(numero);
        var numeroArray = numeroString.split(".");
        var parteEntera = numeroArray[0];
        var parteDecimal = numeroArray[1];
        var salida = "";
        for (var i = 0; i < parteEntera.length; i++) {
            if ((parteEntera.length - i) % 3 == 0 && i != 0) {
                salida += ".";
            }
            salida += parteEntera[i];
        }
        if (parteDecimal != undefined && parteDecimal != null) {
            salida += "," + parteDecimal;
        }
        return salida;
    };
    Formato.bool2text = function (valorBool) {
        if (valorBool) {
            return "Si";
        }
        else {
            return "No";
        }
    };
    Formato.Fecha = function (fecha) {
        var arrayF = fecha.split("-");
        var salida = arrayF[2] + "/" + arrayF[1] + "/" + arrayF[0];
        return salida;
    };
    return Formato;
}());
var Hash = (function () {
    function Hash() {
    }
    Hash.get = function () {
        var salida = location.hash;
        return salida;
    };
    Hash.set = function (hash) {
        location.hash = "/" + hash;
    };
    Hash.getParametros = function () {
        var salida = [];
        var hash = location.href.replace(HOST, "");
        var hashArray = hash.split("/");
        hashArray = hashArray.filter(function (valor) { return valor.length > 0; });
        for (var i = 0; i < hashArray.length; i++) {
            var valor = hashArray[i];
            var valorArray = valor.split("=");
            if (valorArray.length != 2)
                continue;
            salida[valorArray[0]] = valorArray[1];
        }
        return salida;
    };
    Hash.Parametro2String = function (inputObject) {
        var salida = "";
        for (var key in inputObject) {
            var valor = key + "=" + inputObject[key] + "/";
            salida += valor;
        }
        return salida;
    };
    return Hash;
}());
var Loader = (function () {
    function Loader() {
    }
    Loader.Mostrar = function () {
        var div = document.createElement("div");
        div.setAttribute("class", "pantalla-oscura");
        div.innerHTML =
            '<div class="modal show" id="' + this.id + '" data-backdrop="static">' +
                '   <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm">' +
                '       <div class="modal-content">' +
                '           <div class="modal-body text-center text-defecto p-5">' +
                '               <div class="spinner-grow">' +
                '                   <span class="sr-only"></span>' +
                '               </div>' +
                '           </div>' +
                '       </div>' +
                '   </div>' +
                '</div>';
        document.body.appendChild(div);
        $("#" + this.id).modal("show");
    };
    Loader.Ocultar = function () {
        $("#" + this.id).modal("hide");
        $(".pantalla-oscura").remove();
    };
    Loader.id = "loader-general";
    return Loader;
}());
function AnalizarForm(idForm) {
    var form = document.getElementById(idForm);
    var elementos = form.elements;
    var data = {};
    for (var i = 0; i < elementos.length; i++) {
        var elemento = elementos[i];
        if (elemento.type == "checkbox") {
            var nombre = elemento.name;
            var valor = elemento.checked ? "1" : "0";
            data[nombre] = valor;
        }
        else {
            var nombre = elemento.name;
            var valor = elemento.value;
            data[nombre] = valor;
        }
    }
    return data;
}
var TablaGestion = (function () {
    function TablaGestion(idContenedorTabla) {
        this.idDetalles = "";
        this.idInfoPag = "infoEmpaginado";
        this.idBotonesPag = "botonesEmpagiando";
        this.offsetPaginacion = 2;
        this.data = [];
        this.cantMostrar = 10;
        this.pagina = 1;
        this.total_filas = 0;
        this.order_key = "";
        this.order_type = "ASC";
        this.funcion = "";
        this.idContenedorTabla = idContenedorTabla;
        var contenedor = document.getElementById(this.idContenedorTabla);
        if (contenedor == null) {
            console.error("La tabla de gesti\u00F3n [id: " + idContenedorTabla + "] no existe.");
            return;
        }
        var detalles = document.createElement("div");
        detalles.setAttribute("class", "alert alert-info mb-2 p-2 d-none");
        this.idDetalles = this.idContenedorTabla + "-detalles";
        detalles.setAttribute("id", this.idDetalles);
        detalles.innerHTML = "";
        var empaginado = document.createElement("div");
        empaginado.setAttribute("class", "mt-2 row mx-0");
        empaginado.innerHTML =
            '<div class="col-12 col-md-6 mb-2 mb-md-0 px-0">' +
                '   <div class="h-100 d-flex align-items-center justify-content-center justify-content-md-start" id="' + this.idInfoPag + '">' +
                '       ...' +
                '   </div>' +
                '</div>' +
                '<div class="col-12 col-md-6 px-0">' +
                '   <ul class="pagination justify-content-center justify-content-md-end mb-0" id="' + this.idBotonesPag + '">' +
                '       <li class="page-item disabled">' +
                '           <a class="page-link" tabindex="-1">Anterior</a>' +
                '       </li>' +
                '       <li class="page-item disabled">' +
                '           <a class="page-link" tabindex="-1">...</a>' +
                '       </li>' +
                '       <li class="page-item disabled">' +
                '           <a class="page-link" tabindex="-1">Siguiente</a>' +
                '       </li>' +
                '   </ul>' +
                '</div>';
        contenedor.prepend(detalles);
        contenedor.append(empaginado);
    }
    TablaGestion.prototype.getData = function () {
        return this.data;
    };
    TablaGestion.prototype.Cargando = function () {
        var contenedor = document.getElementById(this.idContenedorTabla);
        var table = contenedor === null || contenedor === void 0 ? void 0 : contenedor.getElementsByTagName("table")[0];
        var tbody = table === null || table === void 0 ? void 0 : table.getElementsByTagName("tbody")[0];
        tbody.innerHTML =
            '<tr>' +
                '   <td colspan="100" center>' +
                '       <div class="spinner-grow m-2">' +
                '           <span class="sr-only">Cargando...</span>' +
                '       </div>' +
                '   </td>' +
                '</tr>';
    };
    TablaGestion.prototype.Error = function () {
        var contenedor = document.getElementById(this.idContenedorTabla);
        var table = contenedor === null || contenedor === void 0 ? void 0 : contenedor.getElementsByTagName("table")[0];
        var tbody = table === null || table === void 0 ? void 0 : table.getElementsByTagName("tbody")[0];
        tbody.innerHTML =
            '<tr class="table-danger">' +
                '   <td colspan="100" center>' +
                '       <h4 class="m-2">Error al actualizar</h4>' +
                '   </td>' +
                '</tr>';
    };
    TablaGestion.prototype.Actualizar = function (objeto) {
        if (objeto === void 0) { objeto = { cuerpo: {}, funcion: '', accion: {} }; }
        this.pagina = objeto.cuerpo.pagina;
        this.cantMostrar = objeto.cuerpo.cantMostrar;
        this.total_filas = objeto.cuerpo.total_filas;
        this.data = objeto.cuerpo.data;
        this.order_key = objeto.cuerpo.order_key;
        this.order_type = objeto.cuerpo.order_type;
        this.funcion = objeto.funcion;
        var data = this.data;
        var parametros = Hash.getParametros();
        var pagina = this.pagina;
        var cantMostrar = this.cantMostrar;
        var totalData = this.total_filas;
        var totalPaginas = 0;
        var inicio = 0;
        var fin = 0;
        totalPaginas = Math.trunc(totalData / cantMostrar);
        if (totalData % cantMostrar > 0)
            totalPaginas += 1;
        if (pagina < 1)
            pagina = 1;
        if (pagina > totalPaginas)
            pagina = totalPaginas;
        inicio = (pagina - 1) * cantMostrar;
        fin = inicio + cantMostrar;
        if (fin > totalData)
            fin = totalData;
        var tbody = document.getElementById(this.idContenedorTabla).getElementsByTagName("tbody")[0];
        if (this.total_filas == 0) {
            tbody.innerHTML =
                '<tr>' +
                    '   <td colspan="100">' +
                    '       <h4 class="text-center">No se encontraron resultados.</h4>' +
                    '   </td>' +
                    '</tr>';
        }
        else {
            tbody.innerHTML = "";
        }
        objeto.accion(tbody, data);
        this.ActualizarDetalles();
        this.ActualizarEncabezado();
        this.ActualizarPaginado(inicio, fin, totalData, pagina, totalPaginas);
    };
    TablaGestion.prototype.ActualizarDetalles = function () {
        var _this = this;
        var parametros = Hash.getParametros();
        var detalles = document.getElementById(this.idDetalles);
        detalles.innerHTML = "";
        var mostrar = false;
        for (var key in parametros) {
            if (key == "pagina")
                continue;
            if (key == "filtros")
                continue;
            mostrar = true;
            var value = parametros[key];
            if (key == "order_key")
                key = "ordenar por";
            if (key == "order_type")
                key = "ordenar tipo";
            detalles.innerHTML += "<div class=\"badge badge-info mx-1\">\n                " + key + ": " + value + "\n            </div>";
        }
        if (mostrar) {
            detalles.innerHTML = "Filtros: <button class=\"close\" id=\"" + this.idDetalles + "-quitarFiltros\">&times;</button><br>" + detalles.innerHTML;
            detalles.className = detalles.className.replace(/ d-none/g, "");
        }
        else {
            detalles.className += " d-none";
        }
        var quitarFiltros = document.getElementById(this.idDetalles + "-quitarFiltros");
        if (quitarFiltros != null && quitarFiltros != undefined) {
            document.getElementById(this.idDetalles + "-quitarFiltros").onclick = function () {
                Hash.set("");
                window[_this.funcion]();
            };
        }
    };
    TablaGestion.prototype.ActualizarEncabezado = function () {
        var _this = this;
        var thead = document.getElementById(this.idContenedorTabla).getElementsByTagName("thead")[0];
        var ths = thead.getElementsByTagName("th");
        var _loop_1 = function (th) {
            var ordenar = th.getAttribute("ordenar");
            var key = th.getAttribute("key");
            if (ordenar != "true")
                return "continue";
            if (key == undefined || key == null)
                return "continue";
            th.style.position = "relative";
            th.style.cursor = "pointer";
            var classImg = "fas fa-sm fa-sort";
            var newOrderType = "ASC";
            if (key == this_1.order_key) {
                if (this_1.order_type == "ASC") {
                    classImg = "fas fa-sm fa-sort-up";
                    newOrderType = "DESC";
                }
                else if (this_1.order_type == "DESC") {
                    classImg = "fas fa-sm fa-sort-down";
                    newOrderType = "ASC";
                }
            }
            th.innerHTML = th.innerText + "\n            <div class=\"position-absolute p-1 text-secondary\" style=\"top: 0px; right: 0px;\">\n                <i class=\"" + classImg + "\"></i>\n            </div>";
            th.onclick = function () {
                var key = th.getAttribute("key");
                var parametros = Hash.getParametros();
                delete parametros['pagina'];
                parametros['order_key'] = key;
                parametros['order_type'] = newOrderType;
                var hash = Hash.Parametro2String(parametros);
                Hash.set(hash);
                window[_this.funcion]();
            };
        };
        var this_1 = this;
        for (var _i = 0, ths_1 = ths; _i < ths_1.length; _i++) {
            var th = ths_1[_i];
            _loop_1(th);
        }
    };
    TablaGestion.prototype.ActualizarPaginado = function (inicio, fin, total, paginaActual, totalPagina) {
        var _this = this;
        var contenedor = document.getElementById(this.idContenedorTabla);
        var info = document.getElementById(this.idInfoPag);
        var botones = document.getElementById(this.idBotonesPag);
        var botonInicio = 1;
        var botonFin = totalPagina;
        var offset = this.offsetPaginacion;
        var puntosInicio = true;
        var puntosFin = true;
        botonInicio = paginaActual - offset;
        if (botonInicio < 1)
            botonInicio = 1;
        botonFin = paginaActual + offset;
        if (botonFin > totalPagina)
            botonFin = totalPagina;
        if (botonInicio <= 1)
            puntosInicio = false;
        if (botonFin >= totalPagina)
            puntosFin = false;
        if (totalPagina == 0) {
            info.innerHTML = "";
            botones.innerHTML = "";
            return;
        }
        info.innerHTML = "Mostrando " + (inicio + 1) + " a " + fin + " resultados de " + total + ".";
        botones.innerHTML = "";
        if (paginaActual <= 1) {
            botones.innerHTML +=
                '<li class="page-item disabled">' +
                    "   <span class=\"page-link\">Anterior</span>" +
                    '</li>';
        }
        else {
            botones.innerHTML +=
                '<li class="page-item">' +
                    ("   <a class=\"page-link\" page=\"" + (paginaActual - 1) + "\">Anterior</a>") +
                    '</li>';
        }
        if (puntosInicio) {
            botones.innerHTML +=
                '<li class="page-item disabled">' +
                    "   <span class=\"page-link\">...</span>" +
                    '</li>';
        }
        for (var i = botonInicio; i <= botonFin; i++) {
            if (paginaActual == i) {
                botones.innerHTML +=
                    '<li class="page-item active">' +
                        ("   <span class=\"page-link\">" + i + "</span>") +
                        '</li>';
            }
            else {
                botones.innerHTML +=
                    '<li class="page-item">' +
                        ("   <a class=\"page-link\" page=\"" + i + "\">" + i + "</a>") +
                        '</li>';
            }
        }
        if (puntosFin) {
            botones.innerHTML +=
                '<li class="page-item disabled">' +
                    "   <span class=\"page-link\">...</span>" +
                    '</li>';
        }
        if (paginaActual >= totalPagina) {
            botones.innerHTML +=
                '<li class="page-item disabled">' +
                    "   <span class=\"page-link\">Siguiente</span>" +
                    '</li>';
        }
        else {
            botones.innerHTML +=
                '<li class="page-item">' +
                    ("   <a class=\"page-link\" page=\"" + (paginaActual + 1) + "\">Siguiente</a>") +
                    '</li>';
        }
        var botonesArray = document.getElementsByTagName("a");
        var _loop_2 = function (i) {
            botonesArray[i].onclick = function (e) {
                var pageString = botonesArray[i].getAttribute("page");
                if (pageString == undefined || pageString == null)
                    return;
                var page = Number(pageString);
                if (isNaN(page))
                    return;
                var parametros = Hash.getParametros();
                parametros['pagina'] = page;
                var hash = Hash.Parametro2String(parametros);
                Hash.set(hash);
                window[_this.funcion]();
            };
        };
        for (var i = 0; i < botonesArray.length; i++) {
            _loop_2(i);
        }
    };
    return TablaGestion;
}());
