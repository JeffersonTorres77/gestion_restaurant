<?php

// Preparativos para los WebSocket
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
require_once(BASE_DIR . "_core/APIs/vendor/autoload.php");

// Url del WebSocket
$urlWs = WEBSOCKET_URL . "socket.io/";
$urlWs .= "?area=".AREA_GERENCIAL;
$urlWs .= "&modulo=mesas";
$urlWs .= "&archivo=servicio";
$urlWs .= "&key=".Sesion::getKey();

/**
 * Solicitamos el cambio del servicio a los WebSockets
 */
try
{
    // Conectamos
    $client = new Client( new Version2X( $urlWs ) );
    $client->initialize();

    // Verificamos el status
    $objRestaurant = Sesion::getRestaurant();
    $event = ( $objRestaurant->getServicio() ) ? 'desactivar-servicio' : 'activar-servicio';
    $client->emit($event, []);

    // Recibimos
    $resp = "";
    while (true) {
        $r = $client->read();
    
        if (!empty($r)) {
            $resp = $r;
            break;
        }
    }

    // Cerramos
    $client->close();
}
catch(Exception $e)
{
    $client->close();
    throw new Exception("Ocurrio un problema con la comunicación con el servicio de WebSockets.");
}