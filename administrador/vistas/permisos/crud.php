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
     * CONSULTAR
     */
    case "CONSULTAR":
        $idRestaurant = Input::POST("idRestaurant");
        $objRestaurant = new RestaurantModel( $idRestaurant );

        $roles = RolesModel::Listado( $objRestaurant->getId() );
        $menusA = MenusAModel::Listado();
        $data = [
            "thead" => [],
            "tbody" => []
        ];

        foreach($roles as $rol)
        {
            array_push($data['thead'], [
                "id" => $rol['idRol'],
                "nombre" => $rol['nombre']
            ]);
        }

        foreach($menusA as $menuA)
        {
            $ObjMenuA = new MenuAModel( $menuA['idMenuA'] );
            $arrayAux = [];
            array_push($arrayAux, [
                "tipo" => "A",
                "img" => $menuA['img'],
                "nombre" => $menuA['nombre']
            ]);

            foreach($roles as $rol)
            {
                array_push($arrayAux, [
                    "idMenu" => $ObjMenuA->getId(),
                    "idRol" => $rol['idRol'],
                    "tipo" => "A",
                    "valor" => $ObjMenuA->Verificar($rol['idRol'])
                ]);
            }

            array_push($data['tbody'], $arrayAux);

            $menusB = MenusBModel::Listado($ObjMenuA->getId());
            foreach($menusB as $menuB)
            {
                $ObjMenuB = new MenuBModel( $menuB['idMenuB'] );
                $arrayAux = [];
                array_push($arrayAux, [
                    "tipo" => "B",
                    "img" => $menuB['img'],
                    "nombre" => $menuB['nombre']
                ]);

                foreach($roles as $rol)
                {
                    array_push($arrayAux, [
                        "idMenu" => $ObjMenuB->getId(),
                        "idRol" => $rol['idRol'],
                        "tipo" => "B",
                        "valor" => $ObjMenuB->Verificar($rol['idRol'])
                    ]);
                }

                array_push($data['tbody'], $arrayAux);
            }
        }

        $respuesta['cuerpo'] = $data;
    break;

    /**
     * MODIFICAR
     */
    case "MODIFICAR":
        $idMenu = Input::POST("idMenu");
        $tipo = Input::POST("tipo");
        $idRol = Input::POST("idRol");

        $objRol = new RolModel( $idRol );

        if($tipo == "A")
        {
            $objMenu = new MenuAModel( $idMenu );
        }
        elseif($tipo == "B")
        {
            $objMenu = new MenuBModel( $idMenu );
        }
        else
        {
            throw new Exception("Tipo de menu <b>{$tipo}</b> invalido.");
        }

        $darPermiso = !( $objMenu->Verificar( $objRol->getId() ) );
        $objMenu->CambiarPermiso( $objRol->getId(), $darPermiso);

        Conexion::getMysql()->Commit();
    break;
    
    /**
     * OTROS
     */
    default:
        throw new Exception("Acción invalida.");
    break;
}