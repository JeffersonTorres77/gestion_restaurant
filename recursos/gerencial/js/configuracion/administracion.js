var botonGuardar = document.getElementById('boton-guardar');
var inputIdMoneda = document.getElementById('input-idMoneda');
var inputFacturar = document.getElementById('input-facturar');
var inputFacturarParaLlevar = document.getElementById('input-facturarParaLlevar');

botonGuardar.onclick = function() {
    GuardarDatos();
}

function GuardarDatos() {
    let idMoneda = inputIdMoneda.value;
    let facturar = (inputFacturar.checked) ? '1' : '0';
    let facturarParaLlevar = (inputFacturarParaLlevar.checked) ? '1' : '0';

    var url = `${HOST_GERENCIAL_AJAX}Configuracion/CRUD_Restaurantes/`;
    var data = new FormData();
    data.append("accion", "MODIFICAR");
    data.append("idMoneda", idMoneda);
    data.append("facturar", facturar);
    data.append("facturarParaLlevar", facturarParaLlevar);

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