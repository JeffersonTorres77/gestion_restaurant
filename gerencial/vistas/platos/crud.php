<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	CRUD DE PLATOS
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
	/*============================================================================
	 * 
	 * 
	 * 
	============================================================================*/
	case "CONSULTAR":
		/**
         * Tomamos los parametros
         */
        $order_key = Input::POST("order_key", FALSE);
        $order_type = Input::POST("order_type", FALSE);
        $pagina = (int) Input::POST("pagina", FALSE);
        $cantMostrar = (int) Input::POST("cantMostrar", FALSE);
        $buscar = Filtro::General( Input::POST("buscar", FALSE) );

        /**
         * Valores por defecto
         */
        if($order_key === FALSE) $order_key = 'nombre';
        if($order_type === FALSE) $order_type = 'ASC';
        if($pagina === FALSE) $pagina = 1;
		if($cantMostrar === 0) $cantMostrar = 10;
		
		if($order_key == "categoria") $order_key = "B.nombre";
		else $order_key = "A.{$order_key}";

        /**
         * Con busqueda
         */
        if($buscar != FALSE)
        {
			$aux = explode("-", $buscar);
			if(sizeof($aux) == 2 && $aux[0] == "categoria")
			{
				$condicional = "B.idCategoria = '{$aux[1]}'";
			}
			else
			{
				$condicional = "A.nombre LIKE '%{$buscar}%' OR ";
				$condicional .= "B.nombre LIKE '%{$buscar}%'";
			}

			$condicional = "A.idRestaurant = '{$idRestaurant}' AND ({$condicional})";

            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $platos = PlatosModel::Listado( $condicional, $par );
            $total_filas = PlatosModel::Total( $condicional );
        }
        /**
         * Sin busqueda
         */
        else
        {
			$condicional = "A.idRestaurant = '{$idRestaurant}'";

            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $platos = PlatosModel::Listado( $condicional, $par );
            $total_filas = PlatosModel::Total();
		}

		/**
         * Organizamos la salida
         */
        $data = [];
		foreach($platos as $plato)
		{
			$objPlato = new PlatoModel( $plato['idPlato'] );
			$objCategoria = new CategoriaModel( $objPlato->getIdCategoria() );

			array_push($data, [
				"id" => $objPlato->getId(),
				"categoria" => [
					"id" => $objCategoria->getId(),
					"nombre" => $objCategoria->getNombre()
				],
				"nombre" => $objPlato->getNombre(),
				"descripcion" => $objPlato->getDescripcion(),
				"imagen" => $objPlato->getImagen(),
				"activo" => $objPlato->getActivo(),
				"precioCosto" => $objPlato->getPrecioCosto(),
				"precioVenta" => $objPlato->getPrecioVenta(),
				"fecha_registro" => $objPlato->getFechaRegistro()
			]);
		}

		if($order_key == "A.nombre") $order_key = "nombre";
		if($order_key == "B.nombre") $order_key = "categoria";

        /**
         * Retornamos la respuesta
         */
        $respuesta['cuerpo'] = [
            "order_key" => $order_key,
            "order_type" => $order_type,
            "pagina" => $pagina,
            "cantMostrar" => $cantMostrar,
            "total_filas" => $total_filas,
            "data" => $data
        ];
	break;

	/*============================================================================
	 * 
	 * 
	 * 
	============================================================================*/
	case "REGISTRAR":
		$nombre = Input::POST("NombrePlato", TRUE);
		$descripcion = Input::POST("DescripPlato", TRUE);
		$idCategoria = Input::POST("CategoriaPlato", TRUE);
		$precioCosto = Input::POST("PrecioCostoPlato", TRUE);
		$precioVenta = Input::POST("PrecioVentaPlato", TRUE);
		$activo = (int) boolval( Input::POST("ActivoPlato", FALSE) );

		if($nombre == "") throw new Exception("El campo <b>nombre</b> no puede estar vacio.");
		if($descripcion == "") throw new Exception("El campo <b>descripcion</b> no puede estar vacio.");
		if($idCategoria == "") throw new Exception("El campo <b>categoria</b> no puede estar vacio.");
		if($precioCosto < 0) throw new Exception("El campo <b>precio costo</b> no puede ser un numero negativo.");
		if($precioVenta < 0) throw new Exception("El campo <b>precio venta</b> no puede ser un numero negativo.");
		
		$precioCosto = bcdiv($precioCosto, '1', 2);
		$precioVenta = bcdiv($precioVenta, '1', 2);

		$objPlato = PlatosModel::Registrar($idRestaurant, $nombre, $descripcion, $idCategoria, $precioCosto, $precioVenta, $activo);

		/**
         * Imagen
         */
        if($_FILES && $_FILES['img'] && $_FILES['img']['name'] != "")
        {
            /**
             * Extraemos la data
             */
            $img = $_FILES['img'];
            $carpetaImg = DIR_IMG_REST."/".$idRestaurant;
            $nombreImg = "plato-{$objPlato->getId()}";
            $aux = explode(".", $img['name']);
            $extensionImg = $aux[ sizeof($aux) - 1 ];
            
            /**
             * Subimos la imagen
             */
            SubirImagen($carpetaImg, $nombreImg, $img);

            /**
             * Guardamos en la base de datos
             */
            $objPlato->setImagen("{$nombreImg}.{$extensionImg}");
		}
		else
		{
			$objPlato->setImagen(IMG_PLATO_DEFECTO);
		}

		Conexion::getMysql()->Commit();

		$respuesta['cuerpo'] = [
			"id" => $objPlato->getId(),
			"nombre" => $objPlato->getNombre(),
			"descripcion" => $objPlato->getDescripcion(),
			"activo" => $objPlato->getActivo()
		];
	break;

	/*============================================================================
	 * 
	 * 
	 * 
	============================================================================*/
	case "MODIFICAR":
		$idPlato = Input::POST("idPlato", TRUE);
		$objPlato = new PlatoModel( $idPlato );

		if($objPlato->getIdRestaurant() != $idRestaurant) {
			throw new Exception("No puede modificar platos de otros resturantes.");
		}

		$nombre = Input::POST("NombrePlato", TRUE);
		$descripcion = Input::POST("MDescripPlato", TRUE);
		$idCategoria = Input::POST("MCategoríaPlato", TRUE);
		$precioCosto = Input::POST("MPrecioCostoPlato", TRUE);
		$precioVenta = Input::POST("MPrecioVentaPlato", TRUE);
		$activo = (int) boolval( Input::POST("ActivoPlato", FALSE) );

		/**
         * Imagen
         */
        if($_FILES && $_FILES['img'] && $_FILES['img']['name'] != "")
        {
            /**
             * Extraemos la data
             */
            $img = $_FILES['img'];
            $carpetaImg = DIR_IMG_REST."/".$idRestaurant;
            $nombreImg = "plato-{$objPlato->getId()}";
            $aux = explode(".", $img['name']);
            $extensionImg = $aux[ sizeof($aux) - 1 ];
            
            /**
             * Subimos la imagen
             */
            SubirImagen($carpetaImg, $nombreImg, $img);

            /**
             * Guardamos en la base de datos
             */
            $objPlato->setImagen("{$nombreImg}.{$extensionImg}");
		}
		
		if($nombre == "") throw new Exception("El campo <b>nombre</b> no puede estar vacio.");
		if($descripcion == "") throw new Exception("El campo <b>descripcion</b> no puede estar vacio.");
		if($idCategoria == "") throw new Exception("El campo <b>categoria</b> no puede estar vacio.");
		if($precioCosto < 0) throw new Exception("El campo <b>precio costo</b> no puede ser un numero negativo.");
		if($precioVenta < 0) throw new Exception("El campo <b>precio venta</b> no puede ser un numero negativo.");

		$precioCosto = bcdiv($precioCosto, '1', 2);
		$precioVenta = bcdiv($precioVenta, '1', 2);

		$objPlato->setNombre( $nombre );
		$objPlato->setDescripcion( $descripcion );
		$objPlato->setIdCategoria( $idCategoria );
		$objPlato->setPrecioCosto( $precioCosto );
		$objPlato->setPrecioVenta( $precioVenta );
		$objPlato->setActivo( $activo );

        Conexion::getMysql()->Commit();
	break;

	/*============================================================================
	 * 
	 * 
	 * 
	============================================================================*/
    case "ELIMINAR":
		$idPlato = Input::POST("idPlato", TRUE);
		$objPlato = new PlatoModel( $idPlato );

		if($objPlato->getIdRestaurant() != $idRestaurant) {
			throw new Exception("No puede eliminar platos de otros resturantes.");
		}

        $objPlato->Eliminar();
        Conexion::getMysql()->Commit();
    break;

	/*============================================================================
	 * 
	 * 
	 * 
	============================================================================*/
	default:
		throw new Exception("Acción No Válida");
	break;
}