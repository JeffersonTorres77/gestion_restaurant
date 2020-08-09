/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Alertas
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Alerta
{
    /*============================================================================
	 *
	 *	Atributos
	 *
    ============================================================================*/
    private static id: string = "contendor-alertas-general";
    
    /*============================================================================
	 *
	 *	Iniciar
	 *
    ============================================================================*/
    private static Iniciar()
    {
        let div = document.createElement("div");
        div.setAttribute("class", "contenedor-alertas");
        div.setAttribute("id", this.id);
        
        document.body.appendChild(div);
    }

    /*============================================================================
	 *
	 *	Agregar nueva alerta
	 *
    ============================================================================*/
    private static Agregar(mensaje: string, tipo: string)
    {
        let contenedor = document.getElementById(this.id)!;
        if(contenedor == null || contenedor == undefined) {
            this.Iniciar();
            contenedor = document.getElementById(this.id)!;
        }

        let alerta = document.createElement("div");
        let cantidad: number = contenedor.getElementsByClassName("alert").length;
        let id: string = "alerta-sistema-"+cantidad;

        if(cantidad == 10) {
            alert(mensaje);
            return;
        }

        alerta.setAttribute("class", "alert alert-"+tipo+" alert-dismissible fade show m-3");
        alerta.setAttribute("id", id);
        alerta.innerHTML =
        '<button class="close" data-dismiss="alert">' +
        '   <span>&times;</span>' +
        '</button>' +
        mensaje;

        contenedor.append(alerta);

        //@ts-ignore
        setTimeout(() => { $("#" + id).alert("close"); }, 5000);
    }

    /*============================================================================
	 *
	 *	Tipos de alertas
	 *
    ============================================================================*/
    public static Primary(mensaje: string) {
        this.Agregar(mensaje, "primary");
    }
    
    public static Secondary(mensaje: string) {
        this.Agregar(mensaje, "secondary");
    }

    public static Success(mensaje: string) {
        this.Agregar(mensaje, "success");
    }

    public static Danger(mensaje: string) {
        this.Agregar(mensaje, "danger");
    }

    public static Warning(mensaje: string) {
        this.Agregar(mensaje, "warning");
    }
    
    public static Info(mensaje: string) {
        this.Agregar(mensaje, "info");
    }

    public static Light(mensaje: string) {
        this.Agregar(mensaje, "light");
    }

    public static Dark(mensaje: string) {
        this.Agregar(mensaje, "dark");
    }
}