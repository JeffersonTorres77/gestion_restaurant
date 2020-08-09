/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Filtro
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Filtro
{
    /*============================================================================
	 *
	 *	Atributos
	 *
    ============================================================================*/
    private idCollapse: string;
    private idForm: string;
    private idBoton: string;
    private funcionBuscar: string;

    /*============================================================================
	 *
	 *	Constructor
	 *
    ============================================================================*/
    public constructor(idCollapse: string, idForm: string, idBoton: string, funcionBuscar: string)
    {
        this.idCollapse = idCollapse;
        this.idForm = idForm;
        this.idBoton = idBoton;
        this.funcionBuscar = funcionBuscar;
        
        let collapse = document.getElementById(this.idCollapse);
        let form = document.getElementById(this.idForm);
        let boton = document.getElementById(this.idBoton);

        if(collapse == null || collapse == undefined) {
            console.error("Collapse del filtro no existe.");
            return;
        }

        if(form == null || form == undefined) {
            console.error("Form del filtro no existe.");
            return;
        }

        if(boton == null || boton == undefined) {
            console.error("Boton del filtro no existe.");
            return;
        }

        this.AsignarAcciones();
    }

    /*============================================================================
	 *
	 *	Asignar acciones
	 *
    ============================================================================*/
    private AsignarAcciones()
    {
        let collapse = document.getElementById(this.idCollapse)!;
        let form = document.getElementById(this.idForm)!;
        let boton = document.getElementById(this.idBoton)!;
        let thisObj = this;

        boton.onclick = (e) =>
        {
            Filtro();
        }

        function Filtro()
        {
            let parametros: object = [];
            let cant: number = 0;

            //@ts-ignore
            for(let i=0; i<form.elements.length; i++)
            {
                //@ts-ignore
                let elemento = form.elements[i];
                let name = elemento.name;
                let valor = elemento.value;

                if(valor == "") continue;
                cant += 1;

                //@ts-ignore
                parametros[name] = valor;
            }

            if(cant > 0) {
                //@ts-ignore
                parametros['filtros'] = "si";
            }

            let hash = "/" + Hash.Parametro2String(parametros);
            hash = hash.replace(/ /g, "_");
            location.hash = hash;
            
            //@ts-ignore
            window[thisObj.funcionBuscar]();

            //@ts-ignore
            $("#" + thisObj.idCollapse).collapse("hide");
        }
    }
}