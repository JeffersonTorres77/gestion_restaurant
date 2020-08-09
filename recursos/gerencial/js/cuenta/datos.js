/**
 * 
 */
var correo = {
    input: document.getElementById("datos-correo"),
    boton: document.getElementById("boton-correo")
};

var clave = {
    input: document.getElementById("datos-clave"),
    boton: document.getElementById("boton-clave")
};

/**
 * 
 */
correo.input.onkeyup = function(e) {
    if(this.value != "") {
        correo.boton.disabled = false;
    } else {
        correo.boton.disabled = true;
    }
}

clave.input.onkeyup = function(e) {
    if(this.value != "") {
        clave.boton.disabled = false;
    } else {
        clave.boton.disabled = true;
    }
}

/**
 * 
 */
correo.boton.onclick = function() {
    var url = HOST_GERENCIAL_AJAX + "Cuenta/Modificar/";
    var data = new FormData();
    data.append('correo', correo.input.value);

    AJAX.Enviar({
        url,
        data,

        antes: function() {
            Loader.Mostrar();
        },

        error: function(mensaje) {
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },

        ok: function(data) {
            Loader.Ocultar();
            Alerta.Success('Correo modificado exitosamente.');
        }
    });
}


clave.boton.onclick = function() {
    var url = HOST_GERENCIAL_AJAX + "Cuenta/Modificar/";
    var data = new FormData();
    data.append('clave', clave.input.value);

    AJAX.Enviar({
        url,
        data,

        antes: function() {
            Loader.Mostrar();
        },

        error: function(mensaje) {
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },

        ok: function(data) {
            clave.input.value = "";
            Loader.Ocultar();
            Alerta.Success('Contraseña modificada exitosamente.');
        }
    });
}