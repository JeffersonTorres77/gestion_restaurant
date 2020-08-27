<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	CRUD DE FACTURAS
 *
 *--------------------------------------------------------------------------------
================================================================================*/

/*================================================================================
 * Tomamos los parametros
================================================================================*/
$accion = Input::POST("accion");
$objRestaurant = Sesion::getRestaurant();
$idRestaurant = $objRestaurant->getId();

/*================================================================================
 * 
================================================================================*/
switch($accion)
{
    /**
     * CONSULTAR
     */
    case "CONSULTAR-HOY":
        /**
         * Tomamos los parametros
         */
        $order_key = Input::POST("order_key", FALSE);
        $order_type = Input::POST("order_type", FALSE);
        $pagina = (int) Input::POST("pagina", FALSE);
        $cantMostrar = (int) Input::POST("cantMostrar", FALSE);
        $buscar = Filtro::General( Input::POST("buscar", FALSE) );
        $filtros = Input::POST("filtros", FALSE);

        /**
         * Valores por defecto
         */
        if($order_key === FALSE) $order_key = 'hora';
        if($order_type === FALSE) $order_type = 'DESC';
        if($pagina === FALSE) $pagina = 1;
        if($cantMostrar === 0) $cantMostrar = 10;

        $fecha_hoy = explode(' ', Time::get())[0];

        /**
         * Con busqueda
         */
        if($buscar != FALSE)
        {
            $condicional = "numero LIKE '%{$buscar}%'";

            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $condicional = "fecha = '{$fecha_hoy}' AND ({$condicional})";
            $facturas = FacturasModel::Listado( $condicional, $par );
            $total_filas = FacturasModel::Total( $condicional );
        }
        /**
         * Con filtros
         */
        elseif($filtros == "si")
        {
            $numero = Filtro::General( Input::POST("numero", FALSE) );
            $totalInicio = Filtro::General( Input::POST("total-inicio", FALSE) );
            $totalFin = Filtro::General( Input::POST("total-fin", FALSE) );
            $horaInicio = Input::POST("hora-inicio", FALSE);
            $horaFin = Input::POST("hora-fin", FALSE);

            $condicional = "";

            if($numero != FALSE) {
                if($condicional != "") $condicional .= " AND ";
                $condicional .= "numero LIKE '%{$numero}'%";
            }

            if($totalInicio != FALSE) {
                if($condicional != "") $condicional .= " AND ";
                $condicional .= "total >= '{$totalInicio}'";
            }

            if($totalFin != FALSE) {
                if($condicional != "") $condicional .= " AND ";
                $condicional .= "total <= '{$totalFin}'";
            }

            if($horaInicio != FALSE) {
                $horaInicio .= ":00";
                if($condicional != "") $condicional .= " AND ";
                $condicional .= "hora >= '{$horaInicio}'";
            }

            if($horaFin != FALSE) {
                $horaFin .= ":00";
                if($condicional != "") $condicional .= " AND ";
                $condicional .= "hora <= '{$horaFin}'";
            }

            $condicional = "idRestaurant = '{$idRestaurant}' AND ({$condicional})";

            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $condicional = "fecha = '{$fecha_hoy}' AND ({$condicional})";
            $facturas = FacturasModel::Listado( $condicional, $par );
            $total_filas = FacturasModel::Total( $condicional );
        }
        /**
         * Sin busqueda
         */
        else
        {
            $condicional = "idRestaurant = '{$idRestaurant}'";

            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $condicional = "fecha = '{$fecha_hoy}' AND ({$condicional})";
            $facturas = FacturasModel::Listado( $condicional, $par );
            $total_filas = FacturasModel::Total( $condicional );
        }

        /**
         * Organizamos la salida
         */
        $datos = [];
        for($I=0; $I<sizeof($facturas); $I++)
        {
            $objFactura = new FacturaModel( $facturas[$I]['idFactura'] );
            $objMoneda = new MonedaModel($objFactura->getIdMoneda());
            $items = $objFactura->getItems();

            $datos[$I] = [
                "id" => $objFactura->getId(),
                "numero" => $objFactura->getNumero(),
                "total" => $objFactura->getTotal(),
                "items" => sizeof($items),
                "fecha" => $objFactura->getFecha(),
                "hora" => $objFactura->getHora(),
                "moneda" => [
                    "id" => $objMoneda->getId(),
                    "nombre" => $objMoneda->getNombre()
                ]
            ];
        }

        if($order_key == "fecha") $order_key = "fecha";

        /**
         * Retornamos la respuesta
         */
        $respuesta['cuerpo'] = [
            "order_key" => $order_key,
            "order_type" => $order_type,
            "pagina" => $pagina,
            "cantMostrar" => $cantMostrar,
            "total_filas" => $total_filas,
            "data" => $datos
        ];
    break;

    /**
     * CONSULTAR
     */
    case "CONSULTAR":
        /**
         * Tomamos los parametros
         */
        $order_key = Input::POST("order_key", FALSE);
        $order_type = Input::POST("order_type", FALSE);
        $pagina = (int) Input::POST("pagina", FALSE);
        $cantMostrar = (int) Input::POST("cantMostrar", FALSE);
        $buscar = Filtro::General( Input::POST("buscar", FALSE) );
        $filtros = Input::POST("filtros", FALSE);

        /**
         * Valores por defecto
         */
        if($order_key === FALSE) $order_key = 'fecha';
        if($order_type === FALSE) $order_type = 'DESC';
        if($pagina === FALSE) $pagina = 1;
        if($cantMostrar === 0) $cantMostrar = 10;

        /**
         * Con busqueda
         */
        if($buscar != FALSE)
        {
            $condicional = "numero LIKE '%{$buscar}%'";

            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $facturas = FacturasModel::Listado( $condicional, $par );
            $total_filas = FacturasModel::Total( $condicional );
        }
        /**
         * Con filtros
         */
        elseif($filtros !== FALSE)
        {
            $numero = Filtro::General( Input::POST("numero", FALSE) );
            $totalInicio = Filtro::General( Input::POST("total-inicio", FALSE) );
            $totalFin = Filtro::General( Input::POST("total-fin", FALSE) );
            $fechaInicio = Input::POST("fecha-inicio", FALSE);
            $fechaFin = Input::POST("fecha-fin", FALSE);

            $condicional = "";

            if($numero != FALSE) {
                if($condicional != "") $condicional .= " AND ";
                $condicional .= "numero LIKE '%{$numero}'%";
            }

            if($totalInicio != FALSE) {
                if($condicional != "") $condicional .= " AND ";
                $condicional .= "total >= '{$totalInicio}'";
            }

            if($totalFin != FALSE) {
                if($condicional != "") $condicional .= " AND ";
                $condicional .= "total <= '{$totalFin}'";
            }

            if($fechaInicio != FALSE) {
                if($condicional != "") $condicional .= " AND ";
                $condicional .= "fecha >= '{$fechaInicio}'";
            }

            if($fechaFin != FALSE) {
                if($condicional != "") $condicional .= " AND ";
                $condicional .= "fecha <= '{$fechaFin}'";
            }

            $condicional = "idRestaurant = '{$idRestaurant}' AND ({$condicional})";

            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $facturas = FacturasModel::Listado( $condicional, $par );
            $total_filas = FacturasModel::Total( $condicional );
        }
        /**
         * Sin busqueda
         */
        else
        {
            $condicional = "idRestaurant = '{$idRestaurant}'";

            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $facturas = FacturasModel::Listado( $condicional, $par );
            $total_filas = FacturasModel::Total( $condicional );
        }

        /**
         * Organizamos la salida
         */
        $datos = [];
        for($I=0; $I<sizeof($facturas); $I++)
        {
            $objFactura = new FacturaModel( $facturas[$I]['idFactura'] );
            $objMoneda = new MonedaModel($objFactura->getIdMoneda());
            $items = $objFactura->getItems();

            $datos[$I] = [
                "id" => $objFactura->getId(),
                "numero" => $objFactura->getNumero(),
                "total" => $objFactura->getTotal(),
                "items" => sizeof($items),
                "fecha" => $objFactura->getFecha(),
                "hora" => $objFactura->getHora(),
                "moneda" => [
                    "id" => $objMoneda->getId(),
                    "nombre" => $objMoneda->getNombre(),
                    "simbolo" => $objMoneda->getSimbolo()
                ]
            ];
        }

        if($order_key == "fecha") $order_key = "fecha";

        /**
         * Retornamos la respuesta
         */
        $respuesta['cuerpo'] = [
            "order_key" => $order_key,
            "order_type" => $order_type,
            "pagina" => $pagina,
            "cantMostrar" => $cantMostrar,
            "total_filas" => $total_filas,
            "data" => $datos
        ];
    break;

    /**
     * OTROS
     */
    default:
        throw new Exception("Acción invalida.");
    break;
}