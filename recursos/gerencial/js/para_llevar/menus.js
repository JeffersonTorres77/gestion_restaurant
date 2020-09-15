function Actualizar()
{
    var contenedor = document.getElementById("contenedor-combos");
    var url = `${HOST_AJAX}Menus/Consultar/`;
    var data = new FormData();

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
            
            var combos = cuerpo.combos;
            var code = "";

            code += '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 px-2">';

            for(var combo of combos)
            {
                code += '<a class="mb-4 d-flex justify-content-center px-2" href="'+HOST_GERENCIAL+'Para_Llevar/Menus/'+combo.id+'/'+'">';
                code += '   <div class="card card-especial" tabindex="0">';
                code += '       <img src="'+combo.imagen+'" class="card-img-top border-bottom" style="height: 180px;">';

                code += '       <div class="card-body">';
                code += '           <h5 class="mb-0">';
                code += '               ' + combo.nombre;
                code += '           </h5>';
                code += '       </div>';
                
                code += '       <div class="card-footer bg-white">';
                code += '           <div class="mb-0 font-weight-bold text-success">';
                code += '               Descuento: ' + Formato.Numerico(combo.descuento, 2) + '%';
                code += '           </div>';
                code += '       </div>';
                code += '   </div>';
                code += '</a>';
            }

            code += '</div>';

            contenedor.innerHTML = code;
        }
    });
}

Actualizar();