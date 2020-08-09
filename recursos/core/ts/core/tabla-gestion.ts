/// <reference path="hash.ts" />

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Tabla Gestion
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class TablaGestion
{
    /*============================================================================
	 *
	 *	Atributos
	 *
	============================================================================*/
    private idContenedorTabla: string;
    private idDetalles: string = "";
    private idInfoPag: string = "infoEmpaginado";
    private idBotonesPag: string = "botonesEmpagiando";
    private offsetPaginacion: number = 2;

    private data: object[] = [];
    private cantMostrar: number = 10;
    private pagina: number = 1;
    private total_filas: number = 0;
    private order_key: string = "";
    private order_type: string = "ASC";
    private funcion: string = "";

    public getData() {
        return this.data;
    }

    /*============================================================================
	 *
	 *	Constructor
	 *
	============================================================================*/
    public constructor(idContenedorTabla: string)
    {
        this.idContenedorTabla = idContenedorTabla;
        let contenedor = document.getElementById(this.idContenedorTabla);
        if(contenedor == null) {
            console.error(`La tabla de gestión [id: ${idContenedorTabla}] no existe.`);
            return;
        }

        let detalles = document.createElement("div");
        detalles.setAttribute("class", "alert alert-info mb-2 p-2 d-none");
        this.idDetalles = this.idContenedorTabla+"-detalles";
        detalles.setAttribute("id", this.idDetalles);
        detalles.innerHTML = ``;

        let empaginado = document.createElement("div");
        empaginado.setAttribute("class", "mt-2 row mx-0");
        empaginado.innerHTML =        
        '<div class="col-12 col-md-6 mb-2 mb-md-0 px-0">' +
        '   <div class="h-100 d-flex align-items-center justify-content-center justify-content-md-start" id="'+this.idInfoPag+'">' +
        '       ...' +
        '   </div>' +
        '</div>' +
        
        '<div class="col-12 col-md-6 px-0">' +
        '   <ul class="pagination justify-content-center justify-content-md-end mb-0" id="'+this.idBotonesPag+'">' +
        '       <li class="page-item disabled">' +
        '           <a class="page-link" tabindex="-1">Anterior</a>' +
        '       </li>' +
        
        '       <li class="page-item disabled">' +
        '           <a class="page-link" tabindex="-1">...</a>' +
        '       </li>' +
        
        '       <li class="page-item disabled">' +
        '           <a class="page-link" tabindex="-1">Siguiente</a>' +
        '       </li>' +
        '   </ul>' +
        '</div>';

        contenedor.prepend(detalles);
        contenedor.append(empaginado);
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public Cargando()
    {
        let contenedor = document.getElementById(this.idContenedorTabla);
        let table = contenedor?.getElementsByTagName("table")[0];
        let tbody = table?.getElementsByTagName("tbody")[0]!;

        tbody.innerHTML =
        '<tr>' +
        '   <td colspan="100" center>' +
        '       <div class="spinner-grow m-2">' +
        '           <span class="sr-only">Cargando...</span>' +
        '       </div>' +
        '   </td>' +
        '</tr>';
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public Error()
    {
        let contenedor = document.getElementById(this.idContenedorTabla);
        let table = contenedor?.getElementsByTagName("table")[0];
        let tbody = table?.getElementsByTagName("tbody")[0]!;

        tbody.innerHTML =
        '<tr class="table-danger">' +
        '   <td colspan="100" center>' +
        '       <h4 class="m-2">Error al actualizar</h4>' +
        '   </td>' +
        '</tr>';
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public Actualizar(objeto: any = { cuerpo: {}, funcion: '', accion: {} })
    {
        this.pagina = objeto.cuerpo.pagina;
        this.cantMostrar = objeto.cuerpo.cantMostrar;
        this.total_filas = objeto.cuerpo.total_filas;
        this.data = objeto.cuerpo.data;
        this.order_key = objeto.cuerpo.order_key;
        this.order_type = objeto.cuerpo.order_type;
        this.funcion = objeto.funcion;

        /*------------------------------------------------------------------------
		 *	Definimos los parametros que vamos a utilizar en este metodo
        ------------------------------------------------------------------------*/
        let data = this.data;
        let parametros = Hash.getParametros();
        let pagina: number = this.pagina;
        let cantMostrar: number = this.cantMostrar;
        let totalData: number = this.total_filas;
        let totalPaginas: number = 0;
        let inicio: number = 0;
        let fin: number = 0;

        /*------------------------------------------------------------------------
		 *	Calculamos la cantidad total de paginas
		------------------------------------------------------------------------*/
        //@ts-ignore
        totalPaginas = Math.trunc( totalData / cantMostrar );
        if(totalData % cantMostrar > 0) totalPaginas += 1;

        /*------------------------------------------------------------------------
		 *	Verificamos si se envio la pagina y la validamos
		------------------------------------------------------------------------*/
        if(pagina < 1) pagina = 1;
        if(pagina > totalPaginas) pagina = totalPaginas;

        /*------------------------------------------------------------------------
		 *	Calculamos el inicio y fin de los elementos a mostrar
		------------------------------------------------------------------------*/
        inicio = (pagina - 1) * cantMostrar;
        fin = inicio + cantMostrar;
        if(fin > totalData) fin = totalData;

        /*------------------------------------------------------------------------
         * 
        ------------------------------------------------------------------------*/
        let tbody = document.getElementById(this.idContenedorTabla)!.getElementsByTagName("tbody")[0];
        if(this.total_filas == 0)
        {
            tbody.innerHTML =
            '<tr>' +
            '   <td colspan="100">' +
            '       <h4 class="text-center">No se encontraron resultados.</h4>' +
            '   </td>' +
            '</tr>';
        }
        else
        {
            tbody.innerHTML = "";
        }

        /*------------------------------------------------------------------------
         * 
        ------------------------------------------------------------------------*/
        objeto.accion(tbody, data);

        /*------------------------------------------------------------------------
         * 
        ------------------------------------------------------------------------*/
        this.ActualizarDetalles();

        /*------------------------------------------------------------------------
         * 
        ------------------------------------------------------------------------*/
        this.ActualizarEncabezado();
        
        /*------------------------------------------------------------------------
         * Construimos el empaginado
        ------------------------------------------------------------------------*/
        this.ActualizarPaginado(inicio, fin, totalData, pagina, totalPaginas);
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    private ActualizarDetalles()
    {
        let parametros = Hash.getParametros();
        let detalles = document.getElementById(this.idDetalles)!;

        detalles.innerHTML = "";
        let mostrar = false;
        for(let key in parametros)
        {
            if(key == "pagina") continue;
            if(key == "filtros") continue;

            mostrar = true;
            let value = parametros[key];

            if(key == "order_key") key = "ordenar por";
            if(key == "order_type") key = "ordenar tipo";

            detalles.innerHTML += `<div class="badge badge-info mx-1">
                ${key}: ${value}
            </div>`;
        }

        if(mostrar) {
            detalles.innerHTML = `Filtros: <button class="close" id="${this.idDetalles}-quitarFiltros">&times;</button><br>` + detalles.innerHTML;
            detalles.className = detalles.className.replace(/ d-none/g, "");
        } else {
            detalles.className += " d-none";
        }
        
        let quitarFiltros = document.getElementById(this.idDetalles+"-quitarFiltros")!;
        if(quitarFiltros != null && quitarFiltros != undefined)
        {
            document.getElementById(this.idDetalles+"-quitarFiltros")!.onclick = () =>
            {
                Hash.set("");
                //@ts-ignore
                window[this.funcion]();
            };
        }
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    private ActualizarEncabezado()
    {
        let thead = document.getElementById(this.idContenedorTabla)!.getElementsByTagName("thead")[0];
        let ths: any = thead.getElementsByTagName("th");

        for(let th of ths)
        {
            let ordenar = th.getAttribute("ordenar");
            let key = th.getAttribute("key");

            if(ordenar != "true") continue;
            if(key == undefined || key == null) continue;

            th.style.position = "relative";
            th.style.cursor = "pointer";

            let classImg = "fas fa-sm fa-sort";
            let newOrderType = "ASC";

            if(key == this.order_key)
            {
                if(this.order_type == "ASC")
                {
                    classImg = "fas fa-sm fa-sort-up";
                    newOrderType = "DESC";
                }
                else if(this.order_type == "DESC")
                {
                    classImg = "fas fa-sm fa-sort-down";
                    newOrderType = "ASC";
                }
            }

            th.innerHTML = `${th.innerText}
            <div class="position-absolute p-1 text-secondary" style="top: 0px; right: 0px;">
                <i class="${classImg}"></i>
            </div>`;

            th.onclick = () =>
            {
                let key = th.getAttribute("key");
                let parametros = Hash.getParametros();
                delete parametros['pagina'];
                parametros['order_key'] = key;
                parametros['order_type'] = newOrderType;
                let hash = Hash.Parametro2String(parametros);
                Hash.set(hash);
                //@ts-ignore
                window[this.funcion]();
            }
        }
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    private ActualizarPaginado(inicio: number, fin: number, total: number, paginaActual: number, totalPagina: number)
    {
        /*------------------------------------------------------------------------
         * Variables
        ------------------------------------------------------------------------*/
        //Elementos
        let contenedor = document.getElementById(this.idContenedorTabla)!;
        let info = document.getElementById(this.idInfoPag)!;
        let botones = document.getElementById(this.idBotonesPag)!;
        //Numeros
        let botonInicio: number = 1;
        let botonFin: number = totalPagina;
        let offset: number = this.offsetPaginacion;
        //Condiciones
        let puntosInicio: boolean = true;
        let puntosFin: boolean = true;

        /*------------------------------------------------------------------------
         * Calculos
        ------------------------------------------------------------------------*/
        botonInicio = paginaActual - offset;
        if(botonInicio < 1) botonInicio = 1;

        botonFin = paginaActual + offset;
        if(botonFin > totalPagina) botonFin = totalPagina;

        if(botonInicio <= 1) puntosInicio = false;
        if(botonFin >= totalPagina) puntosFin = false;

        if(totalPagina == 0) {
            info.innerHTML = ``;
            botones.innerHTML = ``;
            return;
        }

        /*------------------------------------------------------------------------
         * Información del empaginado
        ------------------------------------------------------------------------*/
        info.innerHTML = `Mostrando ${inicio+1} a ${fin} resultados de ${total}.`;

        /*------------------------------------------------------------------------
         * Botones del empagiando
        ------------------------------------------------------------------------*/
        //Boton ANTERIOR
        botones.innerHTML = "";
        if(paginaActual <= 1)
        {
            botones.innerHTML +=
            '<li class="page-item disabled">' +
            `   <span class="page-link">Anterior</span>` +
            '</li>';
        }
        else
        {
            botones.innerHTML +=
            '<li class="page-item">' +
            `   <a class="page-link" page="${paginaActual - 1}">Anterior</a>` +
            '</li>';
        }

        //...
        if(puntosInicio)
        {
            botones.innerHTML +=
            '<li class="page-item disabled">' +
            `   <span class="page-link">...</span>` +
            '</li>';
        }

        //Botones
        for(let i=botonInicio; i<=botonFin; i++)
        {
            if(paginaActual == i)
            {
                botones.innerHTML +=
                '<li class="page-item active">' +
                `   <span class="page-link">${i}</span>` +
                '</li>';
            }
            else
            {
                botones.innerHTML +=
                '<li class="page-item">' +
                `   <a class="page-link" page="${i}">${i}</a>` +
                '</li>';
            }
        }

        //...
        if(puntosFin)
        {
            botones.innerHTML +=
            '<li class="page-item disabled">' +
            `   <span class="page-link">...</span>` +
            '</li>';
        }

        //Boton SIGUIENTE
        if(paginaActual >= totalPagina)
        {
            botones.innerHTML +=
            '<li class="page-item disabled">' +
            `   <span class="page-link">Siguiente</span>` +
            '</li>';
        }
        else
        {
            botones.innerHTML +=
            '<li class="page-item">' +
            `   <a class="page-link" page="${paginaActual + 1}">Siguiente</a>` +
            '</li>';
        }

        /*------------------------------------------------------------------------
         * Eventos de los botones
        ------------------------------------------------------------------------*/
        let botonesArray = document.getElementsByTagName("a");
        for(let i=0; i<botonesArray.length; i++)
        {
            botonesArray[i].onclick = (e) =>
            {
                let pageString: string = botonesArray[i].getAttribute("page")!;
                if(pageString == undefined || pageString == null) return; 
                let page: number = Number(pageString);
                if(isNaN(page)) return;

                let parametros: any = Hash.getParametros();
                parametros['pagina'] = page;

                let hash = Hash.Parametro2String(parametros);
                Hash.set(hash);

                //@ts-ignore
                window[this.funcion]();
            }
        }
    }
}