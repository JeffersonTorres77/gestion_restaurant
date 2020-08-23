/*================================================================================
 *
 *	Variables
 *
================================================================================*/
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

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
Actualizar();

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
function Actualizar()
{
    /**
     * Parametros adicionales
     */
    var url = `${HOST_GERENCIAL_AJAX}Facturas/CRUD/`;
    var data = new FormData();
    data.append("accion", "CONSULTAR-HOY");
    var parametros = Hash.getParametros();
    for(var key in parametros)
    {
        data.append(key, parametros[key]);
    }

    /**
     * Enviamos la petición
     */
    AJAX.Enviar({
        url: url,
        data: data,
        antes: function()
        {
            tabla.Cargando();
        },
        error: function(mensaje)
        {
            tabla.Error();
            Alerta.Danger(mensaje);
        },
        ok: function(cuerpo)
        {
            tabla.Actualizar({
                cuerpo: cuerpo,
                funcion: 'Actualizar',
                accion: (tbody, data) =>
                {
                    for(var i=0; i<data.length; i++)
                    {
                        let dato = data[i];
                        if(dato == undefined) continue;

                        var link = HOST_GERENCIAL + `Facturas/Ver/${dato.id}/`;
                        var numero = dato.numero;
                        var total = 'Bs. ' + Formato.Numerico(dato.total);
                        var items = dato.items;
                        var fecha = dato.fecha;
                        var hora = dato.hora;

                        tbody.innerHTML +=
                        '<tr class="table-sm">' +
                        '   <td style="vertical-align: middle;" left>' +
                        '       ' + numero +
                        '   </td>' +

                        '   <td style="vertical-align: middle;" right>' +
                        '       ' + total +
                        '   </td>' +
                        

                        '   <td style="vertical-align: middle;" center>' +
                        '       ' + items +
                        '   </td>' +

                        '   <td style="vertical-align: middle;" center>' +
                        '       ' + hora +
                        '   </td>' +

                        '   <td style="vertical-align: middle;" center>' +
                        '       <a class="btn btn-sm btn-success" href="' + link + '">' +
                        '           <i class="fas fa-eye"></i>'
                        '       </a>' +
                        '   </td>' +
                        '</tr>';
                    }
                }
            });
        }
    });
}