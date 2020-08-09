/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Loader
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Loader
{
	/*============================================================================
	 *
	 *	Atributos
	 *
	============================================================================*/
    private static id: string = "loader-general";

	/*============================================================================
	 *
	 *	Mostrar
	 *
	============================================================================*/
    public static Mostrar()
    {
        let div = document.createElement("div");
        div.setAttribute("class", "pantalla-oscura");
        div.innerHTML =
        '<div class="modal show" id="'+this.id+'" data-backdrop="static">' +
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

        //@ts-ignore
        $("#"+this.id).modal("show");
    }

	/*============================================================================
	 *
	 *	Ocultar
	 *
	============================================================================*/
    public static Ocultar()
    {
        //@ts-ignore
        $("#"+this.id).modal("hide");
        $(".pantalla-oscura").remove();
    }
}