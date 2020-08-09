/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Hash
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Hash
{
    /*============================================================================
	 *
	 *	Obtener hash
	 *
	============================================================================*/
    public static get(): string
    {
        let salida: string = location.hash;
        return salida;
    }

    /*============================================================================
	 *
	 *	Set hash
	 *
    ============================================================================*/
    public static set(hash: string): void
    {
        location.hash = "/" + hash;
    }

    /*============================================================================
	 *
	 *	Obtener parametros en un array
	 *
	============================================================================*/
    public static getParametros(): any
    {
        let salida: any = [];
        //@ts-ignore
        let hash: string = location.href.replace(HOST, "");
        let hashArray = hash.split("/");
        hashArray = hashArray.filter( valor => valor.length > 0 );

        for(let i=0; i<hashArray.length; i++)
        {
            let valor = hashArray[i];

            let valorArray = valor.split("=");
            if(valorArray.length != 2) continue;

            salida[ valorArray[0] ] = valorArray[1];
        }
        
        return salida;
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public static Parametro2String(inputObject: any): string
    {
        let salida: string = "";

        for(let key in inputObject)
        {
            let valor = `${key}=${inputObject[key]}/`;
            salida += valor;
        }

        return salida;
    }
}