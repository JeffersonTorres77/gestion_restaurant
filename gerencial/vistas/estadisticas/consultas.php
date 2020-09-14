<?php $respuesta['cuerpo'] = [];

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
if($order_key === FALSE) $order_key = 'nombre';
if($order_type === FALSE) $order_type = 'ASC';
if($pagina === FALSE || $pagina < 1) $pagina = 1;
if($cantMostrar === 0) $cantMostrar = 10;

$accion = Input::POST('accion', TRUE);
$buscar = Input::POST('buscar', FALSE);
$nombre = Input::POST('nombre', FALSE);
$FechaInicio = Input::POST('fecha-inicio', FALSE);
$fechaFin = Input::POST('fecha-fin', FALSE);

$objRestaurant = Sesion::getRestaurant();
$idRestaurant = $objRestaurant->getId();

$totalCantidad = 0;
$totalIngresos = 0;

/**
 * 
 */
switch($accion)
{
    //
    case "PLATILLOS":
        $condicional = "idRestaurant = '{$idRestaurant}'";
        if($buscar != FALSE) $condicional .= " AND nombre LIKE '%{$buscar}%'";
        if($nombre != FALSE) $condicional .= " AND nombre LIKE '%{$nombre}%'";

        $platos = PlatosModel::General($condicional, $order_type);
        $total_filas = count($platos);

        $datos = [];
        foreach($platos as $index => $plato)
        {
            $id = $plato['idPlato'];
            $nombre = $plato['nombre'];
            $cantidad = 0;
            $ingresos = 0;

            $query = "SELECT SUM(cantidad) AS cantidad, SUM(precioTotal) AS ingresos FROM facturas_detalles WHERE idPlato = '{$id}' AND status = '4'";
            if($FechaInicio != FALSE) { $FechaInicio .= " 00:00:00"; $query .= " AND fecha_registro >= '{$FechaInicio}'"; }
            if($fechaFin != FALSE) { $fechaFin .= " 23:59:59"; $query .= " AND fecha_registro <= '{$fechaFin}'"; }
            $result = Conexion::getMysql()->Consultar($query);

            $cantidad = ($result[0]['cantidad'] != NULL) ? $result[0]['cantidad'] : 0;
            $ingresos = ($result[0]['ingresos'] != NULL) ? $result[0]['ingresos'] : 0;

            $totalCantidad += $cantidad;
            $totalIngresos += $ingresos;

            $objPlato = new PlatoModel($id);
            $objCategoria = new CategoriaModel($objPlato->getIdCategoria());

            array_push($datos, [
                "id" => $id,
                "nombre" => $nombre,
                "cantidad" => $cantidad,
                "ingresos" => $ingresos,
                "idCategoria" => $objCategoria->getId(),
                "nombreCategoria" => $objCategoria->getNombre()
            ]);
        }
    break;
    
    //
    case "MENUS":
        $condicional = "idRestaurant = '{$idRestaurant}'";
        if($buscar != FALSE) $condicional .= " AND nombre LIKE '%{$buscar}%'";
        if($nombre != FALSE) $condicional .= " AND nombre LIKE '%{$nombre}%'";

        $menus = CombosModel::General($condicional, $order_type);
        $total_filas = count($menus);

        $datos = [];
        foreach($menus as $index => $menu)
        {
            $id = $menu['idCombo'];
            $nombre = $menu['nombre'];
            $cantidad = 0;
            $ingresos = 0;

            $query = "SELECT SUM(cantidad) AS cantidad, SUM(precioTotal) AS ingresos FROM facturas_detalles WHERE idCombo = '{$id}' AND status = '4'";
            if($FechaInicio != FALSE) { $FechaInicio .= " 00:00:00"; $query .= " AND fecha_registro >= '{$FechaInicio}'"; }
            if($fechaFin != FALSE) { $fechaFin .= " 23:59:59"; $query .= " AND fecha_registro <= '{$fechaFin}'"; }
            $result = Conexion::getMysql()->Consultar($query);

            $cantidad = ($result[0]['cantidad'] != NULL) ? $result[0]['cantidad'] : 0;
            $ingresos = ($result[0]['ingresos'] != NULL) ? $result[0]['ingresos'] : 0;

            $totalCantidad += $cantidad;
            $totalIngresos += $ingresos;

            array_push($datos, [
                "id" => $id,
                "nombre" => $nombre,
                "cantidad" => $cantidad,
                "ingresos" => $ingresos
            ]);
        }
    break;
    
    //
    case "CATEGORIAS":
        $condicional = "idRestaurant = '{$idRestaurant}'";
        if($buscar != FALSE) $condicional .= " AND nombre LIKE '%{$buscar}%'";
        if($nombre != FALSE) $condicional .= " AND nombre LIKE '%{$nombre}%'";

        $menus = CategoriasModel::General($condicional, $order_type);
        $total_filas = count($menus);

        $datos = [];
        foreach($menus as $index => $menu)
        {
            $id = $menu['idCategoria'];
            $nombre = $menu['nombre'];
            $cantidad = 0;
            $ingresos = 0;

            $platosArray = '';
            $platos = PlatosModel::General("idCategoria = '{$id}'");
            foreach($platos as $plato) {
                if($platosArray != "") $platosArray = ", ";
                $platosArray = $plato['idPlato'];
            }

            $query = "SELECT SUM(cantidad) AS cantidad, SUM(precioTotal) AS ingresos FROM facturas_detalles WHERE idPlato IN ({$platosArray}) AND status = '4'";
            if($FechaInicio != FALSE) { $FechaInicio .= " 00:00:00"; $query .= " AND fecha_registro >= '{$FechaInicio}'"; }
            if($fechaFin != FALSE) { $fechaFin .= " 23:59:59"; $query .= " AND fecha_registro <= '{$fechaFin}'"; }
            $result = Conexion::getMysql()->Consultar($query);

            $cantidad = ($result[0]['cantidad'] != NULL) ? $result[0]['cantidad'] : 0;
            $ingresos = ($result[0]['ingresos'] != NULL) ? $result[0]['ingresos'] : 0;

            $totalCantidad += $cantidad;
            $totalIngresos += $ingresos;

            array_push($datos, [
                "id" => $id,
                "nombre" => $nombre,
                "cantidad" => $cantidad,
                "ingresos" => $ingresos
            ]);
        }
    break;
    
    //
    case "AREAS":
        $condicional = "'1' = '1'";
        if($buscar != FALSE) $condicional .= " AND nombre LIKE '%{$buscar}%'";
        if($nombre != FALSE) $condicional .= " AND nombre LIKE '%{$nombre}%'";

        $areas = AreasMonitoreoModel::General($condicional, $order_type);
        $total_filas = count($areas);

        $datos = [];
        foreach($areas as $index => $area)
        {
            $id = $area['idAreaMonitoreo'];
            $nombre = $area['nombre'];
            $cantidad = 0;
            $ingresos = 0;

            $query = "SELECT SUM(cantidad) AS cantidad, SUM(precioTotal) AS ingresos FROM facturas A, facturas_detalles B WHERE A.idFactura = B.idFactura AND A.idRestaurant = '{$idRestaurant}' AND B.idAreaMonitoreo = '{$id}' AND B.status = '4'";
            if($FechaInicio != FALSE) { $FechaInicio .= " 00:00:00"; $query .= " AND fecha_registro >= '{$FechaInicio}'"; }
            if($fechaFin != FALSE) { $fechaFin .= " 23:59:59"; $query .= " AND fecha_registro <= '{$fechaFin}'"; }
            $result = Conexion::getMysql()->Consultar($query);

            $cantidad = ($result[0]['cantidad'] != NULL) ? $result[0]['cantidad'] : 0;
            $ingresos = ($result[0]['ingresos'] != NULL) ? $result[0]['ingresos'] : 0;

            $totalCantidad += $cantidad;
            $totalIngresos += $ingresos;

            array_push($datos, [
                "id" => $id,
                "nombre" => $nombre,
                "cantidad" => $cantidad,
                "ingresos" => $ingresos
            ]);
        }
    break;
    
    //
    case "MESAS":
        $condicional = "idRestaurant = '{$idRestaurant}'";
        if($buscar != FALSE) $condicional .= " AND alias LIKE '%{$buscar}%'";
        if($nombre != FALSE) $condicional .= " AND alias LIKE '%{$nombre}%'";

        $mesas = MesasModel::General($condicional, $order_type);
        $total_filas = count($mesas);

        $datos = [];
        foreach($mesas as $index => $mesa)
        {
            $id = $mesa['idMesa'];
            $nombre = $mesa['alias'];
            $cantidad = 0;
            $ingresos = 0;

            $query = "SELECT SUM(cantidad) AS cantidad, SUM(precioTotal) AS ingresos FROM facturas_detalles WHERE idMesa = '{$id}' AND status = '4'";
            if($FechaInicio != FALSE) { $FechaInicio .= " 00:00:00"; $query .= " AND fecha_registro >= '{$FechaInicio}'"; }
            if($fechaFin != FALSE) { $fechaFin .= " 23:59:59"; $query .= " AND fecha_registro <= '{$fechaFin}'"; }
            $result = Conexion::getMysql()->Consultar($query);

            $cantidad = ($result[0]['cantidad'] != NULL) ? $result[0]['cantidad'] : 0;
            $ingresos = ($result[0]['ingresos'] != NULL) ? $result[0]['ingresos'] : 0;

            $totalCantidad += $cantidad;
            $totalIngresos += $ingresos;

            array_push($datos, [
                "id" => $id,
                "nombre" => $nombre,
                "cantidad" => $cantidad,
                "ingresos" => $ingresos
            ]);
        }
    break;
    
    //
    default:
        throw new Exception("Acción <b>{$accion}</b> invalida.");
    break;
}

/**
 * Ordenamos
 */
if($order_key == "cantidad" || $order_key == "ingresos" || $order_key == "nombreCategoria")
{
    for($i=0; $i<sizeof($datos); $i++)
    {
        for($j=0; $j<sizeof($datos); $j++)
        {
            if($order_type == "DESC")
            {
                if($datos[$i][$order_key] > $datos[$j][$order_key])
                {
                    $aux = $datos[$i];
                    $datos[$i] = $datos[$j];
                    $datos[$j] = $aux;
                }
            }
            else
            {
                if($datos[$i][$order_key] < $datos[$j][$order_key])
                {
                    $aux = $datos[$i];
                    $datos[$i] = $datos[$j];
                    $datos[$j] = $aux;
                }
            }
        }
    }
}

/**
 * Cortamos
 */
$inicio = ($pagina - 1) * $cantMostrar;
$datos = array_slice($datos, $inicio, $cantMostrar);

/**
 * Retornamos la respuesta
 */
$respuesta['cuerpo'] = [
    "order_key" => $order_key,
    "order_type" => $order_type,
    "pagina" => $pagina,
    "cantMostrar" => $cantMostrar,
    "total_filas" => $total_filas,
    "data" => [
        "datos" => $datos,
        "totalCantidad" => $totalCantidad,
        "totalIngresos" => $totalIngresos
    ]
];