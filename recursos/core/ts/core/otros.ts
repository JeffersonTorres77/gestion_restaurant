/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Analizar Formulario
 *
 *--------------------------------------------------------------------------------
================================================================================*/
function AnalizarForm(idForm: string): any
{
    let form: any = document.getElementById(idForm)!;
    let elementos = form.elements;
    let data: object = {};

    for(let i=0; i<elementos.length; i++)
    {
        let elemento = elementos[i];

        if(elemento.type == "checkbox")
        {
            let nombre: string = elemento.name;
            let valor: string = elemento.checked ? "1": "0";
            //@ts-ignore
            data[nombre] = valor;
            
        }
        else
        {
            let nombre: string = elemento.name;
            let valor: string = elemento.value;

            //@ts-ignore
            data[nombre] = valor;
        }
    }

    return data;
}