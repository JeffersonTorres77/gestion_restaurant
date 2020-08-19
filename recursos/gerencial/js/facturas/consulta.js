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
    data.append("accion", "CONSULTAR");
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

                        //var link = HOST_GERENCIAL + `Usuarios/Ver/${dato.id}/`;
                        var numero = dato.numero;
                        var total = 'Bs. ' + Formato.Numerico(dato.total);
                        var items = dato.items;
                        var fecha = Formato.Fecha( dato.fecha_registro.split(' ')[0] );

                        tbody.innerHTML +=
                        '<tr class="table-sm">' +
                        '   <td style="vertical-align: middle;" center>' +
                        '       ' + numero +
                        '   </td>' +

                        '   <td style="vertical-align: middle;" right>' +
                        '       ' + total +
                        '   </td>' +
                        

                        '   <td style="vertical-align: middle;" center>' +
                        '       ' + items +
                        '   </td>' +

                        '   <td style="vertical-align: middle;" center>' +
                        '       ' + fecha +
                        '   </td>' +
                        '</tr>';
                    }
                }
            });
        }
    });
}