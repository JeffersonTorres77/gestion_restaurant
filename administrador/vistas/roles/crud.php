<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	CRUD DE LOS ROLES
 *
 *--------------------------------------------------------------------------------
================================================================================*/

/*================================================================================
 * Tomamos los parametros
================================================================================*/
$accion = Input::POST("accion");

/*================================================================================
 * 
================================================================================*/
switch($accion)
{
    /**
     * 
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
        if($order_key === FALSE) $order_key = 'idRol';
        if($order_type === FALSE) $order_type = 'ASC';
        if($pagina === FALSE) $pagina = 1;
        if($cantMostrar === 0) $cantMostrar = 10;

        /**
         * Con busqueda
         */
        if($buscar != FALSE)
        {
            $condicional = "nombre LIKE '%{$buscar}%' OR ";
            $condicional .= "descripcion LIKE '%{$buscar}%'";

            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $roles = RolesModel::Listado( $condicional, $par );
            $total_filas = RolesModel::Total( $condicional );
        }
        /**
         * Sin busqueda
         */
        else
        {
            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $roles = RolesModel::Listado( '', $par );
            $total_filas = RolesModel::Total();
        }

        /**
         * Organizamos la salida
         */
        $datos = [];
        for($I=0; $I<sizeof($roles); $I++)
        {
            $datos[$I] = [
                "id" => $roles[$I]['idRol'],
                "nombre" => $roles[$I]['nombre'],
                "descripcion" => $roles[$I]['descripcion'],
                "responsable" => boolval( (int) $roles[$I]['responsable'] ),
                "fecha_registro" => $roles[$I]['fecha_registro']
            ];
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
            "data" => $datos
        ];
    break;
    
    /**
     * 
     */
    case "REGISTRAR":
        $nombre = Input::POST("nombre", TRUE);
        $descripcion = Input::POST("descripcion", TRUE);
        $responsable = Input::POST("responsable", TRUE);

        if(RolesModel::ExisteNombre($nombre) == TRUE) throw new Exception("El rol <b>{$nombre}</b> ya existe.");
        $objRol = RolesModel::Registrar($nombre, $descripcion, $responsable);
        Conexion::getMysql()->Commit();

        $respuesta['cuerpo'] = [
            "id" => $objRol->getId(),
            "nombre" => $objRol->getNombre(),
            "descripcion" => $objRol->getDescripcion(),
            "responsable" => $objRol->getResponsable(),
            "fecha_registro" => $objRol->getFechaRegistro()
        ];
    break;

    /**
     * 
     */
    case "MODIFICAR":
        $idRol = Input::POST("idRol");
        $nombre = Input::POST("nombre", FALSE);
        $descripcion = Input::POST("descripcion", FALSE);
        $responsable = Input::POST("responsable", FALSE);

        $objRol = new RolModel($idRol);

        if($nombre !== FALSE) $objRol->setNombre( $nombre );
        if($descripcion !== FALSE) $objRol->setDescripcion( $descripcion );
        if($responsable !== FALSE) $objRol->setResponsable( $responsable );
        Conexion::getMysql()->Commit();

        $respuesta['cuerpo'] = [
            "id" => $objRol->getId(),
            "nombre" => $objRol->getNombre(),
            "descripcion" => $objRol->getDescripcion(),
            "responsable" => $objRol->getResponsable(),
            "fecha_registro" => $objRol->getFechaRegistro()
        ];
    break;

    /**
     * 
     */
    case "ELIMINAR":
        $idRol = Input::POST("idRol", TRUE);
        $idRolReemplazo = Input::POST("idRolSustituir", TRUE);

        if($idRol == $idRolReemplazo) throw new Exception("El rol a eliminar y el de reemplazo deben ser diferentes.");

        $objRol = new RolModel($idRol);
        $objRolReemplazo = new RolModel($idRolReemplazo);

        if($objRol->getId() == '1') {
            throw new Exception("No se puede eliminar el rol <b>".$objRol->getNombre()."</b> ya que es para responsables.");
        }

        $objRol->Eliminar( $objRolReemplazo->getId() );
        Conexion::getMysql()->Commit();

        $respuesta['cuerpo'] = [
            "id" => $objRol->getId(),
            "nombre" => $objRol->getNombre(),
            "descripcion" => $objRol->getDescripcion(),
            "responsable" => $objRol->getResponsable(),
            "fecha_registro" => $objRol->getFechaRegistro()
        ];
    break;

    /**
     * 
     */
    case "PERMISOS-CONSULTAR":
        $idRol = Input::POST("idRol", TRUE);
        $objRol = new RolModel($idRol);
        
        $salida = [];
        $menusA = MenusAModel::Listado();
        foreach($menusA as $menuA)
        {
            $opciones = [];
            $menusB = MenusBModel::Listado($menuA['idMenuA']);
            foreach($menusB as $menuB)
            {
                array_push($opciones, [
                    "idMenuB" => $menuB['idMenuB'],
                    "nombre" => $menuB['nombre'],
                    "img" => $menuB['img'],
                    "status" => MenusBModel::Verificar($menuB['idMenuB'], $objRol->getId())
                ]);
            }

            array_push($salida, [
                "idMenuA" => $menuA['idMenuA'],
                "nombre" => $menuA['nombre'],
                "img" => $menuA['img'],
                "con_opciones" => boolval((int) $menuA['con_opciones']),
                "opciones" => $opciones,
                "status" => MenusAModel::Verificar($menuA['idMenuA'], $objRol->getId())
            ]);
        }

        $respuesta['cuerpo'] = $salida;
    break;

    /**
     * 
     */
    case "PERMISOS-MODIFICAR":
        $idRol = Input::POST("idRol", TRUE);
        $idMenu = Input::POST("idMenu", TRUE);
        $tipo = Input::POST("tipo", TRUE);

        $objRol = new RolModel($idRol);
        if($tipo == "A") {
            $objMenu = new MenuAModel($idMenu);
            $objMenu->CambiarPermiso($objRol->getId(), !(MenusAModel::Verificar($idMenu, $idRol)));
        } else {
            $objMenu = new MenuBModel($idMenu);
            $objMenu->CambiarPermiso($objRol->getId(), !(MenusBModel::Verificar($idMenu, $idRol)));
        }

        Conexion::getMysql()->Commit();
    break;

    default:
        throw new Exception("Acción invalida.");
    break;
}