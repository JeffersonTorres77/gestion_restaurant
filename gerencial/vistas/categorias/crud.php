<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	CRUD DE CATEGORIAS
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

            $categorias = CategoriasModel::Listado( $condicional, $par );
            $total_filas = CategoriasModel::Total( $condicional );
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

            $categorias = CategoriasModel::Listado( $condicional, $par );
            $total_filas = CategoriasModel::Total();
		}
		
		/**
         * Organizamos la salida
         */
        $data = [];
		foreach($categorias as $categoria)
		{
			$objCategoria = new CategoriaModel( $categoria['idCategoria'] );
			$objArea = new AreaMonitoreoModel( $objCategoria->getIdAreaMonitoreo() );

			array_push( $data, [
				"id" => $objCategoria->getId(),
				"nombre" => $objCategoria->getNombre(),
				"atiende" => [
					"id" => $objArea->getId(),
					"nombre" => $objArea->getNombre()
				],
				"fecha_registro" => $objCategoria->getFechaRegistro()
			] );
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

	/**
	 * REGISTRAR
	 */
	case "REGISTRAR":
		$nombre = Input::POST("NombreCategoria", TRUE);
		$idAreaMonitoreo = Input::POST("EnviaCategoria", TRUE);

		$objArea = new AreaMonitoreoModel( $idAreaMonitoreo );
		$objCategoria = CategoriasModel::Registrar($nombre, $objArea->getId(), $idRestaurant);
		Conexion::getMysql()->Commit();

		$respuesta['cuerpo'] = [
			"id" => $objCategoria->getId(),
			"nombre" => $objCategoria->getNombre(),
			"atiende" => [
				"id" => $objArea->getId(),
				"nombre" => $objArea->getNombre()
			],
			"fecha_registro" => $objCategoria->getFechaRegistro()
		];
	break;

	/**
	 * MODIFICAR
	 */
	case "MODIFICAR":
		$idCategoria = Input::POST("idCategoria", TRUE);
		$nombre = Input::POST("NombreCategoria", TRUE);
		$idAreaMonitoreo = Input::POST("EnviaCategoria", TRUE);

		$objArea = new AreaMonitoreoModel( $idAreaMonitoreo );
		$objCategoria = new CategoriaModel( $idCategoria );

		$objCategoria->setNombre( $nombre );
		$objCategoria->setIdAreaMonitoreo( $idAreaMonitoreo );
		Conexion::getMysql()->Commit();
		
		$respuesta['cuerpo'] = [
			"id" => $objCategoria->getId(),
			"nombre" => $objCategoria->getNombre(),
			"atiende" => [
				"id" => $objArea->getId(),
				"nombre" => $objArea->getNombre()
			],
			"fecha_registro" => $objCategoria->getFechaRegistro()
		];
	break;

	/**
	 * ELIMINAR
	 */
	case "ELIMINAR":
		$idCategoria = Input::POST("idCategoria", TRUE);
		$idCategoriaReemplazo = Input::POST("EIdCategoriaReemplazo", TRUE);

		$objCategoria = new CategoriaModel( $idCategoria );
		$objCategoriaReemplazo = new CategoriaModel( $idCategoriaReemplazo );

		if($objCategoria->getId() == $objCategoriaReemplazo->getId()) {
			throw new Exception("Las categorias a eliminar y de reemplazo no puedes ser iguales.");
		}

		$objCategoria->Eliminar( $objCategoriaReemplazo->getId() );
		Conexion::getMysql()->Commit();
		$respuesta['cuerpo'] = [];
	break;

	/**
	 * OTROS
	 */
	default:
		throw new Exception("Accion invalida");
	break;
}