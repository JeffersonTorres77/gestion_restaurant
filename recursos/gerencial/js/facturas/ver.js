var formEnvioCorreo = document.getElementById('form-envio-correo');
var modalEnvioCorreo = $("#modal-envio-correo");

formEnvioCorreo.onsubmit = function(e) {
    e.preventDefault();
    EnviarPorCorreo();
}

function EnviarPorCorreo() {
    let url = `${HOST_GERENCIAL_AJAX}Facturas/Enviar_Correo/`;
    let data = new FormData(formEnvioCorreo);
    data.append('idFactura', ID_FACTURA);
    AJAX.Enviar({
        url: url,
        data: data,
        antes() {
            Loader.Mostrar();
        },
        error(mensaje) {
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },
        ok(data) {
            Loader.Ocultar();
            Alerta.Success('Se ha enviado el correo exitosamente.');
            modalEnvioCorreo.modal('hide');
        }
    });
}