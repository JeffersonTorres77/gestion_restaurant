var botonGuardar = document.getElementById('boton-guardar');
var inputIdMoneda = document.getElementById('input-idMoneda');
var inputIva = document.getElementById('input-iva');
var inputFacturar = document.getElementById('input-facturar');

botonGuardar.onclick = function() {
    GuardarDatos();
}

function GuardarDatos() {
    let idMoneda = inputIdMoneda.value;
    let iva = inputIva.value;
    let facturar = (inputFacturar.checked) ? '1' : '0';

    var url = `${HOST_GERENCIAL_AJAX}Configuracion/CRUD_Restaurantes/`;
    var data = new FormData();
    data.append("accion", "MODIFICAR");
    data.append("idMoneda", idMoneda);
    data.append('iva', iva);
    data.append("facturar", facturar);

    AJAX.Enviar({
        url: url,
        data: data,
        antes: function() {
            Loader.Mostrar();
        },

        error: function(mensaje) {
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },

        ok: function(data) {
            Loader.Ocultar();
            Alerta.Success("Datos modificados exitosamente.");
        }
    });
}