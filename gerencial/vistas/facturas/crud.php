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
        if($order_key === FALSE) $order_key = 'numero';
        if($order_type === FALSE) $order_type = 'ASC';
        if($pagina === FALSE) $pagina = 1;
        if($cantMostrar === 0) $cantMostrar = 10;

        if($order_key == "fecha") $order_key = "fecha_registro";

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
            $total = Filtro::General( Input::POST("total", FALSE) );
            $fecha = Input::POST("fecha", FALSE);

            $condicional = "";

            if($numero !== FALSE) {
                if($condicional != "") $condicional .= " AND ";
                $condicional .= "numero LIKE '{$numero}'";
            }

            if($total !== FALSE) {
                if($condicional != "") $condicional .= " AND ";
                $condicional .= "total = '{$total}'";
            }

            if($fecha !== FALSE) {
                if($condicional != "") $condicional .= " AND ";
                $condicional .= "fecha_registro LIKE '{$fecha}%'";
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
            $items = $objFactura->getItems();

            $datos[$I] = [
                "id" => $objFactura->getId(),
                "numero" => $objFactura->getNumero(),
                "total" => $objFactura->getTotal(),
                "items" => sizeof($items),
                "fecha_registro" => $objFactura->getFechaRegistro()
            ];
        }

        if($order_key == "fecha_registro") $order_key = "fecha";

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