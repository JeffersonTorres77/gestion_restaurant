<?php

$accion = Input::POST('accion', TRUE);
$idRestaurant = Input::POST('idRestaurant', TRUE);
$objRestaurant = new RestaurantModel($idRestaurant);

switch($accion)
{
    case "CONSULTAR":
        $roles = RolesModel::Listado("");
        $resp = [];

        foreach($roles as $rol)
        {
            array_push($resp, [
                "id" => $rol['idRol'],
                "nombre" => $rol['nombre'],
                "descripcion" => $rol['descripcion'],
                "responsable" => boolval((int) $rol['responsable']),
                "status" => RolesModel::Permiso($rol['idRol'], $idRestaurant)
            ]);
        }

        $respuesta['cuerpo'] = $resp;
    break;

    case "MODIFICAR":
        $idRol = Input::POST("idRol", TRUE);
        $objRol = new RolModel($idRol);

        $status = RolesModel::Permiso($idRol, $idRestaurant);
        RolesModel::setPermiso($idRol, $idRestaurant, !$status);
        Conexion::getMysql()->Commit();
    break;

    default:
        throw new Exception("Acción invalida.");
    break;
}