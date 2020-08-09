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

        /**
         * Con busqueda
         */
        if($buscar != FALSE)
        {
			$condicional = "nombre LIKE '%{$buscar}%'";
			$condicional = "idRestaurant = '{$idRestaurant}' AND ({$condicional})";

            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $combos = CombosModel::Listado( $condicional, $par );
            $total_filas = CombosModel::Total( $condicional );
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

            $combos = CombosModel::Listado( $condicional, $par );
            $total_filas = CombosModel::Total();
		}
		
		/**
         * Organizamos la salida
         */
        $data = [];
		foreach($combos as $combo)
		{
			$objCombo = new ComboModel( $combo['idCombo'] );

			array_push($data, [
				"id" => $objCombo->getId(),
				"nombre" => $objCombo->getNombre(),
				"descripcion" => $objCombo->getDescripcion(),
				"imagen" => $objCombo->getImagen(),
				"descuento" => $objCombo->getDescuento(),
				"activo" => $objCombo->getActivo(),
				"fecha_registro" => $objCombo->getFechaRegistro()
			]);
		}

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
	case "ANALIZAR-PLATOS":
		$platos = Input::POST("platos", TRUE);
		$platos = json_decode($platos);

		$platos_filtro = [];
		$categorias = [];

		for($I=0; $I<sizeof($platos); $I++)
		{
			$objPlato = new PlatoModel($platos[$I]->id);
			if($objPlato->getidRestaurant() != $idRestaurant) {
				continue;
			}

			if(!$objPlato->getActivo()) {
				continue;
			}

			$salir = FALSE;
			for($J=0; $J<sizeof($platos_filtro); $J++)
			{
				if($objPlato->getId() == $platos_filtro[$J]['id']) {
					$salir = TRUE;
					break;
				}
			}

			if($salir) continue;
			
			array_push($platos_filtro, [
				"id" => $objPlato->getId(),
				"nombre" => $objPlato->getNombre()
			]);

			$objCategoria = new CategoriaModel( $objPlato->getIdCategoria() );
			$existeCategoria = FALSE;
			
			for($J=0; $J<sizeof($categorias); $J++)
			{
				if($categorias[$J]['id'] == $objCategoria->getId())
				{
					$categorias[$J]['cantidad'] += 1;
					$existeCategoria = TRUE;
					break;
				}
			}

			if($existeCategoria === FALSE) {
				array_push($categorias, [
					"id" => $objCategoria->getId(),
					"nombre" => $objCategoria->getNombre(),
					"cantidad" => 1
				]);
			}
		}

		$platos = $platos_filtro;

		$respuesta['cuerpo'] = [
			"platos" => $platos,
			"categorias" => $categorias
		];
	break;

	/*============================================================================
	 * 
	 * 
	 * 
	============================================================================*/
    case "REGISTRAR":
		$nombre = Input::POST("nombre", TRUE);
		$descripcion = Input::POST("descripcion", TRUE);
		$descuento = Input::POST("descuento", TRUE);
		$categorias = Input::POST("categorias", TRUE);
		$platos = Input::POST("platos", TRUE);
		$platos = json_decode($platos);

		$objCombo = CombosModel::Registrar($idRestaurant, $nombre, $descripcion, $descuento);

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
            $nombreImg = "combo-{$objCombo->getId()}";
            $aux = explode(".", $img['name']);
            $extensionImg = $aux[ sizeof($aux) - 1 ];
            
            /**
             * Subimos la imagen
             */
            SubirImagen($carpetaImg, $nombreImg, $img);

            /**
             * Guardamos en la base de datos
             */
            $objCombo->setImagen( "{$nombreImg}.{$extensionImg}" );
        }

		foreach($categorias as $categoria)
		{
			$objCombo->addCategoria($categoria['id'], $categoria['cantidad']);
		}

		foreach($platos as $plato)
		{
			$objCombo->addPlato($plato->id);
		}

		Conexion::getMysql()->Commit();

		$respuesta['cuerpo'] = [];
	break;

	/*============================================================================
	 * 
	 * 
	 * 
	============================================================================*/
    case "MODIFICAR":
		$idCombo = Input::POST("idCombo", TRUE);

		$nombre = Input::POST("nombre", TRUE);
		$descuento = Input::POST("descuento", TRUE);
		$descripcion = Input::POST("descripcion", TRUE);
		$activo = isset($_POST['activo']);
		$categorias = Input::POST("categorias", TRUE);
		$platos = Input::POST("platos", TRUE);
		$platos = json_decode($platos);

		$objCombo = new ComboModel($idCombo);

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
            $nombreImg = "combo-{$objCombo->getId()}";
            $aux = explode(".", $img['name']);
            $extensionImg = $aux[ sizeof($aux) - 1 ];
            
            /**
             * Subimos la imagen
             */
            SubirImagen($carpetaImg, $nombreImg, $img);

            /**
             * Guardamos en la base de datos
             */
            $objCombo->setImagen( "{$nombreImg}.{$extensionImg}" );
		}

		$objCombo->setNombre($nombre);
		$objCombo->setDescuento($descuento);
		$objCombo->setDescripcion($descripcion);
		$objCombo->setActivo($activo);

		$objCombo->resetCategorias();
		$objCombo->resetPlatos();

		foreach($categorias as $categoria)
		{
			$objCombo->addCategoria($categoria['id'], $categoria['cantidad']);
		}

		foreach($platos as $plato)
		{
			$objCombo->addPlato($plato->id);
		}

		Conexion::getMysql()->Commit();

		$respuesta['cuerpo'] = [];
	break;

	/*============================================================================
	 * 
	 * 
	 * 
	============================================================================*/
    case "ELIMINAR":
		$idCombo = Input::POST("idCombo", TRUE);
		$objCombo = new ComboModel( $idCombo );

		if($objCombo->getIdRestaurant() != $idRestaurant) {
			throw new Exception("No puede eliminar combos de otros resturantes.");
		}

        $objCombo->Eliminar();
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