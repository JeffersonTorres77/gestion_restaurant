/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Formulario
{
	/*============================================================================
	 *
	 *	Coloca como valores por defecto los seleccionados
	 *
	============================================================================*/
    public static Sync(idForm: string): void
    {
        let form = document.getElementById(idForm)!;
        //@ts-ignore
        for(let i=0; i<form.elements.length; i++)
        {
            //@ts-ignore
            let input = form.elements[i];

            if(input.type == "select-one")
            {
                let options = input.getElementsByTagName("option");
                let indexSelected = input.selectedIndex;
                for(let j=0; j<options.length; j++) {
                    options[j].removeAttribute("selected");
                }
                options[ indexSelected ].setAttribute("selected", "");
            }
            else if(input.type == "checkbox")
            {
                if(input.checked) {
                    input.setAttribute("checked", "");
                } else {
                    input.removeAttribute("checked");
                }
            }
            else if(input.type == "textarea")
            {
                input.innerHTML = input.value;
            }
            else
            {
                input.setAttribute("value", input.value);
            }
        }

        //@ts-ignore
        form.reset();
    }

    /*============================================================================
	 *
	 *	Validar
	 *
    ============================================================================*/
    public static Validar(idForm: string): boolean
    {
        this.QuitarClasesValidaciones(idForm);

        let form: any = $("#"+idForm)[0];
        let elements: any = form.elements;
        let formValido = true;

        for(let element of elements)
        {
            let clase = element.getAttribute("class");
            clase = (clase == null || clase == undefined) ? '' : clase;

            if(element.checkValidity() == false) {
                formValido = false;
                element.setAttribute( 'class', clase.replace('is-valid', '') );
                element.setAttribute( 'class', clase+' is-invalid' );
            } else {
                element.setAttribute( 'class', clase.replace('is-invalid', '') );
                element.setAttribute( 'class', clase+' is-valid' );
            }
            
            element.onchange = () =>
            {
                Formulario.Validar(idForm);
            }
        }

        return formValido;
    }
    
	/*============================================================================
	 *
	 *	Quitar clases validaciones
	 *
    ============================================================================*/
    public static QuitarClasesValidaciones(idForm: string): void
    {
        let form: any = $("#"+idForm)[0];
        let elements: any = form.elements;

        for(let element of elements)
        {
            if(element.getAttribute("class") == undefined || element.getAttribute("class") == null) continue;
            element.setAttribute( 'class', element.getAttribute("class").replace('is-valid', '') );
            element.setAttribute( 'class', element.getAttribute("class").replace('is-invalid', '') );
        }
    }
}