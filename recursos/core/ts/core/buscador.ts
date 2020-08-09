/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Buscador
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Buscador
{
    /*============================================================================
	 *
	 *	Atributos
	 *
    ============================================================================*/
    private idInputBuscador: string;
    private idBotonBuscador: string;
    private funcionBuscar: string;

    /*============================================================================
	 *
	 *	Constructor
	 *
    ============================================================================*/
    public constructor(idInputBuscador: string, idBotonBuscador: string, funcionBuscar: string)
    {
        this.idInputBuscador = idInputBuscador;
        this.idBotonBuscador = idBotonBuscador;
        this.funcionBuscar = funcionBuscar;

        let input = document.getElementById(this.idInputBuscador);
        let boton = document.getElementById(this.idBotonBuscador);

        if(input == null || input == undefined) {
            console.error("Input del buscador no existe.");
            return;
        }

        if(boton == null || boton == undefined) {
            console.error("Boton del buscador no existe.");
            return;
        }

        this.AsignarActividad();
    }
    
    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    private AsignarActividad()
    {
        let input = document.getElementById(this.idInputBuscador)!;
        let boton = document.getElementById(this.idBotonBuscador)!;
        let thisObj = this;

        input!.onkeyup = (e) =>
        {
            if(e.key == "Enter") {
                boton.click();
            }
        }

        boton.onclick = (e) =>
        {
            //@ts-ignore
            let valor = input.value;
            Buscar(valor);
        }

        function Buscar(valor: string)
        {
            let parametros: any = [];

            if(valor != "") {
                parametros['buscar'] = valor;
            }

            let hash = "/" + Hash.Parametro2String(parametros);
            hash = hash.replace(/ /g, "_");
            location.hash = hash;
            
            //@ts-ignore
            window[thisObj.funcionBuscar]();
        }
    }
}