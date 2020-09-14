/*================================================================================
 *
 *	Elementos
 *
================================================================================*/
var botonActualizar = document.getElementById('boton-actualizar');
var tbody = document.getElementById('tbody-elementos');
//Tabla
var idTabla = "tabla";
var tabla = new TablaGestion(idTabla);
//Buscador
var buscador = new Buscador("input-buscador", "boton-buscador", "Actualizar");
//Filtros
var filtro = new Filtro("filtros", "form-filtro", "boton-filtro", "Actualizar");

/*================================================================================
 *
 *	Actualizar datos
 *
================================================================================*/
Actualizar();
botonActualizar.onclick = function() { Actualizar(); }
function Actualizar()
{
    /**
     * Parametros adicionales
     */
    var url = `${HOST_GERENCIAL_AJAX}Estadisticas/Consultas/`;
    var data = new FormData();
    data.append("accion", "PLATILLOS");

    var parametros = Hash.getParametros();
    for(var key in parametros)
    {
        data.append(key, parametros[key]);
    }

    AJAX.Enviar({
        url: url,
        data: data,
        antes: function() {
            tabla.Cargando();
        },

        error: function(mensaje) {
            tabla.Error();
            Alerta.Danger(mensaje);
        },

        ok: function(cuerpo) {
            tabla.Actualizar({
                cuerpo: cuerpo,
                funcion: 'Actualizar',
                accion: (tbody, data) =>
                {
                    var datos = data.datos;
                    var totalCantidad = data.totalCantidad;
                    var totalIngresos = data.totalIngresos;

                    for(var i=0; i<datos.length; i++)
                    {
                        let dato = datos[i];
                        if(dato == undefined) continue;

                        tbody.innerHTML += `<tr>
                            <td>
                                ${dato.nombre}
                            </td>

                            <td center>
                                ${dato.nombreCategoria}
                            </td>

                            <td center>
                                ${Formato.Numerico(dato.cantidad, 0)}
                            </td>

                            <td right>
                                ${Formato.Numerico(dato.ingresos, 2)}
                            </td>
                        </tr>`;
                    }

                    tbody.innerHTML += `<tr class="font-weight-bold">
                        <td class="py-2" colspan="2">
                            TOTAL
                        </td>

                        <td center style="vertical-align: middle;">
                            ${Formato.Numerico(totalCantidad, 0)}
                        </td>

                        <td right style="vertical-align: middle;">
                            ${Formato.Numerico(totalIngresos, 2)}
                        </td>
                    </tr>`;
                }
            });
        }
    });
}