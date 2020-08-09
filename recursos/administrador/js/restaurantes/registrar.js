// Example starter JavaScript for disabling form submissions if there are invalid fields
(function()
{
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('validacion_campos');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

/**
 * Creamos las variables con los ID que se van a utilizar
 */
var idFormRegistro = "form-registro";
var idBotonRegistro = "boton-registro";

/**
 * Creamos los elementos
 */
var formulario = document.getElementById(idFormRegistro);
var boton = document.getElementById(idBotonRegistro);

/**
 * Evento para cuando se haga submit al formulario
 */
formulario.addEventListener("submit", function(e)
{
  /**
   * Anulamos la redireccion de la pagina o evento
   */
  event.preventDefault();
  event.stopPropagation();

  /**
   * Verificamos el status del formulario 
   */
  if(formulario.checkValidity() === false) {
    Alerta.Danger("Debe rellenar todos los campos.");
    return;
  }

  /**
   * Validamos las contraseñas
   */
  var clave1 = document.getElementById("ClaveGerente").value;
  var clave2 = document.getElementById("Clave2Gerente").value;
  if(clave1 != clave2) {
    Alerta.Danger("Las contraseñas del usuario deben ser iguales.");
    return;
  }

  /**
   * Variables
   */
  var url = `${HOST_ADMIN_AJAX}Restaurantes/CRUD/`;
  var data = new FormData(formulario);

  data.append("accion", "REGISTRAR");

  /**
   * Realizamos la petición
   */
  AJAX.Enviar({
    url: url,
    data: data,
    
    antes: function()
    {
      Loader.Mostrar();
    },

    error: function(mensaje)
    {
      Alerta.Danger(mensaje);
      Loader.Ocultar();
    },

    ok: function(cuerpo)
    {
      var id = cuerpo.id;
      var link = HOST_ADMIN + "Restaurantes/Gestion/"+id+"/";
      location.href = link;
    }
  });
}, false);