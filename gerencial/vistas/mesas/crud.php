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
        if($order_key === FALSE) $order_key = 'alias';
        if($order_type === FALSE) $order_type = 'ASC';
        if($pagina === FALSE) $pagina = 1;
        if($cantMostrar === 0) $cantMostrar = 10;

        /**
         * Con busqueda
         */
        if($buscar != FALSE)
        {
			$condicional = "alias LIKE '%{$buscar}%'";
			$condicional = "idRestaurant = '{$idRestaurant}' AND ({$condicional})";

            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $mesas = MesasModel::Listado( $condicional, $par );
            $total_filas = MesasModel::Total( $condicional );
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

            $mesas = MesasModel::Listado( $condicional, $par );
            $total_filas = MesasModel::Total();
		}
		
		/**
         * Organizamos la salida
         */
        $data = [];
		foreach($mesas as $mesa)
		{
			$objMesa = new MesaModel( $mesa['idMesa'] );
			$status = $objMesa->getStatus();
			$nombreStatus = STATUS_MESAS[$status];

			array_push($data, [
				"id" => $objMesa->getId(),
				"alias" => $objMesa->getAlias(),
				"status" => [
					"key" => $status,
					"nombre" => $nombreStatus
				],
				"usuario" => $objMesa->getUsuario(),
				"clave" => $objMesa->getClave(),
				"fecha_registro" => $objMesa->getFechaRegistro()
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

	/**
	 * REGISTRAR
	 */
	case "REGISTRAR":
		$alias = Input::POST("alias", TRUE);
		$usuario = Input::POST("usuario", TRUE);
		$clave = Input::POST("clave", TRUE);

		if(MesasModel::Existe($idRestaurant, $usuario) === TRUE) {
			throw new Exception("Ya existe una mesa con el usuario <b>{$usuario}</b> en este restaurant.");
		}

		$objMesa = MesasModel::Registrar($idRestaurant, $alias, $usuario, $clave);
		Conexion::getMysql()->Commit();

		$respuesta['cuerpo'] = [
			"id" => $objMesa->getId(),
			"alias" => $objMesa->getAlias(),
			"status" => [
				"key" => $objMesa->getStatus(),
				"nombre" => STATUS_MESAS[$objMesa->getStatus()]
			],
			"fecha_registro" => $objMesa->getFechaRegistro()
		];
	break;

	/**
	 * MODIFICAR
	 */
	case "MODIFICAR":
		$idMesa = Input::POST("MIdMesa", TRUE);
		$alias = Input::POST("alias", TRUE);
		$usuario = Input::POST("usuario", TRUE);
		$clave = Input::POST("clave", TRUE);
		$status = Input::POST("status", TRUE);

		$objMesa = new MesaModel( $idMesa );

		if(MesasModel::Existe($idRestaurant, $usuario) === TRUE && $usuario != $objMesa->getUsuario()) {
			throw new Exception("Ya existe una mesa con el usuario <b>{$usuario}</b> en este restaurant.");
		}

		if($alias == "") throw new Exception("El alias de la mesa no puede estar vacio.");
		if($usuario == "") throw new Exception("El usuario de la mesa no puede estar vacio.");
		if($clave == "") throw new Exception("La contraseña de la mesa no puede estar vacia.");
		if($status == "") throw new Exception("El status de la mesa no puede estar vacia.");

		$objMesa->setAlias( $alias );
		$objMesa->setUsuario( $usuario );
		$objMesa->setClave( $clave );
		$objMesa->setStatus( $status );

		Conexion::getMysql()->Commit();
	

		$respuesta['cuerpo'] = [
			"id" => $objMesa->getId(),
			"alias" => $objMesa->getalias()
			
		];
	break;

	/**
	 * ELIMINAR
	 */
	case "ELIMINAR":
		$idMesa = Input::POST("EidMesa", TRUE);
		$objMesa = new MesaModel( $idMesa );
		$objMesa->Eliminar( $objMesa->getId() );
		Conexion::getMysql()->Commit();
		$respuesta['cuerpo'] = [];
	break;

	/**
	 * OTROS
	 */
	default:
		throw new Exception("Acción No Válida");
	break;
}