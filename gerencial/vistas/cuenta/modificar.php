<?php

$objUsuario = Sesion::getUsuario();
$correo = Input::POST('correo', FALSE);
$clave = Input::POST('clave', FALSE);

if($correo !== FALSE && $correo == "") throw new Exception("El correo es obligatorio.");
if($clave !== FALSE && $clave == "") throw new Exception("La contraseña es obligatoria.");

if($correo !== FALSE) $objUsuario->setCorreo($correo);
if($clave !== FALSE) $objUsuario->setClave($clave);

Conexion::getMysql()->Commit();